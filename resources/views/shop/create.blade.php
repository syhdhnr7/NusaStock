@extends('main')

@section('content')

<div class="card card-body shadow">

    <h3>Tambah Toko</h3>
    <hr>

    <form action="/shop/store" method="POST">

        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Toko</label>
            <input type="text" name="nama_toko" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required></textarea>
        </div>

        <button class="btn btn-success">
            Simpan
        </button>

        <a href="/shop" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

@endsection