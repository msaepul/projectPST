@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="card mt-4 rounded-3 shadow custom-card">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold">Hasil Pencarian</h5>
        </div>
        <div class="card-body p-4">
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
                            <th>Status Pegawai</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            @if (auth()->user()->role !== 'pegawai' || $item->nama_pegawais->contains('nama_pegawai', auth()->user()->nama_lengkap))
                                @if (auth()->user()->cabang_asal === $item->cabang_asal || auth()->user()->role === 'admin' || auth()->user()->cabang_asal === 'HO')
                                    <tr class="{{ $item->acc_cabang === 'oke' ? 'table-success' : ($item->acc_cabang === 'reject' || $item->acc_ho === 'reject' || $item->acc_bm === 'reject' ? 'table-danger' : ($item->acc_cabang === 'cancel' || $item->acc_ho === 'cancel' || $item->acc_bm === 'cancel' ? 'table-warning' : '')) }} hover-row">
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $item->no_surat }}</td>
                                        <td>{{ $item->nama_pemohon }}</td>
                                        <td>{{ $item->cabang_asal }}</td>
                                        <td>{{ $item->cabang_tujuan }}</td>
                                        <td>{{ $item->tujuan }}</td>
                                        <td class="text-center">
                                            @if ($item->acc_cabang == 'oke')
                                                <span class="badge bg-success">Sudah Diverifikasi</span>
                                            @elseif ($item->acc_ho == 'reject')
                                                <span class="badge bg-danger">Verifikasi Ditolak HO</span>
                                            @elseif ($item->acc_ho == 'oke' && $item->acc_cabang != 'oke')
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi Cabang</span>
                                            @elseif ($item->acc_bm == 'oke' && $item->acc_ho != 'oke')
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi HO</span>
                                            @elseif ($item->acc_bm == 'reject')
                                                <span class="badge bg-danger">Verifikasi Ditolak BM</span>
                                            @elseif ($item->acc_bm != 'oke' && $item->acc_hrd == 'oke')
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi BM</span>
                                            @elseif (in_array($item->acc_bm, ['cancel', 'reject']) ||
                                                    in_array($item->acc_ho, ['cancel']) ||
                                                    in_array($item->acc_cabang, ['cancel']))
                                                <span class="badge bg-danger">Cancel</span>
                                            @else
                                                <span class="badge bg-danger">Belum Diverifikasi</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $formRejected =
                                                    in_array($item->acc_cabang, ['reject', 'cancel']) ||
                                                    in_array($item->acc_ho, ['reject', 'cancel']) ||
                                                    in_array($item->acc_bm, ['reject', 'cancel']);
            
                                                $anyRejected = false;
                                                $anyAccepted = false;
                                            @endphp
            
                                            @foreach ($item->nama_pegawais as $pegawai)
                                                @if ($pegawai->acc_nm == 'tolak' || $formRejected)
                                                    @php $anyRejected = true; @endphp
                                                    <span class="badge bg-danger">Pegawai Ditolak:
                                                        {{ $pegawai->nama_pegawai }}</span>
                                                @elseif ($pegawai->acc_nm == 'oke')
                                                    @php $anyAccepted = true; @endphp
                                                @endif
                                            @endforeach
            
                                            @if ($formRejected)
                                                <span class="badge bg-danger">Semua Pegawai Ditolak (Form Ditolak)</span>
                                            @elseif (!$anyRejected && !$anyAccepted)
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                            @elseif ($anyAccepted)
                                                <span class="badge bg-success">Semua Pegawai Diterima</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route($item->cabang_asal === 'HO' ? 'formpst.show_nm' : 'formpst.show', ['id' => $item->id]) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                                @if (auth()->user()->role === 'hrd' && $item->acc_cabang !== 'oke')
                                                    <a href="{{ route('formpst.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-3">Tidak ada data ditemukan.</td>
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
                paging: true,
                searching: true,
                ordering: true,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>

<style>
    /* Styling tabel */
    .custom-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Header tabel */
    .custom-table thead tr {
        background-color: #6a5acd; /* Warna ungu kebiruan */
        color: white;
        text-align: left;
    }

    /* Style untuk sel header */
    .custom-table thead th {
        padding: 14px 18px;
        font-size: 16px;
        font-weight: bold;
    }

    /* Style untuk baris tabel */
    .custom-table tbody tr {
        background-color: #f8f6ff; /* Ungu muda */
        transition: background-color 0.3s ease-in-out;
    }

    /* Style baris tabel dengan warna bergantian */
    .custom-table tbody tr:nth-child(even) {
        background-color: white;
    }

    /* Hover effect */
    .custom-table tbody tr:hover {
        background-color: #e6e1ff; /* Warna ungu yang lebih terang */
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Style untuk sel tabel */
    .custom-table tbody td {
        padding: 12px 16px;
        font-size: 14px;
        color: #333;
    }

    /* Tambahkan border radius hanya di atas dan bawah tabel */
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

    /* Style untuk badge */
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
