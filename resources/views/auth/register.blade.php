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
            /* Gradasi biru navy dan abu */
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
            /* Tambahkan bayangan pada container */
            color: white;
            width: 400px;
            /* Ukuran container sedikit lebih kecil */
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
        input[type="password"] {
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
        input[type="password"]:focus {
            border-color: #17a2b8;
            /* Border berubah saat focus */
            box-shadow: 0 0 8px rgba(23, 162, 184, 0.8);
            /* Efek shadow saat fokus */
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
            /* Efek hover pada tombol */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            /* Efek bayangan tombol saat hover */
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

        /* Grid layout untuk dua kolom */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row .form-group {
            margin-bottom: 10px;
        }

        /* Menyesuaikan ukuran icon di password */
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
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name">
                @error('name')
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    autocomplete="username">
                @error('email')
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Menggunakan layout dua kolom untuk NIK dan Departemen -->
            <div class="form-row">
                <div class="form-group">
                    <label for="nik">{{ __('NIK') }}</label>
                    <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror"
                        name="nik" value="{{ old('nik') }}" required>
                    @error('nik')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="departemen">{{ __('Departemen') }}</label>
                    <input id="departemen" type="text" class="form-control @error('departemen') is-invalid @enderror"
                        name="departemen" value="{{ old('departemen') }}" required>
                    @error('departemen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Menggunakan layout dua kolom untuk Cabang Asal dan No HP -->
            <div class="form-row">
                <div class="form-group">
                    <label for="cabang_asal">{{ __('Cabang Asal') }}</label>
                    <input id="cabang_asal" type="text"
                        class="form-control @error('cabang_asal') is-invalid @enderror" name="cabang_asal"
                        value="{{ old('cabang_asal') }}" required>
                    @error('cabang_asal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_hp">{{ __('No HP') }}</label>
                    <input id="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror"
                        name="no_hp" value="{{ old('no_hp') }}" required>
                    @error('no_hp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Password dan Confirm Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">
                <span class="icon" id="togglePassword">🔒</span> <!-- Ikon mata untuk password -->
                @error('password')
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="new-password">
                <span class="icon" id="toggleConfirmPassword">🔒</span> <!-- Ikon mata untuk konfirmasi password -->
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
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            this.textContent = type === 'password' ? '🔒' : '🔓';
        });

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('password_confirmation');

        toggleConfirmPassword.addEventListener('click', function(e) {
            const type = confirmPassword.type === 'password' ? 'text' : 'password';
            confirmPassword.type = type;
            this.textContent = type === 'password' ? '🔒' : '🔓';
        });
    </script>
</body>

</html>
