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
            $table->decimal('broker_fee', 8, 2)->nullable();
            $table->enum('status', ['pendiente', 'completado', 'cancelado'])->default('pendiente');
            $table->timestamps(0);  // This will create created_at and updated_at columns.
            $table->softDeletes();  // This adds deleted_at column for soft deletes.

            // Add indexes
            $table->index('user_id');
            $table->index('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
