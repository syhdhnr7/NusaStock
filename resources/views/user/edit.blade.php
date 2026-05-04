@extends('main')

@section('content')

<div class="card card-body shadow">

    <h3>Edit Data User</h3>
    <hr>

    <form action="/user/update/{{ $user->id }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <div class="input-group">
                <input type="text"
                    class="form-control"
                    name="name"
                    value="{{ $user->name }}"
                    required>
                <span class="input-group-text"><i class="ti-user"></i></span>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <input type="email"
                    class="form-control"
                    name="email"
                    value="{{ $user->email }}"
                    required>
                <span class="input-group-text"><i class="ti-email"></i></span>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <div class="input-group">
                <select name="role" class="form-control">

                    <option value="Admin"
                        {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="User"
                        {{ $user->role == 'user' ? 'selected' : '' }}>
                        User
                    </option>

                </select>
                <span class="input-group-text"><i class="ti-id-badge"></i></span>
            </div>
        </div>

        <br>
        <button class="btn btn-success">
            Update
        </button>

        <a href="/user" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

@endsection