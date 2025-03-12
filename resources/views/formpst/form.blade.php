@extends('layouts.main')

@section('content')

    {{ Breadcrumbs::render('Form') }}

    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo">
                <h4 style="margin: 0; margin-left: 10px;">Form Permintaan</h4>
            </div>
        </div>

        <div class="card-body">
            @php
                $actionRoute = route('formpst.store', ['role' => auth()->user()->role]);
            @endphp

            <form id="suratTugasForm" action="{{ $actionRoute }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="noSurat">No. Surat</label>
                            <input type="text" class="form-control form-control-sm" name="no_surat" id="noSurat"
                                value="{{ $nomorSurat }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="namaPemohon">Nama Pemohon</label>
                            <input type="text" id="namaPemohon" name="namaPemohon" class="form-control"
                                value="{{ old('namaPemohon', Auth::user()->nama_lengkap ?? '') }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="cabangAsal">Cabang Asal</label>
                            <input type="text" id="cabangAsal" name="cabangAsal" class="form-control"
                                value="{{ old('cabangAsal', Auth::user()->cabang_asal ?? '') }}" required readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cabangTujuan">Cabang Tujuan</label>
                            <select class="form-control select2" name="cabang_tujuan" id="cabangTujuan" required>
                                <option value="" disabled selected>Pilih Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tujuan">Tujuan Penugasan</label>
                            <select class="form-control select2" name="tujuan" id="tujuan" required>
                                <option value="" disabled selected>Pilih Tujuan</option>
                                @foreach ($tujuans as $tujuan)
                                    <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan_penugasan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggalKeberangkatan">Tanggal Keberangkatan</label>
                            <input type="date" id="tanggalKeberangkatan" name="tanggalKeberangkatan" class="form-control"
                                required>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">Daftar Pegawai yang Berangkat</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pegawaiTable" class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>NIK</th>
                                        <th>No. HP</th>
                                        <th>Ditugaskan Oleh</th>
                                        <th>Status Koordinasi</th>
                                        <th>Lama Keberangkatan</th>
                                        <th>Estimasi</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="rowToClone">
                                        <td>
                                            <select name="namaPegawai" class="form-control namaPegawai" required>
                                                <option value="" disabled selected>Pilih Nama</option>
                                                @if (auth()->user()->role !== 'nm')
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            data-departemen="{{ $user->departemen }}"
                                                            data-nik="{{ $user->nik }}"
                                                            data-nama="{{ $user->nama_lengkap }}">
                                                            {{ $user->nama_lengkap }} / {{ $user->departemen }} /
                                                            {{ $user->nik }}
                                                        </option>
                                                    @endforeach
                                                @endif

                                                @if (auth()->user()->role === 'nm')
                                                    @foreach ($nm as $user)
                                                        <option value="{{ $user->id }}"
                                                            data-departemen="{{ $user->departemen }}"
                                                            data-nik="{{ $user->nik }}"
                                                            data-nama="{{ $user->nama_lengkap }}">
                                                            {{ $user->nama_lengkap }} / {{ $user->departemen }} /
                                                            {{ $user->nik }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" name="namaPegawaiId" class="namaPegawaiId">
                                            <input type="text" class="form-control namaPegawaiDisplay" readonly>
                                        </td>
                                        <td><input type="text" name="departemen" class="form-control departemen"
                                                readonly></td>
                                        <td><input type="text" name="nik" class="form-control nik" readonly></td>
                                        <td><input type="text" name="noHp" class="form-control noHp" required></td>
                                        <td><input type="text" name="ditugaskanOleh" class="form-control ditugaskanOleh"
                                                required></td>
                                        <td>
                                            <select name="statusKoordinasi" class="form-control statusKoordinasi" required>
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option value="Sudah Koordinasi">Sudah Koordinasi</option>
                                                <option value="Belum Koordinasi">Belum Koordinasi</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date" name="tanggalBerangkat"
                                                    class="form-control tanggalBerangkat" required>
                                                <span class="mx-2">s/d</span>
                                                <input type="date" name="tanggalKembali"
                                                    class="form-control tanggalKembali" required>
                                            </div>
                                        </td>
                                        <td><input type="text" name="estimasi" class="form-control estimasi" required>
                                        </td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn btn-danger btn-remove">
                                                <i class="bi bi-trash" style="font-size: 16px; margin-right: 4px;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary mt-3" id="add-field">Tambah Pegawai</button>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success me-2">Submit Form</button>
                    <button type="reset" class="btn btn-secondary">Reset Form</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <script>
        document.getElementById('pegawaiContainer').addEventListener('change', function(event) {
            if (event.target.classList.contains('namaPegawai')) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const row = event.target.closest('.pegawai-row');
                const departemenInput = row.querySelector('.departemen');
                const nikInput = row.querySelector('.nik');
                const namaPegawaiDisplayInput = row.querySelector('.namaPegawaiDisplay');
                const namaPegawaiId = row.querySelector('.namaPegawaiId');

                if (selectedOption && departemenInput && nikInput && namaPegawaiDisplayInput) {
                    departemenInput.value = selectedOption.getAttribute('data-departemen');
                    nikInput.value = selectedOption.getAttribute('data-nik');
                    namaPegawaiDisplayInput.value = selectedOption.getAttribute('data-nama');
                    namaPegawaiId.value = selectedOption.value;

                    // Sembunyikan dropdown, tampilkan input text
                    event.target.style.display = 'none';
                    namaPegawaiDisplayInput.style.display = 'block';

                    // Blur dropdown agar otomatis hilang
                    event.target.blur();
                }
            }
        });

        // Klik input namaPegawaiDisplay untuk mengganti nama
        document.getElementById('pegawaiContainer').addEventListener('click', function(event) {
            if (event.target.classList.contains('namaPegawaiDisplay')) {
                const row = event.target.closest('.pegawai-row');
                const dropdown = row.querySelector('.namaPegawai');

                // Tampilkan kembali dropdown, sembunyikan input text
                dropdown.style.display = 'block';
                event.target.style.display = 'none';

                // Fokus ke dropdown agar bisa langsung memilih
                dropdown.focus();
            }
        });

        // Tambah Baris Baru
        document.getElementById('add-field').addEventListener('click', function() {
            const rowToClone = document.getElementById('rowToClone');
            if (rowToClone) {
                const newRow = rowToClone.cloneNode(true);
                newRow.removeAttribute('id');
                newRow.querySelectorAll('input, select').forEach(input => input.value = '');
                document.getElementById('pegawaiContainer').appendChild(newRow);

                // Aktifkan Select2 di dropdown yang baru
                $(newRow).find('.select2').select2();

                // Pastikan input text kosong dan dropdown terlihat
                newRow.querySelector('.namaPegawaiId').value = '';
                newRow.querySelector('.namaPegawaiDisplay').value = '';
                newRow.querySelector('.namaPegawai').style.display = 'block';
                newRow.querySelector('.namaPegawaiDisplay').style.display = 'none';
            }
        });

        // Menghapus Baris
        document.getElementById('pegawaiContainer').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove')) {
                event.target.closest('.pegawai-row').remove();
            }
        });

        // Menambahkan Nama Pegawai ke Form Saat Submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const namaPegawaiInputs = document.querySelectorAll('.namaPegawai');
            namaPegawaiInputs.forEach((select, index) => {
                const selectedOption = select.options[select.selectedIndex];
                const nama = selectedOption.getAttribute('data-nama');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `namaPegawaiNama[${index}]`;
                input.value = nama;
                this.appendChild(input);
            });
        });

        // Mengaktifkan Select2 pada dropdown
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 10px;
        }

        .card-container {
            position: relative;
        }

        .card {
            position: relative;
            z-index: 1;
        }

        .card-header {
            background-color: #3b0100;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .card-body {
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .logo {
            height: 40px;
            width: auto;
        }

        form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .select2 {
            width: 100% !important;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .btn {
            padding: 10px;
            font-size: 14px;
            border: none;
            color: white;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #0415f8;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        /* Tambahan CSS untuk layout yang lebih rapi */
        .card-body .row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card-body .col-md-6 {
            flex: 1 1 48%;
            min-width: 300px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        #pegawaiTable {
            width: 100%;
            border-collapse: collapse;
        }

        #pegawaiTable th,
        #pegawaiTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #pegawaiTable th {
            background-color: #f2f2f2;
        }

        #pegawaiTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #pegawaiTable input[type="text"],
        #pegawaiTable input[type="date"],
        #pegawaiTable select {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        #pegawaiTable .d-flex {
            gap: 5px;
        }
    </style>
@endsection
