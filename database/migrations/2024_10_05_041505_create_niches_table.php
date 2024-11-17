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
        Schema::create('niches', function (Blueprint $table) {
            $table->id()->from(010000000);
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->string('niche_number');
            $table->text('description');
            $table->string('capacity');
            $table->string('status')->default('Available');
            $table->string('status_payment');
            $table->string('level');
            $table->string('price');
            $table->string('price_checkout')->nullable();
            $table->string('total_paid')->nullable();
            $table->json('service')->nullable();
            $table->json('products')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_ref')->nullable();
            $table->string('plan')->nullable();
            $table->text('checkout_url')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niches');
    }
};
