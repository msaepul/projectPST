@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card p-4 shadow-lg" style="border: 2px solid maroon;">
            <div class="card-header text-white" style="background-color: maroon;">
                <h4 class="text-center">Form Permintaan</h4>
            </div>

            {{-- Section 1: Form Pengajuan --}}
            <div class="p-3">
                <div class="row">
                    <div class="col-md-6">
                        <label>No. Surat:</label>
                        <input type="text" class="form-control" value="005/PST/PDL/III/2025" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Cabang Tujuan:</label>
                        <select class="form-control">
                            <option>Pilih Cabang</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Nama Pemohon:</label>
                        <input type="text" class="form-control" value="Johnny Jhon">
                    </div>
                    <div class="col-md-6">
                        <label>Tujuan Penugasan:</label>
                        <select class="form-control">
                            <option>Pilih Tujuan</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Ditugaskan Oleh:</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Keberangkatan:</label>
                        <input type="date" class="form-control">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Cabang Asal:</label>
                        <input type="text" class="form-control" value="PDL" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Status Koordinasi:</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>

            {{-- Section 2: Daftar Pegawai --}}
            <div class="p-3 mt-3" style="border: 2px solid maroon;">
                <div class="card-header text-white" style="background-color: maroon;">
                    <h5>Daftar Pegawai yang Berangkat</h5>
                </div>

                <table class="table table-bordered mt-3">
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
                        <tr>
                            <td>
                                <select class="form-control">
                                    <option>Pilih Nama</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control"></td>
                            <td><input type="text" class="form-control"></td>
                            <td><input type="file" class="form-control"></td>
                            <td>
                                <div class="d-flex">
                                    <input type="date" class="form-control me-2">
                                    <span class="mx-1">s/d</span>
                                    <input type="date" class="form-control">
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button class="btn btn-primary">Tambah Pegawai</button>
            </div>

            {{-- Tombol Submit & Reset --}}
            <div class="mt-3 d-flex justify-content-end">
                <button class="btn btn-success me-2">Submit Form</button>
                <button class="btn btn-secondary">Reset Form</button>
            </div>
        </div>
    </div>
@endsection
