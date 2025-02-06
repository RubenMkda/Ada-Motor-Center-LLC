<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('make', 100);
            $table->string('model', 100);
            $table->year('year');
            $table->decimal('price', 12, 2);
            $table->string('VIN', 17)->unique();
            $table->enum('status', ['disponible', 'vendido', 'reservado'])->default('disponible');
            $table->timestamps();
            $table->softDeletes();
            $table->index('make');
            $table->index('model');
            $table->index('year');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
