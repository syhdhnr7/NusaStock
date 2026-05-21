@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">

@include('../../partials/_head')

<body style="background: #57B657;">
    <div class="content-wrapper d-flex align-items-center auth px-0" style="background: #57B657;">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left shadow" style="background: linear-gradient(to top, #ffffff, #ffffff);">
                    <div class="py-5 px-5">
                        <div class="brand-logo text-center">
                            <img src="{{ asset('template') }}/images/nusalogo.png" alt="logo" style="width: 120px;">
                        </div>
                        <h4 class="text-center font-weight-medium">Bantuan Kata Sandi</h4>
                        <p class="font-weight-light text-center mb-4">Silahkan masukkan nama anda untuk lanjut mengganti kata sandi.</p>
                        @if (session('error'))
                        <div class="alert alert-danger mt-2">
                            {{ session('error') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('password.check') }}">
                            @csrf
                            <div class="input-group mt-2">
                                <input type="text"
                                    name="name"
                                    placeholder="Masukkan Nama" class="form-control form-control-lg">
                            </div>

                            <div class="mt-4 mb-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                    {{ __('Lanjut') }}
                                </button>
                            </div>
                            <div class="d-flex align-items-center my-2">
                                <hr class="flex-grow-1">
                                <span class="px-3 text-muted">Atau</span>
                                <hr class="flex-grow-1">
                            </div>
                            <div class="text-center mt-3 font-weight-light">
                                <a href="../login" style="color: #00a700;">
                                    Kembali Ke Halaman Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

@endsection