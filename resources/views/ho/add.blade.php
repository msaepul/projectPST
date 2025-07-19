@extends('layouts.main')

@section('content')
<div class="container-modern">
    <h2 class="form-title">Tambah User Baru</h2>
    <form method="POST" action="{{ route('ho.user.store') }}">
        @csrf

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
            @error('nama_lengkap')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="name">Nama User</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group password-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="toggle-password" id="togglePassword">
                    <i class="bi bi-eye"></i>
                </span>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required>
                @error('nik')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="departemen">Departemen</label>
            <select name="departemen" required>
                <option value="">Pilih Departemen</option>
                @foreach ($departemens as $departemen)
                    <option value="{{ $departemen->id }}" {{ old('departemen') == $departemen->id ? 'selected' : '' }}>
                        {{ $departemen->nama_departemen }}
                    </option>
                @endforeach
            </select>
            @error('departemen')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="cabang_asal">Cabang Asal</label>
            <select name="cabang_asal" required>
                <option value="">Pilih Cabang</option>
                @foreach ($cabangs as $cabang)
                    <option value="{{ $cabang->kode_cabang }}" {{ old('cabang_asal') == $cabang->kode_cabang ? 'selected' : '' }}>
                        {{ $cabang->nama_cabang }} - {{ $cabang->kode_cabang }}
                    </option>
                @endforeach
            </select>
            @error('cabang_asal')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                @error('no_hp')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="bm" {{ old('role') == 'bm' ? 'selected' : '' }}>BM</option>
                    <option value="hrd" {{ old('role') == 'hrd' ? 'selected' : '' }}>HRD</option>
                    <option value="nm" {{ old('role') == 'nm' ? 'selected' : '' }}>NM</option>
                    <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                </select>
            </div>
        </div>

        <button type="submit" class="submit-btn">Tambah User</button>
    </form>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>

<style>
    .container-modern {
        background: #fff;
        padding: 40px;
        max-width: 700px;
        margin: 30px auto;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }

    .form-title {
        text-align: center;
        font-size: 26px;
        margin-bottom: 30px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    input, select {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #fafafa;
        font-size: 15px;
        transition: 0.2s all;
    }

    input:focus, select:focus {
        border-color: #5b9bd5;
        outline: none;
        background-color: #fff;
    }

    .submit-btn {
        width: 100%;
        padding: 14px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 37px;
        cursor: pointer;
        font-size: 18px;
        color: #999;
    }

    .error-message {
        color: red;
        font-size: 13px;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .container-modern {
            padding: 25px;
        }
    }
</style>
@endsection
