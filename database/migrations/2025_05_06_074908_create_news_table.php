<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();  // Kolom ID auto increment
            $table->string('title');  // Kolom untuk judul berita
            $table->text('content');  // Kolom untuk konten berita
            $table->string('image')->nullable();  // Kolom untuk gambar (nullable, karena tidak semua berita mungkin memiliki gambar)
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
