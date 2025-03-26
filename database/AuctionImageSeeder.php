<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\AuctionImage;
use Illuminate\Support\Facades\DB;

class AuctionImageSeeder extends Seeder
{
    public function run()
    {
        $auctions = Auction::all();

        if ($auctions->isEmpty()) {
            $this->command->info('No hay subastas disponibles. Primero ejecuta el AuctionSeeder.');
            return;
        }

        $images = [
            [
                'image_path' => 'vehicle_photos/toyota_corolla_2.png',
                'order' => 1,
            ],
            [
                'image_path' => 'vehicle_photos/honda_civic_1.png',
                'order' => 1,
            ],
            [
                'image_path' => 'vehicle_photos/ford_mustang_1.png',
                'order' => 1,
            ],
        ];

        foreach ($auctions as $index => $auction) {
            AuctionImage::create([
                'auction_id' => $auction->id,
                'image_path' => $images[$index]['image_path'],
                'order' => $images[$index]['order'],
            ]);
        }

        $this->command->info('Imágenes de subastas insertadas correctamente.');
    }
}