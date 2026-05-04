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
        // Validasi
        $request->validate([
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:inventories,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:1',
            'tujuan' => 'required',
            'tanggal' => 'required|date',
            'shop_id' => 'required_if:tujuan,pengiriman|nullable|exists:shops,id'
        ]);

        foreach ($request->barang_id as $index => $barangId) {

            $jumlah = $request->jumlah[$index];

            $barang = Inventory::findOrFail($barangId);

            // CEK DULU (sebelum dikurangi)
            if ($barang->stok < $jumlah) {
                return back()->with('error', 'Stok tidak cukup untuk ' . $barang->nama_barang);
            }

            // Simpan transaksi
            Outcoming::create([
                'inventory_id' => $barangId,
                'shop_id' => $request->tujuan == 'pengiriman' ? $request->shop_id : null,
                'tujuan' => $request->tujuan,
                'jumlah' => $jumlah,
                'tanggal' => $request->tanggal
            ]);

            // Kurangi stok (HANYA SEKALI)
            $barang->stok -= $jumlah;
            $barang->save();
        }

        return redirect('/transaction')->with('success', 'Data berhasil disimpan');
    }
}
