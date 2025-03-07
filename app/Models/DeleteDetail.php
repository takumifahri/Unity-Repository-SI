<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteDetail extends Model
{
    //
    protected $table = 'detail_deletes';
    protected $fillable = ['reason', 'catalog_id', 'nama_katalog', 'deskripsi'];
    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }
}
