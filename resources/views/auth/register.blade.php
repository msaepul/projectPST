<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #003366, #b0bec5);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #343a40;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            color: white;
            width: 400px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #ffffff;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #495057;
            background-color: #495057;
            color: white;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 8px rgba(23, 162, 184, 0.8);
        }

        button {
            background-color: #17a2b8;
            color: white;
            padding: 12px;
            border-radius: 8px;
            border: none;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #138496;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .link-container {
            margin-top: 15px;
            text-align: center;
        }

        .link-container a {
            color: #dc3545;
            text-decoration: none;
            font-size: 14px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row .form-group {
            margin-bottom: 10px;
        }

        .form-group .icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ced4da;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <p style="text-align: center; margin-bottom: 20px;">Silakan Daftar dengan Email Anda</p>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                @error('nama_lengkap')
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama User:</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <span class="icon" id="togglePassword"></span>
                    @error('password')
                        <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nik">NIK:</label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required>
                    @error('nik')
                        <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- <div class="form-group">
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
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Cabang Asal:</label>
                <select class="form-control" name="cabang_asal" required>
                    <option value="">Pilih Cabang</option>
                    @foreach ($cabangs as $cabang)
                        <option value="{{ $cabang->id }}" {{ old('cabang_asal') == $cabang->id ? 'selected' : '' }}>
                            {{ $cabang->nama_cabang }}
                        </option>
                    @endforeach
                </select>
                @error('cabang_asal')
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div> --}}

            <div class="form-row">
                <div class="form-group">
                    <label for="no_hp">No HP:</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                    @error('no_hp')
                        <p style="color: red; margin-top: 5px;">{{ $message }}</p>
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

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="new-password">
                <span class="icon" id="toggleConfirmPassword"></span>
                @error('password_confirmation')
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">Register</button>

            <div class="link-container">
                <a href="{{ route('login') }}">Already registered?</a>
            </div>
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

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('password_confirmation');

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.type === 'password' ? 'text' : 'password';
            confirmPassword.type = type;
            this.innerHTML = type === 'password' ? '&#128065;' : '&#128064;';
        });
    </script>
</body>

</html>
