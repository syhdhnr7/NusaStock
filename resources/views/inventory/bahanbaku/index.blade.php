<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Stok</title>
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
                <div>
                    <h3 class="mb-2">Daftar Bahan Baku</h3>
                    <p>Berikut daftar stok bahan baku yang ada di inventory anda.</p>
                </div>
                <a href="/inventory/create" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i>
                    &nbsp; Tambah
                </a>
            </div>
            <hr>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            {{-- ================= BAHAN BAKU ================= --}}
            <div class="mt-4">

                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-success">
                                <th width="5%">No</th>
                                <th width="15%">Gambar</th>
                                <th width="30%">Nama Barang</th>
                                <th width="10%">Stok</th>
                                <th width="10%">Minimum</th>
                                <th width="10%">Maksimum</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($data as $index => $item)

                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>
                                    @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar {{ $item->nama_barang }}" width="100">
                                    @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->stok }} {{ $item->satuan }}</td>
                                <td>{{ $item->batas_minimum }} {{ $item->satuan }}</td>
                                <td>{{ $item->batas_maksimum }} {{ $item->satuan }}</td>
                                <td>
                                    <button
                                        class="btn btn-success btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewModal"
                                        data-gambar="{{ asset('storage/' . $item->gambar) }}"
                                        data-nama="{{ $item->nama_barang }}"
                                        data-stok="{{ $item->stok }} {{ $item->satuan }}"
                                        data-min="{{ $item->batas_minimum }} {{ $item->satuan }}"
                                        data-max="{{ $item->batas_maksimum }} {{ $item->satuan }}"
                                        data-jenis="{{ ucwords(str_replace('_', ' ', $item->jenis_barang)) }}">
                                        Lihat
                                    </button>
                                    <a href="/inventory/edit/{{ $item->id }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="/inventory/{{ $item->id }}" method="POST" class="d-inline"
                                        onsubmit="event.preventDefault(); confirmDelete(this);">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
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
                        <h3>Detail Bahan Baku</h3>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div id="view_gambar" class="text-center mb-3"></div>

                    <table class="table">
                        <tr>
                            <th>Nama Barang</th>
                            <td id="view_nama"></td>
                        </tr>
                        <tr>
                            <th>Jenis Barang</th>
                            <td id="view_jenis"></td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td id="view_stok"></td>
                        </tr>
                        <tr>
                            <th>Batas Minimum</th>
                            <td id="view_min"></td>
                        </tr>
                        <tr>
                            <th>Batas Maksimum</th>
                            <td id="view_max"></td>
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
        var gambar = button.getAttribute('data-gambar')
        if (gambar) {
            document.getElementById('view_gambar').innerHTML = '<img src="' + gambar + '" class="img-fluid rounded shadow" style="max-height:250px;" alt="Gambar ' + button.getAttribute('data-nama') + '" width="100">'
        } else {
            document.getElementById('view_gambar').innerHTML = '<span class="text-muted">Tidak ada gambar</span>'
        }
        var nama = button.getAttribute('data-nama')
        var stok = button.getAttribute('data-stok')
        var min = button.getAttribute('data-min')
        var max = button.getAttribute('data-max')
        var jenis = button.getAttribute('data-jenis')

        document.getElementById('view_gambar').innerHTML = gambar ? '<img src="' + gambar + '" alt="Gambar ' + nama + '" width="100">' : '<span class="text-muted">Tidak ada gambar</span>';
        document.getElementById('view_nama').innerText = nama
        document.getElementById('view_stok').innerText = stok
        document.getElementById('view_min').innerText = min
        document.getElementById('view_max').innerText = max
        document.getElementById('view_jenis').innerText = jenis

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