@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="container" style="max-width: 950px;">
        <div class="card mb-6"
            style="border: 1px solid #ccc; border-radius: 5px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <div class="card-header" style="background-color: #6A64F1; color: white; padding: 10px;">
                <h4 style="margin: 0;">Form Permintaan</h4>
            </div>
            <div class="card-body" style="padding: 20px;">
                <form id="suratTugasForm" action="{{ route('formpst.store') }}" method="POST" enctype="multipart/form-data"
                    style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
                    @csrf

                    <div class="form-group row">
                        <label for="noSurat" class="col-md-3 col-form-label">No. Surat</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-sm" name="no_surat" id="no_surat"
                                value="{{ $nomorSurat }}" readonly style="width: 110px;" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="namaPemohon" class="col-md-3 col-form-label">Nama Pemohon</label>
                        <div class="col-md-9">
                            <input type="text" id="namaPemohon" name="namaPemohon" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cabangAsal">Cabang Asal</label>
                            <select class="form-control" name="cabang_asal" id="cabangAsal" required>
                                <option value="" disabled>Pilih Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}" 
                                        {{ auth()->user()->cabang_id == $cabang->id ? 'selected' : '' }}>
                                        {{ $cabang->nama_cabang }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cabangTujuan">Cabang Tujuan</label>
                            <select class="form-control" name="cabang_tujuan" id="cabangTujuan" required>
                                <option value="" disabled selected>Pilih Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                                @endforeach
                            </select>
                        </div>
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

                    <div class="card" style="margin-top: 20px; border: 1px solid #ccc; border-radius: 5px;">
                        <div class="card-header"
                            style="background-color: #f0f0f0; padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">
                            Daftar Pegawai yang Berangkat
                        </div>
                        <div class="card-body" style="padding: 20px;">
                            <div class="table-responsive">
                                <table id="pegawaiTable" class="table table-bordered" style="width: 100%; min-width: 1200px; table-layout: auto;">
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
                                                <select name="namaPegawai[]" class="form-control namaPegawai select2" required>
                                                    <option value="" disabled selected>Pilih Nama</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            data-departemen="{{ $user->departemen }}"
                                                            data-nik="{{ $user->nik }}"
                                                            data-nama="{{ $user->nama_lengkap }}">
                                                            {{ $user->nama_lengkap }} / {{ $user->departemen }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" name="departemen[]" class="form-control departemen" readonly></td>
                                            <td><input type="text" name="nik[]" class="form-control nik" readonly></td>
                                            <td><input type="file" name="uploadFile[]" class="form-control"></td>
                                            <td><input type="date" name="lamaKeberangkatan[]" class="form-control" required></td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="button" class="btn btn-danger btn-sm remove-item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
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
                newRow.querySelectorAll('input, select').forEach(input => input.value = '');
                document.querySelector('#pegawaiTable tbody').appendChild(newRow);
            } else {
                console.error("Element 'rowToClone' tidak ditemukan.");
            }
        });

        // Hapus Baris
        document.querySelector('#pegawaiTable').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-item')) {
                event.target.closest('tr').remove();
            }
        });

        // Update Kolom Departemen dan NIK Berdasarkan Pilihan Dropdown
        document.querySelector('#pegawaiTable').addEventListener('change', function(event) {
            if (event.target.classList.contains('namaPegawai')) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const row = event.target.closest('tr');
                row.querySelector('.departemen').value = selectedOption.getAttribute('data-departemen');
                row.querySelector('.nik').value = selectedOption.getAttribute('data-nik');
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
            $(document).ready(function() {
                $('.select2').select2(); // Aktifkan select2 untuk dropdown tujuan penugasan
            });
        });
        $(document).ready(function() {
    $('.select2').select2({
        placeholder: "Cari Nama Pegawai...",
        allowClear: true,
        width: '100%' // Supaya menyesuaikan lebar parent
    });

    // Event listener untuk mengisi Departemen dan NIK setelah memilih pegawai
    $(document).on('select2:select', '.namaPegawai', function(e) {
        let selectedOption = $(this).find(':selected'); // Ambil option yang dipilih
        let row = $(this).closest('tr'); // Cari tr terdekat

        // Set nilai Departemen dan NIK berdasarkan data yang ada di option
        row.find('.departemen').val(selectedOption.data('departemen'));
        row.find('.nik').val(selectedOption.data('nik'));
    });
});

    </script>
@endsection
