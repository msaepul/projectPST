@extends('layouts.main')

@section('content')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #eef2f7;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            margin: 40px auto;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            color: #555;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            background-color: #f9f9f9;
            font-size: 16px;
            transition: all 0.2s;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        button {
            padding: 12px 30px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>

    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4 mt-3">
                    <div class="card-header bg-primary text-white py-2">
                    </div>

                    <div class="card-body">
                        <h5 class="text-center mb-8">Edit Data User</h5>
                        <div class="card-body">
                            <form method="POST" action="{{ route('ho.user.update', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Nama User:</label>
                                    <input type="text" id="name" name="name" value="{{ $user->name }}"
                                        class="form-control" required>
                                    @error('name')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" value="{{ $user->email }}"
                                        class="form-control" required>
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nik">NIK:</label>
                                    <input type="text" id="nik" name="nik" value="{{ $user->nik }}"
                                        class="form-control" required>
                                    @error('nik')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Departemen:</label>
                                    <select class="form-control" name="departemen" required>
                                        @foreach ($departemens as $departemen)
                                            <option value="{{ $departemen->nama_departemen }}"
                                                {{ $user->departemen == $departemen->nama_departemen ? 'selected' : '' }}>
                                                {{ $departemen->nama_departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Cabang Asal:</label>
                                    <select class="form-control" name="cabang_asal" required>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->nama_cabang }}"
                                                {{ $user->cabang_asal == $cabang->nama_cabang ? 'selected' : '' }}>
                                                {{ $cabang->nama_cabang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="no_hp">No HP:</label>
                                    <input type="text" id="no_hp" name="no_hp" value="{{ $user->no_hp }}"
                                        class="form-control" required>
                                    @error('no_hp')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role">Role:</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>

                                <div class="btn-container">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('ho.user') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                @endsection
