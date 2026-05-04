<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Toko</title>
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
                    <h3 class="mb-2">Daftar Toko</h3>
                    <p>Berikut daftar toko penjualan produk beserta alamatnya.</p>
                </div>

                <a href="/shop/create" class="btn btn-success">
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

            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-success">
                            <th width="5%">No</th>
                            <th width="40%">Nama Toko</th>
                            <th width="35%">Alamat</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $iteration = 1 @endphp
                        @foreach ($shops as $item)
                        <tr>
                            <td>{{ $iteration++ }}</td>
                            <td>{{ $item['nama_toko'] }}</td>
                            <td>{{ $item['alamat'] }}</td>
                            <td>
                                <button
                                    class="btn btn-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewModal"
                                    data-nama="{{ $item->nama_toko }}"
                                    data-alamat="{{ $item->alamat }}">
                                    Lihat
                                </button>
                                <a href="/shop/edit/{{ $item->id }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/shop/{{ $item->id }}" method="POST" class="d-inline"
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
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <h3>Detail Toko</h3>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Nama Toko</th>
                            <td id="view_nama"></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td id="view_alamat"></td>
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

        var nama = button.getAttribute('data-nama')
        var alamat = button.getAttribute('data-alamat')

        document.getElementById('view_nama').innerText = nama
        document.getElementById('view_alamat').innerText = alamat

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
@endsection
</body>

</html>