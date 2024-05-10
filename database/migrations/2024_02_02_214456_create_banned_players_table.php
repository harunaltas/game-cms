<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('banned_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('player_id')->nullable()->constrained('players')->onDelete('cascade');
            $table->string('gamer_id')->nullable();
            $table->string('ban_type_id')->nullable()->constrained('ban_types')->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('ban_image')->nullable();
            $table->string('ban_time_id')->nullable()->constrained('ban_times')->onDelete('set null');;
            $table->string('banned_date')->nullable();
            $table->boolean('status')->nullable()->default(true);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banned_players');
    }
};
