@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">

@include('../partials/_head')

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
              <h4 class="text-center font-weight-medium">Halo, Selamat Datang!</h4>
              <p class="font-weight-light text-center">Silahkan login untuk melanjutkan.</p>

              <form class="pt-3" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group mb-2 mt-3">
                  <span class="input-group-text bg-primary text-white"><i class="fas fa-envelope"></i></span>
                  <input id="email" type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Masukkan Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="input-group mt-3 mb-4">
                  <span class="input-group-text bg-primary text-white"><i class="fas fa-lock"></i></span>
                  <input id="password" type="password" class="form-control form-control-lg border-right-0 @error('password') is-invalid @enderror" placeholder="Masukkan Kata Sandi" name="password" required autocomplete="current-password">

                  <button
                    type="button"
                    class="input-group-text bg-white border-left-0"
                    onclick="togglePassword()">
                    <i id="eyeIcon" class="fas fa-eye"></i>
                  </button>

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="mt-4">
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
                  <a href="{{ route('forgot.password') }}"
                    class="auth-link text-muted">
                    Lupa kata sandi?
                  </a>
                </div>

                <div class="text-center mt-5 font-weight-light">
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
  <script>
    function togglePassword() {
      const password = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');

      if (password.type === 'password') {
        password.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        password.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }
  </script>
  <!-- endinject -->
</body>

</html>

@endsection