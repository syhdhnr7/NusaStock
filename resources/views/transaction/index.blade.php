<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<style>
    #viewModal .table tr:first-child th,
    #viewModal .table tr:first-child td {
        border-top: none;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    @extends('main')

    @section('content')
    <div class="card card-body shadow">
        <div class="mx-2 my-2">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Riwayat Transaksi</h2>
            </div>
            <hr>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="mt-4">
                <div class="table-responsive">


                    

                    <table class="table border-bottom">
                        <tbody>
                            @foreach ($transactions as $index => $item)

                            <tr class="{{ $item->jenis_transaksi == 'masuk' ? 'border-left-lg border-success bg-soft-green' : ($item->jenis_transaksi == 'keluar' ? 'border-left-lg border-danger bg-soft-red' : '') }}">
                                <td width="5%">
                                    @if ($item->jenis_transaksi == 'masuk')
                                    <i class="fas fa-sign-in"></i>
                                    @elseif ($item->jenis_transaksi == 'keluar')
                                    <i class="fas fa-sign-out"></i>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="text-start">{{ $item->nama_barang ?? '-' }}</td>
                                <td width="35%" class="text-end">{{ $item->tanggal ?? '-' }}</td>
                                <td width="15%" class="text-end">
                                    <button
                                        class="btn btn-success btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewModal"
                                        data-transaksi="{{ ucwords(str_replace('_', ' ', $item->jenis_transaksi)) }}"
                                        data-jenis="{{ ucwords(str_replace('_', ' ', $item->jenis_barang)) }}"
                                        data-nama="{{ $item->nama_barang }}"
                                        data-tujuan="{{ $item->tujuan }}"
                                        data-toko="{{ $item->nama_toko ?? '-' }}"
                                        data-jumlah="{{ $item->jumlah }}"
                                        data-tanggal="{{ $item->tanggal }}">
                                        Detail
                                    </button>

                                    <!-- <form action="/transaction/delete/{{ $item->type }}/{{ $item->id }}" method="POST" class="d-inline" onsubmit="event.preventDefault(); confirmDelete(this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form> -->

                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <h3>Detail Transakssi</h3>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Jenis Transaksi</th>
                            <td id="view_transaksi"></td>
                        </tr>
                        <tr>
                            <th>Jenis Barang</th>
                            <td id="view_jenis"></td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td id="view_nama"></td>
                        </tr>
                        <tr>
                            <th>Tujuan</th>
                            <td id="view_tujuan"></td>
                        </tr>
                        <tr>
                            <th>Nama Toko</th>
                            <td id="view_toko"></td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td id="view_jumlah"></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td id="view_tanggal"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
@section('scripts')
<script>
    var viewModal = document.getElementById('viewModal')

    viewModal.addEventListener('show.bs.modal', function(event) {

        var button = event.relatedTarget

        var transaksi = button.getAttribute('data-transaksi')
        var jenis = button.getAttribute('data-jenis')
        var nama = button.getAttribute('data-nama')
        var tujuan = button.getAttribute('data-tujuan')
        var toko = button.getAttribute('data-toko')
        var jumlah = button.getAttribute('data-jumlah')
        var tanggal = button.getAttribute('data-tanggal')

        // mapping jenis transaksi
        if (jenis === 'masuk') {
            jenis = 'Barang Masuk'
        } else if (jenis === 'keluar') {
            jenis = 'Barang Keluar'
        }
        document.getElementById('view_transaksi').innerText = transaksi
        document.getElementById('view_jenis').innerText = jenis
        document.getElementById('view_nama').innerText = nama
        document.getElementById('view_tujuan').innerText = tujuan
        document.getElementById('view_toko').innerText = toko
        document.getElementById('view_jumlah').innerText = jumlah
        document.getElementById('view_tanggal').innerText = tanggal

    })
</script>
<script>
    function confirmDelete(form) {
        Swal.fire({
            text: "Yakin ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(255, 55, 55)',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection

</html>