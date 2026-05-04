@extends('main')

@section('content')

<div class="card card-body shadow">

    <h3>Edit Data Produk</h3>
    <hr>

    <form action="/inventory/update/{{ $item->id }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text"
                class="form-control"
                name="nama_barang"
                value="{{ $item->nama_barang }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Barang</label>
            <select name="jenis_barang" class="form-control">

                <option value="bahan_baku"
                    {{ $item->jenis_barang == 'bahan_baku' ? 'selected' : '' }}>
                    Bahan Baku
                </option>

                <option value="kemasan"
                    {{ $item->jenis_barang == 'kemasan' ? 'selected' : '' }}>
                    Kemasan
                </option>

                <option value="produk_jadi"
                    {{ $item->jenis_barang == 'produk_jadi' ? 'selected' : '' }}>
                    Produk Jadi
                </option>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number"
                class="form-control"
                name="stok"
                value="{{ $item->stok }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Batas Minimum</label>
            <input type="number"
                class="form-control"
                name="batas_minimum"
                value="{{ $item->batas_minimum }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Batas Maksimum</label>
            <input type="number"
                class="form-control"
                name="batas_maksimum"
                value="{{ $item->batas_maksimum }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar</label>

            <!-- tampilkan gambar lama -->
            @if($item->gambar)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $item->gambar) }}"
                    id="preview"
                    class="img-thumbnail"
                    width="150">
            </div>
            @else
            <img id="preview" class="img-thumbnail mb-2" width="150" style="display:none;">
            @endif

            <!-- upload gambar baru -->
            <input type="file"
                class="form-control"
                name="gambar"
                accept="image/*"
                onchange="previewImage(event)">

            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
        </div>

        <br>
        <button class="btn btn-success mt-2">
            Update
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