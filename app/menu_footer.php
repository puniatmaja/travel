<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menu_footer extends Model
{
    protected $table = 'menu_footer';
    protected $fillable = ['judul','link'];
}
