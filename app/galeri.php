<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class galeri extends Model
{
    protected $table = 'galeri';
    protected $fillable = ['id_galeri_kategori','judul','gambar','id_product']; 
}
