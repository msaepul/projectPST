@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    
    <div class="container">
        <div class="card mb-6">
            <div class="card-header">
                <h4 style="margin: 0;">Form Permintaan</h4>
            </div>
            <div class="card-body">
                <form id="suratTugasForm" action="{{ route('formpst.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="noSurat">No. Surat</label>
                                    <input type="text" class="form-control form-control-sm" name="no_surat" id="noSurat"
                                           value="{{ $nomorSurat }}" readonly required style="width: 100%;">
                                </div>
                    
                                <div class="col-md-12 mb-3">
                                    <label for="namaPemohon">Nama Pemohon</label>
                                    <input type="text" id="namaPemohon" name="namaPemohon" class="form-control" 
                                           value="{{ old('namaPemohon', Auth::user()->nama_lengkap ?? '') }}" required readonly style="width: 100%;">
                                </div>
                    
                                <div class="col-md-12 mb-3">
                                    <label for="cabangAsal">Cabang Asal</label>
                                    <input type="text" id="cabangAsal" name="cabangAsal" class="form-control" 
                                           value="{{ old('cabangAsal', Auth::user()->cabang_asal ?? '') }}" required readonly style="width: 100%;">
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="cabangTujuan">Cabang Tujuan</label>
                                    <select class="form-control select2" name="cabang_tujuan" id="cabangTujuan" required style="width: 100%;">
                                        <option value="" disabled selected>Pilih Cabang</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <div class="col-md-12 mb-3">
                                    <label for="tujuan">Tujuan Penugasan</label>
                                    <select class="form-control select2" name="tujuan" id="tujuan" required style="width: 100%;">
                                        <option value="" disabled selected>Pilih Tujuan</option>
                                        @foreach ($tujuans as $tujuan)
                                            <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan_penugasan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <div class="col-md-12 mb-3">
                                    <label for="tanggalKeberangkatan">Tanggal Keberangkatan</label>
                                    <input type="date" id="tanggalKeberangkatan" name="tanggalKeberangkatan" class="form-control" required style="width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card_1">
                        <div class="card-header">
                            Daftar Pegawai yang Berangkat
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pegawaiTable" class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 10%;">Nama</th>
                                            <th style="width: 10%;">Departemen</th>
                                            <th style="width: 10%;">NIK</th>
                                            <th style="width: 10%;">Upload File</th>
                                            <th style="width: 10%;">Lama Keberangkatan</th>
                                            <th style="width: 5%; text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="rowToClone">
                                            <td>
                                                <select name="namaPegawai[]" class="form-control namaPegawai " required>
                                                    <option value="" disabled selected>Pilih Nama</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            data-departemen="{{ $user->departemen }}"
                                                            data-nik="{{ $user->nik }}"
                                                            data-nama="{{ $user->nama_lengkap }}">
                                                            {{ $user->nama_lengkap }} / {{ $user->departemen }} / {{ $user->nik }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" name="departemen[]" class="form-control departemen" readonly></td>
                                            <td><input type="text" name="nik[]" class="form-control nik" readonly></td>
                                            <td><input type="file" name="uploadFile[]" class="form-control"></td>
                                            <td><input type="date" name="lamaKeberangkatan[]" class="form-control" required></td>
                                            <td style="text-align: center;"><button type="button" class="btn btn-danger btn-remove">Hapus</button></td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <button type="button" class="btn btn-primary mt-3" id="add-field">Tambah Pegawai</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-4">Submit Form</button>
                    <button type="reset" class="btn btn-secondary mt-4">Reset Form</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Tambah Baris Baru
        document.getElementById('add-field').addEventListener('click', function() {
            const rowToClone = document.getElementById('rowToClone');
            if (rowToClone) {
                const newRow = rowToClone.cloneNode(true);
                newRow.removeAttribute('id');
                // Reset values
                newRow.querySelectorAll('input, select').forEach(input => input.value = '');
                // Append the new row to the table
                document.querySelector('#pegawaiTable tbody').appendChild(newRow);
                // Reinitialize Select2 after cloning
                $(newRow).find('.select2').select2();
            } else {
                console.error("Element 'rowToClone' tidak ditemukan.");
            }
        });

        document.querySelector('#pegawaiTable').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove')) {
                event.target.closest('tr').remove();
            }
        });
    
    
        // Update Kolom Departemen dan NIK Berdasarkan Pilihan Dropdown
        document.querySelector('#pegawaiTable').addEventListener('change', function(event) {
            if (event.target.classList.contains('namaPegawai')) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const row = event.target.closest('tr');
                
                // Update Departemen dan NIK hanya jika Nama Pegawai dipilih
                const departemenInput = row.querySelector('.departemen');
                const nikInput = row.querySelector('.nik');
                
                if (selectedOption && departemenInput && nikInput) {
                    // Isi departemen dan NIK berdasarkan data pegawai
                    departemenInput.value = selectedOption.getAttribute('data-departemen');
                    nikInput.value = selectedOption.getAttribute('data-nik');
                }
            }
        });
    
        // Tambahkan Nama Lengkap Pegawai ke Form Saat Submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const namaPegawaiInputs = document.querySelectorAll('.namaPegawai');
            namaPegawaiInputs.forEach((select, index) => {
                const selectedOption = select.options[select.selectedIndex];
                const nama = selectedOption.getAttribute('data-nama');
    
                // Buat hidden input untuk mengirim nama lengkap
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `namaPegawaiNama[${index}]`; // Pastikan nama sesuai dengan backend
                input.value = nama;
                this.appendChild(input); // Tambahkan ke form
            });
        });
    
        $(document).ready(function() {
        // Aktifkan select2 untuk dropdown tujuan penugasan dan cabang tujuan
        $('.select2').select2();
    });
    </script>
    
    <style>
        /* Gaya untuk container utama */
        .container {
            max-width: 950px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Jika Anda ingin background di card */
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            background-image: url('{{ asset('dist/img/arnon.png') }}');
            background-size: 30%; 
            background-position: 50% 30%; 
            background-repeat: no-repeat;
        }

        /* Gaya untuk card header */
        .card-header {
            background-color: #3b0100;
            color: white;
            padding: 10px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        /* Gaya untuk card body */
        .card-body {
            padding: 20px;
        }

        /* Gaya untuk form */
        form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }

        /* Gaya untuk tabel */
        .table {
            width: 100%;
            min-width: 1200px;
            table-layout: auto;
            border-collapse: collapse;
        }

        /* Gaya untuk header tabel */
        .table thead th {
            background-color: #f0f0f0;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        /* Gaya untuk sel tabel */
        .table tbody td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        /* Gaya untuk tombol */
        .btn {
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        /* Gaya untuk tombol primary */
        .btn-primary {
            background-color: #0415f8;
            color: white;
            border: none;
        }

        /* Gaya untuk tombol danger */
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        /* Gaya untuk tombol success */
        .btn-success {
            background-color: #28a745;
            color: white;
            border: none;
        }

        /* Gaya untuk tombol secondary */
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
        }

        /* Gaya untuk input dan select */
        .form-control {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Gaya untuk select2 */
        .select2 {
            width: 100% !important;
        }
    </style>

    
@endsection