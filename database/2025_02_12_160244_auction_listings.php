<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auction_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_vehicle_id')->constrained('auction_vehicles')->onDelete('cascade');
            $table->string('lot_number', 50);
            $table->decimal('estimated_price', 12, 2);
            $table->decimal('auction_fee', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_listings');
    }
};
