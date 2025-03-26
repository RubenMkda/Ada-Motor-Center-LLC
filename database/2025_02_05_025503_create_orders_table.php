<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['dealer', 'broker']);
            $table->foreignId('vehicle_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('auction_vehicle_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['pendiente', 'completado', 'cancelado'])->default('pendiente');
            $table->timestamps(0); 
            $table->softDeletes();  

            $table->index('user_id');
            $table->index('type');
        });

        Schema::create('broker_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('broker_fee', 8, 2);
            $table->timestamps(0); 
            $table->softDeletes();
            $table->index('order_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('broker_fees');
        Schema::dropIfExists('orders');
    }
};

