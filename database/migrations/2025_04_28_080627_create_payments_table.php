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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->string('nama');
            $table->string('angkatan');
            $table->string('prodi');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->date('tanggal_bayar');
            $table->timestamps();
            $table->unique(['nim', 'bulan', 'tahun'], 'payments_nim_bulan_tahun_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};