<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Player;
use App\Models\PlayerDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getSlug(Request $request)
    {
        $table = $request->table;
        $name = $request->name;
        // $slug = customSlug($name);

        $slug = generateUniqueSlug($name);

        $originalSlug = $slug;
        if ($request->has('id')) {
            $id = $request->id;
            $counter = 1;
            while (DB::table($table)->where('id', '!=', $id)->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        } else {
            $counter = 1;
            while (DB::table($table)->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        return $slug;
    }

    public function index(Request $request)
    {
        $tournamentId = $request->input('tournament_id');
        $tournaments = Tournament::whereNull('deleted_at')->orderBy('name')->get();

        // Base Queries
        $playerQuery = Player::query();
        $teamQuery = Team::query();
        
        if ($tournamentId) {
            $playerQuery->where('tournament_id', $tournamentId);
            $teamQuery->where('tournament_id', $tournamentId);
        }

        // ==========================================
        // 1. Top Stat Boxes
        // ==========================================
        $countTournaments = Tournament::whereNull('deleted_at')->count();
        $countTeams = (clone $teamQuery)->whereNull('deleted_at')->count();
        $countPlayers = (clone $playerQuery)->count();
        
        $soldCount = (clone $playerQuery)->where('player_status', 'sold')->count();
        $unsoldCount = (clone $playerQuery)->where('player_status', 'unsold')->count();
        $pendingCount = (clone $playerQuery)->where('player_status', 'pending')->count();
        
        $totalSpent = (clone $playerQuery)->where('player_status', 'sold')->sum('sold_out_points') ?? 0;
        
        $pendingRegistrations = (clone $playerQuery)
            ->where('registration_status', 'pending')
            ->where('registration_source', 'online')
            ->count();

        // ==========================================
        // 2. Teams List & Player Counts
        // ==========================================
        $teams = (clone $teamQuery)
            ->whereNull('deleted_at')
            ->withSum(['players as spent_points' => function($q) {
                $q->where('player_status', 'sold');
            }], 'sold_out_points')
            ->orderBy('created_at', 'desc')
            ->take(6) // Show top 6 on dashboard
            ->get();

        // ==========================================
        // 3. Top 5 Buys List
        // ==========================================
        $topBuys = (clone $playerQuery)
            ->where('player_status', 'sold')
            ->with('team')
            ->orderBy('sold_out_points', 'desc')
            ->take(5)
            ->get();

        // ==========================================
        // 4. Chart Data
        // ==========================================
        
        // Chart A: Auction Progress (Donut)
        $statusChart = [
            ['status' => 'Sold', 'count' => $soldCount, 'color' => '#16a34a'],
            ['status' => 'Unsold', 'count' => $unsoldCount, 'color' => '#be212a'],
            ['status' => 'Pending', 'count' => $pendingCount, 'color' => '#334155'],
        ];

        // Chart B: Role-wise Players (Horizontal Bar)
        $roleQuery = PlayerDetail::select('role', DB::raw('count(*) as players'))
            ->join('players', 'player_details.player_id', '=', 'players.id')
            ->whereNotNull('role')
            ->groupBy('role');
            
        if ($tournamentId) {
            $roleQuery->where('players.tournament_id', $tournamentId);
        }
        
        $rolesRaw = $roleQuery->get();
        $roleNames = [1 => 'Batsman', 2 => 'Bowler', 3 => 'Wicket Keeper', 4 => 'All-Rounder'];
        
        $roleChart = [];
        foreach ($rolesRaw as $r) {
            $roleChart[] = [
                'role' => $roleNames[$r->role] ?? 'Unknown',
                'players' => $r->players
            ];
        }
        usort($roleChart, fn($a, $b) => $b['players'] <=> $a['players']);

        // Chart C: Team Purse Usage (Radial/Bar)
        // Compares Available Points vs Spent Points for top teams
        $teamPurseChart = $teams->map(function($team) {
            $spent = (int) $team->spent_points;
            return [
                'team' => $team->short_name ?? substr($team->name, 0, 8),
                'spent' => $spent,
                'available' => (int) $team->available_points
            ];
        });

        // Chart D: Registration Source (Pie)
        $regSourceQuery = Player::select('registration_source', DB::raw('count(*) as count'))
            ->groupBy('registration_source');
        
        if ($tournamentId) {
            $regSourceQuery->where('tournament_id', $tournamentId);
        }
        
        $regSourceRaw = $regSourceQuery->get();
        $regSourceChart = [];
        foreach ($regSourceRaw as $r) {
            $regSourceChart[] = [
                'source' => ucfirst($r->registration_source),
                'count' => $r->count
            ];
        }

        return view('dashboard', compact(
            'tournaments',
            'tournamentId',
            'countTournaments',
            'countTeams',
            'countPlayers',
            'soldCount',
            'unsoldCount',
            'pendingCount',
            'totalSpent',
            'pendingRegistrations',
            'teams',
            'topBuys',
            'statusChart',
            'roleChart',
            'teamPurseChart',
            'regSourceChart'
        ));
    }

    public function upload_img(Request $request)
    {
        $page = $request->input('page');

        $fileType = $request->input('filetype');
        if ($fileType == 'image') {
            $validExtensions = ['png', 'jpeg', 'jpg'];
        } else {
            $validExtensions = ['mp4', 'mp3', 'mov'];
        }

        if (!$request->file('file')->isValid()) {
            return response('Invalid file', 400);
        }
        $file = $request->file('file');
        if (!in_array($file->getClientOriginalExtension(), $validExtensions)) {
            return response('Invalid file extension', 400);
        }
        if ($page == 'news') {
            $upload_file = $file->store('news', 'public');
        } else if ($page == 'breaking_new') {
            $upload_file = $file->store('breaking_news', 'public');
        } else if ($page == 'pages') {
            $upload_file = $file->store('pages', 'public');
        }
        return $upload_file;
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    public function checkOldPass(Request $request)
    {
        $id = Auth::user()->id;
        $password = $request->oldpass;
        $data = Admin::find($id);
        if ($data) {
            if (Hash::check($password, $data->password)) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        } else {
            return response()->json(false);
        }
    }

    public function update_profile(Request $request)
    {
        $username = $request->username;
        $email = $request->email;
        $new_password = $request->newpassword;
        $confirm_password = $request->confirmpassword;
        $id = Auth::user()->id;
        if (!empty($new_password) && !empty($confirm_password)) {
            if ($new_password == $confirm_password) {
                $admin = Admin::find($id);
                $admin->username = $username;
                $admin->email = $email;
                $admin->password = $confirm_password;
                if ($request->hasFile('file')) {
                    $admin->image = $request->file('file')->store('admin', 'public');
                }
                $admin->save();
                $response = [
                    'error' => false,
                    'message' => trans('Password Change Successfully..'),
                ];
                return response()->json($response);
            } else {
                $response = [
                    'error' => true,
                    'message' => trans('New and Confirm Password not Match..'),
                ];
                return response()->json($response);
            }
        } else {
            $admin = Admin::find($id);
            $admin->username = $username;
            $admin->email = $email;
            if ($request->hasFile('file')) {
                $admin->image = $request->file('file')->store('admin', 'public');
            }
            $admin->save();
            $response = [
                'error' => false,
                'message' => __('updated_success'),
            ];
            return response()->json($response);
        }
    }

    public function database_backup()
    {
        try {
            Artisan::call('backup:run', ['--only-db' => true]);
            // '--disable-notifications' => true
            $app_name = env('APP_NAME');
            $path = storage_path('app/' . $app_name . '/*');
            $latest_ctime = 0;
            $latest_filename = '';
            $files = glob($path);
            foreach ($files as $file) {
                if (is_file($file) && filectime($file) > $latest_ctime) {
                    $latest_ctime = filectime($file);
                    $latest_filename = $file;
                }
            }
            return response()->download($latest_filename);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
