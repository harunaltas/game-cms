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
        Schema::create('ban_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');

        });
        DB::table('ban_types')->insert([
            [
                'title' => 'Oda Kurma Banı',
            ],
            [
                'title' => 'Sohbet Banı',
            ],
            [
                'title' => 'Oyun Banı',
            ],
            [
                'title' => 'Server Banı',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ban_types');
    }
};
