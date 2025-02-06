<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->enum('discount_type', ['porcentaje', 'monto_fijo']);
            $table->decimal('amount', 8, 2);
            $table->enum('applicable_to', ['dealer', 'broker', 'ambos']);
            $table->date('valid_from');
            $table->date('valid_until');
            $table->timestamps(0);  // This will create created_at and updated_at columns.
            $table->softDeletes();  // This adds deleted_at column for soft deletes.

            // Add index to code column
            $table->index('code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
