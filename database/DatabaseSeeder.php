<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        $this->call(UserSeeder::class);
        $this->call(MakesModelsVehiclesSeeder::class);
        $this->call(AuctionSeeder::class);
        $this->call(AuctionImageSeeder::class);

    }
}
