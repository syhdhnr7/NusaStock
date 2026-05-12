<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incoming;
use App\Models\Outcoming;

class TransactionController extends Controller
{
    public function index(Request $request)
    {

        $incomings = collect(
            Incoming::with('inventory')->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'incoming',
                    'jenis_transaksi' => 'masuk',
                    'jenis_barang' => $item->inventory->jenis_barang ?? '-',
                    'nama_barang' => $item->inventory->nama_barang ?? '-',
                    'tujuan' => '-',
                    'nama_toko' => '-',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->inventory->satuan ?? '-',
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                ];
            })
        );

        $outcomings = collect(
            Outcoming::with(['inventory', 'shop'])->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'outcoming',
                    'jenis_transaksi' => 'keluar',
                    'jenis_barang' => $item->inventory->jenis_barang ?? '-',
                    'nama_barang' => $item->inventory->nama_barang ?? '-',
                    'tujuan' => $item->tujuan,
                    'nama_toko' => $item->shop->nama_toko ?? '-',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->inventory->satuan ?? '-',
                    'tanggal' => $item->tanggal,
                    'created_at' => $item->created_at,
                ];
            })
        );

        $transactions = $incomings->merge($outcomings)
            ->sortByDesc(function ($item) {
                return $item['created_at'] . '-' . $item['id'];
            });

        // Filter jenis
        if ($request->filled('type')) {
            $transactions = $transactions->where('jenis_transaksi', $request->type);
        }

        // Filter bulan
        if ($request->filled('month')) {
            $transactions = $transactions->filter(function ($item) use ($request) {
                return date('m', strtotime($item['tanggal'])) == $request->month;
            });
        }

        return view('transaction.index', compact('transactions'));
    }

    public function destroy($type, $id)
    {
        if ($type == 'incoming') {
            Incoming::findOrFail($id)->delete();
        } elseif ($type == 'outcoming') {
            Outcoming::findOrFail($id)->delete();
        }

        return back()->with('success', 'Data berhasil dihapus');
    }
}
