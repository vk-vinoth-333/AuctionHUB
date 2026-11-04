<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index($id)
    {
        $tournament = Tournament::with(['teams' => function ($query) {
            $query->whereNull('deleted_at')->orderBy('id', 'asc')
                ->with(['players' => function ($q) {
                    $q->whereNotNull('team_id')
                        ->with('detail');
                }]);
        }])->findOrFail($id);

        $totalPlayers = $tournament->players()->count();
        $soldCount = $tournament->players()->where('player_status', 'sold')->count();
        $unsoldCount = $tournament->players()->where('player_status', 'unsold')->count();
        $remaining = $totalPlayers - $soldCount - $unsoldCount;

        $playersPerTeam = $tournament->players_per_team ?? 11;
        $basePoint = $tournament->base_point ?? 1000;

        return view('auction.index', compact(
            'tournament',
            'totalPlayers',
            'soldCount',
            'unsoldCount',
            'remaining',
            'playersPerTeam',
            'basePoint'
        ));
    }

    public function allPlayers($id)
    {
        $tournament = Tournament::findOrFail($id);

        $players = \App\Models\Player::with(['detail', 'team'])
            ->where('tournament_id', $id)
            ->orderBy('id', 'asc')
            ->get();

        return view('auction.all_players', compact('tournament', 'players'));
    }

    public function spinWheel($id)
    {
        $tournament = Tournament::findOrFail($id);

        $pendingPlayers = \App\Models\Player::with('detail')
            ->where('tournament_id', $id)
            ->where('player_status', 'pending')
            ->get();

        $teams = $tournament->teams()->whereNull('deleted_at')->get();

        $spinType = 'pending';

        return view('auction.spin', compact('tournament', 'pendingPlayers', 'teams', 'spinType'));
    }

    public function spinWheelUnsold($id)
    {
        $tournament = Tournament::findOrFail($id);

        $pendingPlayers = \App\Models\Player::with('detail')
            ->where('tournament_id', $id)
            ->where('player_status', 'unsold')
            ->get();

        $teams = $tournament->teams()->whereNull('deleted_at')->get();

        $spinType = 'unsold';

        return view('auction.spin', compact('tournament', 'pendingPlayers', 'teams', 'spinType'));
    }

    public function showAssignPage(Request $request, $id, $player_id)
    {
        $tournament = Tournament::findOrFail($id);
        $player = \App\Models\Player::with('detail')->where('tournament_id', $id)->findOrFail($player_id);

        $teams = $tournament->teams()
            ->whereNull('deleted_at')
            ->with(['players' => function ($q) {
                $q->where('player_status', 'sold')->with('detail');
            }])
            ->orderBy('id', 'asc')
            ->get();

        foreach ($teams as $team) {
            $remainingSlots = max(0, $tournament->players_per_team - $team->player_count);
            $otherSlots = max(0, $remainingSlots - 1);
            $reservedPoints = $otherSlots * $tournament->base_point;

            $team->max_bid = max(0, $team->available_points - $reservedPoints);
            if ($remainingSlots <= 0) {
                $team->max_bid = 0;
            }
        }

        $spinType = $request->query('type', 'pending');

        return view('auction.assign', compact('tournament', 'player', 'teams', 'spinType'));
    }

    public function assignPlayer(Request $request, $id)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'team_id'   => 'required|string',
            'points'    => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $player = \App\Models\Player::findOrFail($request->player_id);
            $tournament = Tournament::findOrFail($id);
            $spinType = $request->input('spin_type', 'pending');

            if ($request->team_id === 'unsold') {
                $player->player_status = 'unsold';
                $player->team_id = null;
                $player->sold_out_points = null;
                $player->sold_at = now();
                $player->save();

                DB::commit();
                return redirect()->route('auction.spin-unsold', $tournament->id)->with('success', 'Player marked as Unsold successfully.');
            }

            $team = \App\Models\Team::findOrFail($request->team_id);
            $points = $request->points ?? 0;

            if ($team->player_count >= $tournament->players_per_team) {
                return back()->with('error', 'This team has already reached the maximum number of players.');
            }

            if ($team->available_points < $points) {
                return back()->with('error', 'Team does not have enough points for this bid.');
            }

            $remainingSlots = max(0, $tournament->players_per_team - $team->player_count);
            $otherSlots = max(0, $remainingSlots - 1);
            $reservedPoints = $otherSlots * $tournament->base_point;
            $maxBid = max(0, $team->available_points - $reservedPoints);

            if ($points > $maxBid) {
                return back()->with('error', "Bid exceeds the Max Bid allowed (₹" . number_format($maxBid) . ").");
            }

            $player->player_status = 'sold';
            $player->team_id = $team->id;
            $player->sold_out_points = $points;
            $player->sold_at = now();
            $player->save();

            $team->available_points -= $points;
            $team->player_count += 1;
            $team->save();

            DB::commit();

            $routeName = $spinType === 'unsold' ? 'auction.spin-unsold' : 'auction.spin';
            return redirect()->route($routeName, $tournament->id)->with('success', 'Player assigned successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function revertPlayer(Request $request, $id)
    {
        $request->validate([
            'player_id'  => 'required|exists:players,id',
            'action'     => 'required|in:revert,reassign',
            'new_team_id' => 'required_if:action,reassign|nullable|exists:teams,id',
            'new_points' => 'required_if:action,reassign|nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $player = \App\Models\Player::findOrFail($request->player_id);

            if ($player->player_status !== 'sold' || !$player->team_id) {
                return back()->with('error', 'This player is not currently assigned to any team.');
            }

            $oldTeam = \App\Models\Team::findOrFail($player->team_id);
            $tournament = Tournament::findOrFail($id);

            $oldTeam->available_points += $player->sold_out_points;
            $oldTeam->player_count -= 1;
            $oldTeam->save();

            if ($request->action === 'revert') {
                $player->player_status = 'pending';
                $player->team_id = null;
                $player->sold_out_points = null;
                $player->sold_at = null;
                $player->save();

                DB::commit();
                return redirect()->route('auction.spin', $tournament->id)->with('success', 'Player reverted to auction pool successfully.');
            }

            if ($request->action === 'reassign') {
                $newTeam = \App\Models\Team::findOrFail($request->new_team_id);
                $newPoints = $request->new_points ?? 0;

                if ($newTeam->player_count >= $tournament->players_per_team) {
                    throw new \Exception('The selected new team has already reached the maximum number of players.');
                }

                if ($newTeam->available_points < $newPoints) {
                    throw new \Exception('The selected new team does not have enough points for this bid.');
                }

                $remainingSlots = max(0, $tournament->players_per_team - $newTeam->player_count);
                $otherSlots = max(0, $remainingSlots - 1);
                $reservedPoints = $otherSlots * $tournament->base_point;
                $maxBid = max(0, $newTeam->available_points - $reservedPoints);

                if ($newPoints > $maxBid) {
                    throw new \Exception("Bid exceeds the Max Bid allowed for the new team (" . number_format($maxBid) . ").");
                }

                $player->team_id = $newTeam->id;
                $player->sold_out_points = $newPoints;
                $player->sold_at = now();
                $player->save();

                $newTeam->available_points -= $newPoints;
                $newTeam->player_count += 1;
                $newTeam->save();

                DB::commit();

                return redirect()->route('auction.spin', $tournament->id)->with('success', 'Player re-assigned to ' . $newTeam->name . ' successfully.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
