@extends('layouts.main')

@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo">
                <h4 class="mb-0 ms-2">Form Permintaan</h4>
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
                            <label for="yangMenugaskan">Ditugaskan oleh</label>
                            <select class="form-control select2" name="yangMenugaskan" id="yangMenugaskan" required>
                                <option value="" disabled selected>Pilih Nama</option>
                                @foreach ($users as $user)
                                    @if (in_array($user->role, ['bm', 'nm']))
                                        <option value="{{ $user->id }}">
                                            {{ $user->nama_lengkap }} - {{ $user->departemen }} - {{ $user->cabang_asal }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
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
                                    <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }} /
                                        {{ $cabang->kode_cabang }}</option>
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
                        <div class="form-group">
                            <label for="statusKoordinasi">Status Koordinasi</label>
                            <input type="text" id="statusKoordinasi" name="statusKoordinasi" class="form-control"
                                required>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo">
                            <h4 class="mb-0 ms-2">Pegawai yang berangkat</h4>
                        </div>
                    </div>

                    <div class="card-body mt-4 transparent-card p-3">
                        <div class="row gx-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle table-sm" id="pegawaiTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Departemen</th>
                                            <th>NIK</th>
                                            <th>KTP</th>
                                            <th>Lama Penugasan</th>
                                            <th>Estimasi Lama Penugasan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="namaPegawai[]" list="listPegawai"
                                                    class="form-control namaPegawai form-control-sm" required>
                                                <datalist id="listPegawai">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->nama_lengkap }}">
                                                    @endforeach
                                                </datalist>
                                            </td>
                                                                                

                                            <td>
                                                <input type="text" name="departemen[]"
                                                    class="form-control departemen form-control-sm" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="nik[]"
                                                    class="form-control nik form-control-sm" readonly>
                                            </td>
                                            <td>
                                                <input type="file" name="uploadFile[]"
                                                    class="form-control form-control-sm" required>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="date" name="tanggalBerangkat[]"
                                                        class="form-control form-control-sm" required>
                                                    <span class="mx-2">s/d</span>
                                                    <input type="date" name="tanggalKembali[]"
                                                        class="form-control form-control-sm" required>
                                                </div>
                                            </td>
                                            <td class="d-flex align-items-center">
                                                <input type="number" name="estimasi[]" min="0"
                                                    class="form-control form-control-sm estimasi" placeholder="Estimasi">
                                                <span class="ms-1">hari</span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-remove btn-sm">
                                                    <i class="bi bi-trash"
                                                        style="font-size: 16px; margin-right: 4px;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary mt-3" id="add-field">Tambah Pegawai</button>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success me-2">Submit Form</button>
                    <button type="reset" class="btn btn-secondary">Reset Form</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Data pegawai dari server untuk autofill
        const pegawaiData = @json($users);
    
        // Autofill departemen & nik saat input nama pegawai
        document.querySelector('#pegawaiTable').addEventListener('input', function(event) {
            if (event.target.classList.contains('namaPegawai')) {
                const selectedName = event.target.value;
                const row = event.target.closest('tr');
                const departemenInput = row.querySelector('.departemen');
                const nikInput = row.querySelector('.nik');
    
                const found = pegawaiData.find(user => user.nama_lengkap === selectedName);
    
                if (found) {
                    departemenInput.value = found.departemen;
                    nikInput.value = found.nik;
                } else {
                    departemenInput.value = '';
                    nikInput.value = '';
                }
            }
        });
    
        // Clone baris pegawai baru (tanpa select2)
        document.getElementById('add-field').addEventListener('click', function() {
            const rowToClone = document.querySelector('#pegawaiTable tbody tr');
            if (rowToClone) {
                const newRow = rowToClone.cloneNode(true);
    
                // Reset semua input value di baris baru
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                
                // Append baris ke tabel
                document.querySelector('#pegawaiTable tbody').appendChild(newRow);
            }
        });
    
        // Hapus baris pegawai
        document.querySelector('#pegawaiTable').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove')) {
                event.target.closest('tr').remove();
            }
        });
    
        // Tambahkan hidden input saat submit untuk namaPegawai[]
        document.querySelector('form').addEventListener('submit', function(e) {
            const namaPegawaiInputs = document.querySelectorAll('.namaPegawai');
            namaPegawaiInputs.forEach((input, index) => {
                const nama = input.value;
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `namaPegawaiNama[${index}]`;
                hiddenInput.value = nama;
                this.appendChild(hiddenInput);
            });
        });
    </script>
    
    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            $('.select2').select2();
        });
    </script>
    


    <style>
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

        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
