@extends('layouts.main')

@section('content')
    {{-- {{ Breadcrumbs::render('Form') }} --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-4">
            <div class="card shadow-sm p-3 text-white"
                style="background-color: #a9a2e6; border-radius: 12px; min-width: 150px;">
                <div class="small">Surat Tugas</div>
                <div class="fw-bold fs-4">{{ $jumlahSuratTugas ?? 0 }}</div>
            </div>
            <a href="{{ route('formpst.index_masuk') }}" class="text-decoration-none">
                <div class="card shadow-sm p-3 text-white"
                    style="background-color: #1cc88a; border-radius: 12px; min-width: 150px;">
                    <div class="small">Surat Masuk</div>
                    <div class="fw-bold fs-4">{{ $jumlahSuratMasuk ?? 0 }}</div>
                </div>
            </a>
            <div class="card shadow-sm p-3 text-white"
                style="background-color: #ffa844; border-radius: 12px; min-width: 150px;">
                <div class="small">Surat Keluar</div>
                <div class="fw-bold fs-4">{{ $jumlahSuratKeluar ?? 0 }}</div>
            </div>
        </div>
        <div>
            <a href="{{ route('formpst.form') }}" class="btn btn-primary">
                + Tambah Surat Tugas
            </a>
        </div>
    </div>



    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover custom-table">
            <thead>
                <tr class="table-primary text-white">
                    <th>Tanggal Dibuat</th>
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
                    @if (auth()->user()->role === 'admin' ||
                            ((auth()->user()->role !== 'pegawai' ||
                                $item->nama_pegawais->contains('nama_pegawai', auth()->user()->nama_lengkap)) &&
                                (auth()->user()->cabang_asal === $item->cabang_asal || auth()->user()->cabang_asal === 'HO')))
                        <tr
                            class="{{ $item->acc_cabang === 'oke' ? 'table-success' : ($item->acc_cabang === 'reject' || $item->acc_ho === 'reject' || $item->acc_bm === 'reject' ? 'table-warning' : ($item->acc_cabang === 'cancel' || $item->acc_ho === 'cancel' || $item->acc_bm === 'cancel' ? 'table-danger' : '')) }} hover-row">
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                            <td>{{ $item->no_surat }}</td>
                            <td>{{ $item->nama_pemohon }}</td>
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
                                    <a href="{{ route($item->cabang_asal === 'HO' ? 'formpst.show_nm' : 'formpst.show', ['id' => $item->id]) }}"
                                        class="btn btn-sm btn-outline-primary" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === $item->cabang_asal && $item->acc_cabang !== 'oke')
                                        <a href="{{ route('formpst.edit', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
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
    </style>
@endsection
