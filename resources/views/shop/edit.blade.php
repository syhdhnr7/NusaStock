@extends('main')

@section('content')

<div class="card card-body shadow">

    <h3>Edit Data Toko</h3>
    <hr>

    <form action="/shop/update/{{ $shop->id }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Toko</label>
            <div class="input-group">
                <input type="text"
                    class="form-control"
                    name="nama_toko"
                    value="{{ $shop->nama_toko }}"
                    required>
                <span class="input-group-text"><i class="ti-shop"></i></span>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <div class="input-group">
                <input type="alamat"
                    class="form-control"
                    name="alamat"
                    value="{{ $shop->alamat }}"
                    required>
                <span class="input-group-text"><i class="ti-alamat"></i></span>
            </div>
        </div>

        <br>
        <button class="btn btn-success">
            Update
        </button>

        <a href="/shop" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

@endsection