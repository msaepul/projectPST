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
        }

        .left {
            flex: 1;
            background-color: #7b9ce6;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .left h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .left p {
            font-size: 20px;
        }

        .right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f5f6fa;
            padding: 40px;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            background-color: #6c5ce7;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            margin-top: 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #5a4bcc;
        }

        .remember-me {
            margin: 10px 0;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 10px;
        }

        .forgot-password a {
            color: #6c5ce7;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .social-login {
            text-align: center;
            margin-top: 20px;
        }

        .social-login button {
            margin: 5px;
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .google-btn {
            background-color: #db4437;
            color: white;
        }

        .facebook-btn {
            background-color: #3b5998;
            color: white;
        }

        .github-btn {
            background-color: #333;
            color: white;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .left,
            .right {
                flex: none;
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="left">
        <h1>SELAMAT DATANG!</h1>
        <p>Ajukan Surat Tugasmu dengan Mudah dan Cepat.</p>
        <!-- Gambar ilustrasi surat -->
        <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png" alt="Surat Tugas" width="150"
            style="margin-top:20px;">
    </div>

    <div class="right">
        <div class="login-box">
            <h2>Login</h2>

            @if (session('status'))
                <div style="color: green; margin-bottom: 10px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <p style="color: red; font-size: 13px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <p style="color: red; font-size: 13px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">{{ __('Remember me') }}</label>
                </div>

                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit">Login</button>
            </form>

            <div class="social-login">
                <p>or login with</p>
                <button class="google-btn">Google</button>
                <button class="facebook-btn">Facebook</button>
                <button class="github-btn">GitHub</button>
            </div>
        </div>
    </div>
</body>

</html>
