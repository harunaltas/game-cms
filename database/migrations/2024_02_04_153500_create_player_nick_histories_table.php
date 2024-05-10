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
        Schema::create('player_nick_histories', function (Blueprint $table) {
            $table->id();
            $table->string('gamer_id')->nullable();
            $table->string('new_player_nick')->nullable();
            $table->timestamps();
            $table->foreign('gamer_id')->references('gamer_id')->on('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_nick_historys');
    }
};
