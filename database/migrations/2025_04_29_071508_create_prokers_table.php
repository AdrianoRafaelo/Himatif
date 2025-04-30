<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prokers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by'); // relasi ke local_users

            $table->string('subject');           // perihal
            $table->text('description')->nullable();     // deskripsi
            $table->text('objective')->nullable();       // tujuan
            $table->string('location')->nullable();      // lokasi
            $table->date('planned_date')->nullable();    // rencana_tanggal
            $table->date('actual_date')->nullable();     // realisasi_tanggal
            $table->string('funding_source')->nullable(); // sumber_dana
            $table->decimal('planned_budget', 15, 2)->nullable(); // rencana_biaya
            $table->decimal('actual_budget', 15, 2)->nullable();  // realisasi_biaya
            $table->string('status')->nullable();         // status (ex: 'pending', 'approved')
            $table->string('period')->nullable();         // periode (ex: '2024/2025')

            $table->timestamps();

            // Relasi ke local_users
            $table->foreign('created_by')->references('id')->on('local_users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prokers');
    }
};
