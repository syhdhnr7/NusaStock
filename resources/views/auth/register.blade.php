@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Registrasi</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('template') }}/vendors/feather/feather.css">
  <link rel="stylesheet" href="{{ asset('template') }}/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="{{ asset('template') }}/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('template') }}/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('template') }}/images/favicon.png" />
</head>

<body style="background: #57B657;">
  <div class="content-wrapper d-flex align-items-center auth px-0" style="background: #57B657;">
    <div class="row w-100 mx-0">
      <div class="col-lg-8 mx-auto">
        <div class="auth-form-light text-left shadow" style="background: linear-gradient(to top, #ffffff, #ffffff);">
          <div class="row g-0">
            <!----------------- KIRI (GAMBAR) ----------------->
            <div class="col-md-6">
              <img src="{{ asset('template/images/nusawpp.jpg') }}"
                alt="login image"
                style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            </div>

            <!----------------- KANAN (FORM LOGIN) ----------------->
            <div class="col-md-6 py-5 pr-5">
              <div class="brand-logo text-center">
                <img src="{{ asset('template') }}/images/nusalogo.png" alt="logo" style="width: 100px;">
              </div>
              <h4 class="text-center">Baru bergabung?</h4>
              <h6 class="font-weight-light text-center">Buat akun sekarang, prosesnya cepat dan mudah.</h6>

              <form class="pt-3" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                  <input id="name" type="text" placeholder="Nama" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <input id="email" type="email" placeholder="Email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <input id="password" type="password" placeholder="Kata Sandi" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <input id="password-confirm" type="password" placeholder="Konfirmasi Kata Sandi" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    {{ __('Register') }}
                  </button>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Sudah memiliki akun? <a href="/login" style="color: #00a700;">Login</a>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('template') }}/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('template') }}/js/off-canvas.js"></script>
  <script src="{{ asset('template') }}/js/hoverable-collapse.js"></script>
  <script src="{{ asset('template') }}/js/template.js"></script>
  <script src="{{ asset('template') }}/js/settings.js"></script>
  <script src="{{ asset('template') }}/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>

@endsection