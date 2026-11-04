<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerDetail;
use App\Models\Team;
use App\Models\Tournament;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['player-list', 'player-create', 'player-edit', 'player-delete']);

        try {
            $players = Player::with(['team', 'tournament', 'detail'])->latest()->get();
            return view('players.index', compact('players'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        ResponseService::noPermissionThenRedirect('player-create');

        $tournaments = Tournament::whereNull('deleted_at')->get();
        $teams       = Team::whereNull('deleted_at')->get();

        return view('players.create', compact('tournaments', 'teams'));
    }

    public function store(Request $request)
    {
        ResponseService::noPermissionThenRedirect('player-create');

        $validator = Validator::make($request->all(), [
            'tournament_id'       => 'required|exists:tournaments,id',
            'team_id'             => 'nullable|exists:teams,id',
            'name'                => 'required|string|max:255',
            'player_number'       => 'nullable|string|max:50',
            'role'                => 'required|in:batsman,bowler,wicket_keeper,all_rounder',
            'bowling_style'       => 'required|in:right,left,na',
            'batting_style'       => 'required|in:right_handed,left_handed',
            'player_status'       => 'required|in:sold,unsold,pending',
            'payment_status'      => 'required|in:paid,not_paid',
            'city'                => 'nullable|string|max:255',
            'base_price'          => 'nullable|string|max:255',
            'sold_price'          => 'nullable|string|max:255',
            'photo'               => 'required|image|max:5120',
            'original_proof'      => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'payment_screenshot'  => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'payment_reference' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $tournament = Tournament::findOrFail($request->tournament_id);
        $playerNumber = $this->generatePlayerNumber($tournament);

        DB::beginTransaction();

        try {
            $player = new Player();
            $player->tournament_id = $request->tournament_id;
            $player->team_id       = $request->team_id;
            $player->name          = $request->name;
            $player->player_number = $playerNumber;
            $player->status        = $request->has('status') ? 1 : 0;
            $player->payment_status = $request->payment_status;
            $player->player_status  = $request->player_status;
            $player->registration_source = 'admin';
            $player->registration_status = 'approved';
            $player->registered_ip = request()->ip();

            if ($request->hasFile('photo')) {
                $player->photo = compressAndUpload($request->file('photo'), 'players');
            }

            $player->save();

            $detail = new PlayerDetail();
            $detail->player_id     = $player->id;
            $detail->city          = $request->city;
            $detail->role          = $this->roleToInt($request->role);
            $detail->batting_style = $request->batting_style;
            $detail->bowling_style = $request->bowling_style;
            $detail->base_price    = $request->base_price;
            $detail->sold_price    = $request->sold_price;
            $detail->payment_reference = $request->payment_reference;

            if ($request->hasFile('original_proof')) {
                $detail->original_proof = compressAndUpload($request->file('original_proof'), 'players/proofs');
            }

            if ($request->hasFile('payment_screenshot')) {
                $detail->payment_screenshot = compressAndUpload($request->file('payment_screenshot'), 'players/payments');
            }

            $detail->save();

            DB::commit();

            return redirect('players')->with('success', __('Player created successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $player = Player::with(['team', 'tournament', 'detail'])->findOrFail($id);
        return view('players.show', compact('player'));
    }

    public function edit($id)
    {
        ResponseService::noPermissionThenRedirect('player-edit');

        $player      = Player::with('detail')->findOrFail($id);
        $tournaments = Tournament::whereNull('deleted_at')->get();
        $teams       = Team::whereNull('deleted_at')->get();

        return view('players.edit', compact('player', 'tournaments', 'teams'));
    }

    public function update(Request $request, $id)
    {
        ResponseService::noPermissionThenRedirect('player-edit');

        $validator = Validator::make($request->all(), [
            'tournament_id'       => 'required|exists:tournaments,id',
            'team_id'             => 'nullable|exists:teams,id',
            'name'                => 'required|string|max:255',
            'player_number'       => 'nullable|string|max:50',
            'role'                => 'required|in:batsman,bowler,wicket_keeper,all_rounder',
            'bowling_style'       => 'required|in:right,left,na',
            'batting_style'       => 'required|in:right_handed,left_handed',
            'player_status'       => 'required|in:sold,unsold,pending',
            'payment_status'      => 'required|in:paid,not_paid',
            'city'                => 'nullable|string|max:255',
            'base_price'          => 'nullable|string|max:255',
            'sold_price'          => 'nullable|string|max:255',
            'photo'               => 'nullable|image|max:5120',
            'original_proof'      => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'payment_screenshot'  => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'registration_status' => 'required|in:pending,approved,rejected',
            'payment_reference'   => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        DB::beginTransaction();

        try {
            $player = Player::findOrFail($id);

            $player->tournament_id = $request->tournament_id;
            $player->team_id       = $request->team_id;
            $player->name          = $request->name;
            $player->status        = $request->has('status') ? 1 : 0;
            $player->payment_status = $request->payment_status;
            $player->player_status  = $request->player_status;
            $player->registration_status = $request->registration_status;

            if ($player->isDirty('tournament_id') || empty($player->player_number)) {
                $tournament = Tournament::findOrFail($request->tournament_id);
                $player->player_number = $this->generatePlayerNumber($tournament, $player->id);
            }

            if ($request->hasFile('photo')) {
                $player->photo = compressAndUpload($request->file('photo'), 'players');
            }

            $player->save();

            $detail = PlayerDetail::firstOrNew(['player_id' => $player->id]);
            $detail->city          = $request->city;
            $detail->role          = $this->roleToInt($request->role);
            $detail->batting_style = $request->batting_style;
            $detail->bowling_style = $request->bowling_style;
            $detail->base_price    = $request->base_price;
            $detail->sold_price    = $request->sold_price;
            $detail->payment_reference = $request->payment_reference;

            if ($request->hasFile('original_proof')) {
                $detail->original_proof = compressAndUpload($request->file('original_proof'), 'players/proofs');
            }
            if ($request->hasFile('payment_screenshot')) {
                $detail->payment_screenshot = compressAndUpload($request->file('payment_screenshot'), 'players/payments');
            }
            $detail->save();

            DB::commit();

            return redirect('players')->with('success', __('Player updated successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        ResponseService::noPermissionThenRedirect('player-delete');

        try {
            Player::findOrFail($id)->delete();
            return redirect('players')->with('success', __('Player deleted successfully'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function generateNumber(Request $request)
    {
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'player_id'     => 'nullable|integer',
        ]);

        $tournament = Tournament::findOrFail($request->tournament_id);

        return response()->json([
            'player_number' => $this->generatePlayerNumber($tournament, $request->player_id),
        ]);
    }

    private function generatePlayerNumber(Tournament $tournament, $excludePlayerId = null): string
    {
        $query = Player::where('tournament_id', $tournament->id);
        if ($excludePlayerId) {
            $query->where('id', '!=', $excludePlayerId);
        }

        $next = $query->count() + 1;
        $short = $tournament->short_code;

        do {
            $candidate = $short . '-' . $next;
            $exists = Player::where('tournament_id', $tournament->id)
                ->where('player_number', $candidate)
                ->when($excludePlayerId, fn($q) => $q->where('id', '!=', $excludePlayerId))
                ->exists();

            if ($exists) $next++;
        } while ($exists);

        return $candidate;
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
}
