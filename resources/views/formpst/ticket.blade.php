@extends('layouts.main')

@section('content')

    

    <div class="container">
        <h2><center>Pemesanan Tiket</center></h2>
        <form action="#" method="post">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="jumlah">Jumlah Tiket</label>
            <input type="number" id="jumlah" name="jumlah" min="1" required>
            
            <label for="kategori">Kategori Tiket</label>
            <select id="kategori" name="kategori">
                <option value="vip">VIP</option>
                <option value="reguler">Reguler</option>
                <option value="ekonomi">Ekonomi</option>
            </select>
            
            <button type="submit">Pesan Tiket</button>
        </form>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 900px;
            height: 1000px;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 75%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        /* button {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background-color: #218838;
        } */
    </style>
@endsection
