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
        Schema::create('niche_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('niche_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('status');
            $table->string('price');
            $table->string('date')->nullable();
            $table->string('date_paid')->nullable();
            $table->string('payment_ref')->nullable();
            $table->text('checkout_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niche_installments');
    }
};
