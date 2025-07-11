@extends('layouts.main')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/nice-forms.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @endpush

    <div class="card mt-4 rounded-3 shadow custom-card">
        <div class="card-body p-4">

            <!-- Filter Bar -->
            <form method="GET" action="{{ route('formpst.index_keluar_ho') }}"
                class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4 filter-bar">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select name="cabang" class="form-select form-select-sm w-auto" disabled>
                        <option value="HO" selected>Cabang HO</option>
                    </select>
                    <input type="hidden" name="cabang" value="HO">

                    <select name="status" class="form-select form-select-sm w-auto">
                        <option value="">Semua Status</option>
                        <option value="oke" @selected(request('status') == 'oke')>Disetujui</option>
                        <option value="reject" @selected(request('status') == 'reject')>Ditolak</option>
                        <option value="cancel" @selected(request('status') == 'cancel')>Dibatalkan</option>
                    </select>

                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                        class="form-control form-control-sm w-auto">

                    <button type="submit" class="btn btn-sm btn-outline-primary px-3">Filter</button>
                    <a href="{{ route('formpst.form') }}" class="btn btn-sm btn-outline-primary px-3">
                        + Buat Pengajuan
                    </a>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover align-middle mb-0 custom-table">
                    <thead>
                        <tr class="table-primary text-white">
                            <th>Tanggal Dibuat</th>
                            <th>No Surat</th>
                            <th>Ditugaskan Oleh</th>
                            <th>Cabang Asal</th>
                            <th>Cabang Tujuan</th>
                            <th>Tujuan Pelatihan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr class="
                                {{ $item->acc_cabang === 'oke' ? 'table-success' :
                                    ($item->acc_bm === 'reject' || $item->acc_ho === 'reject' || $item->acc_cabang === 'reject' ? 'table-warning' :
                                    ($item->acc_bm === 'cancel' || $item->acc_ho === 'cancel' || $item->acc_cabang === 'cancel' ? 'table-danger' : '') )
                                }} hover-row">

                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                <td>{{ $item->no_surat }}</td>
                                <td>{{ $item->yang_menugaskan }}</td>
                                <td>{{ $item->cabang_asal }}</td>
                                <td>{{ $item->cabang_tujuan }}</td>
                                <td>{{ $item->tujuan }}</td>
                                <td class="text-center">
                                    @if ($item->acc_cabang == 'oke')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif ($item->acc_ho == 'reject')
                                        <span class="badge bg-danger">Ditolak HO</span>
                                        @if ($item->reason_ho)
                                            <br><small>Alasan: {{ $item->reason_ho }}</small>
                                        @endif
                                    @elseif ($item->acc_bm == 'reject')
                                        <span class="badge bg-danger">Ditolak BM</span>
                                        @if ($item->reason_bm)
                                            <br><small>Alasan: {{ $item->reason_bm }}</small>
                                        @endif
                                    @elseif (in_array($item->acc_bm, ['cancel', 'reject']) ||
                                            in_array($item->acc_ho, ['cancel']) ||
                                            in_array($item->acc_cabang, ['cancel']))
                                        <span class="badge bg-danger">Cancel</span>
                                        @if ($item->acc_bm == 'cancel' && $item->alasan_cancel_bm)
                                            <br><small>Alasan BM: {{ $item->alasan_cancel_bm }}</small>
                                        @elseif ($item->acc_ho == 'cancel' && $item->alasan_cancel_ho)
                                            <br><small>Alasan HO: {{ $item->alasan_cancel_ho }}</small>
                                        @elseif ($item->acc_cabang == 'cancel' && $item->alasan_cancel_cabang)
                                            <br><small>Alasan Cabang: {{ $item->alasan_cancel_cabang }}</small>
                                        @endif
                                    @elseif ($item->acc_ho == 'oke' && $item->acc_cabang != 'oke')
                                        <span class="badge bg-warning text-dark">Menunggu Cabang</span>
                                    @elseif ($item->acc_bm == 'oke' && $item->acc_ho != 'oke')
                                        <span class="badge bg-warning text-dark">Menunggu HO</span>
                                    @elseif ($item->acc_bm != 'oke' && $item->acc_hrd == 'oke')
                                        <span class="badge bg-warning text-dark">Menunggu BM</span>
                                    @else
                                        <span class="badge bg-danger">Belum Diverifikasi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('formpst.show_nm', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="modal" data-bs-target="#modalPegawai{{ $item->id }}"
                                            title="Lihat Pegawai">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </button>
                                        <a href="{{ route('formpst.surat_tugas', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip"
                                            title="Lihat Surat Tugas">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Pegawai -->
                            <div class="modal fade" id="modalPegawai{{ $item->id }}" tabindex="-1"
                                aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="modalLabel{{ $item->id }}">
                                                <i class="bi bi-people-fill me-2"></i>Daftar Pegawai
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($item->nama_pegawais && count($item->nama_pegawais))
                                                <div class="list-group list-group-flush">
                                                    @foreach ($item->nama_pegawais as $pegawai)
                                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <i class="bi bi-person-circle me-2 text-secondary"></i>
                                                                {{ $pegawai->nama_pegawai }}
                                                            </div>
                                                            <span class="badge bg-info text-dark">{{ $pegawai->departemen }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-warning d-flex align-items-center gap-2">
                                                    <i class="bi bi-exclamation-circle-fill"></i>
                                                    Tidak ada data pegawai.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i> Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-3">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                lengthMenu: [10, 25, 50, 100],
                language: {
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    search: "Cari:",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                },
                initComplete: function () {
                    $('.dataTables_length select').addClass('form-select form-select-sm');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

    <style>
        .custom-card {
            width: 100%;
            max-width: 2000px;
            margin: auto;
        }

        .custom-table thead tr {
            background-color: #6a5acd;
            color: white;
        }

        .badge {
            padding: 6px 10px;
            font-size: 13px;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .hover-row:hover {
            background-color: #e6e1ff !important;
        }
    </style>
@endsection
