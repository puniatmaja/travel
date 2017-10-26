<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->increments('id');       
            $table->integer('id_parent');
            $table->string('judul', 100);
            $table->string('seo_judul', 100);
            $table->string('seo_kata_kunci', 100);
            $table->text('seo_deskripsi');
            $table->string('slug', 100);
            $table->string('gambar', 100);    
            $table->tinyInteger('status');             
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
        Schema::drop('kategori');
    }
}
