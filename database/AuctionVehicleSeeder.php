<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuctionVehicle;
use App\Models\User;
use App\Models\Auction;
use Faker\Factory as Faker;

class AuctionVehicleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $users = User::all();
        $auctions = Auction::all();

        foreach (range(1, 20) as $index) {
            AuctionVehicle::create([
                'user_id' => $users->random()->id,
                'auction_id' => $auctions->random()->id,
                'VIN' => $faker->unique()->regexify('[A-Z0-9]{17}'),
                'status' => $faker->randomElement(['pendiente', 'en_revision', 'aprobado', 'ganado', 'no_ganado', 'pagado', 'enviado']),
            ]);
        }
    }
}