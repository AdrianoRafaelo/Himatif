<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('nim'); // Kolom untuk NIM mahasiswa
            $table->string('message');
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('created_by')->nullable(); // Foreign key ke local_users
            $table->foreign('created_by')->references('id')->on('local_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};