<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcoming extends Model
{
    protected $table = 'outcomings';

    protected $fillable = [
        'inventory_id',
        'shop_id',
        'tujuan',
        'jumlah',
        'tanggal'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
