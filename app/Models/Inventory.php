<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'jenis_barang',
        'stok',
        'satuan',
        'batas_minimum',
        'batas_maksimum',
        'gambar',
    ];

    public function incoming()
    {
        return $this->hasMany(Incoming::class);
    }

    public function outcoming()
    {
        return $this->hasMany(Outcoming::class);
    }

    public function isLowStock()
    {
        return $this->stok <= $this->batas_minimum;
    }

    public function isHighStock()
    {
        return $this->stok >= $this->batas_maksimum;
    }
}
