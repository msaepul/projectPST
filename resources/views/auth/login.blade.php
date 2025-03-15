<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: sans-serif;
            background: linear-gradient(135deg, #003366, #b0bec5);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #343a40;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            color: white;
            width: 300px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #495057;
            color: white;
        }

        button {
            background-color: #17a2b8;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #138496;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 10px;
        }

        .forgot-password a {
            color: #dc3545;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
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
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username">
                @error('email')
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
                @error('password')
                    <p style="color: red; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember" style="margin-right: 5px;">
                <label for="remember_me" style="display:inline;">{{ __('Remember me') }}</label>
            </div>

            <div class="forgot-password">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <button type="submit">Log in</button>
        </form>
    </div>
</body>

</html>
