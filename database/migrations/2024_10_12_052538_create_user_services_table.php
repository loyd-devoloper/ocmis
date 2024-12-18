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
        Schema::create('user_services', function (Blueprint $table) {
            $table->id()->from(010000000);
            $table->boolean('own_priest');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->unsignedBigInteger('priest_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('message');
            $table->string('deceasedname');
            $table->string('status');
            $table->string('date')->nullable();
            $table->string('price')->nullable();
            $table->string('payment_ref')->nullable();
            $table->string('payment_method');
            $table->text('checkout_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_services');
    }
};
