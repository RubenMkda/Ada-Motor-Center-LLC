<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); 
            $table->string('url', 255)->nullable(); 
            $table->text('description')->nullable();
            $table->decimal('starting_price', 12, 2); 
            $table->decimal('current_price', 12, 2)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable(); 
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->string('reserve_fee_stripe_price_id')->unique(); 
            $table->string('vehicle_price_stripe_price_id')->unique();
            $table->decimal('reserve_fee', 12, 2)->default(500.00);
            $table->decimal('vehicle_price', 12, 2); 
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};