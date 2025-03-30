<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('make_id')->constrained('makes')->onDelete('cascade'); 
            $table->foreignId('model_id')->constrained('models')->onDelete('cascade'); 
            $table->year('year');
            $table->decimal('price', 12, 2);
            $table->string('VIN', 17)->unique();
            $table->enum('status', ['disponible', 'vendido', 'reservado'])->default('disponible');
            $table->string('stripe_price_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('year');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};