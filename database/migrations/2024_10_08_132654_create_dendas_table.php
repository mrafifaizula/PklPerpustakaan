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
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->decimal('jumlah_denda', 10, 2);
            $table->string('jenis_denda');
            $table->boolean('status_dibayar')->default(false);
            $table->unsignedBigInteger('id_pinjmabuku');
            $table->foreign('id_pinjmabuku')->references('id')->on('pinjambukus')->onDelete('cascade');
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
        Schema::dropIfExists('dendas');
    }
};
