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
    public function up()
    {
        Schema::dropIfExists('site_settings');

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('description')->nullable();

        });

        DB::table('site_settings')->insert([
            ['key' => 'favicon', 'value' => '', 'description' => 'Site favicon URL\'i'],
            ['key' => 'logo', 'value' => '', 'description' => 'Site logo URL\'i'],
            ['key' => 'title', 'value' => '', 'description' => 'Site başlığı'],
            ['key' => 'email', 'value' => '', 'description' => 'İletişim için email adresi'],
            ['key' => 'login-form-title', 'value' => '', 'description' => 'Giriş formu başlığı'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
