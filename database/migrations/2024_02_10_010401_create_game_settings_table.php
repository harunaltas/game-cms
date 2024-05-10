<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->boolean('is_active')->default(1)->nullable();

        });
        DB::table('game_settings')->insert([
            [
                'title' => 'Genel Duyuru',
                'text' => 'Duyuru',
            ],
            [
                'title' => 'Oyun Bakım Modu',
                'text' => 'Oyun Bakım Modu',
            ],
            [
                'title' => 'Server Bakım Modu',
                'text' => 'Server Bakım Modu',

            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_settings');
    }
};
