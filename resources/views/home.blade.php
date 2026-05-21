<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NusaStock</title>
    <!-- Tailwind -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Alpine -->
    <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>
    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('template') }}/css/vertical-layout-light/skilline.css" />
    <link rel="stylesheet" href="{{ asset('template') }}/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Poppins font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="antialiased">
    <!-- navbar -->
    <div x-data="{ open: false }" class="w-full text-black bg-green">
        <div class="flex flex-col max-w-screen-xl px-8 mx-auto md:items-center md:justify-between md:flex-row py-6">
            @if(Auth::user()->role == 'admin')
            <div class="flex flex-row items-center justify-between py-6 transform transition hover:scale-110 duration-300 ease-in-out">
                <a class="nav-link" href="/dashboard">
                    <i class="fa fa-circle-arrow-left fa-3x text-black"></i>
                </a>
            </div>
            @endif
            @if(Auth::user()->role == 'user')
            <div class="flex flex-row items-center justify-between py-6">
                <a class="nav-link" href="#">
                    <img src="{{ asset('template') }}/images/nusalogo.png" alt="logo" class="w-20 h-20">
                </a>
            </div>
            @endif
            <nav :class="{ 'transform md:transform-none': !open, 'h-full': open }" class="h-0 md:h-auto flex flex-col flex-grow md:items-center pb-4 md:pb-0 md:flex md:justify-end md:flex-row origin-top duration-300 scale-y-0">

                <a class="text-black font-semibold px-3 py-2 mt-2 text-sm bg-transparent rounded-lg md:mt-8 md:ml-3 hover:text-gray-100 focus:outline-none focus:shadow-outline" href="#peringatan">Peringatan Stok</a>

                <a class="text-black font-semibold px-3 py-2 mt-2 text-sm bg-transparent rounded-lg md:mt-8 md:ml-3 hover:text-gray-100 focus:outline-none focus:shadow-outline" href="#daftar">Daftar Stok</a>

                <a class="text-black font-semibold px-3 py-2 mt-2 text-sm bg-transparent rounded-lg md:mt-8 md:ml-3 hover:text-gray-100 focus:outline-none focus:shadow-outline" href="#total">Total Stok</a>

                <a class="text-black font-semibold px-8 py-3 mt-2 text-sm text-center bg-black text-white rounded-full md:mt-8 md:ml-4 transform transition hover:scale-110 duration-300 ease-in-out"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); confirmLogout();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </div>
    </div>
    <div class="bg-green">
        <div class="max-w-screen-xl px-8 mx-auto flex flex-col lg:flex-row items-start">
            <!--Left Col-->
            <div class="flex flex-col w-full lg:w-6/12 justify-center lg:pt-24 items-start text-center lg:text-left mb-5 md:mb-0">
                <h1 data-aos="fade-right" data-aos-once="true" class="my-4 text-5xl font-bold leading-tight text-brown">
                    <span class="text-black">NusaStock</span> website pengelolaan <i>inventory</i> UMKM Nusaibah
                </h1>
                <p data-aos="fade-down" data-aos-once="true" data-aos-delay="300" class="leading-normal text-2xl mb-20 text-white">Hadir untuk membantu mengelola stok produk, dengan fitur sederhana yang mudah digunakan.</p>
            </div>

            <!--Right Col-->
            <div class="w-full lg:w-6/12 lg:-mt-10 relative" id="girl">
                <img data-aos="fade-up" data-aos-once="true" class="w-10/12 mx-auto 2xl:-mb-20" src="{{ asset('template') }}/images/nusawpp2.png" />
            </div>
        </div>
        <div class="text-white -mt-14 sm:-mt-24 lg:-mt-36 z-40 relative">
            <svg class="xl:h-40 xl:w-full" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z" fill="currentColor"></path>
            </svg>
            <div id="peringatan" class="bg-white w-full h-20 -mt-px"></div>
            <div class="bg-white w-full h-20 -mt-px"></div>
        </div>
    </div>

    <!-- CARD KONDISI STOK -->
    <div class="mt-2">
        <div data-aos="flip-down" class="text-center max-w-screen-md mx-auto">
            <h1 class="font-bold text-black text-3xl">Peringatan Stok</h1>
            <p class="text-gray-500">Berikut daftar barang yang stoknya menipis serta daftar barang yang stoknya habis</p>
        </div>
        <div class="flex justify-center">
            @php
            $pesan = "Halo Admin,\n";
            $pesan .= "Berikut, laporan kondisi stok pada (" . now()->format('d-m-Y') . ") :\n";

            // Stok Berlebihan
            if(count($stokMaksimum) > 0){
            $pesan .= "\nStok Berlebihan:\n";
            foreach ($stokMaksimum as $item) {
            $pesan .= "- {$item->nama_barang} : {$item->stok} {$item->satuan}\n";
            }
            }

            // Stok Menipis
            if(count($stokMinimum) > 0){
            $pesan .= "\nStok Menipis:\n";
            foreach ($stokMinimum as $item) {
            $pesan .= "- {$item->nama_barang} : {$item->stok} {$item->satuan}\n";
            }
            }

            // Stok Kosong
            if(count($stokKosong) > 0){
            $pesan .= "\nStok Kosong:\n";
            foreach ($stokKosong as $item) {
            $pesan .= "- {$item->nama_barang}\n";
            }
            }

            $pesan .= "\nTerima kasih.";
            @endphp
            <a href="https://wa.me/6285326812391?text={{ urlencode($pesan) }}"
                target="_blank"
                class="text-black font-semibold px-8 py-3 mt-4 text-sm text-center bg-black text-white rounded-full md:mt-8 transform transition hover:scale-110 duration-300 ease-in-out">
                Laporkan Kondisi Stok
            </a>
        </div>

        <div class="flex justify-center">
            <div class="p-4 rounded-2xl w-full max-w-6xl">

                <!-- Card Peringatan Stok -->
                <div class="grid md:grid-cols-3 gap-14 md:gap-5 mt-2">
                    <div data-aos="fade-up" class="shadow-xl p-6 text-center rounded-xl">
                        <div class="bg-soft-orange px-2 py-2 rounded flex items-center justify-center mx-auto shadow-md">
                            <h1 class="font-semi-bold text-xl lg:px-14 text-black mt-2">Stok Berlebihan</h1>
                        </div>
                        <br>
                        <div class="bg-white">
                            <ul class="space-y-1 list-none pl-0 mx-1">
                                @forelse($stokMaksimum as $item)
                                <div class="border-bottom">
                                    <li class="d-flex justify-content-between align-items-center mb-1">
                                        {{ $item->nama_barang }}
                                        <span class="badge badge-warning">{{ $item->stok }} {{ $item->satuan }}</span>
                                    </li>
                                </div>
                                @empty
                                <li class="">Tidak ada stok yang berlebihan</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="150" class="bg-white shadow-xl p-6 text-center rounded-xl">
                        <div class="bg-soft-red px-2 py-2 rounded flex items-center justify-center mx-auto shadow-md">
                            <h1 class="font-semi-bold text-xl lg:px-14 text-black mt-2">Stok Menipis</h1>
                        </div>
                        <br>
                        <ul class="space-y-1 list-none pl-0 mx-1">
                            @forelse($stokMinimum as $item)
                            <div class="border-bottom">
                                <li class="d-flex justify-content-between align-items-center mb-1">
                                    {{ $item->nama_barang }}
                                    <span class="badge badge-danger">{{ $item->stok }} {{ $item->satuan }}</span>
                                </li>
                            </div>
                            @empty
                            <li class="">Tidak ada stok yang menipis</li>
                            @endforelse
                        </ul>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="300" class="bg-white shadow-xl p-6 text-center rounded-xl">
                        <div class="bg-gray-200 px-2 py-2 rounded flex items-center justify-center mx-auto shadow-md">
                            <h1 class="font-semi-bold text-xl lg:px-14 text-black mt-2">Stok Kosong</h1>
                        </div>
                        <br>
                        <ul class="space-y-1 list-none pl-0 mx-1">
                            @forelse($stokKosong as $item)
                            <div class="border-bottom">
                                <li class="d-flex justify-content-between align-items-center mb-1">
                                    {{ $item->nama_barang }}
                                    <span class="badge badge-dark">{{ $item->stok }} {{ $item->satuan }}</span>
                                </li>
                            </div>
                            @empty
                            <li class="">Tidak ada stok yang kosong</li>
                            @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- container -->
    <div class="container px-4 lg:px-8 mx-auto max-w-screen-xl text-gray-700">
        <div id="daftar" class="lg:pt-20">
            <div data-aos="flip-down" class="text-center max-w-screen-md mx-auto mt-10">
                <h1 class="font-bold text-black text-3xl">Daftar Stok Dalam Gudang</h1>
                <p class="text-gray-500">Berikut daftar nama barang beserta informasi stoknya yang tersedia</p>
            </div>
            <!-- Batas content -->
            <div class="sm:flex items-center sm:space-x-8 mt-20">
                <div data-aos="fade-right" class="sm:w-1/4 relative">
                    <h1 class="font-semibold text-3xl relative z-50 text-black lg:pr-10"><span class="text-orange">Daftar Stok</span><br> Bahan Baku</h1>
                </div>
                <div data-aos="fade-left" class="sm:w-3/4 relative mt-10 sm:mt-0">
                    <!-- <div style="background: #000000;" class="floating w-24 h-24 absolute rounded-lg z-0 -top-3 -left-3"></div> -->
                    <div class="card card-body shadow z-40 relative">
                        <div class="mx-2 my-2" x-data="{ showAll: false }">
                            {{-- ================= Bahan Baku ================= --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                @foreach ($bahanBaku as $index => $item)
                                <div class="flex bg-soft-orange rounded overflow-hidden" x-show="showAll || {{ $index }} < 9">

                                    <!-- Gambar -->
                                    <div class="w-1/3 bg-black flex items-center justify-center border-4 border-orange">
                                        @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}"
                                            alt="{{ $item->nama_barang }}"
                                            class="object-cover w-full h-full rounded-sm">
                                        @else
                                        <span class="text-center text-xs text-gray-200">Gambar Tidak Tersedia</span>
                                        @endif
                                    </div>

                                    <!-- Info -->
                                    <div class="w-2/3 flex flex-col">
                                        <div class="bg-orange text-white text-center text-sm font-semibold py-2">
                                            {{ $item->nama_barang }}
                                        </div>
                                        <div class="bg-soft-orange text-orange text-center text-lg font-bold py-3">
                                            {{ $item->stok }} {{ $item->satuan }}
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                            </div>
                            @if($bahanBaku->count() > 9)

                            <div class="mt-4 text-center">

                                <button
                                    x-show="!showAll"
                                    @click="showAll = true"
                                    class="bg-orange text-white text-sm px-6 py-2 rounded-3xl transform transition hover:scale-110 duration-300 ease-in-out">

                                    Lihat Lebih Banyak

                                </button>

                                <button
                                    x-show="showAll"
                                    @click="showAll = false"
                                    class="bg-gray-600 text-white text-sm px-6 py-2 rounded-3xl transform transition hover:scale-110 duration-300 ease-in-out">

                                    Lihat Lebih Sedikit

                                </button>

                            </div>

                            @endif

                        </div>
                    </div>
                    <!-- <div class="bg-orange w-40 h-40 floating absolute rounded-lg z-10 -bottom-3 -right-3"></div> -->
                </div>
            </div>
        </div>

        <div class="sm:flex items-center sm:space-x-8 mt-24">
            <div data-aos="fade-down" class="md:w-3/4 relative">
                <!-- <div style="background: #57B657" class="w-32 h-32 rounded-full absolute z-0 left-4 -top-12 animate-pulse"></div>
                <div style="background: #000000;" class="w-5 h-5 rounded-full absolute z-0 left-36 -top-12 animate-ping"></div> -->

                <div class="card card-body shadow z-40 relative">
                    <div class="mx-2 my-2" x-data="{ showAll: false }">

                        {{-- ================= Kemasan ================= --}}

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            @foreach ($kemasan as $index => $item)
                            <div class="flex bg-soft-green rounded overflow-hidden" x-show="showAll || {{ $index }} < 9">

                                <!-- Gambar -->
                                <div class="w-1/3 bg-black flex items-center justify-center border-4 border-green">
                                    @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                        alt="{{ $item->nama_barang }}"
                                        class="object-cover w-full h-full rounded-sm">
                                    @else
                                    <span class="text-center text-xs text-gray-200">Gambar Tidak Tersedia</span>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="w-2/3 flex flex-col">
                                    <div class="bg-green text-white text-center text-sm font-semibold py-2">
                                        {{ $item->nama_barang }}
                                    </div>
                                    <div class="bg-soft-green text-green text-center text-lg font-bold py-3">
                                        {{ $item->stok }} {{ $item->satuan }}
                                    </div>
                                </div>

                            </div>
                            @endforeach

                        </div>

                        @if($bahanBaku->count() > 9)

                        <div class="mt-4 text-center">

                            <button
                                x-show="!showAll"
                                @click="showAll = true"
                                class="bg-green text-white text-sm px-6 py-2 rounded-3xl transform transition hover:scale-110 duration-300 ease-in-out">

                                Lihat Lebih Banyak

                            </button>

                            <button
                                x-show="showAll"
                                @click="showAll = false"
                                class="bg-gray-600 text-white text-sm px-6 py-2 rounded-3xl transform transition hover:scale-110 duration-300 ease-in-out">

                                Lihat Lebih Sedikit

                            </button>

                        </div>

                        @endif
                    </div>
                </div>

                <!-- <div style="background: #000000;" class=" w-36 h-36 rounded-full absolute z-0 right-16 -bottom-1 animate-pulse"></div>
                <div style="background: #57B657;" class=" w-5 h-5 rounded-full absolute z-0 right-52 bottom-1 animate-ping"></div> -->
            </div>
            <div data-aos="fade-down" class="md:w-1/4 relative">
                <h1 class="font-semibold text-3xl relative text-black lg:pl-10 text-right"><span class="text-green">Daftar Stok</span><br>Kemasan</h1>
            </div>
        </div>

        <div class="sm:flex items-center sm:space-x-8 mt-24">
            <div data-aos="fade-right" class="sm:w-1/4 relative">
                <h1 class="font-semibold text-3xl relative z-50 text-black lg:pr-10"><span class="text-maroon">Daftar Stok</span><br> Produk Jadi</h1>
            </div>
            <div data-aos="fade-left" class="sm:w-3/4 relative mt-10 sm:mt-0">
                <!-- <div style="background: #000000;" class="floating w-24 h-24 absolute rounded-lg z-0 -top-3 -left-3"></div> -->
                <div class="card card-body shadow z-40 relative">
                    <div class="mx-2 my-2" x-data="{ showAll: false }">

                        {{-- ================= Produk Jadi ================= --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            @foreach ($produkJadi as $index => $item)
                            <div class="flex bg-soft-maroon rounded overflow-hidden" x-show="showAll || {{ $index }} < 9">

                                <!-- Gambar -->
                                <div class="w-1/3 bg-black flex items-center justify-center border-4 border-maroon">
                                    @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                        alt="{{ $item->nama_barang }}"
                                        class="object-cover w-full h-full rounded-sm">
                                    @else
                                    <span class="text-center text-xs text-gray-200">Gambar Tidak Tersedia</span>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="w-2/3 flex flex-col">
                                    <div class="bg-maroon text-white text-center text-sm font-semibold py-2">
                                        {{ $item->nama_barang }}
                                    </div>
                                    <div class="bg-soft-maroon text-maroon text-center text-lg font-bold py-3">
                                        {{ $item->stok }} {{ $item->satuan }}
                                    </div>
                                </div>

                            </div>
                            @endforeach

                        </div>

                        @if($bahanBaku->count() > 9)

                        <div class="mt-4 text-center">

                            <button
                                x-show="!showAll"
                                @click="showAll = true"
                                class="bg-maroon text-white text-sm px-6 py-2 rounded-3xl transform transition hover:scale-110 duration-300 ease-in-out">

                                Lihat Lebih Banyak

                            </button>

                            <button
                                x-show="showAll"
                                @click="showAll = false"
                                class="bg-gray-600 text-white text-sm px-6 py-2 rounded-3xl transform transition hover:scale-110 duration-300 ease-in-out">

                                Lihat Lebih Sedikit

                            </button>

                        </div>

                        @endif
                    </div>
                </div>
                <!-- <div class="bg-maroon w-40 h-40 floating absolute rounded-lg z-10 -bottom-3 -right-3"></div> -->
            </div>
        </div>

        <div id="total"></div>
        <!-- All-In-One Cloud Software. -->
        <div data-aos="flip-down" class="max-w-xl mx-auto text-center mt-36">
            <h1 class="font-bold text-black text-3xl">Total Stok Dalam Gudang</h1>
            <p class="leading-relaxed text-gray-500">Berikut jumlah keseluruhan stok barang yang tersedia di dalam gudang saat ini.</p>
        </div>

        <!-- card -->
        <div class="grid md:grid-cols-3 gap-14 md:gap-5 mt-20">
            <div data-aos="fade-right" data-aos-delay="150" class="bg-white shadow-xl p-6 text-center rounded-xl">
                <div style="background: #ff9225;" class="rounded-full w-16 h-16 flex items-center justify-center mx-auto shadow-lg transform -translate-y-12">
                    <i class="fa fa-leaf fa-2x text-white"></i>
                </div>
                <h1 class="font-medium text-xl mb-3 lg:px-14 text-black">Stok Bahan Baku</h1>
                <hr>
                <p class="px-4 text-4xl" style="color: #ff9225;">{{ $totalBahanBaku }} kg</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="150" class="bg-white shadow-xl p-6 text-center rounded-xl">
                <div style="background: #1fb90a;" class="rounded-full w-16 h-16 flex items-center justify-center mx-auto shadow-lg transform -translate-y-12">
                    <i class="fa fa-box fa-2x text-white"></i>
                </div>
                <h1 class="font-medium text-xl mb-3 lg:px-14 text-black">Stok Kemasan</h1>
                <hr>
                <p class="px-4 text-4xl" style="color: #1fb90a;">{{ $totalKemasan }} pcs</p>
            </div>
            <div data-aos="fade-left" data-aos-delay="150" class="bg-white shadow-xl p-6 text-center rounded-xl">
                <div style="background: #ca2323;" class="rounded-full w-16 h-16 flex items-center justify-center mx-auto shadow-lg transform -translate-y-12">
                    <i class="fa fa-shopping-bag fa-2x text-white"></i>
                </div>
                <h1 class="font-medium text-xl mb-3 lg:px-14 text-black">Stok Produk Jadi</h1>
                <hr>
                <p class="px-4 text-4xl" style="color: #ca2323;">{{ $totalProdukJadi }} pcs</p>
            </div>
        </div>
    </div>

    <!-- .container -->

    <footer class="mt-32" style="background-color: #57B657;">
        <div class="max-w-lg mx-auto">
            <div class="flex py-6 justify-center text-white items-center px-20 sm:px-20">
                <div class="relative mr-3">
                    <!-- <img class="img-lg" src="{{ asset('template') }}/images/nusalogo.png" alt="profile" /> -->
                </div>
                <!-- <span class="border-l border-black text-sm pl-4 py-2 font-semibold text-cream">Website <br> Pengelolaan <br> Inventory</span> -->
            </div>

            <div class="flex items-center text-gray-400 text-sm justify-center">
                <!-- <a href="#!" class="pr-3">Careers</a>
                <a href="#!" class="border-l border-gray-400 px-3">Privacy</a>
                <a href="#!" class="border-l border-gray-400 pl-3">Terms & Conditions</a> -->
            </div>
            <div class="text-center text-white">
                <p class="my-3 text-black text-sm">&copy; 2026 Mahasiswa STT Terpadu Nurul Fikri. </p>
                <div class="py-3 tracking-wide">
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS init -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin?',
                text: "Kamu akan logout dari sistem",
                icon: 'warning',
                showCancelButton: true,
                padding: '40px 20px 20px 20px',
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ff4f4f'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>