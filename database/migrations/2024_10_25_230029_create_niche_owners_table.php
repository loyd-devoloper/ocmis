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
        Schema::create('niche_owners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('niche_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('lname');
            $table->string('fname');
            $table->string('birthdate');
            $table->string('deathdate');
            $table->string('message');
            $table->text('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niche_owners');
    }
};
