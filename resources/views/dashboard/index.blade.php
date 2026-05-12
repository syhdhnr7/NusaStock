@extends('main')
@section('content')

<div class="card shadow">
    <div class="card-body">
        <div class="mt-2 mb-4 text-center">
            <p class="font-tdb">Lakukan Transaksi?</p>
            <p>Silahkan pilih jenis transaksi yang ingin Anda lakukan</p>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-md-3 mb-2"></div>

            <div class="col-md-3 mb-2">
                <a href="../incoming" class="btn btn-success w-100">
                    <i class="fas fa-sign-in"></i> &nbsp; Barang Masuk
                </a>
            </div>

            <div class="col-md-3 mb-2">
                <a href="../outcoming" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out"></i> &nbsp; Barang Keluar
                </a>
            </div>
            <div class="col-md-3 mb-2"></div>
        </div>
    </div>
</div>

<br>
<div class="card card-body shadow">
    <div class="mt-2 text-center">
        <p class="font-tdb">Peringatan Stok!</p>
        <p>Berikut daftar barang yang memerlukan perhatian terkait stoknya</p>
    </div>
    <hr>
    <div class="mx-2 my-2 row d-flex align-items-stretch">

        {{-- STOK MAKSIMUM --}}
        <div class="col-md-4 mb-2 d-flex">
            <div class="card-body bg-soft-orange border-left-lg border-warning">
                <div class="mx-1 my-1">
                    <p class="mb-3 font-cdb">Stok Berlebihan</p>
                    <!-- <p class="mb-3">Berikut daftar barang yang telah mencapai / melewati batas maksimum</p> -->

                    <ul class="font-db list-unstyled">
                        @forelse($stokMaksimum as $item)
                        <li class="d-flex justify-content-between align-items-center badge-light-db mb-1">
                            {{ $item->nama_barang }}
                            <span class="badge badge-warning">{{ $item->stok }} {{ $item->satuan }}</span>
                        </li>
                        @empty
                        <li>Tidak ada stok yang berlebihan</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- STOK MINIMUM --}}
        <div class="col-md-4 mb-2 d-flex">
            <div class="card-body bg-soft-red border-left-lg border-danger">
                <div class="mx-1 my-1">
                    <p class="mb-3 font-cdb">Stok Menipis</p>
                    <!-- <p class="mb-3">Berikut daftar barang yang telah mencapai / melewati batas minimum</p> -->

                    <ul class="font-db list-unstyled">
                        @forelse($stokMinimum as $item)
                        <li class="d-flex justify-content-between align-items-center badge-light-db mb-1">
                            {{ $item->nama_barang }}
                            <span class="badge badge-danger">{{ $item->stok }} {{ $item->satuan }}</span>
                        </li>
                        @empty
                        <li>Tidak ada stok yang menipis</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- STOK KOSONG --}}
        <div class="col-md-4 mb-2 d-flex">
            <div class="card-body bg-soft-grey border-left-lg border-grey">
                <div class="mx-1 my-1">
                    <p class="mb-3 font-cdb">Stok Kosong</p>
                    <!-- <p class="mb-3">Berikut daftar barang yang stoknya habis atau tidak tersedia</p> -->

                    <ul class="font-db list-unstyled">
                        @forelse($stokKosong as $item)
                        <li class="d-flex justify-content-between align-items-center badge-light-db mb-1">
                            {{ $item->nama_barang }}
                            <span class="badge badge-dark">{{ $item->stok }} {{ $item->satuan }}</span>
                        </li>
                        @empty
                        <li>Tidak ada stok yang kosong</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="card card-body shadow">
    <div class="row d-flex">
        <div class="col-md-4">
            <div class="card-body border">
                <h3 class="my-2 text-center">Total Stok</h3>
                <p class="text-center">Berikut total stok barang dalam inventory</p>
                <hr>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <div class="col-md-8 justify-content-end">
            <div class="card-body border">
                <div class="row d-flex">
                    <div class="col-md-10">
                        <h3 class="my-2 ml-2 text-left">Barang Masuk vs Keluar</h3>
                        <p class="ml-2 text-left">Berikut perbandingan jumlah barang masuk dan barang keluar</p>
                    </div>

                    <form method="GET" class="col-md-2 d-flex justify-content-end">
                        <select name="bulan" onchange="this.form.submit()" class="form-control w-auto d-inline">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan', date('n')) == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                                @endfor
                        </select>
                    </form>
                </div>
                <hr>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@extends('scriptdb')
<script>
    const ctx = document.getElementById('pieChart');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: chartLabels.map(label => {
                return label
                    .replace('_', ' ')
                    .replace(/\b\w/g, l => l.toUpperCase());
            }),
            datasets: [{
                data: chartValues,
                backgroundColor: [
                    '#319a49', // bahan baku (hijau)
                    '#ffd500', // kemasan (kuning)
                    '#df0000' // produk jadi (merah)
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20
                    }
                }
            }
        }
    });
</script>
<script src="{{ asset('template/js/indexdb.js') }}"></script>
@endsection