@extends('layouts.main')

@section('content_header')
    {{ Breadcrumbs::render('cabang') }}
    <h1 class="card-title">Master Data Cabang</h1>
@endsection

@section('content')
    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow">
            <div class="card-header bg-light py-3">
                <h4 class="mb-0 fw-bold text-dark">Data Cabang</h4>
            </div>

            <div class="card-body">
                <button type="button" class="btn mb-3"
                    style="background-color: #80acca; border-color: #7ca4be; color: rgb(0, 0, 0);" data-bs-toggle="modal"
                    data-bs-target="#addModal">
                    <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                        style="width: 20px; height: 20px; margin-right: 4px">Tambah Cabang
                </button>

                <div class="table-responsive">
                    <table id="cabangTable" class="table table-bordered table-hover">
                        <thead class="table-primary text-white">
                            <tr>
                                <th class="text-center" style="width: 100px;">No</th>
                                <th>Nama Cabang</th>
                                <th>Alamat Cabang</th>
                                <th>Kode Cabang</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cabangs as $key => $data)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $data->nama_cabang }}</td>
                                    <td>{{ $data->alamat_cabang }}</td>
                                    <td>{{ $data->kode_cabang }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" style="gap: 10px;">
                                            {{-- Tombol Edit --}}
                                            <a href="cabang.edit" class="btn btn-sm btn-outline-warning action-btn"
                                                title="Edit" data-bs-toggle="modal"
                                                data-bs-target="#editModal-{{ $data->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('cabang.destroy', $data->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('cabang.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Cabang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="nama_cabang">Nama Cabang</label>
                            <input type="text" class="form-control" id="nama_cabang" name="nama_cabang" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="alamat_cabang">Alamat Cabang</label>
                            <textarea class="form-control" id="alamat_cabang" name="alamat_cabang" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kode_cabang">Kode Cabang</label>
                            <input type="text" class="form-control" id="kode_cabang" name="kode_cabang" required>
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

    <!-- Modal Edit -->
    @foreach ($cabangs as $data)
        <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1"
            aria-labelledby="editModalLabel-{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('cabang.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Cabang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-2">
                                <label for="nama_cabang">Nama Cabang</label>
                                <input type="text" class="form-control" name="nama_cabang"
                                    value="{{ $data->nama_cabang }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="alamat_cabang">Alamat Cabang</label>
                                <textarea class="form-control" name="alamat_cabang" required>{{ $data->alamat_cabang }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="kode_cabang">Kode Cabang</label>
                                <input type="text" class="form-control" name="kode_cabang"
                                    value="{{ $data->kode_cabang }}" required>
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
            var table = $('#cabangTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5'],
                language: {
                    lengthMenu: "Tampilkan _MENU_ entri per halaman",
                    zeroRecords: "Tidak ada data ditemukan",
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
