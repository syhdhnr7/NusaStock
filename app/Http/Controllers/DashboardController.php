<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Incoming;
use App\Models\Outcoming;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();

        // stok kosong
        $stokKosong = Inventory::where('stok', 0)->get();

        // stok mencapai batas minimum (<= batas_minimum tapi masih ada stok)
        $stokMinimum = Inventory::whereColumn('stok', '<=', 'batas_minimum')
            ->where('stok', '>', 0)
            ->get();

        // stok mencapai batas maksimum (>= batas_maksimum)
        $stokMaksimum = Inventory::whereColumn('stok', '>=', 'batas_maksimum')
            ->get();

        $chartData = DB::table('inventories')
            ->select('jenis_barang', DB::raw('SUM(stok) as total'))
            ->groupBy('jenis_barang')
            ->pluck('total', 'jenis_barang');

        $chartLabels = ['bahan_baku', 'kemasan', 'produk_jadi'];

        $chartValues = [
            Inventory::where('jenis_barang', 'bahan_baku')->sum('stok'),
            Inventory::where('jenis_barang', 'kemasan')->sum('stok'),
            Inventory::where('jenis_barang', 'produk_jadi')->sum('stok'),
        ];

        $bulan = request('bulan', date('n'));
        $tahun = date('Y');

        $days = [];
        $incomingData = [];
        $outcomingData = [];

        $jumlahHari = Carbon::create($tahun, $bulan)->daysInMonth;

        for ($i = 1; $i <= $jumlahHari; $i++) {
            $days[] = $i;

            $incomingData[] = Incoming::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->whereDay('created_at', $i)
                ->sum('jumlah');

            $outcomingData[] = Outcoming::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->whereDay('created_at', $i)
                ->sum('jumlah');
        }

        return view('dashboard.index', compact('stokKosong', 'stokMinimum', 'stokMaksimum', 'chartData', 'chartLabels', 'chartValues', 'days', 'incomingData', 'outcomingData'));
    }
}
