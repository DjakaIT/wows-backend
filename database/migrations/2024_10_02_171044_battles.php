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
        Schema::create('battles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('battle_id')->unique();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->timestamp('battle_date');
            $table->integer('duration');
            $table->string('map_name', 255);
            $table->boolean('victory');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battles');
    }
};
