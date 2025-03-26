<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->enum('applicable_to', ['dealer', 'broker', 'ambos']);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps(0);  
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
};
