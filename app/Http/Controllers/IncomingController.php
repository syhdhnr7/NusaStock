<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incoming;
use App\Models\Inventory;

class IncomingController extends Controller
{

    public function index()
    {
        $inventories = Inventory::all();
        $incomings = Incoming::all();

        return view('incoming.index', compact('inventories', 'incomings'));
    }

    public function getBarang($jenis)
    {
        $barang = Inventory::where('jenis_barang', $jenis)->get();

        return response()->json($barang);
    }
    public function create()
    {
        $inventories = Inventory::all();
        return view('incoming.create', compact('inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah.*' => 'required|numeric|min:1',
        ], [
            'jumlah.*.required' => '*Jumlah barang wajib diisi',
            'jumlah.*.numeric' => '*Jumlah barang masuk tidak valid',
            'jumlah.*.min' => '*Jumlah barang masuk tidak valid',
        ]);

        foreach ($request->barang_id as $index => $barangId) {

            $jumlah = $request->jumlah[$index];
            $barang = Inventory::find($barangId);

            if ($barang) {

                Incoming::create([
                    'inventory_id' => $barang->id,
                    'jumlah' => $jumlah,
                    'tanggal' => $request->tanggal
                ]);

                $barang->stok += $jumlah;
                $barang->save();
            }
        }

        return redirect('/transaction')->with('success', 'Data barang masuk berhasil disimpan');
    }
}
