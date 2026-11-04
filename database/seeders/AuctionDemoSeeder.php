<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Player;
use App\Models\PlayerDetail;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuctionDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a default Admin/Organizer if one doesn't exist
        $organizer = Admin::firstOrCreate(
            ['id' => 1],
            [
                'username' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'status' => 1,
            ]
        );

        // 2. Define Tournaments Data
        $tournamentsData = [
            [
                'name' => 'Kolkata Premier League',
                'short_code' => 'KPL-S1',
                'description' => 'Demo tournament for KPL.',
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(15),
                'venue' => 'Eden Gardens',
                'city' => 'Kolkata',
                'total_teams' => 12,
                'players_per_team' => 15,
                'prize_amount' => '500000',
                'base_point' => 1000,
                'is_pr_free' => 0,
                'pr_amount' => '500',
                'status' => 1,
                'registration_open' => 1,
                'registration_ends_at' => now()->addDays(3),
                'organizer_id' => $organizer->id,
            ],
            [
                'name' => 'Mumbai Cricket League',
                'short_code' => 'MCL-S1',
                'description' => 'Demo tournament for MCL.',
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(25),
                'venue' => 'Wankhede Stadium',
                'city' => 'Mumbai',
                'total_teams' => 12,
                'players_per_team' => 15,
                'prize_amount' => '1000000',
                'base_point' => 1000,
                'is_pr_free' => 1,
                'pr_amount' => null,
                'status' => 1,
                'registration_open' => 1,
                'registration_ends_at' => null,
                'organizer_id' => $organizer->id,
            ]
        ];

        $roles = [1, 2, 3, 4]; // 1=Batsman, 2=Bowler, 3=Wicket Keeper, 4=All-Rounder
        $battingStyles = ['right_handed', 'left_handed'];
        $bowlingStyles = ['right', 'left', 'na'];

        $tournamentCounter = 1;

        foreach ($tournamentsData as $tData) {
            // Create Tournament
            $tournament = Tournament::create($tData);

            // Create 12 Teams for this Tournament
            $teams = [];
            for ($i = 1; $i <= 12; $i++) {
                $teams[] = Team::create([
                    'tournament_id' => $tournament->id,
                    'name' => 'Team ' . $tournamentCounter . '-' . $i,
                    'short_name' => 'T' . $tournamentCounter . $i,
                    'description' => 'Description for Team ' . $i,
                    'owner_name' => 'Owner ' . $i,
                    'contact_email' => 'team' . $tournamentCounter . $i . '@example.com',
                    'contact_phone' => '987654' . str_pad($tournamentCounter . $i, 4, '0', STR_PAD_LEFT),
                    'available_points' => 60000,
                    'player_count' => 0,
                    'pool' => 'Pool A',
                    'status' => 1,
                ]);
            }

            // Create 20 Players for this Tournament
            for ($i = 1; $i <= 20; $i++) {
                // Randomly assign to a team (or leave as null for auction pool)
                $isSold = $i <= 10; // Let's make the first 10 players already sold
                $team = $isSold ? $teams[array_rand($teams)] : null;

                // Generate player number (e.g., KPL-S1-1)
                $playerNumber = $tournament->short_code . '-' . $i;

                $player = Player::create([
                    'tournament_id' => $tournament->id,
                    'team_id' => $team ? $team->id : null,
                    'name' => 'Player ' . $tournamentCounter . '-' . $i,
                    'player_number' => $playerNumber,
                    'email' => 'player' . $tournamentCounter . $i . '@example.com',
                    'phone' => '900000' . str_pad($tournamentCounter . $i, 4, '0', STR_PAD_LEFT),
                    'photo' => null,
                    'sold_out_points' => $isSold ? rand(500, 5000) : null,
                    'sold_at' => $isSold ? now() : null,
                    'status' => 1,
                    'player_status' => $isSold ? 'sold' : 'pending', // pending, unsold, sold
                    'payment_status' => $isSold ? 'paid' : 'not_paid',

                    // Latest Registration Fields
                    'registration_source' => 'admin',
                    'registration_status' => 'approved',
                    'registered_ip' => '127.0.0.1',
                ]);

                // Create Player Details
                PlayerDetail::create([
                    'player_id' => $player->id,
                    'city' => 'City ' . rand(1, 10),
                    'role' => $roles[array_rand($roles)],
                    'batting_style' => $battingStyles[array_rand($battingStyles)],
                    'bowling_style' => $bowlingStyles[array_rand($bowlingStyles)],
                    'original_proof' => null,
                    'payment_screenshot' => null,
                    'payment_reference' => $isSold ? 'UTR' . rand(100000, 999999) : null,
                    'base_price' => (string) rand(1000, 5000),
                    'sold_price' => $isSold ? (string) $player->sold_out_points : null,
                ]);

                // Update Team Points and Player Count if the player is sold
                if ($isSold && $team) {
                    $team->increment('player_count');
                    $team->decrement('available_points', $player->sold_out_points);
                }
            }

            $tournamentCounter++;
        }
    }
}
