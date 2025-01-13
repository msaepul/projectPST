@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="card mb-6" style="border: 1px solid #ccc; border-radius: 5px; max-width: 1000px; margin: auto; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color: #6A64F1; color: white; padding: 10px;">
            <h4 style="margin: 0;">Form Data Permintaan</h4>
        </div>
        <div class="card-body" style="padding: 20px;">
            <form id="suratTugasForm" action="{{ route('formpst.index') }}" method="GET" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
                @csrf

                <div class="form-group row">
                    <label for="namaPemohon" class="col-md-3 col-form-label">Nama Pemohon</label>
                    <div class="col-md-9">
                        <input type="text" id="namaPemohon" name="namaPemohon" class="form-control" value="{{ request('namaPemohon') }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Cari Data</button>
            </form>
        </div>
    </div>

    <div class="card mt-4" style="border: 1px solid #ccc; border-radius: 5px; max-width: 1000px; margin: auto;">
        <div class="card-header" style="background-color: #f0f0f0; padding: 10px; font-weight: bold;">
            Hasil Pencarian
        </div>
        <div class="card-body" style="padding: 20px;">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Surat</th>
                            <th>Nama Pemohon</th>
                            <th>Cabang Asal</th>
                            <th>Cabang Tujuan</th>
                            <th>Tujuan Pelatihan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $item->no_surat }}</td>
                                <td>{{ $item->nama_pemohon }}</td>
                                <td>{{ $item->cabang_asal }}</td>
                                <td>{{ $item->cabang_tujuan }}</td>
                                <td>{{ $item->tujuan }}</td>
                                <td>
                                    <button id="verify-button-{{ $item->id }}" class="not-verified" onclick="toggleVerifikasi({{ $item->id }})">
                                        Belum Diverifikasi
                                    </button>
                                </td>
                                <td>
                                    <a href="{{ route('formpst.show', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleVerifikasi(itemId) {
            var button = document.getElementById("verify-button-" + itemId);

            if (button.classList.contains("not-verified")) {
                button.classList.remove("not-verified");
                button.classList.add("verified");
                button.innerText = "Sudah Diverifikasi";
            } else {
                button.classList.remove("verified");
                button.classList.add("not-verified");
                button.innerText = "Belum Diverifikasi";
            }
        }
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
        }

        .card {
            margin: 20px auto;
            border-radius: 8px;
            border: 1px solid #ccc;
            max-width: 1000px;
        }

        .card-body {
            padding: 20px;
        }

        button {
            padding: 1px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .verified {
            background-color: #28a745;
        }

        .verified:hover {
            background-color: #218838;
        }

        .not-verified {
            background-color: #dc3545;
        }

        .not-verified:hover {
            background-color: #c82333;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endsection
