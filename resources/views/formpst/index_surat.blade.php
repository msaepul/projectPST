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
                            <th scope="col">Tanggal Dibuat</th>
                            <th scope="col">No Surat</th>
                            <th scope="col">Nama Pemohon</th>
                            <th scope="col">Cabang Asal</th>
                            <th scope="col">Cabang Tujuan</th>
                            <th scope="col">Tujuan Pelatihan</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            @if (auth()->user()->role !== 'pegawai' || $item->nama_pegawais->contains('nama_pegawai', auth()->user()->nama_lengkap))
                                @if (auth()->user()->cabang_asal === $item->cabang_tujuan ||
                                        auth()->user()->cabang_asal === $item->cabang_asal ||
                                        auth()->user()->role === 'admin' ||
                                        (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO'))
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $item->no_surat }}</td>
                                        <td>{{ $item->nama_pemohon }}</td>
                                        <td>{{ $item->cabang_asal }}</td>
                                        <td>{{ $item->cabang_tujuan }}</td>
                                        <td>{{ $item->tujuan }}</td>
                                        <td class="text-center d-flex justify-content-center gap-2 text-nowrap">
                                            <a href="{{ route('formpst.show', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                                                <i class="bi bi-eye" style="font-size: 16px;"></i>
                                            </a>
                                            <a href="{{ route('formpst.surat_tugas', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                                                <i class="bi bi-file-earmark-text" style="font-size: 16px;"></i>
                                            </a>
                                            <a href="{{ route('formpst.ticket', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" id="viewEmployeesBtn">
                                                <i class="bi bi-airplane" style="font-size: 16px;"></i>
                                             </a>
                                             
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3">Tidak ada data ditemukan.</td>
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
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data tersedia",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>

    <style>

.custom-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
}

.custom-table thead tr {
    background-color: #6a5acd; /* Warna ungu kebiruan */
    color: white;
    text-align: left;
}

.custom-table thead th {
    padding: 12px 16px;
    font-size: 16px;
    font-weight: bold;
}

.custom-table tbody tr {
    background-color: #f8f6ff; /* Ungu muda */
    transition: background-color 0.3s ease-in-out;
}

.custom-table tbody tr:nth-child(even) {
    background-color: white;
}

.custom-table tbody tr:hover {
    background-color: #e6e1ff; /* Warna ungu yang lebih terang */
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

    </style>
@endsection