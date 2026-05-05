<nav class="sidebar sidebar-offcanvas shadow" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="/dashboard">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#inventory" aria-expanded="false" aria-controls="inventory">
        <i class="icon-box menu-icon"></i>
        <span class="menu-title">Daftar Stok</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="inventory">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="/inventory/bahanbaku">Bahan Baku</a></li>
          <li class="nav-item"> <a class="nav-link" href="/inventory/kemasan">Kemasan</a></li>
          <li class="nav-item"> <a class="nav-link" href="/inventory/produkjadi">Produk Jadi</a></li>
        </ul>
      </div>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="/inventory/bahanbaku">
        <i class="icon-box menu-icon"></i>
        <span class="menu-title">Stok Bahan Baku</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/inventory/kemasan">
        <i class="icon-layers menu-icon"></i>
        <span class="menu-title">Stok Kemasan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/inventory/produkjadi">
        <i class="icon-bag menu-icon"></i>
        <span class="menu-title">Stok Produk Jadi</span>
      </a>
    </li> -->

    <li class="nav-item">
      <a class="nav-link" href="/shop">
        <i class="ti-shopping-cart menu-icon"></i>
        <span class="menu-title">Daftar Toko</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/transaction">
        <i class="icon-clock menu-icon"></i>
        <span class="menu-title">Riwayat Transaksi</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#tentang-user" aria-expanded="false" aria-controls="tentang-user">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Tentang User</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="tentang-user">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="../home">Halaman User</a></li>
          <li class="nav-item"> <a class="nav-link" href="/user">Daftar User</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}"
        onclick="event.preventDefault(); confirmLogout();">
        <i class="ti-power-off menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </li>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      function confirmLogout() {
        Swal.fire({
          title: 'Yakin?',
          text: "Kamu akan logout dari sistem",
          icon: 'warning',
          showCancelButton: true,
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
</nav>