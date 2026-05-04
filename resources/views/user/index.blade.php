<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<style>
    #viewModal .table tr:first-child th,
    #viewModal .table tr:first-child td {
        border-top: none;
    }
</style>

<body>
    @extends('main')
    @section('content')
    <div class="card card-body shadow">
        <div class="mx-2 my-2">
            <h2 class="font-weight-medium">Daftar Pengguna</h2>
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
                            <th width="35%">Nama</th>
                            <th width="30%">Email</th>
                            <th width="10%">Role</th>
                            <!-- <th>Password</th> -->
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $iteration = 1 @endphp
                        @foreach ($users as $item)
                        <tr>
                            <td>{{ $iteration++ }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            <!-- <td class="text-wrap">{{ $item['password'] }}</td> -->
                            <td>
                                <button
                                    class="btn btn-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewModal"
                                    data-nama="{{ $item->name }}"
                                    data-email="{{ $item->email }}"
                                    data-role="{{ $item->role }}">
                                    Lihat
                                </button>
                                <a href="/user/edit/{{ $item->id }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/user/{{ $item->id }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
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
                        <h3>Detail User</h3>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td id="view_nama"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="view_email"></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td id="view_role"></td>
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
        var email = button.getAttribute('data-email')
        var role = button.getAttribute('data-role')

        document.getElementById('view_nama').innerText = nama
        document.getElementById('view_email').innerText = email
        document.getElementById('view_role').innerText = role

    })
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
@endsection
</body>

</html>