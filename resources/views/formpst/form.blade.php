@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="card mb-6" style="border: 1px solid #ccc; border-radius: 5px; max-width: 1000px; margin: auto; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #6A64F1; color: white; padding: 10px;">
            <h4 style="margin: 0;">Form Permintaan</h4>
        </div>
        <div class="card-body" style="padding: 20px;">
            <form id="suratTugasForm" action="{{ route('formpst.store') }}" method="POST" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
                @csrf

                <div class="form-group row">
                    <label for="noSurat" class="col-md-3 col-form-label">No. Surat</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control form-control-sm d-inline-block" name="nomor_surat" id="nomor_surat"
                        value="{{ $nomorSurat }}" readonly style="width: 110px;">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="namaPemohon" class="col-md-3 col-form-label">Nama Pemohon</label>
                    <div class="col-md-9">
                        <input type="text" id="namaPemohon" name="namaPemohon" class="form-control" >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cabangAsal">Cabang Asal</label>
                        <select class="form-control" name="cabang_asal" id="cabangAsal" >
                            <option value="" disabled selected>Pilih Cabang</option>
                            @foreach ($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cabangTujuan">Cabang Tujuan</label>
                        <select class="form-control" name="cabang_tujuan" id="cabangTujuan" >
                            <option value="" disabled selected>Pilih Cabang</option>
                            @foreach ($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tujuanPenugasan">Tujuan Penugasan</label>
                    <select class="form-control" name="tujuan" id="tujuan" >
                        <option value="" disabled selected>Pilih Tujuan</option>
                        @foreach ($tujuans as $tujuan)
                            <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan_penugasan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggalKeberangkatan">Tanggal Keberangkatan</label>
                    <input type="date" id="tanggalKeberangkatan" name="tanggalKeberangkatan" class="form-control" >
                </div>

                <div class="card" style="margin-top: 20px; border: 1px solid #ccc; border-radius: 5px;">
                    <div class="card-header" style="background-color: #f0f0f0; padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">
                        Daftar Pegawai yang Berangkat
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <div class="table-responsive">
                            <table id="pegawaiTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>NIK</th>
                                        <th>Upload File</th>
                                        <th>Lama Keberangkatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="rowToClone">
                                        <td><input type="text" name="namaPegawai[]" class="form-control" ></td>
                                        <td>
                                            <select class="form-control" name="departemen[]" >
                                                <option value="" disabled selected>Pilih Departemen</option>
                                                @foreach ($departemens as $departemen)
                                                    <option value="{{ $departemen->nama_departemen }}">{{ $departemen->nama_departemen }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="nik[]" class="form-control" ></td>
                                        <td><input type="file" name="uploadFile[]" class="form-control"></td>
                                        <td><input type="date" name="lamaKeberangkatan[]" class="form-control" ></td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button></td>
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

    <script>
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

        document.querySelector('#pegawaiTable').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-item')) {
                event.target.closest('tr').remove();
            }
        });
    </script>
@endsection
