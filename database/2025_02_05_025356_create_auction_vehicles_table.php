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
            $table->enum('status', ['pendiente', 'en_revision', 'aprobado', 'ganado', 'no_ganado', 'pagado', 'enviado'])->default('pendiente');
            $table->timestamps(0);  
            $table->softDeletes(); 

        });
    }

    public function down()
    {
        Schema::dropIfExists('auction_vehicles');
    }
};
