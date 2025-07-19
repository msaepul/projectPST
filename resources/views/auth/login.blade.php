<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Learn to Code</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #eef1f7;
        }

        .left {
            flex: 1;
            background: linear-gradient(135deg, #6c5ce7, #0984e3);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
        }

        .left h1 {
            font-size: 42px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .left p {
            font-size: 18px;
            opacity: 0.9;
        }

        .right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            background-color: white;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #6c5ce7;
            outline: none;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 15px;
        }

        .forgot-password a {
            color: #6c5ce7;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        button[type="submit"] {
            width: 100%;
            background-color: #6c5ce7;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #5945d3;
        }

        .status-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .error-message {
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .left,
            .right {
                width: 100%;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="left">
        <h1>SELAMAT DATANG!</h1>
        <p>Ajukan Surat Tugasmu dengan Mudah dan Cepat.</p>
        <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png" alt="Surat Tugas" width="140"
            style="margin-top:20px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
    </div>

    <div class="right">
        <div class="login-box">
            <h2>Masuk ke Akun</h2>

            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">{{ __('Ingat Saya') }}</label>
                </div>

                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
