@extends('layouts.main')
@section('content')
<div class="card">
    <div class="card-header">
        Detail Form Permintaan
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label for="noSurat" class="col-md-3 col-form-label">No. Surat</label>
            <div class="col-md-9">
                <input type="text" class="form-control form-control-sm d-inline-block" value="12345/ABC/2025" readonly style="width: 110px;">
            </div>
        </div>

        <div class="form-group row">
            <label for="namaPemohon" class="col-md-3 col-form-label">Nama Pemohon</label>
            <div class="col-md-9">
                <input type="text" class="form-control" value="John Doe" readonly>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cabangAsal">Cabang Asal</label>
                <input type="text" class="form-control" value="Cabang Jakarta" readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="cabangTujuan">Cabang Tujuan</label>
                <input type="text" class="form-control" value="Cabang Surabaya" readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="tujuanPenugasan">Tujuan Penugasan</label>
            <input type="text" class="form-control" value="Survey Lokasi" readonly>
        </div>

        <div class="form-group">
            <label for="tanggalKeberangkatan">Tanggal Keberangkatan</label>
            <input type="date" class="form-control" value="2025-01-15" readonly>
        </div>

        <div class="card">
            <div class="card-header" style="background-color: #f0f0f0; color: black;">
                Daftar Pegawai yang Berangkat
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pegawaiTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>NIK</th>
                                <th>File Upload</th>
                                <th>Lama Keberangkatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jane Smith</td>
                                <td>HRD</td>
                                <td>12345678</td>
                                <td><a href="#">Lihat File</a></td>
                                <td>3 Hari</td>
                            </tr>
                            <tr>
                                <td>Mike Johnson</td>
                                <td>IT</td>
                                <td>87654321</td>
                                <td><a href="#">Lihat File</a></td>
                                <td>5 Hari</td>
                            </tr>
                            <tr>
                                <td>Alice Brown</td>
                                <td>Finance</td>
                                <td>13579135</td>
                                <td>Tidak Ada File</td>
                                <td>2 Hari</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{ route('hrd.list_nm') }}" class="btn btn-primary mt-4">
            <button type="submit">Submit</button>
        </a>
    </div>
</div>
@endsection
