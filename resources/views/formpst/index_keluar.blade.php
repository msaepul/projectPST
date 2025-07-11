@extends('layouts.main')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/nice-forms.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @endpush

    {{-- {{ Breadcrumbs::render('Form') }} --}}

    <div class="card mt-4 rounded-3 shadow custom-card">
        <div class="card-body p-4">
            <!-- Filter Bar -->
            <form method="GET" action="{{ route('formpst.index_keluar') }}"
                class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4 filter-bar">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select name="cabang" class="form-select form-select-sm w-auto">
                        <option value="">Semua Cabang</option>
                        @foreach ($cabangList as $cabang)
                            <option value="{{ $cabang }}" @selected(request('cabang') == $cabang)>{{ $cabang }}</option>
                        @endforeach
                    </select>

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
                            @if (auth()->user()->role === 'admin' ||
                                    ((auth()->user()->role !== 'pegawai' ||
                                        $item->nama_pegawais->contains('nama_pegawai', auth()->user()->nama_lengkap)) &&
                                        (auth()->user()->cabang_asal === $item->cabang_asal || auth()->user()->cabang_asal === 'HO')))
                                @php
                                    $user = auth()->user();
                                    $bolehTampil = false;

                                    if ($user->role === 'admin') {
                                        $bolehTampil = true;
                                    } elseif ($user->role === 'hrd' && $user->cabang_asal === 'HO') {
                                        $bolehTampil = $item->acc_bm === 'oke'; // hanya yang sudah diverifikasi BM
                                    } elseif (
                                        $user->role !== 'pegawai' ||
                                        ($item->nama_pegawais->contains('nama_pegawai', $user->nama_lengkap) &&
                                            ($user->cabang_asal === $item->cabang_asal || $user->cabang_asal === 'HO'))
                                    ) {
                                        $bolehTampil = true;
                                    }
                                @endphp

                                @if ($bolehTampil)
                                    <tr
                                        class="{{ $item->acc_cabang === 'oke' ? 'table-success' : ($item->acc_cabang === 'reject' || $item->acc_ho === 'reject' || $item->acc_bm === 'reject' ? 'table-warning' : ($item->acc_cabang === 'cancel' || $item->acc_ho === 'cancel' || $item->acc_bm === 'cancel' ? 'table-danger' : '')) }} hover-row">
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
                                                <span class="badge bg-danger">Verifikasi Ditolak HO</span>
                                                @if ($item->reason_ho)
                                                    <br><small>Alasan: {{ $item->reason_ho }}</small>
                                                @endif
                                            @elseif ($item->acc_bm == 'reject')
                                                <span class="badge bg-danger">Verifikasi Ditolak BM</span>
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
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi Cabang</span>
                                            @elseif ($item->acc_bm == 'oke' && $item->acc_ho != 'oke')
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi HO</span>
                                            @elseif ($item->acc_bm != 'oke' && $item->acc_hrd == 'oke')
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi BM</span>
                                            @else
                                                <span class="badge bg-danger">Belum Diverifikasi</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- Detail --}}
                                                <a href="{{ route($item->cabang_asal === 'HO' ? 'formpst.show_nm' : 'formpst.show', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Lihat Detail Surat">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                {{-- Lihat Pegawai (modal trigger) --}}
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalPegawai{{ $item->id }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Pegawai">
                                                    <i class="bi bi-person-lines-fill"></i>
                                                </button>

                                                {{-- Edit (khusus HRD yang sesuai cabang dan belum acc) --}}
                                                {{-- @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === $item->cabang_asal && $item->acc_cabang !== 'oke')
                                                    <a href="{{ route('formpst.edit', ['id' => $item->id]) }}"
                                                        class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Edit Surat">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                @endif --}}

                                                {{-- Lihat Surat Tugas --}}
                                                <a href="{{ route('formpst.surat_tugas', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Lihat Surat Tugas">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                    <!-- Modal per item -->
                                    <div class="modal fade" id="modalPegawai{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title d-flex align-items-center gap-2"
                                                        id="modalLabel{{ $item->id }}">
                                                        <i class="bi bi-people-fill"></i>
                                                        Daftar Pegawai dalam Pengajuan
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($item->nama_pegawais && count($item->nama_pegawais))
                                                        <div class="list-group list-group-flush">
                                                            @foreach ($item->nama_pegawais as $pegawai)
                                                                <div
                                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <i
                                                                            class="bi bi-person-circle me-2 text-secondary"></i>
                                                                        {{ $pegawai->nama_pegawai }}
                                                                    </div>
                                                                    <span
                                                                        class="badge bg-info text-dark">{{ $pegawai->departemen }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning d-flex align-items-center gap-2"
                                                            role="alert">
                                                            <i class="bi bi-exclamation-circle-fill"></i>
                                                            Tidak ada data pegawai untuk pengajuan ini.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bi bi-x-circle"></i> Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


            </div>
            @endif
            @endif
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
        $(document).ready(function() {

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
                initComplete: function() {
                    $('.dataTables_length select').addClass('form-select form-select-sm');
                }
            });
            $(function() {
                $('#dataTable').DataTable({
                    destroy: true,
                    lengthMenu: [10, 25, 50, 100],
                    language: {
                        lengthMenu: 'Tampilkan _MENU_ data per halaman',
                        search: 'Cari:',
                        info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                        infoEmpty: 'Tidak ada data',
                        paginate: {
                            first: '«',
                            last: '»',
                            next: '›',
                            previous: '‹'
                        }
                    },
                    createdRow: function(row) {
                        const status = $('td:eq(6) span', row).text().trim();
                        if (status === 'Selesai') $(row).addClass('table-success');
                        else if (status.startsWith('Menunggu')) $(row).addClass(
                            'table-warning');
                        else if (status === 'Cancel' || status.startsWith('Ditolak')) $(row)
                            .addClass('table-danger');
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
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

        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }

        .card.shadow-sm.p-3 {
            border-radius: 10px;
            background-color: #f8f9fa;
            min-width: 130px;
            text-align: center;
        }

        .custom-table thead tr {
            background-color: #6a5acd;
            color: white;
            text-align: left;
        }

        .custom-table thead th {
            padding: 14px 18px;
            font-size: 16px;
            font-weight: bold;
        }

        .custom-table tbody tr {
            background-color: #f8f6ff;
            transition: background-color 0.3s ease-in-out;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: white;
        }

        .custom-table tbody tr:hover {
            background-color: #e6e1ff;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .custom-table tbody td {
            padding: 12px 16px;
            font-size: 14px;
            color: #333;
        }

        .custom-table thead tr:first-child th:first-child {
            border-top-left-radius: 12px;
        }

        .custom-table thead tr:first-child th:last-child {
            border-top-right-radius: 12px;
        }

        .custom-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px;
        }

        .custom-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px;
        }

        .badge {
            transition: background-color 0.3s ease, transform 0.2s;
            padding: 6px 10px;
            font-size: 13px;
            border-radius: 8px;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .badge.bg-success {
            background-color: #28a745;
        }

        .badge.bg-danger {
            background-color: #dc3545;
        }

        .badge.bg-warning {
            background-color: #ffc107;
            color: black;
        }

        .minimal-filter select,
        .minimal-filter input[type="date"] {
            min-width: 140px;
        }

        .minimal-filter button {
            white-space: nowrap;
        }

        @media (max-width: 576px) {
            .minimal-filter {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .filter-bar {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            max-width: 100%;
        }

        .filter-bar select,
        .filter-bar input[type="date"] {
            min-width: 130px;
        }

        .filter-bar button {
            min-width: 70px;
        }

        @media (max-width: 576px) {
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endsection
