<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class administrator extends Model
{
    protected $table = 'administrators';
    protected $fillable = ['name','username','password'];
}
