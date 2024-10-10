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
        Schema::create('priest_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('priest_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priest_schedules');
    }
};
