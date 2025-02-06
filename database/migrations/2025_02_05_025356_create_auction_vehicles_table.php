<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('auction_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('auction_id')->constrained()->onDelete('cascade');
            $table->string('VIN', 17);
            $table->enum('status', ['pendiente', 'en_proceso', 'comprado'])->default('pendiente');
            $table->timestamps(0);  
            $table->softDeletes(); 

            // Add index to VIN column
            $table->index('VIN');
        });
    }

    public function down()
    {
        Schema::dropIfExists('auction_vehicles');
    }
};
