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
        Schema::create('memorials', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method');
            $table->string('payment_ref')->nullable();
            $table->text('checkout_url')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('message')->nullable();;
            $table->string('deceased_name');
            $table->datetime('date_time')->nullable();
            $table->string('password')->nullable();
            $table->string('status')->nullable();
            $table->text('link')->nullable();
            $table->text('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorials');
    }
};
