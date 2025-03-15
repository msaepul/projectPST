@extends('layouts.main')

@section('content')
    {{ Breadcrumbs::render('cabang') }}

    <div class="alert alert-info" role="alert">
        <strong>Info:</strong> Pastikan semua data cabang terisi dengan lengkap dan benar.
    </div>

    <div class="card mb-4 rounded-3 shadow">
        <div class="card-header bg-light text-white py-3">
            <h4 class="mb-0 fw-bold">Data Cabang</h4>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                    style="width: 20px; height: 20px; margin-right: 4px">Tambah Data
            </button>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                    <thead class="table-primary text-white">
                        <tr>
                            <th scope="col" class="text-center" style="width: 50px;">No</th>
                            <th scope="col">Nama Cabang</th>
                            <th scope="col">Alamat Cabang</th>
                            <th scope="col" style="width: 200px;">Kode Cabang</th>
                            <th scope="col" class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cabangs as $key => $data)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration + ($cabangs->currentPage() - 1) * $cabangs->perPage() }}</td>
                                <td>{{ $data->nama_cabang }}</td>
                                <td>{{ $data->alamat_cabang }}</td>
                                <td>{{ $data->kode_cabang }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 10px;">
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal-{{ $data->id }}" title="Edit">
                                            <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                                style="width: 20px; height: 20px;">
                                        </button>
                                        <form action="{{ route('cabang.destroy', $data->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <img src="{{ asset('icons/trash-outline.svg') }}" alt="Hapus"
                                                    style="width: 20px; height: 20px;">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $cabangs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('cabang.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Data Cabang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_cabang">Nama Cabang:</label>
                            <input type="text" class="form-control" id="nama_cabang" name="nama_cabang" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat_cabang">Alamat Cabang:</label>
                            <textarea class="form-control" id="alamat_cabang" name="alamat_cabang" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kode_cabang">Kode Cabang:</label>
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

    @foreach ($cabangs as $data)
        <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1"
            aria-labelledby="editModalLabel-{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('cabang.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $data->id }}">Edit Data Cabang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_cabang">Nama Cabang:</label>
                                <input type="text" class="form-control" id="nama_cabang" name="nama_cabang"
                                    value="{{ $data->nama_cabang }}" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat_cabang">Alamat Cabang:</label>
                                <textarea class="form-control" id="alamat_cabang" name="alamat_cabang" required>{{ $data->alamat_cabang }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="kode_cabang">Kode Cabang:</label>
                                <input type="text" class="form-control" id="kode_cabang" name="kode_cabang"
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
