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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question')->nullable();

        });
        DB::table('questions')->insert([
            [
                'question' => 'Favori İçeceğiniz Nedir ?',
            ],
            [
                'question' => 'Telefon Numaranızın Son Dört Hanesi Nedir ?',
            ],
            [
                'question' => 'Bilgisayarınızın Markası Nedir ?',
            ],
            [
                'question' => 'En Sevdiğiniz Renk Nedir ? ',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
