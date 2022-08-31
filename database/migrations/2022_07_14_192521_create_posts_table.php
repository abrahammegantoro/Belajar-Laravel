<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id'); // foreign key yg connect ke table lain, dengan nama function_id, nanti laravel otomatis cari tables mana yang terconnect
            $table->foreignId('user_id');
            $table->string('title');
            $table->string('slug')->unique(); // unique = gaboleh sama satu sama lain
            $table->string('image')->nullable();
            $table->text('excerpt'); // Biasa di web ada tulisan more buat liat lebih detail, nah text sebagian yang ditunjukkin namanya excerpt
            $table->text('body');
            $table->timestamp('published_at')->nullable(); // nullable artinya boleh kosong
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
