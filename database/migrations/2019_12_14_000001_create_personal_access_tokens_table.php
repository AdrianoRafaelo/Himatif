<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    public function up()
    {
        Schema::create('local_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('nama');
            $table->string('nim')->nullable();
            $table->string('angkatan')->nullable();
            $table->string('prodi')->nullable();
            $table->string('role')->default('mahasiswa'); // role default mahasiswa
            $table->string('password')->nullable(); // jika ada password lokal (optional)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('local_users');
    }
}

