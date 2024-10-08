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
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->text('testimoni');
            $table->unsignedTinyInteger('penilaian');
            $table->unsignedBigInteger('id_pinjambuku');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_buku');
            $table->foreign('id_pinjambuku')->references('id')->on('pinjambukus')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_buku')->references('id')->on('bukus')->onDelete('cascade');
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
        Schema::dropIfExists('testimonis');
    }
};
