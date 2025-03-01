<?php

namespace App\Models;

use App\Events\CatalogChanged;
use Illuminate\Database\Eloquent\Model;
use App\Models\History;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContracts;
use OwenIt\Auditing\Auditable;

class Catalog extends Model implements AuditableContracts
{
    use HasFactory, Auditable;
    // 
    protected $fillable = [
        'id',
        'nama_katalog',
        'deskripsi',
        'stok',
        'tipe_bahan',
        'jenis_katalog',
        'harga',
        'gambar'
    ];
   
   
}
