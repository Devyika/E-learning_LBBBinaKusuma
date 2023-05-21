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
        Schema::create('kelas_mapel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jurusanTingkatKelas');
            $table->unsignedBigInteger('id_mapel');
            $table->foreign('id_jurusanTingkatKelas')->references('id')->on('jurusan_tingkat_kelas');
            $table->foreign('id_mapel')->references('id')->on('mapel');
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
        Schema::dropIfExists('kelas_mapel');
    }
};
