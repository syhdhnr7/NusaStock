<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{

    private function mapFolder($jenis)
    {
        return match ($jenis) {
            'bahan_baku' => 'bahanbaku',
            'produk_jadi' => 'produkjadi',
            'kemasan' => 'kemasan',
            default => abort(404)
        };
    }
    // =========================== INDEX ==============================

    public function bahanBaku()
    {
        $data = Inventory::where('jenis_barang', 'bahan_baku')->get();
        return view('inventory.bahanbaku.index', compact('data'));
    }

    public function kemasan()
    {
        $data = Inventory::where('jenis_barang', 'kemasan')->get();
        return view('inventory.kemasan.index', compact('data'));
    }

    public function produkJadi()
    {
        $data = Inventory::where('jenis_barang', 'produk_jadi')->get();
        return view('inventory.produkjadi.index', compact('data'));
    }

    // =========================== INDEX ==============================

    public function index($jenis)
    {
        // mapping jenis ke folder
        if ($jenis == 'bahan_baku') {
            $folder = 'bahanbaku';
        } elseif ($jenis == 'kemasan') {
            $folder = 'kemasan';
        } else {
            $folder = 'produkjadi';
        }

        $data = Inventory::where('jenis_barang', $jenis)->get();

        return view("inventory.$folder.index", compact('data'));
    }

    // =========================== CREATE ==============================

    public function create()
    {
        return view("inventory.create");
    }

    public function store(Request $request)
    {
        // Tentukan satuan otomatis
        $satuan = $request->jenis_barang === 'bahan_baku' ? 'kg' : 'pcs';

        // VALIDASI
        $request->validate([
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'stok' => 'required|integer|min:0',
            'batas_minimum' => 'required|integer|min:0',
            'batas_maksimum' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('gambar', 'public');
        }

        Inventory::create([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'stok' => $request->stok,
            'satuan' => $satuan,
            'batas_minimum' => $request->batas_minimum,
            'batas_maksimum' => $request->batas_maksimum,
            'gambar' => $path
        ]);

        return redirect('/inventory/type/' . $request->jenis_barang)
            ->with('success', 'Data berhasil ditambahkan');
    }

    // =========================== EDIT ==============================

    public function edit($id)
    {
        $item = Inventory::findOrFail($id);

        $folder = $this->mapFolder($item->jenis_barang);

        return view("inventory.edit", compact('item'));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $path = $inventory->gambar;

        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            if ($inventory->gambar && Storage::exists('public/' . $inventory->gambar)) {
                Storage::delete('public/' . $inventory->gambar);
            }

            $path = $request->file('gambar')->store('gambar', 'public');
        }


        $inventory->update([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'stok' => $request->stok,
            'batas_minimum' => $request->batas_minimum,
            'batas_maksimum' => $request->batas_maksimum,
            'gambar' => $path
        ]);

        return redirect('/inventory/type/' . $request->jenis_barang)
            ->with('success', 'Data berhasil diperbarui');
    }

    // =========================== DELETE ==============================

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $jenis = $inventory->jenis_barang;

        $inventory->delete();

        return redirect('/inventory/type/' . $jenis)
            ->with('success', 'Data berhasil dihapus');
    }
}
