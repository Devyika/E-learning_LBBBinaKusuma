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
        Schema::create('jurusan_tingkat_kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('jurusan_id');
            $table->unsignedInteger('tingkat_id');
            $table->unsignedInteger('kelas_id');
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
        Schema::dropIfExists('jurusan_tingkat_kelas');
    }
};
