@extends('layouts.main')

@section('content_header')
    {{ Breadcrumbs::render('departemen') }}
    <h1 class="card-title">Master Data Departemen</h1>
@endsection

@section('content')
    <div class="alert alert-info" role="alert">
        <strong>Info:</strong> Pastikan semua data departemen terisi dengan lengkap dan benar.
    </div>

    <div class="card mb-4 rounded-3 shadow">
        <div class="card-header bg-light py-3">
            <h4 class="mb-0 fw-bold text-dark">Data Departemen</h4>
        </div>

        <div class="card-body">
            <button type="button" class="btn mb-3"
                style="background-color: #80acca; border-color: #7ca4be; color: rgb(0, 0, 0);" data-bs-toggle="modal"
                data-bs-target="#tambahDepartemenModal">
                <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                    style="width: 20px; height: 20px; margin-right: 4px">Tambah Departemen Baru
            </button>

            <div class="table-responsive">
                <table id="departemenTable" class="table table-bordered table-hover" style="width: 100%;">
                    <thead class="table-primary text-white">
                        <tr>
                            <th scope="col" style="text-align: center;">No</th>
                            <th scope="col">Nama Departemen</th>
                            <th scope="col">Kode Departemen</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departemens as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $item->nama_departemen }}</td>
                                <td>{{ $item->kode_departemen }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 5px;">
                                        <!-- Edit -->
                                        <a href="#" class="btn btn-sm btn-outline-warning action-btn" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('ho.departemen.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus departemen ini?');"
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahDepartemenModal" tabindex="-1" role="dialog"
        aria-labelledby="tambahDepartemenModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('ho.departemen.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDepartemenModalLabel">Tambah Departemen Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="nama_departemen">Nama Departemen</label>
                            <input type="text" class="form-control" id="nama_departemen" name="nama_departemen" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="kode_departemen">Kode Departemen</label>
                            <input type="text" class="form-control" id="kode_departemen" name="kode_departemen" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit untuk setiap departemen -->
    @foreach ($departemens as $item)
        <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('ho.departemen.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $item->id }}">Edit Departemen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-2">
                                <label for="nama_departemen">Nama Departemen</label>
                                <input type="text" class="form-control" name="nama_departemen"
                                    value="{{ $item->nama_departemen }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="kode_departemen">Kode Departemen</label>
                                <input type="text" class="form-control" name="kode_departemen"
                                    value="{{ $item->kode_departemen }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan"
                                    value="{{ $item->keterangan }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
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
            var table = $('#departemenTable').DataTable({
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
