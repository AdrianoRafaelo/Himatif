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
            $table->string('position'); 
            $table->string('period'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bphs');
    }
}