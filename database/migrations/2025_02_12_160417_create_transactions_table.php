<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); 
            $table->decimal('amount', 12, 2); 
            $table->enum('type', ['deposit', 'final_payment']); 
            $table->enum('status', ['pending', 'completed', 'refunded'])->default('pending'); 
            $table->string('payment_method', 50); 
            $table->timestamp('transaction_date')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes();

            $table->index('order_id');
            $table->index(['type', 'status']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
