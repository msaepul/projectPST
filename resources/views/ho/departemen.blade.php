@extends('layouts.main')

@section('content_header')
    <h1 class="card-title">Master Data Departemen</h1>
@endsection

@section('content')
    <div class="alert alert-info" role="alert">
        <strong>Info:</strong> Pastikan semua data departemen terisi dengan lengkap dan benar.
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Master Data Departemen</h3>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahDepartemenModal">
                    <i class="fas fa-plus"></i> Tambah Departemen Baru
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" style="background-color: #f0f8ff; color: #000;">
                <thead style="background-color: #ffffff;">
                    <tr>
                        <th style="width: 20%;">Nama Departemen</th>
                        <th style="width: 20%;">Kode Departemen</th>
                        <th style="width: 30%;">Keterangan</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departemens as $item)
                        <tr id="departemen-{{ $item->id }}">
                            <td>{{ $item->nama_departemen }}</td>
                            <td>{{ $item->kode_departemen }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <div class="d-flex" style="gap: 8px;">
                                    <!-- Button untuk Edit Modal -->
                                    <button type="button" class="btn btn-sm btn-primary me-3" data-toggle="modal"
                                        data-target="#editModal-{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel-{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('ho.departemen.update', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel-{{ $item->id }}">Edit
                                                            Departemen</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="nama_departemen">Nama Departemen:</label>
                                                            <input type="text" class="form-control" id="nama_departemen"
                                                                name="nama_departemen" value="{{ $item->nama_departemen }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kode_departemen">Kode Departemen:</label>
                                                            <input type="text" class="form-control" id="kode_departemen"
                                                                name="kode_departemen" value="{{ $item->kode_departemen }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan:</label>
                                                            <input type="text" class="form-control" id="keterangan"
                                                                name="keterangan" value="{{ $item->keterangan }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save"></i> Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Hapus -->
                                    <form action="{{ route('ho.departemen.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus departemen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada data departemen</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Departemen -->
    <div class="modal fade" id="tambahDepartemenModal" tabindex="-1" role="dialog"
        aria-labelledby="tambahDepartemenModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDepartemenModalLabel">Tambah Departemen Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('ho.departemen.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nama_departemen">Nama Departemen</label>
                            <input type="text" class="form-control" id="nama_departemen" name="nama_departemen"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="kode_departemen">Kode Departemen</label>
                            <input type="text" class="form-control" id="kode_departemen" name="kode_departemen"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
