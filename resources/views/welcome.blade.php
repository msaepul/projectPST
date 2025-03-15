<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Surat Tugas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background: linear-gradient(to bottom right, #2980b9, #34495e);
            color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .container {
            background-color: rgba(44, 62, 80, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 450px;
            backdrop-filter: blur(5px);
        }

        .icon-surat {
            font-size: 80px;
            margin-bottom: 25px;
            color: #fff;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 2em;
            margin-bottom: 15px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        p {
            font-size: 1.1em;
            color: #bdc3c7;
            line-height: 1.6;
            margin-bottom: 30px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .login-button {
            display: inline-block;
            padding: 14px 30px;
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
        }

        .login-button:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="antialiased">
    <div class="container">
        <i class="fas fa-envelope-open-text icon-surat"></i>
        <h1>Selamat Datang</h1>
        <p>Website ini dibuat untuk mempermudah proses pengajuan surat tugas. Anda dapat mengajukan surat tugas secara
            online dengan mudah dan cepat. Silakan login untuk memulai proses pengajuan.</p>

        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="login-button">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="login-button">Log in</a>
            @endauth
        @endif
    </div>
</body>

</html>
