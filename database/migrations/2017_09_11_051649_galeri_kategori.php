<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GaleriKategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galeri_kategori', function (Blueprint $table) {
            $table->increments('id');                   
            $table->string('judul', 100);
            $table->string('gambar', 100);
            $table->tinyInteger('status');
            $table->string('seo_judul', 100);
            $table->string('seo_kata_kunci', 100);
            $table->text('seo_deskripsi');
            $table->string('slug', 100);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('galeri_kategori');
    }
}
