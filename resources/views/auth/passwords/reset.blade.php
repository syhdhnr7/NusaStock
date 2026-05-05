@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password baru">
    <input type="password" name="password_confirmation" required placeholder="Konfirmasi password">

    <button type="submit">Reset Password</button>
</form>

@endsection
