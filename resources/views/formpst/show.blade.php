@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4 mt-3">
                    <div class="card-header" style=" top: 0; z-index: 100;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @if (auth()->user()->role !== 'nm')
                                    <li class="breadcrumb-item">
                                        <span
                                            class="breadcrumb-step @if (($form->acc_bm === '' || $form->acc_hrd === '') && ($form->acc_bm !== 'oke' || $form->acc_hrd !== 'oke')) breadcrumb-active @endif">
                                            Pengajuan Cabang
                                        </span>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span
                                            class="breadcrumb-step @if ($form->acc_bm === 'oke' && $form->acc_hrd === 'oke' && ($form->acc_ho === '' || $form->acc_ho !== 'oke')) breadcrumb-active @endif">
                                            Konfirmasi HO
                                        </span>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span
                                            class="breadcrumb-step @if ($form->acc_ho === 'oke' && ($form->acc_cabang === '' || $form->acc_cabang !== 'oke')) breadcrumb-active @endif">
                                            Konfirmasi Cabang Tujuan
                                        </span>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span
                                            class="breadcrumb-step @if ($form->acc_cabang === 'oke') breadcrumb-active @endif">
                                            Selesai
                                        </span>
                                    </li>
                                    @if (
                                        $form->acc_bm === 'reject' &&
                                            $form->acc_hrd === 'reject' &&
                                            $form->acc_ho === 'reject' &&
                                            $form->acc_cabang === 'reject')
                                        text-primary
                                        <li class="breadcrumb-item" @if (
                                            $form->acc_bm === 'reject' &&
                                                $form->acc_hrd === 'reject' &&
                                                $form->acc_ho === 'reject' &&
                                                $form->acc_cabang === 'reject') text-primary @endif>
                                            <span class="breadcrumb-step text-danger">
                                                Ditolak
                                            </span>
                                        </li>
                                    @endif
                                @endif
                                @if (auth()->user()->role === 'nm')
                                    <li class="breadcrumb-item">
                                        <span
                                            class="breadcrumb-step @if ($form->acc_bm === 'oke' && $form->acc_hrd === 'oke' && ($form->acc_ho === '' || $form->acc_ho !== 'oke')) breadcrumb-active @endif">
                                            Konfirmasi HO
                                        </span>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span
                                            class="breadcrumb-step @if ($form->acc_ho === 'oke' && ($form->acc_cabang === '' || $form->acc_cabang !== 'oke')) breadcrumb-active @endif">
                                            Konfirmasi Cabang Tujuan
                                        </span>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span
                                            class="breadcrumb-step @if ($form->acc_cabang === 'oke') breadcrumb-active @endif">
                                            Selesai
                                        </span>
                                    </li>
                                    @if (
                                        $form->acc_bm === 'reject' &&
                                            $form->acc_hrd === 'reject' &&
                                            $form->acc_ho === 'reject' &&
                                            $form->acc_cabang === 'reject')
                                        text-primary
                                        <li class="breadcrumb-item" @if (
                                            $form->acc_bm === 'reject' &&
                                                $form->acc_hrd === 'reject' &&
                                                $form->acc_ho === 'reject' &&
                                                $form->acc_cabang === 'reject') text-primary @endif>
                                            <span class="breadcrumb-step text-danger">
                                                Ditolak
                                            </span>
                                        </li>
                                    @endif
                                @endif
                            </ol>
                    </div>


                    <div class="card-body">

                        {{-- tombol submit  --}}
                        <div class="mb-4">
                            <form id="approvalForm" action="{{ route('form.submit', $form->id) }}" method="POST">
                                @csrf
                                @if (auth()->user()->role === 'bm')
                                    @if ($form->acc_bm == null)
                                        <button type="submit" name="action" value="acc_bm" class="btn btn-primary mr-2">
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmAction('reject_bm', {{ $form->id }})">
                                            Tolak
                                        </button>
                                    @endif
                                @endif

                                @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'Head Office')
                                    @if ($form->acc_ho == null && $form->acc_bm == 'oke')
                                        <button type="submit" id="submitHoButton" name="action" value="acc_ho"
                                            class="btn btn-primary mr-2" disabled>
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmAction('reject_ho', {{ $form->id }})">
                                            Tolak
                                        </button>
                                    @endif
                                @endif

                                @if (auth()->user()->role === 'bm' && auth()->user()->cabang_asal === $form->cabang_tujuan)
                                    @if ($form->acc_cabang == null && $form->acc_ho == 'oke')
                                        <button type="submit" name="action" value="acc_cabang"
                                            class="btn btn-primary mr-2">
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmAction('reject_cabang', {{ $form->id }})">
                                            Tolak
                                        </button>
                                    @endif
                                @endif

                                @if ($form->acc_cabang != 'oke')
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmAction('cancel', {{ $form->id }})">
                                        Cancel
                                    </button>
                                @endif
                            </form>
                        </div>

                        <h5 class="text-center mb-8">
                            @if ($form->acc_ho == 'oke')
                                Form Persetujuan Cabang
                            @elseif ($form->acc_bm == 'oke')
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

                        {{-- tabel list pegawai --}}
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
                                            @if (
                                                (auth()->user()->role === 'nm' && auth()->user()->departemen === $item->departemen) ||
                                                    auth()->user()->role === 'admin' ||
                                                    auth()->user()->role === 'user' ||
                                                    auth()->user()->role === 'bm' ||
                                                    auth()->user()->role === 'hrd' ||
                                                    auth()->user()->role === 'pegawai')
                                                <tr>
                                                    <td>{{ $item->nama_pegawai }}</td>
                                                    <td>{{ $item->nik }}</td>
                                                    <td>{{ $item->departemen }}</td>
                                                    <td>{{ $item->lama_keberangkatan }} Hari</td>
                                                    <td>
                                                        @if ($item->upload_file)
                                                            <a href="{{ asset('storage/' . $item->upload_file) }}"
                                                                target="_blank">Lihat File</a>
                                                        @else
                                                            Tidak ada file
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if (
                                                            (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'Head Office') ||
                                                                (auth()->user()->role === 'nm' && auth()->user()->departemen === $item->departemen))
                                                            @if ($form->acc_bm == 'oke' && $form->acc_hrd != 'reject' && $form->acc_bm != 'reject' && $item->acc_nm == null)
                                                                <button class="btn btn-success btn-sm"
                                                                    onclick="updateStatus({{ $item->id }}, 'oke')">
                                                                    Setuju
                                                                </button>
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="openRejectModal({{ $item->id }})">
                                                                    Tolak
                                                                </button>
                                                            @endif
                                                        @endif

                                                        {{-- Status Teks --}}
                                                        @if ($item->acc_nm === 'oke')
                                                            <span class="text-success">Diterima</span>
                                                        @elseif ($item->acc_nm === 'tolak' || $form->acc_bm === 'reject' || $form->acc_hrd === 'reject')
                                                            <span class="text-danger">Ditolak</span>
                                                        @elseif (empty($form->acc_bm) || empty($form->acc_hrd))
                                                            <span class="text-warning">Menunggu</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($item->acc_nm == 'oke')
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($item->acc_nm == 'tolak')
                                                            <span class="badge bg-danger">{{ $item->alasan }}</span>
                                                        @elseif ($item->acc_nm == '' || $form->acc_bm != 'reject')
                                                            <span class="badge bg-warning">Menunggu</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif

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
                            <!-- ACC HRD -->
                            <div class="status-step">
                                <img src="{{ $form->acc_hrd == 'oke' ? asset('dist/img/oke.png') : ($form->acc_hrd == 'reject' ? asset('dist/img/reject.png') : asset('dist/img/no.png')) }}"
                                    alt="Status HRD" class="thumb-icon" width="50">
                                <div class="status-name">
                                    @if ($form->acc_hrd == 'oke')
                                        {{ $form->submitted_by_hrd }} (HRD) - Setuju
                                    @elseif ($form->acc_hrd == 'reject')
                                        {{ $form->submitted_by_hrd }} (HRD) - Ditolak
                                    @else
                                        HRD - Menunggu
                                    @endif
                                </div>

                            </div>
                            <!-- ACC BM -->
                            @if ($form->acc_hrd == 'oke')
                                <div class="status-step">
                                    <img src="{{ $form->acc_bm == 'oke' ? asset('dist/img/oke.png') : ($form->acc_bm == 'reject' ? asset('dist/img/reject.png') : asset('dist/img/no.png')) }}"
                                        alt="Status BM" class="thumb-icon" width="50">
                                    <div class="status-name">
                                        @if ($form->acc_bm == 'oke')
                                            {{ $form->submitted_by_bm }} (BM) - Setuju
                                        @elseif ($form->acc_bm == 'reject')
                                            {{ $form->submitted_by_bm }} (BM) - Ditolak
                                        @else
                                            BM - Menunggu
                                        @endif
                                    </div>
                                </div>
                            @endif


                            {{-- ACC HO  --}}
                            @if ($form->acc_bm == 'oke')
                                <div class="status-step">
                                    <img src="{{ $form->acc_ho == 'oke' ? asset('dist/img/oke.png') : ($form->acc_ho == 'reject' ? asset('dist/img/reject.png') : asset('dist/img/no.png')) }}"
                                        alt="Status HO" class="thumb-icon" width="50">
                                    <div class="status-name">
                                        @if ($form->acc_ho == 'oke')
                                            {{ $form->submitted_by_ho }} (HRD HO) - Setuju
                                        @elseif ($form->acc_ho == 'reject')
                                            {{ $form->submitted_by_ho }} (HRD HO) - Ditolak
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
                                            {{ $form->submitted_by_cabang }} (CABANG) - Setuju
                                        @elseif ($form->acc_cabang == 'reject')
                                            {{ $form->submitted_by_cabang }} (CABANG)- Ditolak
                                        @else
                                            CABANG- Menunggu
                                        @endif
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmAction(actionType, itemId) {
                let title = actionType === 'cancel' ? 'Masukkan alasan pembatalan' : 'Masukkan alasan penolakan';

                Swal.fire({
                    title: title,
                    input: 'textarea',
                    inputPlaceholder: 'Tuliskan alasan...',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim',
                    cancelButtonText: 'Batal',
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('Alasan wajib diisi!');
                        }
                        return reason;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/update-status/' + itemId + '/' + actionType,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                alasan: result.value
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'Terjadi kesalahan: ' + xhr.responseJSON.message,
                                    'error');
                            }
                        });
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

                function changeStep(index) {
                    let steps = document.querySelectorAll('.step');
                    steps.forEach(step => step.classList.remove('active'));
                    steps[index].classList.add('active');
                }
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
                width: 250px;
            }

            .status-name {
                margin-top: 5px;
                font-size: 14px;
                color: #555;
            }

            /* Breadcrumb styles */
            .breadcrumb {
                background-color: #f8f9fa;
                /* Light gray background */
                padding: 10px 15px;
                border-radius: 5px;
                display: flex;
                /* Enable flexbox for horizontal layout */
            }

            .breadcrumb-item {
                margin-right: 10px;
                position: relative;
                /* For positioning the triangle */
                display: flex;
                /* Ensure items are displayed as flex containers */
                align-items: center;
                /* Vertically align items */
                background-color: #ffffff;
                /* Light gray background for box */
                padding: 5px 15px;
                /* Adjust padding as needed */
                border-radius: 3px;
                /* Rounded corners */
            }

            .breadcrumb-step {
                display: inline-block;
                padding: 8px 12px;
                border-radius: 4px;
            }

            .breadcrumb-active {
                background-color: #368df0;
                /* Warna biru Bootstrap */
                color: white !important;
            }

            .breadcrumb-item+.breadcrumb-item::before {
                content: "";
                position: absolute;
                left: -15px;
                /* Adjust position of the triangle */
                top: 50%;
                transform: translateY(-50%);
                border-top: 10px solid transparent;
                border-bottom: 10px solid transparent;
                border-left: 15px solid #c3e0fd;
                ;
                /* Match the box background color */
            }

            .breadcrumb-link {
                color: #007bff;
                /* Blue link color */
                text-decoration: none;
            }

            .breadcrumb-link:hover {
                color: #0056b3;
                /* Darker blue on hover */
            }

            .breadcrumb-item.active .breadcrumb-text {
                color: #6c757d;
                /* Gray for active item */
                font-weight: 500;
            }

            .breadcrumb-text.text-danger {
                color: #dc3545 !important;
            }

            /* Responsive adjustments (example) */
            @media (max-width: 768px) {
                .breadcrumb {
                    flex-wrap: wrap;
                }

                .breadcrumb-item {
                    margin-bottom: 5px;
                }

                .breadcrumb-item+.breadcrumb-item::before {
                    display: inline-block;
                    /* Show arrows on small screens */
                    border: none;
                    /* Remove default triangle on smaller screens */
                    content: "\f105";
                    /* Use Font Awesome icon */
                    font-family: "FontAwesome";
                }
            }
        </style>
    @endsection
