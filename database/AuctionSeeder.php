<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Stripe\Stripe;
use Stripe\Price;

class AuctionSeeder extends Seeder
{
    public function run()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $auctions = [
            [
                'name' => 'Subasta de Toyota Corolla 2022',
                'url' => 'https://www.copart.com/es/lot/89408665/salvage-2024-chevrolet-silverado-k1500-ct-hartford',
                'description' => 'Subasta de un Toyota Corolla 2022 en excelentes condiciones.',
                'starting_price' => 20000.00,
                'current_price' => 22000.00,
                'start_date' => Carbon::now()->addDays(1),
                'end_date' => Carbon::now()->addDays(7),
                'status' => 'active',
                'reserve_fee' => 500.00, // Tarifa de reserva fija
                'vehicle_price' => 22000.00, // Precio del vehículo
            ],
            [
                'name' => 'Subasta de Honda Civic 2021',
                'url' => 'https://www.copart.com/es/lot/89408665/salvage-2024-chevrolet-silverado-k1500-ct-hartford',
                'description' => 'Subasta de un Honda Civic 2021 con bajo kilometraje.',
                'starting_price' => 18000.00,
                'current_price' => 19000.00,
                'start_date' => Carbon::now()->addDays(2),
                'end_date' => Carbon::now()->addDays(8),
                'status' => 'active',
                'reserve_fee' => 500.00, 
                'vehicle_price' => 19000.00,
            ],
            [
                'name' => 'Subasta de Ford Mustang 2023',
                'url' => 'https://www.copart.com/es/lot/89408665/salvage-2024-chevrolet-silverado-k1500-ct-hartford',
                'description' => 'Subasta de un Ford Mustang 2023 en perfecto estado.',
                'starting_price' => 35000.00,
                'current_price' => 37000.00,
                'start_date' => Carbon::now()->addDays(3),
                'end_date' => Carbon::now()->addDays(9),
                'status' => 'active',
                'reserve_fee' => 500.00,
                'vehicle_price' => 37000.00,
            ],
        ];

        foreach ($auctions as $auction) {
            $reserveFeePrice = Price::create([
                'unit_amount' => $auction['reserve_fee'] * 100, 
                'currency' => 'usd',
                'product_data' => [
                    'name' => "Tarifa de Reserva - {$auction['name']}",
                ],
            ]);

            $vehiclePrice = Price::create([
                'unit_amount' => $auction['vehicle_price'] * 100, 
                'currency' => 'usd',
                'product_data' => [
                    'name' => "Precio del Vehículo - {$auction['name']}",
                ],
            ]);

            $auction['reserve_fee_stripe_price_id'] = $reserveFeePrice->id;
            $auction['vehicle_price_stripe_price_id'] = $vehiclePrice->id;

            Auction::create($auction);
        }
    }
}