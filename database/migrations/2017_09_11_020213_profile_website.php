<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProfileWebsite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('profile_website', function (Blueprint $table) {
            $table->increments('id');                   
            $table->string('judul', 100);
            $table->text('deskripsi');
            $table->string('logo', 100);
            $table->string('gambar', 100);
            $table->string('email', 100);            
            $table->text('alamat');
            $table->string('seo_judul', 100);
            $table->string('seo_kata_kunci', 100);
            $table->text('seo_deskripsi');
            $table->string('google_webmaster', 225);
            $table->text('google_analytics');
            $table->text('facebook_pixel');
            $table->text('tripadvisor'); 
            $table->text('map');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profile_website');
    }
}
