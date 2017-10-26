<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HomeSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_setting', function (Blueprint $table) {
            $table->increments('id');       
            $table->string('name',50);                        
            $table->tinyInteger('status');        
            $table->string('judul',100);        
            $table->integer('posisi');
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
        Schema::drop('home_setting');
    }
}
