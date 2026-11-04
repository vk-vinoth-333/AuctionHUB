<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerDetail;
use App\Models\PlayerRegistrationLog;
use App\Models\Tournament;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;


class PlayerRegistrationController extends Controller
{
    public function show(string $shortCode)
    {
        $tournament = $this->findTournament($shortCode);

        return view('public.player-register', [
            'tournament' => $tournament,
            'isOpen'     => $this->isOpen($tournament),
        ]);
    }

    public function store(Request $request, string $shortCode)
    {
        $tournament = $this->findTournament($shortCode);

        if (filled($request->input('website'))) {
            return redirect()->route('player.register', $shortCode);
        }

        if (!$this->isOpen($tournament)) {
            return back()->with('error', 'Registration for this tournament is closed.')->withInput();
        }

        $request->merge(['phone' => $this->normalizePhone($request->input('phone'))]);

        $paymentRequired = !$tournament->is_pr_free;

        $validator = Validator::make($request->all(), [
            'name'               => ['required', 'string', 'min:2', 'max:100'],
            'phone'              => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                Rule::unique('players', 'phone')->where(
                    fn($q) => $q->where('tournament_id', $tournament->id)->whereNull('deleted_at')
                ),
            ],
            'city'               => ['required', 'string', 'max:100'],
            'role'               => ['required', 'in:batsman,bowler,wicket_keeper,all_rounder'],
            'batting_style'      => ['required', 'in:right_handed,left_handed'],
            'bowling_style'      => ['required', 'in:right,left,na'],
            'photo'              => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'original_proof'     => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'payment_screenshot' => [$paymentRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'payment_reference'  => ['nullable', 'string', 'max:100'],
            'confirm'            => ['accepted'],
        ], [
            'phone.regex'  => 'Enter a valid 10-digit mobile number.',
            'phone.unique' => 'This mobile number is already registered for this tournament.',
            'confirm.accepted' => 'Please confirm that your details are correct.',
            'photo.max'    => 'Photo must be 5 MB or smaller.',
            'original_proof.max' => 'Proof must be 5 MB or smaller.',
            'payment_screenshot.max' => 'Screenshot must be 5 MB or smaller.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $uploaded = [];

        try {
            DB::beginTransaction();

            $locked = Tournament::whereKey($tournament->id)->whereNull('deleted_at')->lockForUpdate()->first();

            if (!$locked || !$this->isOpen($locked)) {
                throw new DomainException('Registration for this tournament is closed.');
            }

            $duplicate = Player::where('tournament_id', $locked->id)
                ->where('phone', $request->phone)
                ->whereNull('deleted_at')
                ->lockForUpdate()
                ->exists();

            if ($duplicate) {
                throw new DomainException('This mobile number is already registered for this tournament.');
            }

            $playerNumber = $this->nextPlayerNumber($locked);

            $player = new Player();
            $player->tournament_id       = $locked->id;
            $player->team_id             = null;
            $player->name                = trim($request->name);
            $player->phone               = $request->phone;
            $player->player_number       = $playerNumber;
            $player->player_status       = 'pending';
            $player->payment_status      = 'not_paid';
            $player->status              = 0;
            $player->registration_source = 'online';
            $player->registration_status = 'pending';
            $player->registered_ip       = $request->ip();

            $player->photo = $uploaded[] = compressAndUpload($request->file('photo'), 'players');
            $player->save();

            $detail = new PlayerDetail();
            $detail->player_id         = $player->id;
            $detail->city              = trim($request->city);
            $detail->role              = $this->roleToInt($request->role);
            $detail->batting_style     = $request->batting_style;
            $detail->bowling_style     = $request->bowling_style;
            $detail->payment_reference = $request->payment_reference;
            $detail->original_proof    = $uploaded[] = compressAndUpload($request->file('original_proof'), 'players/proofs');

            if ($request->hasFile('payment_screenshot')) {
                $detail->payment_screenshot = $uploaded[] = compressAndUpload($request->file('payment_screenshot'), 'players/payments');
            }

            $detail->save();

            DB::commit();

            $this->writeLog('success', $request, $locked->id, $player->id);

            return redirect()
                ->route('player.register', $shortCode)
                ->with('registered', ['name' => $player->name, 'number' => $playerNumber]);
        } catch (DomainException $e) {
            DB::rollBack();
            $this->deleteUploaded($uploaded);
            $this->writeLog('rejected', $request, $tournament->id, null, $e);

            return back()->with('error', $e->getMessage())->withInput();
        } catch (Throwable $e) {
            DB::rollBack();
            $this->deleteUploaded($uploaded);
            $this->writeLog('failed', $request, $tournament->id, null, $e);

            return back()
                ->with('error', 'Something went wrong while saving your registration. Please try again in a moment.')
                ->withInput();
        }
    }

    private function findTournament(string $shortCode): Tournament
    {
        return Tournament::whereNull('deleted_at')
            ->whereRaw('LOWER(short_code) = ?', [strtolower($shortCode)])
            ->firstOrFail();
    }

    private function isOpen(Tournament $tournament): bool
    {
        if (!$tournament->registration_open) {
            return false;
        }

        return !$tournament->registration_ends_at || now()->lte($tournament->registration_ends_at);
    }

    private function normalizePhone(?string $phone): string
    {
        $digits = preg_replace('/\D/', '', (string) $phone);

        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            $digits = substr($digits, 2);
        } elseif (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        }

        return $digits;
    }

    private function nextPlayerNumber(Tournament $tournament): string
    {
        $prefix = $tournament->short_code . '-';

        $max = Player::withTrashed()
            ->where('tournament_id', $tournament->id)
            ->where('player_number', 'like', $prefix . '%')
            ->pluck('player_number')
            ->map(fn($n) => (int) substr($n, strlen($prefix)))
            ->max() ?? 0;

        return $prefix . ($max + 1);
    }

    private function roleToInt(?string $role): ?int
    {
        return match ($role) {
            'batsman'       => 1,
            'bowler'        => 2,
            'wicket_keeper' => 3,
            'all_rounder'   => 4,
            default         => null,
        };
    }

    private function deleteUploaded(array $paths): void
    {
        foreach ($paths as $path) {
            try {
                if ($path) {
                    Storage::disk('public')->delete($path);
                }
            } catch (Throwable $e) {
                Log::warning('Could not clean up upload: ' . $path);
            }
        }
    }

    private function writeLog(string $result, Request $request, ?int $tournamentId, ?int $playerId, ?Throwable $e = null): void
    {
        try {
            PlayerRegistrationLog::create([
                'tournament_id' => $tournamentId,
                'player_id'     => $playerId,
                'phone'         => $request->input('phone'),
                'result'        => $result,
                'error_message' => $e?->getMessage(),
                'error_trace'   => ($e && $result === 'failed') ? mb_substr($e->getTraceAsString(), 0, 5000) : null,
                'payload'       => $request->except(['_token', 'photo', 'original_proof', 'payment_screenshot', 'website']),
                'ip_address'    => $request->ip(),
                'user_agent'    => mb_substr((string) $request->userAgent(), 0, 500),
            ]);
        } catch (Throwable $logError) {
            Log::error('Registration log failed: ' . $logError->getMessage());
        }
    }
}
