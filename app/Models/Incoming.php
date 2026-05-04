<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
    protected $table = 'incomings';

    protected $fillable = [
        'jenis_barang',
        'nama_barang',
        'jumlah',
        'tanggal'
    ];
}