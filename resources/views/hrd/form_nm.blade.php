@extends('layouts.main')

@section('content')
    <style>
        .form-details {
            width: 100%;
            max-width: 100%;
        }

        .package-container {
            width: 100%;
        }

        .item-table table {
            width: 100%;
        }

        .card {
            max-width: 100%;
        }

        .status-bar {
            display: flex;
            justify-content: space-evenly;
        }

        .form-details {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }

        .detail-group {
            margin-bottom: 8px;
            display: flex;
            align-items: baseline;
        }

        .detail-label {
            font-weight: bold;
            width: 150px;
        }

        .detail-value {
            flex-grow: 1;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 3px;
        }

        .package-container {
            border: 1px solid #000;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .item-table table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
        }

        .item-table th,
        .item-table td {
            padding: 10px;
            text-align: left;
            vertical-align: middle;
            border: 1px solid #000;
        }

        .item-table th {
            background-color: #e9ecef;
        }

        td.text-center {
            text-align: center;
        }

        .btn {
            padding: 5px 10px;
            margin: 0 3px;
            border: 1px solid #ccc;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .btn-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }

        .status-bar {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .status-step {
            text-align: center;
        }

        .thumb-icon {
            width: 200px;
        }

        .status-name {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }
    </style>

    <div class="container-fluid pt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4 mt-3">
                    <div class="card-header bg-primary text-white py-2" style="position: sticky; top: 0; z-index: 100;">
                        <Nav>Form Persetujuan NM</Nav>
                    </div>

                    <div class="card-body">
                        <!-- Informasi Surat -->
                        <div class="form-details mb-4">
                            <div class="detail-group">
                                <label class="detail-label">No Surat:</label>
                                <div class="detail-value">HRD/2025/0002</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Cabang Asal:</label>
                                <div class="detail-value">Head Office</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Cabang Tujuan:</label>
                                <div class="detail-value">Lampung</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Tujuan Penugasan:</label>
                                <div class="detail-value">Implementasi ERP</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Tanggal Keberangkatan:</label>
                                <div class="detail-value">2025-01-27</div>
                            </div>
                        </div>

                        <!-- Tabel Pegawai -->
                        <div class="item-table">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Departemen</th>
                                        <th>Lama Keberangkatan</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>asep</td>
                                        <td>123456</td>
                                        <td>EDP</td>
                                        <td>2025-02-10</td>
                                        <td><a href="#" class="text-primary">Lihat File</a></td>
                                        <td>
                                            <button class="btn btn-success btn-sm">Setuju</button>
                                            <button class="btn btn-danger btn-sm">Tolak</button>
                                        </td>
                                        <td><span class="badge bg-warning">Menunggu</span></td>
                                    </tr>
                                    <tr>
                                        <td>ria</td>
                                        <td>1558</td>
                                        <td>Produksi</td>
                                        <td>2025-02-07</td>
                                        <td><a href="#" class="text-primary">Lihat File</a></td>
                                        <td>
                                            <button class="btn btn-success btn-sm">Setuju</button>
                                            <button class="btn btn-danger btn-sm">Tolak</button>
                                        </td>
                                        <td><span class="badge bg-warning">Menunggu</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
