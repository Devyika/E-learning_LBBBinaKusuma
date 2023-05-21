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
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jurusanTingkatKelas');
            $table->unsignedBigInteger('id_siswa');
            $table->foreign('id_jurusanTingkatKelas')->references('id')->on('jurusan_tingkat_kelas');
            $table->foreign('id_siswa')->references('id')->on('siswa');
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
        Schema::dropIfExists('kelas_siswa');
    }
};
