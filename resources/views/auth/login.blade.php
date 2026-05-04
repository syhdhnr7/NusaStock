@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
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
                <img src="{{ asset('template') }}/images/nusalogo.png" alt="logo" style="width: 120px;">
              </div>
              <h4 class="text-center">Halo, Selamat Datang!</h4>
              <h6 class="font-weight-light text-center">Silahkan login untuk melanjutkan.</h6>

              <form class="pt-3" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                  <input id="email" type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Masukkan Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Masukkan Kata Sandi" name="password" required autocomplete="current-password">

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    {{ __('Login') }}
                  </button>
                </div>

                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      Ingat saya
                    </label>
                  </div>
                  @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="auth-link text-black">Lupa kata sandi?</a>
                  @endif
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Belum memiliki akun? <a href="/register" style="color: #00a700;">Daftar</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
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