@extends('layouts.main')

@section('content')
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4 mt-3">
                    <div class="card-header bg-primary text-white py-2">
                    </div>

                    <div class="card-body">
                        <h5 class="text-center mb-8">Form Persetujuan BM</h5>

                        <div class="form-details mt-4">
                            <div class="detail-group">
                                <label class="detail-label">No Surat:</label>
                                <div class="detail-value">{{ $form->no_surat }}</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Cabang Asal:</label>
                                <div class="detail-value">{{ $form->cabang_asal }}</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Cabang Tujuan:</label>
                                <div class="detail-value">{{ $form->cabang_tujuan }}</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Tujuan Penugasan:</label>
                                <div class="detail-value">{{ $form->tujuan }}</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Tanggal Keberangkatan:</label>
                                <div class="detail-value">{{ $form->tanggal_keberangkatan }}</div>
                            </div>
                        </div>

                        <div class="package-container">
                            <div class="item-table">
                                <table class="table table-bordered">
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
                                        @forelse ($data as $item)
                                            <tr>
                                                <td>{{ $item->nama_pegawai }}</td>
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->departemen }}</td>
                                                <td>{{ $item->lama_keberangkatan }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-success btn-sm">Setuju</button>
                                                    <button class="btn btn-danger btn-sm">Tolak</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data untuk Form ID:
                                                    {{ $targetFormId }}.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary" id="saveButton">
                                Simpan Persetujuan
                            </button>
                        </div>

                        <div class="stamps-container row mt-4 justify-content-around">
                            <div class="col-md-2 text-center">
                                <div class="stamp" id="stamp1" style="display: none;">
                                    APPROVED
                                    <div class="bm-name mt-2" style="display: none;">Nama BM: {{ $form->bm_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="stamp" id="stamp2" style="display: none;">
                                    APPROVED
                                    <div class="bm-name mt-2" style="display: none;">Nama BM: {{ $form->bm_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="stamp" id="stamp3" style="display: none;">
                                    APPROVED
                                    <div class="bm-name mt-2" style="display: none;">Nama BM: {{ $form->bm_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="stamp" id="stamp4" style="display: none;">
                                    APPROVED
                                    <div class="bm-name mt-2" style="display: none;">Nama BM: {{ $form->bm_name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
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
            display: flex;
            justify-content: center;
            gap: 10px;
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

        .stamps-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .stamp {
            font-size: 24px;
            font-weight: bold;
            color: green;
            border: 3px solid green;
            padding: 10px;
            width: 150px;
            margin: 10px auto;
            border-radius: 10px;
            background-color: white;
            text-align: center;
            display: none;
        }

        .bm-name {
            font-size: 16px;
            color: black;
        }

        .progress {
            height: 25px;
            background-color: #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }

        .progress-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>

    <script>
        var stampIndex = 0;

        document.getElementById("saveButton").addEventListener("click", function() {
            var stamps = document.querySelectorAll(".stamp");
            var bmNames = document.querySelectorAll(".bm-name");

            if (stampIndex < stamps.length) {
                stamps[stampIndex].style.display = "block";
                bmNames[stampIndex].style.display = "block";
                stampIndex++;
            }
        });
    </script>
@endsection
