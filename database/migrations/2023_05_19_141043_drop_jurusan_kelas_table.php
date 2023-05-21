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
        Schema::dropIfExists('jurusan_kelas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('jurusan_tingkat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_jurusan');
            $table->unsignedBigInteger('id_kelas');
            // Kolom-kolom lainnya

            $table->index('id_jurusan');

            // Menambahkan foreign key constraint
            $table->foreign('id_jurusan')->references('id')->on('jurusan');
            $table->foreign('id_kelas')->references('id')->on('kelas');
        });
    }
};
