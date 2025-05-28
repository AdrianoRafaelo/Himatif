<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proker_id');
            $table->unsignedBigInteger('proposal_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'completed', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('angkatan_akses')->nullable();
            $table->timestamps();
            
            $table->foreign('proker_id')->references('id')->on('prokers')->onDelete('cascade');
            $table->foreign('proposal_id')->references('id')->on('proposals')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};