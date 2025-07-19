@extends('layouts.main')

@section('content_header')
    {{-- {{ Breadcrumbs::render('maskapai') }} --}}
    <h1 class="card-title">Master Data Maskapai</h1>
@endsection

@section('content')
    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow">
            <div class="card-header bg-light py-3">
                <h4 class="mb-0 fw-bold text-dark">Data Maskapai</h4>
            </div>

            <div class="card-body">
                <!-- Tombol Tambah -->
                <button type="button" class="btn mb-3"
                    style="background-color: #80acca; border-color: #7ca4be; color: rgb(0, 0, 0);" data-bs-toggle="modal"
                    data-bs-target="#tambahMaskapaiModal">
                    <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                        style="width: 20px; height: 20px; margin-right: 4px">
                    Tambah Maskapai
                </button>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table id="maskapaiTable" class="table table-bordered table-hover">
                        <thead class="table-primary text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Operator</th>
                                <th>Nama Operator</th>
                                <th>Jenis Kendaraan</th>
                                <th class="text-center" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($maskapais as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $item->kode_maskapai }}</td>
                                    <td>{{ $item->nama_maskapai }}</td>
                                    <td>{{ $item->jenis_kendaraan }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" style="gap: 10px;">
                                            <!-- Edit -->
                                            <a href="{{ route('ho.maskapai.edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-warning action-btn" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('ho.maskapai.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus maskapai ini?');"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger action-btn"
                                                    title="Hapus">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Maskapai -->
    <div class="modal fade" id="tambahMaskapaiModal" tabindex="-1" role="dialog"
        aria-labelledby="tambahMaskapaiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('ho.maskapai.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Maskapai Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="kode_maskapai">Kode Operator</label>
                            <input type="text" class="form-control" id="kode_maskapai" name="kode_maskapai" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="nama_maskapai">Nama Operator</label>
                            <input type="text" class="form-control" id="nama_maskapai" name="nama_maskapai" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
                                <option value="">-- Pilih Jenis Kendaraan --</option>
                                <option value="Travel">Travel</option>
                                <option value="Bus">Bus</option>
                                <option value="Kereta">Kereta</option>
                                <option value="Pesawat">Pesawat</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.css" />
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#maskapaiTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5'],
                language: {
                    lengthMenu: "Tampilkan _MENU_ entri per halaman",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    info: "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                },
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0
                }],
                order: [
                    [1, 'asc']
                ]
            });

            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
    </script>
@endpush

@push('styles')
    <style>
        .action-btn i {
            font-size: 16px;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .action-btn:hover i {
            transform: scale(1.2);
        }

        .btn-outline-warning:hover i {
            color: #ffc107;
        }

        .btn-outline-danger:hover i {
            color: #dc3545;
        }

        .btn-outline-warning,
        .btn-outline-danger {
            padding: 5px 10px;
            border-radius: 8px;
        }
    </style>
@endpush
