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
        Schema::create('pinjambukus', function (Blueprint $table) {
            $table->id();
            $table->string('jumlah');
            $table->string('pesan')->nullable();
            $table->date('tanggal_pinjambuku');
            $table->date('tanggal_kembali');
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak', 'menunggu pengembalian', 'dikembalikan', 'pengembalian ditolak', 'dibatalkan'])->default('menunggu');
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_buku')->references('id')->on('bukus')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('pinjambukus');
    }
};
