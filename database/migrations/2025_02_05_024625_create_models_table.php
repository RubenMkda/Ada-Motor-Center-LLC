<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('make_id')->constrained('makes')->onDelete('cascade');
            $table->string('name', 100);
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['make_id', 'name']); 
            $table->index(['make_id', 'deleted_at']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
