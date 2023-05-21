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
        Schema::table('mapel', function (Blueprint $table) {
            $table->dropColumn('jurusan');
            $table->dropColumn('deskripsi');
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mapel', function (Blueprint $table) {
            $table->string('jurusan', 50)->collation('utf8mb4_unicode_ci');
            $table->string('deskripsi', 255)->collation('utf8mb4_unicode_ci');
            $table->bigInteger('user_id');
        });
    }
};
