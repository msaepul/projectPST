@extends('layouts.main')

@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="card mt-4 rounded-3 shadow custom-card">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold">Hasil Pencarian</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-hover custom-table">
                    <thead>
                        <tr class="table-primary text-white">
                            <th scope="col">No Surat</th>
                            <th scope="col">Nama Pemohon</th>
                            <th scope="col">Cabang Asal</th>
                            <th scope="col">Cabang Tujuan</th>
                            <th scope="col">Tujuan Pelatihan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Status Pegawai</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            @if (auth()->user()->cabang_asal === $item->cabang_tujuan ||
                                    auth()->user()->cabang_asal == 'HO' ||
                                    auth()->user()->role === 'admin')
                                <tr>
                                    <td>{{ $item->no_surat }}</td>
                                    <td>{{ $item->nama_pemohon }}</td>
                                    <td>{{ $item->cabang_asal }}</td>
                                    <td>{{ $item->cabang_tujuan }}</td>
                                    <td>{{ $item->tujuan }}</td>
                                    <td class="text-center">
                                        @if ($item->acc_cabang == 'oke')
                                            <span class="badge bg-success">Sudah Diverifikasi</span>
                                        @elseif ($item->acc_cabang == 'reject')
                                            <span class="badge bg-danger">Verifikasi Ditolak Cabang</span>
                                        @elseif ($item->acc_ho == 'oke')
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
                                            @if ($pegawai->acc_nm == 'tolak')
                                                @php $anyRejected = true; @endphp
                                                <span class="badge bg-danger">Pegawai Ditolak: {{ $pegawai->nama_pegawai }}</span>
                                            @elseif ($pegawai->acc_nm == 'oke')
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
                                        <a href="{{ route('formpst.show', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-outline-primary">Detail</a>
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
        $('#datatable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari total _MAX_ data)",
                "search": "Cari:",
                "paginate": {
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            },
            "order": [[0, "asc"]],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
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
        background-color: #6a5acd !important; /* Warna ungu */
        color: white !important;
        text-align: left;
    }

    /* Style untuk sel header */
    .custom-table thead th {
        padding: 12px 16px;
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
        background-color: #e6e1ff; /* Warna ungu lebih terang */
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

    /* Badge Styling */
    .badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 8px;
    }
</style>
@endsection
