<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outcoming;
use App\Models\Shop;
use App\Models\Inventory;

class OutcomingController extends Controller
{
    public function create()
    {
        $inventories = Inventory::all();
        $shops = Shop::all();

        return view('outcoming.create', compact('inventories', 'shops'));
    }

    public function getBarang($jenis)
    {
        $data = Inventory::where('jenis_barang', $jenis)->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|array',
            'inventory_id.*' => 'exists:inventories,id',

            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:1',

            'tujuan' => 'required',
            'tanggal' => 'required|date',

            'shop_id' => 'required_if:tujuan,pengiriman|nullable|exists:shops,id'
        ], [
            'jumlah.*.required' => '*Jumlah barang wajib diisi',
            'jumlah.*.numeric' => '*Jumlah barang keluar tidak valid',
            'jumlah.*.min' => '*Jumlah barang keluar tidak valid',
        ]);

        foreach ($request->inventory_id as $index => $inventoryId) {

            $inventory = Inventory::find($inventoryId);

            if (!$inventory) {
                return back()->withErrors([
                    'inventory_id.' . $index => '*Barang tidak ditemukan'
                ])->withInput();
            }

            $jumlah = $request->jumlah[$index];

            if ($jumlah > $inventory->stok) {
                return back()->withErrors([
                    'jumlah.' . $index => '*Jumlah barang keluar melebihi stok yang tersedia'
                ])->withInput();
            }

            Outcoming::create([
                'inventory_id' => $inventory->id,
                'shop_id' => $request->tujuan == 'pengiriman'
                    ? $request->shop_id
                    : null,

                'tujuan' => $request->tujuan,
                'jumlah' => $jumlah,
                'tanggal' => $request->tanggal
            ]);

            $inventory->stok -= $jumlah;
            $inventory->save();
        }

        return redirect('/transaction')
            ->with('success', 'Data barang keluar berhasil disimpan');
    }
}
