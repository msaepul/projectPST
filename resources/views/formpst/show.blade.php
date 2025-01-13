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
                        <!-- Menampilkan informasi form -->
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
                                            <td colspan="5" class="text-center">Tidak ada data untuk Form ID: {{ $targetFormId }}.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-primary" id="saveButton">
                            Simpan Persetujuan
                        </button>
                    </div>

                    <!-- 4 Kolom Stempel "APPROVED" -->
                    <div class="stamps-container row mt-4">
                        <div class="col-md-3">
                            <div class="stamp" id="stamp1" style="display: none;">APPROVED</div>
                        </div>
                        <div class="col-md-3">
                            <div class="stamp" id="stamp2" style="display: none;">APPROVED</div>
                        </div>
                        <div class="col-md-3">
                            <div class="stamp" id="stamp3" style="display: none;">APPROVED</div>
                        </div>
                        <div class="col-md-3">
                            <div class="stamp" id="stamp4" style="display: none;">APPROVED</div>
                        </div>
                    </div>

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
            gap: 10px;
        }

        /* Styling for Stamps */
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

        .stamps-container {
            display: flex;
            justify-content: space-between;
        }
    </style>

    <script>
        // Inisialisasi variabel untuk mengatur urutan stempel
        var stampIndex = 0;

        // Menampilkan stempel "APPROVED" satu per satu saat tombol "Simpan Persetujuan" ditekan
        document.getElementById("saveButton").addEventListener("click", function() {
            // Mengambil semua stempel
            var stamps = document.querySelectorAll(".stamp");

            // Mengecek jika ada stempel yang belum ditampilkan
            if (stampIndex < stamps.length) {
                // Menampilkan stempel sesuai urutan
                stamps[stampIndex].style.display = "block";
                // Meningkatkan indeks untuk menampilkan stempel berikutnya pada klik berikutnya
                stampIndex++;
            }
        });
    </script>

@endsection
