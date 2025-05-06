@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="card mt-4 rounded-3 shadow custom-card">
        <div class="card-header bg-light py-3">
            <h4 class="mb-0 fw-bold">Daftar Keberangkatan</h4>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover custom-table">
                    <thead>
                        <tr class="table-primary text-white">
                            <th scope="col">No</th>
                            <th scope="col">No. Surat</th>
                            <th scope="col">Nama Pemohon</th>
                            <th scope="col">Agen</th>
                            <th scope="col">Tanggal Issued</th>
                            <th scope="col">Transportasi</th>
                            <th scope="col">Maskapai</th>
                            <th scope="col">Detail Perjalanan</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $dummyDepartures = [
                                [
                                    'id' => 1,
                                    'no_surat' => 'SRT-001',
                                    'nama_pemohon' => 'John Doe',
                                    'agen' => 'Travel A',
                                    'tanggal_issued' => '2025-05-01',
                                    'transport' => 'Pesawat',
                                    'maskapai' => 'Garuda Indonesia',
                                    'detail_url' => '#',
                                ],
                                [
                                    'id' => 2,
                                    'no_surat' => 'SRT-002',
                                    'nama_pemohon' => 'Jane Smith',
                                    'agen' => 'Travel B',
                                    'tanggal_issued' => '2025-05-03',
                                    'transport' => 'Kereta',
                                    'maskapai' => 'PT KAI',
                                    'detail_url' => '#',
                                ],
                                // Tambahkan data dummy lainnya jika perlu
                            ];
                        @endphp

                        @forelse ($dummyDepartures as $index => $departure)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $departure['no_surat'] }}</td>
                                <td>{{ $departure['nama_pemohon'] }}</td>
                                <td>{{ $departure['agen'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($departure['tanggal_issued'])->format('d-m-Y') }}</td>
                                <td>{{ $departure['transport'] }}</td>
                                <td>{{ $departure['maskapai'] }}</td>
                                <td>
                                    {{-- <a href="{{ route('departures.show', $departure['id']) }}" --}}
                                    {{-- class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center">
                                    <i class="bi bi-eye" style="font-size: 16px;"></i> --}}
                                    </a>
                                </td>
                                <td>
                                    <select class="form-select status-select" data-departure-id="{{ $departure['id'] }}">
                                        {{-- <option {{ $departure['status'] === 'On Time' ? 'selected' : '' }}>On Time</option>
                                        <option {{ $departure['status'] === 'Delay' ? 'selected' : '' }}>Delay</option>
                                        <option {{ $departure['status'] === 'Cancelled' ? 'selected' : '' }}>Cancelled
                                        </option> Opsi Cancelled --}}
                                    </select>
                                </td>
                            </tr>
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

    {{-- <script>
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
    </script> --}}

    <style>
        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }

        .custom-table thead tr {
            background-color: #6a5acd;
            /* Warna ungu kebiruan */
            color: white;
            text-align: left;
        }

        .custom-table thead th {
            padding: 12px 16px;
            font-size: 16px;
            font-weight: bold;
        }

        .custom-table tbody tr {
            background-color: #f8f6ff;
            /* Ungu muda */
            transition: background-color 0.3s ease-in-out;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: white;
        }

        .custom-table tbody tr:hover {
            background-color: #e6e1ff;
            /* Warna ungu yang lebih terang */
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
