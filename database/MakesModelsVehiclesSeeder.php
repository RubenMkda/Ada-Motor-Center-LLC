<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Stripe\Stripe;
use Stripe\Price;

class MakesModelsVehiclesSeeder extends Seeder
{
    public function run()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        DB::table('makes')->insert([
            ['name' => 'Toyota'],
            ['name' => 'Honda'],
            ['name' => 'Ford'],
        ]);

        $makes = DB::table('makes')->pluck('id', 'name');

        DB::table('models')->insert([
            ['make_id' => $makes['Toyota'], 'name' => 'Corolla'],
            ['make_id' => $makes['Toyota'], 'name' => 'Camry'],
            ['make_id' => $makes['Honda'], 'name' => 'Civic'],
            ['make_id' => $makes['Honda'], 'name' => 'Accord'],
            ['make_id' => $makes['Ford'], 'name' => 'Focus'],
            ['make_id' => $makes['Ford'], 'name' => 'Mustang'],
        ]);

        $models = DB::table('models')->pluck('id', 'name');

        $vehicles = [
            [
                'make_id' => $makes['Toyota'], 
                'model_id' => $models['Corolla'],
                'year' => 2022,
                'price' => 20000.00,
                'VIN' => '1HGCM82633A123456',
                'status' => 'disponible',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'make_id' => $makes['Honda'], 
                'model_id' => $models['Civic'],
                'year' => 2021,
                'price' => 22000.00,
                'VIN' => '1HGCM82633A654321',
                'status' => 'vendido',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'make_id' => $makes['Ford'], 
                'model_id' => $models['Mustang'],
                'year' => 2023,
                'price' => 35000.00,
                'VIN' => '1FAFP4041WF123456',
                'status' => 'reservado',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($vehicles as $vehicle) {
            $stripePrice = Price::create([
                'unit_amount' => $vehicle['price'] * 100, 
                'currency' => 'usd',
                'product_data' => [
                    'name' => "{$vehicle['make_id']} {$vehicle['model_id']} {$vehicle['year']}",
                ],
            ]);

            $vehicle['stripe_price_id'] = $stripePrice->id;

            DB::table('vehicles')->insert($vehicle);
        }

        $vehicles = DB::table('vehicles')->pluck('id', 'VIN');

        DB::table('vehicle_photos')->insert([
            [
                'vehicle_id' => $vehicles['1HGCM82633A123456'],
                'photo_path' => 'vehicle_photos/toyota_corolla_1.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => $vehicles['1HGCM82633A123456'],
                'photo_path' => 'vehicle_photos/toyota_corolla_2.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => $vehicles['1HGCM82633A654321'],
                'photo_path' => 'vehicle_photos/honda_civic_1.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => $vehicles['1HGCM82633A654321'],
                'photo_path' => 'vehicle_photos/honda_civic_2.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => $vehicles['1FAFP4041WF123456'],
                'photo_path' => 'vehicle_photos/ford_mustang_1.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => $vehicles['1FAFP4041WF123456'],
                'photo_path' => 'vehicle_photos/ford_mustang_2.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}