<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampusStudentsTable extends Migration
{
    /**
     * Menjalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('campus_students')) {
            Schema::create('campus_students', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('dim_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('user_name')->nullable();
                $table->string('nim')->unique();
                $table->string('nama');
                $table->string('email')->nullable();
                $table->unsignedBigInteger('prodi_id')->nullable();
                $table->string('prodi_name');
                $table->string('fakultas')->nullable();
                $table->integer('angkatan');
                $table->string('status')->default('Aktif');
                $table->string('asrama')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Membatalkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campus_students');
    }
}