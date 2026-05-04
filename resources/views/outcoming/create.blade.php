<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    @extends('main')

    @section('content')

    <div class="card card-body shadow">

        <h3>Transaksi Barang Keluar</h3>
        <hr>

        <form action="/outcoming" method="POST">
            @csrf

            <div class="mb-3">
                <label>Jenis Barang</label>
                <select name="jenis_barang" id="jenis_barang" class="form-control" required>
                    <option value="">-- Pilih Jenis Barang --</option>
                    <option value="bahan_baku">Bahan Baku</option>
                    <option value="kemasan">Kemasan</option>
                    <option value="produk_jadi">Produk Jadi</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>

                <div id="barang-container">
                    <div class="row mb-2 barang-item">
                        <div class="col-md-8">
                            <select name="barang_id[]" class="form-control nama_barang" required>
                                <option value="">-- Pilih Nama Barang --</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                                <span class="input-group-text">kg / pcs</span>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-remove">X</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm mt-2" id="btn-tambah">
                    + Tambah Barang
                </button>
            </div>

            <div class="mb-3">
                <label>Tujuan</label>
                <select id="tujuan" name="tujuan" class="form-control">
                    <option value="">-- Pilih tujuan --</option>
                    <option value="pengiriman">Pengiriman</option>
                    <option value="penggunaan">Penggunaan</option>
                </select>

            </div>

            <div class="mb-3" id="tujuanField" style="display:none;">
                <label id="labelTujuan">Toko Tujuan</label>
                <select name="shop_id" class="form-control">
                    <option value="">-- Pilih Toko --</option>
                    @foreach ($shops as $shop)
                    <option value="{{ $shop->id }}">{{ $shop->nama_toko }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
            </div>

            <button class="btn btn-success">
                Simpan
            </button>
            <a href="/dashboard" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>

    <script>
        const jenisSelect = document.getElementById('jenis_barang');
        const container = document.getElementById('barang-container');
        const btnTambah = document.getElementById('btn-tambah');

        let dataBarang = [];

        // 🔹 ambil data dari database
        jenisSelect.addEventListener('change', function() {
            const jenis = this.value;

            container.innerHTML = '';

            if (jenis) {
                fetch(`/get-barang/${jenis}`)
                    .then(res => res.json())
                    .then(data => {
                        dataBarang = data;
                        tambahRow(); // otomatis tambah 1 row
                    });
            }
        });

        // 🔹 function buat row
        function tambahRow() {
            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'barang-item');

            row.innerHTML = `
            <div class="col-md-8">
                <select name="barang_id[]" class="form-control" required>
                    <option value="">-- Pilih Nama Barang --</option>
                    ${dataBarang.map(item =>
                        `<option value="${item.id}">${item.nama_barang}</option>`
                    ).join('')}
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                    <span class="input-group-text">kg / pcs</span>
                </div>
            </div>

            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-remove">X</button>
            </div>
        `;

            container.appendChild(row);
        }

        // 🔹 tombol tambah
        btnTambah.addEventListener('click', function() {
            if (dataBarang.length === 0) {
                alert('Pilih jenis barang dulu!');
                return;
            }
            tambahRow();
        });

        // 🔹 hapus row
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.barang-item').remove();
            }
        });

        // 🔹 tujuan
        document.getElementById("tujuan").addEventListener("change", function() {

            let tujuan = this.value
            let field = document.getElementById("tujuanField")

            if (tujuan == "pengiriman") {
                field.style.display = "block"
            } else {
                field.style.display = "none"
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    @endsection
</body>

</html>