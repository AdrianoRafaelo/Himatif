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
           Schema::create('student_registrations', function (Blueprint $table) {
               $table->id();
               $table->unsignedBigInteger('event_id');
               $table->string('student_name');
               $table->string('username', 20);
               $table->string('email')->nullable();
               $table->string('nim')->nullable();
               $table->string('angkatan')->nullable();
               $table->string('prodi')->nullable();
               $table->string('attendance_status')->default('Belum Dikonfirmasi');
               $table->timestamps();

               // Foreign key constraint
               $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
           });
       }

       /**
        * Reverse the migrations.
        *
        * @return void
        */
       public function down()
       {
           Schema::dropIfExists('student_registrations');
       }
   };