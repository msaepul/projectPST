@extends('layouts.main')
@section('content')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-4 mt-3">
                <div class="card-header bg-primary text-white py-2">
                    <h4 class="mb-0">Form Persetujuan BM</h4>
                </div>
                <div class="card-body">
                    <!-- Informasi Surat -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <label class="form-label fw-bold me-2" style="width: 150px;">Nomor Surat:</label>
                                <span>{{ $form->no_surat }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <label class="form-label fw-bold me-2" style="width: 150px;">Cabang Asal:</label>
                                <span>{{ $form->cabang_asal }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <label class="form-label fw-bold me-2" style="width: 150px;">Cabang Tujuan:</label>
                                <span>{{ $form->cabang_tujuan }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <label class="form-label fw-bold me-2" style="width: 150px;">Tanggal Keberangkatan:</label>
                                <span>{{ $form->tanggal_keberangkatan }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <label class="form-label fw-bold me-2" style="width: 150px;">Tujuan Penugasan:</label>
                                <span>{{ $form->tujuan }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Data Persetujuan</h5>
                </div>
                <div class="card-body p-3">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Departemen</th>
                                <th>Lama Keberangkatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama A</td>
                                <td>123456789</td>
                                <td>Departemen A</td>
                                <td>2025-01-15</td>
                                <td class="text-center">
                                    <button class="btn btn-success btn-sm">Setuju</button>
                                    <button class="btn btn-danger btn-sm">Tolak</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama B</td>
                                <td>987654321</td>
                                <td>Departemen B</td>
                                <td>2025-01-16</td>
                                <td class="text-center">
                                    <button class="btn btn-success btn-sm">Setuju</button>
                                    <button class="btn btn-danger btn-sm">Tolak</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                    Simpan Persetujuan
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    .form-control-plaintext {
        border: none;
        padding: 0.5rem;
        display: inline;
    }

    .package-container {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .item-table table {
        width: 100%;
        margin-bottom: 0;
    }

    .item-table th,
    .item-table td {
        padding: 10px;
        text-align: left;
        vertical-align: middle;
    }

    .item-table th {
        background-color: #f8f9fa;
    }

    td.text-center {
        display: flex;
        justify-content: center;
        gap: 5px;
    }
</style>
@endsection
