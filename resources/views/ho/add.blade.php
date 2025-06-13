@extends('layouts.main')

@section('content')
   

    <div class="container">
        <h2>Tambah User Baru</h2>
        <form method="POST" action="{{ route('ho.user.store') }}">
            @csrf

            <!-- Row 1: Name and Email -->

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                @error('nama_lengkap')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama User:</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row 2: Password and NIK -->
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <span class="icon" id="togglePassword">&#128065;</span>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nik">NIK:</label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required>
                    @error('nik')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Departemen Selection -->
            <div class="form-group">
                <label>Departemen:</label>
                <select class="form-control" name="departemen" required>
                    <option value="">Pilih Departemen</option>
                    @foreach ($departemens as $departemen)
                        <option value="{{ $departemen->id }}"
                            {{ old('departemen') == $departemen->id ? 'selected' : '' }}>
                            {{ $departemen->nama_departemen }}
                        </option>
                    @endforeach
                </select>
                @error('departemen')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Cabang Asal Selection -->
            
            <div class="form-group">
                <label>Cabang Asal:</label>
                <select class="form-control" name="cabang_asal" required>
                    <option value="">Pilih Cabang</option>
                    @foreach ($cabangs as $cabang)
                        <option value="{{ $cabang->kode_cabang }}" {{ old('cabang_asal') == $cabang->kode_cabang ? 'selected' : '' }}>
                            {{ $cabang->nama_cabang }} - {{ $cabang->kode_cabang }}
                        </option>
                    @endforeach
                </select>
                @error('cabang_asal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Row 3: No HP and Role -->
            <div class="form-row">
                <div class="form-group">
                    <label for="no_hp">No HP:</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                    @error('no_hp')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="bm" {{ old('role') == 'bm' ? 'selected' : '' }}>BM</option>
                        <option value="hrd" {{ old('role') == 'hrd' ? 'selected' : '' }}>HRD</option>
                        <option value="nm" {{ old('role') == 'nm' ? 'selected' : '' }}>NM</option>
                        <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>

                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit">Tambah</button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            this.innerHTML = type === 'password' ? '&#128065;' : '&#128064;';
        });
    </script>

     <style>
        /* General Styling */
        /* body {
                    font-family: 'Arial', sans-serif;
                    background: #f8f9fa;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    margin: 0;
                } */


        /* Container Styling */
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            width: 600px;
            margin-top: 20px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
            color: #343a40;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #495057;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            background-color: white;
            color: #495057;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        input:focus,
        select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            border: none;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        button:hover {
            background-color: #0069d9;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group .icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ced4da;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .container {
                width: 90%;
            }
        }

        .error-message {
            color: red;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
@endsection
