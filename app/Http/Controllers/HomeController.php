<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $inventories = Inventory::all();

        // stok kosong
        $stokKosong = Inventory::where('stok', 0)->get();

        // stok mencapai batas minimum (<= batas_minimum tapi masih ada stok)
        $stokMinimum = Inventory::whereColumn('stok', '<=', 'batas_minimum')
            ->where('stok', '>', 0)
            ->get();

        $stokMaksimum = Inventory::whereColumn('stok', '>', 'batas_maksimum')
            ->get();

        $produkJadi = Inventory::where('jenis_barang', 'produk_jadi')->get();
        $bahanBaku  = Inventory::where('jenis_barang', 'bahan_baku')->get();
        $kemasan    = Inventory::where('jenis_barang', 'kemasan')->get();

        $totalProdukJadi = Inventory::where('jenis_barang', 'produk_jadi')->sum('stok');
        $totalBahanBaku  = Inventory::where('jenis_barang', 'bahan_baku')->sum('stok');
        $totalKemasan    = Inventory::where('jenis_barang', 'kemasan')->sum('stok');

        return view('home', compact('stokKosong', 'stokMinimum', 'stokMaksimum', 'produkJadi', 'bahanBaku', 'kemasan', 'totalProdukJadi', 'totalBahanBaku', 'totalKemasan'));
    }
}
