@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4 mt-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo">
                            <h4 style="margin: 0; margin-left: 10px;">Edit Surat</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('formpst.update', $form->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No Surat:</label>
                                        <input type="text" class="form-control" value="{{ $form->no_surat }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Pemohon:</label>
                                        <input type="text" class="form-control" value="{{ $form->nama_pemohon }}"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Cabang Asal:</label>
                                        <input type="text" class="form-control" value="{{ $form->cabang_asal }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{-- <div class="form-group">
                                        <label>Cabang Tujuan:</label>
                                        <input type="text" class="form-control" value="{{ $form->cabang_tujuan }}"
                                            readonly>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="cabang_tujuan">Cabang Tujuan</label>
                                        <select name="cabang_tujuan" id="cabang_tujuan" class="form-control">
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}"
                                                    {{ $cabang->kode_cabang == $form->cabang_tujuan ? 'selected' : '' }}>
                                                    {{ $cabang->nama_cabang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tujuan">Tujuan</label>
                                        <select name="tujuan" id="tujuan" class="form-control">
                                            @foreach ($tujuans as $tujuan)
                                                <option value="{{ $tujuan->tujuan_penugasan }}"
                                                    {{ $tujuan->tujuan_penugasan == $form->tujuan ? 'selected' : '' }}>
                                                    {{ $tujuan->tujuan_penugasan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Keberangkatan:</label>
                                        <input type="date" name="tanggal_keberangkatan" class="form-control"
                                            value="{{ $form->tanggal_keberangkatan }}">
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header">Daftar Pegawai yang Berangkat</div>
                                <div class="card-body">
                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>NIK</th>
                                                    <th>Departemen</th>
                                                    <th>Lama Keberangkatan</th>
                                                    <th>File</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($nama_pegawais as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="nama[{{ $item->id }}]"
                                                                value="{{ old('nama.' . $item->id, $item->nama_pegawai) }}"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nik[{{ $item->id }}]"
                                                                value="{{ old('nik.' . $item->id, $item->nik) }}"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="departemen[{{ $item->id }}]"
                                                                value="{{ old('departemen.' . $item->id, $item->departemen) }}"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <input type="date"
                                                                    name="lama_keberangkatan[{{ $item->id }}][tanggal_berangkat]"
                                                                    value="{{ old('lama_keberangkatan.' . $item->id . '.tanggal_berangkat', $item->tanggal_berangkat) }}"
                                                                    class="form-control">

                                                                <span class="mx-2">s/d</span>

                                                                <input type="date"
                                                                    name="lama_keberangkatan[{{ $item->id }}][tanggal_kembali]"
                                                                    value="{{ old('lama_keberangkatan.' . $item->id . '.tanggal_kembali', $item->tanggal_kembali) }}"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($item->upload_file)
                                                                <div class="file-actions d-flex align-items-center">
                                                                    <a href="{{ asset('storage/' . $item->upload_file) }}"
                                                                        target="_blank" class="file-link">
                                                                        <i class="fas fa-file-pdf"></i> Lihat File
                                                                    </a>
                                                                    <label for="file-{{ $item->id }}"
                                                                        class="btn btn-primary btn-sm mx-1">
                                                                        <i class="fas fa-edit"></i>
                                                                    </label>
                                                                    <input type="file" name="file[{{ $item->id }}]"
                                                                        id="file-{{ $item->id }}"
                                                                        style="display: none;">
                                                                </div>
                                                            @else
                                                                <label for="file-{{ $item->id }}"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-upload"></i>
                                                                </label>
                                                                <input type="file" name="file[{{ $item->id }}]"
                                                                    id="file-{{ $item->id }}" style="display: none;">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="btn-container mt-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <a href="{{ route('formpst.index_keluar') }}" class="btn btn-danger">Kembali</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .container {
            max-width: 1200px;
            padding: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin: 30px 0 20px 0;
            /* Atas: 30px, Bawah: 20px */
            padding: 10px 20px;
            /* Tambah padding kiri & kanan */
        }

        .btn {
            padding: 10px;
            font-size: 14px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .card-header {
            background-color: #3b0100;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .logo {
            height: 40px;
            width: auto;
        }

        .table-responsive {
            overflow-x: auto;
            white-space: nowrap;
        }

        .table {
            min-width: 1200px;
            /* Sesuaikan dengan kebutuhan */
        }

        .file-actions {
            display: flex;
            align-items: center;
        }

        .file-link {
            display: inline-flex;
            align-items: center;
            margin-right: 10px;
            /* Tambahkan margin kanan untuk memberi jarak */
        }
    </style>
@endsection
