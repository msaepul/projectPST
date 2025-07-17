@extends('layouts.main')

@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/nice-forms.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endpush

<div class="card mt-4 rounded-3 shadow custom-card">
    <div class="card-body p-4">

        {{-- FILTER DAN TOMBOL TAMBAH --}}
        <form method="GET" action="{{ route('formpst.index_masuk') }}" class="mb-4">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary px-3 d-inline-flex align-items-center gap-2 btn-animated-filter"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse"
                        title="Filter pencarian">
                    <i class="bi bi-funnel"></i>
                </button>

                
            </div>

            <div class="collapse mt-3" id="filterCollapse">
                <div class="d-flex flex-wrap align-items-center gap-2 filter-bar">
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

                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control form-control-sm w-auto">

                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i> Terapkan Filter
                    </button>
                </div>
            </div>
        </form>

        {{-- TABEL --}}
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-hover align-middle custom-table">
                <thead>
                    <tr class="table-primary text-white">
                        <th>Tanggal Dibuat</th>
                        <th>No Surat</th>
                        <th>Nama Pemohon</th>
                        <th>Cabang Asal</th>
                        <th>Cabang Tujuan</th>
                        <th>Tujuan Pelatihan</th>
                        <th>Status</th>
                        <th>Status Pegawai</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        @if (auth()->user()->cabang_asal === $item->cabang_tujuan ||
                             auth()->user()->cabang_asal === 'HO' ||
                             auth()->user()->role === 'admin')
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                <td>{{ $item->no_surat }}</td>
                                <td>{{ $item->nama_pemohon }}</td>
                                <td>{{ $item->cabang_asal }}</td>
                                <td>{{ $item->cabang_tujuan }}</td>
                                <td>{{ $item->tujuan }}</td>
                                <td class="text-center">
                                    @if ($item->acc_cabang === 'oke')
                                        <span class="badge bg-success">Sudah Diverifikasi</span>
                                    @elseif ($item->acc_cabang === 'reject')
                                        <span class="badge bg-danger">Verifikasi Ditolak Cabang</span>
                                    @elseif ($item->acc_ho === 'oke')
                                        <span class="badge bg-warning text-dark">Menunggu Verifikasi Cabang</span>
                                    @else
                                        <span class="badge bg-danger">Belum Diverifikasi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $anyRejected = false;
                                        $anyAccepted = false;
                                    @endphp

                                    @foreach ($item->nama_pegawais as $pegawai)
                                        @if ($pegawai->acc_nm === 'tolak')
                                            @php $anyRejected = true; @endphp
                                            <span class="badge bg-danger">Pegawai Ditolak: {{ $pegawai->nama_pegawai }}</span>
                                        @elseif ($pegawai->acc_nm === 'oke')
                                            @php $anyAccepted = true; @endphp
                                        @endif
                                    @endforeach

                                    @if (!$anyRejected && !$anyAccepted)
                                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                    @elseif (!$anyRejected && $anyAccepted)
                                        <span class="badge bg-success">Semua Pegawai Diterima</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route($item->cabang_asal === 'HO' ? 'formpst.show_nm' : 'formpst.show', ['id' => $item->id]) }}"
                                           class="btn btn-sm btn-outline-primary" title="Detail">
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

                                        {{-- @if (auth()->user()->role === 'hrd' && $item->acc_cabang !== 'oke')
                                            <a href="{{ route('formpst.edit', ['id' => $item->id]) }}"
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endif --}}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr><td colspan="8" class="text-center py-3">Tidak ada data ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL PEGAWAI --}}
@foreach ($data as $item)
    <div class="modal fade" id="modalPegawai{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-people-fill"></i> Daftar Pegawai</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($item->nama_pegawais && count($item->nama_pegawais))
                        <div class="list-group list-group-flush">
                            @foreach ($item->nama_pegawais as $pegawai)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div><i class="bi bi-person-circle me-2 text-secondary"></i>{{ $pegawai->nama_pegawai }}</div>
                                    <span class="badge bg-info text-dark">{{ $pegawai->departemen }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-circle-fill"></i> Tidak ada data pegawai untuk pengajuan ini.
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
@endforeach

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 text-end'B>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [
                    { extend: 'copy', className: 'btn btn-sm buttons-copy' },
                    { extend: 'excel', className: 'btn btn-sm buttons-excel' },
                    { extend: 'csv', className: 'btn btn-sm buttons-csv' },
                    { extend: 'pdf', className: 'btn btn-sm buttons-pdf' },
                    { extend: 'print', className: 'btn btn-sm buttons-print' }
                ],
                lengthMenu: [10, 25, 50, 100],
                language: {
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    search: "Cari:",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        first: "Awal", last: "Akhir", next: "Berikutnya", previous: "Sebelumnya"
                    }
                }
            });

            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/nice-forms.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <style>
        .custom-card {
            max-width: 2000px;
            margin: auto;
        }

        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
        }

        .custom-table thead tr {
            background-color: #6a5acd;
            color: white;
        }

        .custom-table thead th,
        .custom-table tbody td {
            padding: 12px 16px;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: white;
        }

        .custom-table tbody tr:hover {
            background-color: #e6e1ff;
        }

        .badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .badge.bg-info {
            background-color: #d0e2f2 !important;
            color: #1c3c5a !important;
        }

        .filter-bar select,
        .filter-bar input[type="date"] {
            min-width: 130px;
        }

        @media (max-width: 576px) {
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .modal-content {
            border-radius: 14px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
            border: none;
        }

        .modal-header {
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
            background: #3b4d63;
            color: #ffffff;
        }

        .modal-body {
            font-size: 15px;
            line-height: 1.6;
            background-color: #f9fafb;
        }

        .modal-footer {
            border-bottom-right-radius: 14px;
            border-bottom-left-radius: 14px;
            background: #f0f2f5;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #e0e0e0;
            padding: 12px 0;
            background-color: transparent;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .modal-title i {
            margin-right: 6px;
        }

        .btn-close-white {
            filter: brightness(0) invert(1);
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: none;
            border-radius: 6px;
            padding: 12px;
        }

        .animated-envelope {
            transition: transform 0.3s ease;
        }

        .btn-animated-envelope:hover .animated-envelope {
            transform: translateY(-3px) rotate(-5deg);
        }

        .btn-animated-filter i {
            transition: transform 0.3s ease;
        }

        .btn-animated-filter:hover i {
            transform: rotate(15deg);
        }

        .btn-animated-filter {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .btn-animated-filter:hover {
            background-color: #4a69bd;
            color: #fff;
            border-color: #4a69bd;
        }

        #filterCollapse {
            transition: all 0.3s ease-in-out;
        }

        div.dt-buttons {
            display: inline-flex;
            background-color: #6c757d;
            border-radius: 8px;
            padding: 6px 12px;
            gap: 8px;
        }

        .dt-button {
            background: none !important;
            border: none !important;
            color: white !important;
            padding: 4px 10px !important;
            font-weight: 500;
            font-size: 14px;
            transition: background-color 0.2s ease;
            border-radius: 4px;
        }

        .dt-button:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .dt-button:focus {
            box-shadow: none !important;
        }
    </style>
@endpush
@endsection
