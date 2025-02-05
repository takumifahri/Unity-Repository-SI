<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    // 
    protected $fillable = [
        'catalog_id',
        'nama_katalog',
        'deskripsi',
        'tipe_bahan',
        'jenis_katalog',
        'harga',
        'gambar'
    ];
}
