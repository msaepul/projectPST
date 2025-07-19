@extends('layouts.main')

@section('content')
    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow">
            <div class="card-header bg-light py-3">
                <h4 class="Judul mb-0 fw-bold text-dark">Data User</h4>
            </div>

            <div class="card-body">
                <!-- Tombol Tambah User -->
                <a href="{{ route('ho.user.add') }}" class="btn mb-3"
                    style="background-color: #80acca; border-color: #7ca4be; color: #000;">
                    <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                        style="width: 20px; height: 20px; margin-right: 4px;">
                    Tambah User
                </a>

                <!-- Tabel Data User -->
                <div class="table-responsive">
                    <table id="userTable" class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-primary text-white">
                                <th class="text-center">No</th>
                                <th>Nama Lengkap</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Departemen</th>
                                <th>Cabang Asal</th>
                                <th>No HP</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if (
                                    (auth()->user()->departemen === 'HRD' &&
                                        (auth()->user()->cabang_asal === 'HO' || auth()->user()->cabang_asal === $user->cabang_asal)) ||
                                        auth()->user()->role === 'admin')
                                    <tr>
                                        <td class="text-center"></td>
                                        <td>{{ $user->nama_lengkap }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->nik }}</td>
                                        <td>{{ $user->departemen }}</td>
                                        <td>{{ $user->cabang_asal }}</td>
                                        <td>{{ $user->no_hp }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Edit -->
                                                <a href="{{ route('ho.user.edit', $user->id) }}"
                                                    class="btn btn-sm btn-outline-warning action-btn" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <!-- Upload Tanda Tangan -->
                                                <button type="button" class="btn btn-sm btn-outline-primary action-btn"
                                                    title="Upload Tanda Tangan" data-bs-toggle="modal"
                                                    data-bs-target="#uploadSignatureModal{{ $user->id }}">
                                                    <i class="bi bi-upload"></i>
                                                </button>

                                                <!-- Delete -->
                                                <form action="{{ route('ho.user.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');"
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

                                    <!-- Modal Upload Tanda Tangan -->
                                    <div class="modal fade" id="uploadSignatureModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="uploadSignatureLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadSignatureLabel{{ $user->id }}">
                                                        Upload Tanda Tangan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ho.user.uploadSignature', $user->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="ttd" class="form-label">Pilih File
                                                                (PNG/JPG):</label>
                                                            <input type="file" name="ttd" id="ttd"
                                                                class="form-control" accept="image/png, image/jpeg"
                                                                required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
                var table = $('#userTable').DataTable({
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

        .btn-outline-primary:hover i {
            color: #0d6efd;
        }

        .btn-outline-danger:hover i {
            color: #dc3545;
        }

        .btn-outline-warning,
        .btn-outline-primary,
        .btn-outline-danger {
            padding: 5px 10px;
            border-radius: 8px;
        }
    </style>
@endsection
