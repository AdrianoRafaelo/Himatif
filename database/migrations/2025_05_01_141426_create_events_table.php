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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proker_id');      // relasi ke proker (wajib)
            $table->unsignedBigInteger('proposal_id')->nullable(); // relasi ke proposal (opsional)
            
            // Informasi dasar event
            $table->string('name');                      // nama event
            $table->text('description')->nullable();     // deskripsi
            $table->string('location');                  // lokasi
            $table->dateTime('start_date');              // tanggal mulai
            $table->dateTime('end_date');                // tanggal selesai
            
            // Status event
            $table->enum('status', ['draft', 'scheduled', 'completed', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();           // catatan
            
            // Foto event (banner/cover)
            $table->string('banner_path')->nullable();   // path foto utama
            
            $table->timestamps();
        
            // Foreign keys
            $table->foreign('proker_id')->references('id')->on('prokers')->onDelete('cascade');
            $table->foreign('proposal_id')->references('id')->on('proposals')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
