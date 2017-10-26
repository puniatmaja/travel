<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sosial_media extends Model
{
    protected $table = 'social_media';
    protected $fillable = ['judul','link','gambar'];
}
