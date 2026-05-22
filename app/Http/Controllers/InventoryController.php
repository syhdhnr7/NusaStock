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

    public function index(Request $request, $jenis)
    {
        $folder = $this->mapFolder($jenis);

        $search = $request->search;

        $data = Inventory::where('jenis_barang', $jenis)
            ->when($search, function ($query, $search) {
                return $query->where('nama_barang', 'like', '%' . $search . '%');
            })
            ->get();

        if ($search && $data->isEmpty()) {
            return back()->with('error', 'Data produk tidak ditemukan');
        }

        return view("inventory.$folder.index", compact('data'));
    }

    // =========================== CREATE ==============================

    public function create()
    {
        return view("inventory.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|unique:inventories,nama_barang',
        ], [
            'nama_barang.unique' => '*Nama barang sudah terdaftar.',
        ]);

        $satuan = $request->jenis_barang === 'bahan_baku' ? 'kg' : 'pcs';

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

            $request->validate([
                'gambar' => 'image|mimes:jpg,jpeg,png|max:5120'
            ]);
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
