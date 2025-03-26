<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auction_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_id'); 
            $table->string('image_path'); 
            $table->integer('order')->default(0);
            $table->timestamps(); 

            $table->foreign('auction_id')
                  ->references('id')
                  ->on('auctions')
                  ->onDelete('cascade'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_images');
    }
};