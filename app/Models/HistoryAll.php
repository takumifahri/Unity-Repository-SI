<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryAll extends Model
{
    //
    protected $table = 'history_alls';
    protected $fillable = [
        'items_id',
        'user_id',
        'new_value',
        'old_value',
        'reason',
        'deleted_at',
        'updated_at',
        'created_at'
    ];
    public function item()
    {
        return $this->morphTo();
    }
}
