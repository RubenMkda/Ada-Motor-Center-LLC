<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transport_rates', function (Blueprint $table) {
            $table->id();
            $table->string('origin', 100);
            $table->string('destination', 100);
            $table->decimal('rate', 8, 2);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['origin', 'destination']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_rates');
    }
};
