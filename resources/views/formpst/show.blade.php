@extends('layouts.main')

@section('content')
    <div class="mb-3">
        <form action="{{ route('form.export.csv', $form->id) }}" method="GET">
            <button type="submit" class="btn btn-success">
                Export ke CSV
            </button>
        </form>
    </div>

    <head>
        <link rel="stylesheet" href={{ asset('css/show.css') }}>
    </head>
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
                                        $form->acc_bm === 'reject' ||
                                            $form->acc_hrd === 'reject' ||
                                            $form->acc_ho === 'reject' ||
                                            $form->acc_cabang === 'reject')
                                        <li class="breadcrumb-item text-danger font-weight-bold">
                                            <span class="breadcrumb-step">
                                                Ditolak
                                            </span>
                                        </li>
                                    @endif
                                @endif
                            </ol>
                    </div>


                    <div class="card-body">

                        {{-- Tombol Submit --}}
                        <div class="mb-4">
                            <form id="actionForm" action="{{ route('form.submit', $form->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" id="actionInput">
                                <input type="hidden" name="reason" id="reasonHiddenInput"> {{-- Input alasan tersembunyi --}}

                                @if (auth()->user()->role === 'bm')
                                    @if ($form->acc_bm == null)
                                        <button type="submit" name="action" value="acc_bm" class="btn btn-primary mr-2">
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="showReasonModal('reject_bm')">
                                            Tolak
                                        </button>
                                    @endif
                                @endif

                                @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO')
                                    @if ($form->acc_ho == null && $form->acc_bm == 'oke')
                                        <button type="submit" id="submitHoButton" name="action" value="acc_ho"
                                            class="btn btn-primary mr-2" disabled>
                                            Confirm
                                        </button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="showReasonModal('reject_ho')">
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
                                            onclick="showReasonModal('reject_cabang')">
                                            Tolak
                                        </button>
                                    @endif
                                @endif

                                {{-- @if ($form->acc_bm !== 'oke' && $form->acc_ho !== 'oke' && $form->acc_hrd !== 'oke')
                                <button type="button" class="btn btn-danger" onclick="showReasonModal('cancel')">
                                    Cancel
                                </button>
                            @endif --}}
                            </form>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('formpst.edit', $form->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Form
                            </a>
                        </div>
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
                            <label class="detail-label">Ditugaskan Oleh:</label>
                            <div class="detail-value">{{ $form->yang_menugaskan }}</div>
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
                            <div class="detail-value">
                                {{ \Carbon\Carbon::parse($form->tanggal_keberangkatan)->format('d M Y') }}</div>
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
                                        <th>Estimasi Lama Penugasan</th>
                                        <th>KTP</th>
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
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_berangkat)->format('d M') }}
                                                    s/d
                                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                                                </td>
                                                <td>{{ $item->estimasi }} HARI</td>

                                                <td>
                                                    @if ($item->upload_file)
                                                        <a href="#" class="preview-file"
                                                            data-file="{{ asset('storage/' . $item->upload_file) }}">Lihat
                                                            File</a>
                                                    @else
                                                        Tidak ada file
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (
                                                        (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO') ||
                                                            (auth()->user()->role === 'nm' && auth()->user()->departemen === $item->departemen))
                                                        @if ($form->acc_bm == 'oke' && $form->acc_hrd != 'reject' && $form->acc_bm != 'reject' && $item->acc_nm == null)
                                                            <button class="btn btn-success btn-sm"
                                                                onclick="updateStatus({{ $item->id }}, 'oke')">
                                                                Proses
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
                                                        <span class="text-warning">Menunggu Persetujuan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->acc_nm == 'oke')
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($item->acc_nm == 'tolak')
                                                        <span class="badge bg-danger">{{ $item->alasan }}</span>
                                                    @elseif ($item->acc_nm == '' || $form->acc_bm != 'reject')
                                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
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

    {{-- Modal Alasan --}}
    <div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reasonModalLabel">Masukkan Alasan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="reasonInput" class="form-control" rows="3" placeholder="Masukkan alasan"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitReasonButton">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk pratinjau file -->
    <div id="filePreviewModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.7); z-index:1000;">
        <div
            style="position:relative; margin: auto; top: 50%; transform: translateY(-50%); width:80%; max-width:800px; background:white; padding:20px;">
            <span id="closeModal" style="cursor:pointer; position:absolute; top:10px; right:10px;">&times;</span>
            <iframe id="filePreview" width="100%" height="400" style="border: none;"></iframe>
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

            if (!confirm("Apakah Anda yakin ingin menolak?")) {
                alert("Aksi dibatalkan.");
                return;
            }

            $.ajax({
                url: '/update-status/' + itemIdToReject + '/tolak',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    alasan: rejectionReason
                },
                success: function(response) {
                    if (response && response.message) {
                        alert(response.message);
                    } else {
                        alert(
                            'Status berhasil diperbarui.'
                        ); // Pesan default jika tidak ada response.message
                    }
                    $('#rejectModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                    } else {
                        alert('Terjadi kesalahan: ' +
                            error); // Pesan default jika tidak ada xhr.responseJSON.message
                    }
                }
            });
        });

        function updateStatus(itemId, status) {
            let message = status === 'oke' ? "Apakah Anda yakin ingin menyetujui?" : "Apakah Anda yakin ingin menolak?";

            if (!confirm(message)) {
                alert("Aksi dibatalkan.");
                return;
            }

            $.ajax({
                url: '/update-status/' + itemId + '/' + status,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response && response.message) {
                        alert(response.message);
                    } else {
                        alert('Status berhasil diperbarui.'); // Pesan default jika tidak ada response.message
                    }
                    location.reload();
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                    } else {
                        alert('Terjadi kesalahan: ' +
                            error); // Pesan default jika tidak ada xhr.responseJSON.message
                    }
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

            updateSubmitHoButton();

            $(document).ajaxSuccess(function() {
                updateSubmitHoButton();
            });

            function changeStep(index) {
                let steps = document.querySelectorAll('.step');
                steps.forEach(step => step.classList.remove('active'));
                steps[index].classList.add('active');
            }
        });

        function confirmAction(actionType) {
            Swal.fire({
                title: actionType === 'tolak' ? 'Alasan Penolakan' : 'Alasan Cancel',
                input: 'textarea',
                inputPlaceholder: 'Masukkan alasan...',
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
                    // Kirim alasan ke backend
                    fetch('/your-route', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                action: actionType,
                                reason: result.value
                            })
                        }).then(response => response.json())
                        .then(data => {
                            Swal.fire('Sukses!', data.message, 'success');
                        }).catch(error => {
                            Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                        });
                }
            });
        }
        let actionType = '';

        function showReasonModal(action) {
            actionType = action;
            $('#reasonModal').modal('show');
        }

        document.getElementById('submitReasonButton').addEventListener('click', function() {
            let reason = document.getElementById('reasonInput').value;

            if (reason.trim() === '') {
                alert('Harap masukkan alasan terlebih dahulu.');
                return;
            }

            document.getElementById('actionInput').value = actionType;
            document.getElementById('reasonHiddenInput').value = reason;
            document.getElementById('actionForm').submit();
        });
        document.addEventListener('DOMContentLoaded', function() {
            const previewLinks = document.querySelectorAll('.preview-file');
            const modal = document.getElementById('filePreviewModal');
            const filePreview = document.getElementById('filePreview');
            const closeModal = document.getElementById('closeModal');

            previewLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const fileUrl = this.getAttribute('data-file');
                    filePreview.src = fileUrl;
                    modal.style.display = 'block';
                });
            });

            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
                filePreview.src = '';
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    filePreview.src = '';
                }
            });
        });
    </script>

@endsection
