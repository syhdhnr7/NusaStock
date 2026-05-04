<style>
  .swal2-popup {
    padding-top: 2rem !important;
  }

  .swal2-icon {
    margin-top: 10px !important;
  }
</style>

<nav class="navbar col-lg-12 p-0 col-12 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center bg-primary">
    <a class="navbar-brand brand-logo align-center" href="/"><img src="{{ asset('template') }}/images/nusalogo2.png" class="mr-2" style="width:150px; height:50px;" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="/"><img src="{{ asset('template') }}/images/nusalogo.png" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end bg-primary">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu text-light"></span>
    </button>
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-search d-none d-lg-block">
        <!-- <div class="input-group">
            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
              <span class="input-group-text" id="search">
                <i class="icon-search"></i>
              </span>
            </div>
            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
          </div> -->
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown">

      </li>

      <li class="nav-item">
        <p class="font-weight-semi-bold text-light">{{ Auth::user()->name }}</p>
      </li>

      <li class="nav-item nav-profile">
        <img class="shadow" src="{{ asset('template') }}/images/nusalogo1.jpg" alt="profile" />
      </li>

      <li class="d-flex align-items-center">
        <a class="btn btn-dark btn-sm" href="{{ route('logout') }}"
          onclick="event.preventDefault(); confirmLogout();">
          <i class="ti-power-off"></i>
          &nbsp; Logout
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
    </ul>
  </div>
</nav>