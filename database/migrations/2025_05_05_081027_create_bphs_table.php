<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBphsTable extends Migration
{
    public function up()
    {
        Schema::create('bphs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('local_users')->onDelete('cascade');
            $table->string('position'); // Ketua, Wakil, Kepala Divisi, Bendahara, dll.
            $table->string('period'); // Misalnya: 2025-2026
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bphs');
    }
}