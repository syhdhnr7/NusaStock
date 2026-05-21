@extends('main')

@section('content')

<div class="card card-body shadow">

    <h3>Tambah Data Produk</h3>
    <hr>


    <form action="/inventory/store" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>

        @error('nama_barang')
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
        
        <div class="mb-3">
            <label class="form-label">Jenis Barang</label>
            <select name="jenis_barang" class="form-control">

                <option value="bahan_baku">Bahan Baku</option>
                <option value="kemasan">Kemasan</option>
                <option value="produk_jadi">Produk Jadi</option>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Batas Minimum</label>
            <input type="number" name="batas_minimum" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Batas Maksimum</label>
            <input type="number" name="batas_maksimum" class="form-control" required>
        </div>
        <br>

        <div class="mb-3">
            <label class="form-label">Gambar <span class="text-muted">(Opsional)</span></label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-success mt-2">
            Simpan
        </button>
        <button onclick="goBack()" class="btn btn-secondary mt-2">
            Kembali
        </button>

        <script>
            function goBack() {
                if (document.referrer !== "") {
                    window.history.back();
                } else {
                    window.location.href = "/"; // fallback ke home
                }
            }
        </script>

    </form>

</div>

@endsection