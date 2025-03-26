<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transport_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->text('pickup_address');
            $table->text('delivery_address');
            $table->dateTime('scheduled_date');
            $table->enum('status', ['pendiente', 'en_transito', 'completado'])->default('pendiente');
            $table->timestamps(0);  
            $table->softDeletes();

            $table->index('order_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transport_services');
    }
};
