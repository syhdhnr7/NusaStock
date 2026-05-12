<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
    protected $table = 'incomings';

    protected $fillable = [
        'inventory_id',
        'jumlah',
        'tanggal'
    ];
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
