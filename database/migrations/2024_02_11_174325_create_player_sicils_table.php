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
        Schema::create('player_sicils', function (Blueprint $table) {
            $table->id();
            $table->string('gamer_id');
            $table->string('admin');
            $table->string('gamer_name');
            $table->string('warning_message');
            $table->string('status'); // Uyarı ise uyarı yazılacak
            $table->string('sicil_date');
            $table->string('ban_time'); // Uyarıysa süresiz
            $table->string('info'); //1 uyarı 3 ban
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_sicils');
    }
};
