@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="mr-2" style="height: 30px;">
                    <h5 class="mb-0">Form Permintaan</h5>
                </div>
            </div>
            <div class="card-body">
                <form id="suratTugasForm" action="{{ route('formpst.store', ['role' => auth()->user()->role]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="noSurat" class="form-label">No. Surat</label>
                            <input type="text" class="form-control" name="no_surat" id="noSurat"
                                value="{{ $nomorSurat }}" readonly required>
                        </div>
                        <div class="col-md-4">
                            <label for="namaPemohon" class="form-label">Nama Pemohon</label>
                            <input type="text" class="form-control" name="namaPemohon" id="namaPemohon"
                                value="{{ Auth::user()->nama_lengkap ?? '' }}" readonly required>
                        </div>
                        <div class="col-md-4">
                            <label for="cabangAsal" class="form-label">Cabang Asal</label>
                            <input type="text" class="form-control" name="cabangAsal" id="cabangAsal"
                                value="{{ Auth::user()->cabang_asal ?? '' }}" readonly required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="cabangTujuan" class="form-label">Cabang Tujuan</label>
                            <select class="form-select select2" name="cabang_tujuan" id="cabangTujuan" required>
                                <option value="" disabled selected>Pilih Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tujuan" class="form-label">Tujuan Penugasan</label>
                            <select class="form-select select2" name="tujuan" id="tujuan" required>
                                <option value="" disabled selected>Pilih Tujuan</option>
                                @foreach ($tujuans as $tujuan)
                                    <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan_penugasan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggalKeberangkatan" class="form-label">Tanggal Keberangkatan</label>
                            <input type="date" class="form-control" name="tanggalKeberangkatan" id="tanggalKeberangkatan"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ditugaskanOleh" class="form-label">Ditugaskan Oleh</label>
                            <input type="text" class="form-control" name="ditugaskanOleh" id="ditugaskanOleh" required>
                        </div>
                        <div class="col-md-4">
                            <label for="statusKoordinasi" class="form-label">Status Koordinasi</label>
                            <input type="text" class="form-control" name="statusKoordinasi" id="statusKoordinasi"
                                required>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="mt-4">
                        <div class="mt-4">
                            <h5>Daftar Pegawai yang Berangkat</h5>
                            <table class="table table-bordered" id="pegawaiTable">
                                <thead>
                                    <tr>
                                        <th style="width: 250px;">Nama</th>
                                        <th style="width: 150px;">Departemen</th>
                                        <th style="width: 200px;">NIK</th>
                                        <th style="width: 200px;">Upload File</th>
                                        <th>Lama Keberangkatan</th>
                                        <th>Estimasi Keterlambatan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="rowToClone">
                                        <td style="width: 250px;">
                                            <select name="namaPegawai[]" class="form-select namaPegawai" required>
                                                <option value="" disabled selected>Pilih Nama</option>
                                                @if (auth()->user()->role !== 'nm')
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            data-departemen="{{ $user->departemen }}"
                                                            data-nik="{{ $user->nik }}"
                                                            data-nama="{{ $user->nama_lengkap }}">
                                                            {{ $user->nama_lengkap }} /
                                                            {{ $user->departemen }} / {{ $user->nik }}</option>
                                                    @endforeach
                                                @endif
                                                @if (auth()->user()->role === 'nm')
                                                    @foreach ($nm as $user)
                                                        <option value="{{ $user->id }}"
                                                            data-departemen="{{ $user->departemen }}"
                                                            data-nik="{{ $user->nik }}"
                                                            data-nama="{{ $user->nama_lengkap }}">
                                                            {{ $user->nama_lengkap }} /
                                                            {{ $user->departemen }} / {{ $user->nik }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" name="namaPegawaiId[]" class="namaPegawaiId">
                                            <input type="text" class="form-control namaPegawaiDisplay" readonly>
                                        </td>
                                        <td style="width: 150px;"><input type="text" name="departemen[]"
                                                class="form-control departemen" readonly></td>
                                        <td style="width: 200px;"><input type="text" name="nik[]"
                                                class="form-control nik" readonly></td>
                                        <td style="width: 200px;"><input type="file" name="uploadFile[]"
                                                class="form-control"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date" name="tanggalBerangkat[]" class="form-control"
                                                    required>
                                                <span class="mx-2">s/d</span>
                                                <input type="date" name="tanggalKembali[]" class="form-control"
                                                    required>
                                            </div>
                                        </td>
                                        <td><input type="date" name="estimasiKeterlambatan[]" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-remove"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary mt-3" id="add-field">Tambah Pegawai</button>
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
        document.querySelector('#pegawaiTable').addEventListener('change', function(event) {
            if (event.target.classList.contains('namaPegawai')) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const row = event.target.closest('tr');
                const departemenInput = row.querySelector('.departemen');
                const nikInput = row.querySelector('.nik');
                const namaPegawaiDisplayInput = row.querySelector('.namaPegawaiDisplay');

                if (selectedOption && departemenInput && nikInput && namaPegawaiDisplayInput) {
                    departemenInput.value = selectedOption.getAttribute('data-departemen');
                    nikInput.value = selectedOption.getAttribute('data-nik');
                    namaPegawaiDisplayInput.value = selectedOption.getAttribute('data-nama');

                    // Sembunyikan dropdown, tampilkan input text
                    event.target.style.display = 'none';
                    namaPegawaiDisplayInput.style.display = 'block';
                }
            }
        });

        // Klik input namaPegawaiDisplay untuk mengganti nama
        document.querySelector('#pegawaiTable').addEventListener('click', function(event) {
            if (event.target.classList.contains('namaPegawaiDisplay')) {
                const row = event.target.closest('tr');
                const dropdown = row.querySelector('.namaPegawai');

                // Tampilkan kembali dropdown, sembunyikan input text
                dropdown.style.display = 'block';
                event.target.style.display = 'none';
            }
        });

        // Tambah Baris Baru
        document.getElementById('add-field').addEventListener('click', function() {
            const rowToClone = document.getElementById('rowToClone');
            if (rowToClone) {
                const newRow = rowToClone.cloneNode(true);
                newRow.removeAttribute('id');
                newRow.querySelectorAll('input, select').forEach(input => input.value = '');
                document.querySelector('#pegawaiTable tbody').appendChild(newRow);

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
        document.querySelector('#pegawaiTable').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove')) {
                event.target.closest('tr').remove();
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
        .card-header.bg-primary {
            background-color: #3b0100 !important;
            /* Merah marun dari logo */
        }

        hr {
            border: 1px solid #3b0100;
            /* Gaya garis pemisah */
        }
    </style>
@endsection
