<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        return view('shop/index', [
            "shops" => $shops
        ]);
    }

    public function create()
    {
        return view('shop.create');
    }
    public function store(Request $request)
    {
        // validasi data
        $request->validate([
            'nama_toko' => 'required',
            'alamat' => 'required'
        ]);

        // create data
        Shop::create([
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat
        ]);

        return redirect('/shop')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return view('shop.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_toko' => 'required',
            'alamat' => 'required'
        ]);

        $shop = shop::findOrFail($id);

        $shop->update([
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat
        ]);

        return redirect('/shop')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $shop = shop::findOrFail($id);
        $shop->delete();

        return redirect('/shop')->with('success', 'Data berhasil dihapus');
    }
}
