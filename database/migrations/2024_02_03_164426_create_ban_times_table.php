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
        Schema::create('ban_times', function (Blueprint $table) {
            $table->id();
            $table->string('title');

        });
        
        DB::table('ban_times')->insert([
            [
                'title' => '1',
            ],
            [
                'title' => '3',
            ],
            [
                'title' => '5',
            ],
            [
                'title' => '7',
            ],
            [
                'title' => 'Süresiz',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ban_times');
    }
};
