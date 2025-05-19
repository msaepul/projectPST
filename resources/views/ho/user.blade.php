@extends('layouts.main')

@section('content')
    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow">
            <div class="card-header bg-light py-3">
                <h4 class="Judul mb-0 fw-bold text-dark">Data User</h4>
            </div>

            <div class="card-body">
                <a href="{{ route('ho.user.add') }}" class="btn mb-3"
                    style="background-color: #80acca; border-color: #7ca4be; color: rgb(0, 0, 0);">
                    <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                        style="width: 20px; height: 20px; margin-right: 4px">Tambah User
                </a>

                <div class="table-responsive">
                    <table id="userTable" class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-primary text-white">
                                <th scope="col" style="text-align: center;">No</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Nama User</th>
                                <th scope="col">Email</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Cabang Asal</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Role</th>
                                <th scope="col" style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if (
                                    (auth()->user()->role === 'hrd' &&
                                        (auth()->user()->cabang_asal === 'HO' || auth()->user()->cabang_asal === $user->cabang_asal)) ||
                                        auth()->user()->role === 'admin')
                                    <tr>
                                        <td class="text-center"></td> {{-- Indeks akan diisi oleh DataTables --}}
                                        <td>{{ $user->nama_lengkap }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->nik }}</td>
                                        <td>{{ $user->departemen }}</td>
                                        <td>{{ $user->cabang_asal }}</td>
                                        <td>{{ $user->no_hp }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                                <a href="{{ route('ho.user.edit', $user->id) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                                        style="width: 20px; height: 20px;">
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-primary" title="Upload Tanda Tangan" data-bs-toggle="modal" data-bs-target="#uploadSignatureModal{{ $user->id }}">
                                                    <img src="{{ asset('icons/upload-outline.svg') }}" alt="Upload"
                                                        style="width: 20px; height: 20px;">
                                                </button>
                                                <form action="{{ route('ho.user.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <img src="{{ asset('icons/trash-outline.svg') }}" alt="Delete"
                                                            style="width: 20px; height: 20px;">
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal Upload Tanda Tangan -->
                                    <div class="modal fade" id="uploadSignatureModal{{ $user->id }}" tabindex="-1" aria-labelledby="uploadSignatureLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadSignatureLabel{{ $user->id }}">Upload Tanda Tangan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ho.user.uploadSignature', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <label for="ttd">Upload Tanda Tangan:</label>
                                                        <input type="file" name="ttd" id="ttd" accept="image/png, image/jpeg" required>
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

    <script>
        $(document).ready(function() {
            var table = $('#userTable').DataTable({
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ entri per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(disaring dari _MAX_ total entri)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0 // Kolom pertama untuk nomor
                }],
                "order": [[1, 'asc']] // Urutkan berdasarkan nama
            });
    
            // Tambahkan event listener agar nomor selalu diurutkan dari 1
            table.on('order.dt search.dt', function() {
                table.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
    </script>
    
@endsection
