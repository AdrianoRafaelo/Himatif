<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proker_id');      // relasi ke tabel prokers
            $table->string('title');                      // judul proposal
            $table->text('description')->nullable();      // deskripsi proposal
            $table->string('file_path');                  // path file proposal (pdf/word)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // status
            $table->timestamp('sent_at')->nullable();     // waktu pengiriman
            $table->timestamp('reviewed_at')->nullable(); // waktu disetujui atau ditolak

            $table->timestamps();

            // Foreign keys
            $table->foreign('proker_id')->references('id')->on('prokers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
