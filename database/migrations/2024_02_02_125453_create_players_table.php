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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('gamer_id')->unique();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('player_nick')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('security_question')->nullable();
            $table->string('security_answer')->nullable();
            $table->string('nick_update_dates')->nullable();
            $table->string('last_login_dates')->nullable();
            $table->string('pc_user_info')->nullable();
            $table->string('exception')->nullable()->default(3);
            $table->string('updated_name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
