<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('nis')->primary();
            $table->string('nama');
            $table->string('id_kelas')->nullable();
            // $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->string('password');
            $table->ipAddress('ip')->nullable();
            $table->longText('wajah')->nullable();
        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
