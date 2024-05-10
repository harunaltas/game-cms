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
        Schema::create('warning_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('player_id')->nullable()->constrained('players')->onDelete('set null');
            $table->string('gamer_id')->nullable();
            $table->text('description')->nullable();
            $table->string('warning_image')->nullable();
            $table->string('status')->nullable()->default("1"); //1se gönderildi. 2 ise okundu.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warning_players');
    }
};
