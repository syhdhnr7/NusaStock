<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';

    protected $fillable = [
        'nama_toko',
        'alamat'
    ];

    public function outcomings()
    {
        return $this->hasMany(Outcoming::class);
    }
}
