@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="container" style="max-width: 950px;">
        <h2>Form Pengajuan Surat Tugas</h2>
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
                                <option value="" disabled selected>Pilih Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
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
                        <label for="tujuanPenugasan">Tujuan Penugasan</label>
                        <select class="form-control" name="tujuan" id="tujuan" required>
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
                                            <td><input type="text" name="namaPegawai[]" class="form-control" required>
                                            </td>
                                            <td>
                                                <select class="form-control" name="departemen[]" required>
                                                    <option value="" disabled selected>Pilih Departemen</option>
                                                    @foreach ($departemens as $departemen)
                                                        <option value="{{ $departemen->nama_departemen }}">
                                                            {{ $departemen->nama_departemen }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="nik[]" class="form-control" minlength="16"
                                                    maxlength="16" required></td>
                                            <td><input type="file" name="uploadFile[]" class="form-control"></td>
                                            <td><input type="date" name="lamaKeberangkatan[]" class="form-control"
                                                    required></td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="button" class="btn btn-danger btn-sm remove-item"
                                                    style="margin: 2px; padding: 0.25rem 0.5rem;">
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
@endsection
