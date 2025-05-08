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
    Schema::create('local_users', function (Blueprint $table) {
        $table->id();
        $table->string('username')->unique();
        $table->string('nama')->nullable();
        $table->string('nim')->nullable();
        $table->string('angkatan')->nullable();
        $table->string('prodi')->nullable();
        $table->string('role')->nullable(); // contoh: admin, mahasiswa, bendahara
        $table->rememberToken(); // << tambah ini jika pakai login
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
        // Drop table yang punya foreign key ke local_users terlebih dahulu
        Schema::dropIfExists('prokers'); // Contoh
        Schema::dropIfExists('bphs');
    }
    
};
