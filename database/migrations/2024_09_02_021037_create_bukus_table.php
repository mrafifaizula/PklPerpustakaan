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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tahun_terbit');
            $table->integer('jumlah_buku');
            $table->string('image_buku');
            $table->string('desc_buku');
            $table->string('code_buku');
            $table->decimal('harga', 8, 2);
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_penulis');
            $table->unsignedBigInteger('id_penerbit');
            $table->foreign('id_kategori')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('id_penulis')->references('id')->on('penulis')->onDelete('cascade');
            $table->foreign('id_penerbit')->references('id')->on('penerbits')->onDelete('cascade');
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
        Schema::dropIfExists('bukus');
    }
};
