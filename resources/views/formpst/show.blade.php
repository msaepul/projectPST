@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4">
        <!-- Breadcrumb Section -->




        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4 mt-3">
                    <div class="card-header style="position: sticky; top: 0; z-index: 100;>
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item">
                                <span class="breadcrumb-step @if ($form->acc_bm === '' || $form->acc_hrd === '') text-primary @endif">
                                    Draft
                                </span>
                            </li> --}}
                            <li class="breadcrumb-item">
                                <span class="breadcrumb-step @if (($form->acc_bm === '' || $form->acc_hrd === '') && ($form->acc_bm !== 'oke' || $form->acc_hrd !== 'oke')) text-primary @endif">
                                    Pengajuan Cabang
                                </span>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="breadcrumb-step @if (($form->acc_bm === 'oke' && $form->acc_hrd === 'oke') && ($form->acc_ho === '' || $form->acc_ho !== 'oke')) text-primary @endif">
                                    Diperiksa HO
                                </span>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="breadcrumb-step @if ($form->acc_ho === 'oke' && ($form->acc_cabang === '' || $form->acc_cabang !== 'oke')) text-primary @endif">
                                    Diperiksa Cabang Tujuan
                                </span>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="breadcrumb-step @if ($form->acc_cabang === 'oke') text-primary @endif">
                                    Selesai
                                </span>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="breadcrumb-step text-danger">
                                    Ditolak
                                </span>
                            </li>
                            
                        </ol>
                    </div>

                    <div class="card-body">

                        <div class="mb-4">
                            <!-- Form Handle (Submit or Reject for BM, HRD, HO) -->
                            <form action="{{ route('form.submit', $form->id) }}" method="POST">
                                @csrf

                                <!-- Tombol untuk ACC atau Tolak BM -->
                                @if ($form->acc_bm == null)
                                    <button type="submit" name="action" value="acc_bm" class="btn btn-primary mr-2">
                                        Submit BM
                                    </button>
                                    <button type="submit" name="action" value="reject_bm" class="btn btn-danger">
                                        Tolak BM
                                    </button>
                                @endif

                                <!-- Tombol untuk ACC atau Tolak HRD -->
                                @if ($form->acc_hrd == null && $form->acc_bm == 'oke')
                                    <button type="submit" name="action" value="acc_hrd" class="btn btn-primary mr-2">
                                        Submit HRD
                                    </button>
                                    <button type="submit" name="action" value="reject_hrd" class="btn btn-danger">
                                        Tolak HRD
                                    </button>
                                @endif

                                <!-- Tombol untuk ACC atau Tolak HO -->
                                @if ($form->acc_ho == null && $form->acc_hrd == 'oke')
                                    <button type="submit" id="submitHoButton" name="action" value="acc_ho"
                                        class="btn btn-primary mr-2" disabled>
                                        Submit HO
                                    </button>
                                    <button type="submit" name="action" value="reject_ho" class="btn btn-danger">
                                        Tolak HO
                                    </button>
                                @endif

                                @if ($form->acc_cabang == null && $form->acc_ho == 'oke')
                                    <button type="submit" name="action" value="acc_cabang" class="btn btn-primary mr-2">
                                        Submit cabang
                                    </button>
                                    <button type="submit" name="action" value="reject_cabang" class="btn btn-danger">
                                        Tolak cabang
                                    </button>
                                @endif

                            </form>
                        </div>



                        <h5 class="text-center mb-8">
                            @if ($form->acc_ho == 'oke')
                                Form Persetujuan Cabang
                            @elseif ($form->acc_bm == 'oke' && $form->acc_hrd == 'oke')
                                Form Persetujuan HO
                            @else
                                Form Persetujuan
                            @endif
                        </h5>

                        <div class="form-details">
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
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td>{{ $item->nama_pegawai }}</td>
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->departemen }}</td>
                                                <td>{{ $item->lama_keberangkatan }}</td>
                                                <td>
                                                    @if ($item->upload_file)
                                                        <a href="{{ asset('storage/' . $item->upload_file) }}"
                                                            target="_blank">Lihat File</a>
                                                    @else
                                                        Tidak ada file
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($form->acc_hrd == 'oke' && $form->acc_hrd != 'reject' && $form->acc_bm != 'reject' && $item->acc_nm == null)

                                                        <button class="btn btn-success btn-sm"
                                                            onclick="updateStatus({{ $item->id }}, 'oke')">
                                                            Setuju
                                                        </button>
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="openRejectModal({{ $item->id }})">
                                                            Tolak
                                                        </button>
                                                    @endif

                                                    @if ($item->acc_nm == 'oke')
                                                        <span class="text-success">Diterima</span>
                                                    @endif

                                                    @if ($item->acc_nm == 'tolak' || $form->acc_bm == 'reject' || $form->acc_hrd == 'reject')
                                                        <span class="text-danger">Ditolak</span>
                                                    @endif

                                                    @if ($form->acc_bm == '' || $form->acc_hrd == '')
                                                        <span class="text-warning">Menunggu</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->acc_nm == 'oke')
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($item->acc_nm == 'tolak')
                                                        <span class="badge bg-danger">{{ $item->alasan }}</span>
                                                    @elseif ($form->acc_hrd == 'reject' || $form->acc_hrd == 'reject')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @elseif ($item->acc_nm == '' || $form->acc_hrd != 'reject' || $form->acc_bm != 'reject')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data untuk Form ID:
                                                    {{ $targetFormId }}.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Bar Status -->
                        <div class="status-bar mb-4" style="position: sticky; top: 70px;">
                            <!-- ACC BM -->
                            <div class="status-step">
                                <img src="{{ $form->acc_bm == 'oke' ? asset('dist/img/oke.png') : ($form->acc_bm == 'reject' ? asset('dist/img/reject.png') : asset('dist/img/no.png')) }}"
                                    alt="Status BM" class="thumb-icon" width="50">
                                <div class="status-name">
                                    @if ($form->acc_bm == 'oke')
                                        BM - Setuju
                                    @elseif ($form->acc_bm == 'reject')
                                        BM - Ditolak
                                    @else
                                        BM - Menunggu
                                    @endif
                                </div>
                            </div>
                            <!-- ACC HRD -->
                            <div class="status-step">
                                <img src="{{ $form->acc_hrd == 'oke' ? asset('dist/img/oke.png') : ($form->acc_hrd == 'reject' ? asset('dist/img/reject.png') : asset('dist/img/no.png')) }}"
                                    alt="Status HRD" class="thumb-icon" width="50">
                                <div class="status-name">
                                    @if ($form->acc_hrd == 'oke')
                                        HRD - Setuju
                                    @elseif ($form->acc_hrd == 'reject')
                                        HRD - Ditolak
                                    @else
                                        HRD - Menunggu
                                    @endif
                                </div>
                            </div>
                            {{-- ACC HO  --}}
                            @if ($form->acc_hrd == 'oke')
                                <div class="status-step">
                                    <img src="{{ $form->acc_ho == 'oke' ? asset('dist/img/oke.png') : ($form->acc_ho == 'reject' ? asset('dist/img/reject.png') : asset('dist/img/no.png')) }}"
                                        alt="Status HO" class="thumb-icon" width="50">
                                    <div class="status-name">
                                        @if ($form->acc_ho == 'oke')
                                            HRD HO - Setuju
                                        @elseif ($form->acc_ho == 'reject')
                                            HRD HO - Ditolak
                                        @else
                                            HRD HO - Menunggu
                                        @endif
                                    </div>
                                </div>
                            @endif
                            {{-- ACC CABANG --}}
                            @if ($form->acc_ho == 'oke')
                                <div class="status-step">
                                    <img src="{{ $form->acc_cabang == 'oke' ? asset('dist/img/oke.png') : ($form->acc_cabang == 'reject' ? asset('dist/img/reject.png') : asset('dist/img/no.png')) }}"
                                        alt="Status CABANG" class="thumb-icon" width="50">
                                    <div class="status-name">
                                        @if ($form->acc_cabang == 'oke')
                                            CABANG - Setuju
                                        @elseif ($form->acc_cabang == 'reject')
                                            CABANG- Ditolak
                                        @else
                                            CABANG- Menunggu
                                        @endif
                                    </div>
                                </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk alasan penolakan -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rejectForm">
                        <div class="mb-3">
                            <label for="rejectionReason" class="form-label">Alasan Penolakan</label>
                            <textarea id="rejectionReason" class="form-control" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-danger" id="submitRejection">Tolak Pegawai</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var itemIdToReject = null;

        function openRejectModal(itemId) {
            itemIdToReject = itemId;
            $('#rejectModal').modal('show');
        }

        document.getElementById('submitRejection').addEventListener('click', function() {
            var rejectionReason = document.getElementById('rejectionReason').value;
            if (!rejectionReason) {
                alert('Alasan penolakan wajib diisi');
                return;
            }

            // Kirim permintaan AJAX untuk menolak pegawai dengan alasan
            $.ajax({
                url: '/update-status/' + itemIdToReject + '/tolak',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    alasan: rejectionReason
                },
                success: function(response) {
                    alert(response.message);
                    $('#rejectModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                }
            });
        });

        function updateStatus(itemId, status) {
            if (status == 'oke' && !confirm("Apakah Anda yakin ingin menyetujui?")) {
                return;
            }
            if (status == 'tolak' && !confirm("Apakah Anda yakin ingin menolak?")) {
                return;
            }

            $.ajax({
                url: '/update-status/' + itemId + '/' + status,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            function updateSubmitHoButton() {
                const submitHoButton = document.getElementById('submitHoButton');
                const rows = document.querySelectorAll('.item-table tbody tr');
                let allReviewed = true;

                rows.forEach(row => {
                    const statusCell = row.querySelector('td span.badge');
                    if (statusCell && statusCell.classList.contains('bg-warning')) {
                        allReviewed = false;
                    }
                });

                submitHoButton.disabled = !allReviewed;
            }

            // Periksa status awal saat halaman dimuat
            updateSubmitHoButton();

            // Tangkap event AJAX untuk memperbarui tombol
            $(document).ajaxSuccess(function() {
                updateSubmitHoButton();
            });
        });
    </script>

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

        /* Breadcrumb styles */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-item a {
            color: #007bff;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }
    </style>
@endsection
