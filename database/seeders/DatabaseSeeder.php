<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            InstallationSeeder::class,
            PermissionSeeder::class,
            // AuctionDemoSeeder::class
        ]);
    }
}
