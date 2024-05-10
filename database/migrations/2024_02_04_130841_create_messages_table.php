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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Kullanıcı ID'si
            $table->unsignedBigInteger('player_id'); // Oyuncu ID'si
            $table->string('gamer_id')->nullable();
            $table->text('message')->nullable(); // Mesaj içeriği
            $table->string('status')->nullable()->default(1); // Mesaj içeriği
            $table->string('date')->nullable(); 

            // users tablosundaki id'ye referans olan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // players tablosundaki id'ye referans olan foreign key
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
