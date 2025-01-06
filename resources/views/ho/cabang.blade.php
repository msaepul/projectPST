@extends('layouts.main')

@section('content')
    {{ Breadcrumbs::render('cabang') }}

    <div class="alert alert-info" role="alert">
        <strong>Info:</strong> Pastikan semua data cabang terisi dengan lengkap dan benar.
    </div>

    <div class="card-header">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addModal">
            <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                style="width: 20px; height: 20px; margin-right: 4px">Tambah Data
        </button>
    </div>

    <!-- Main content -->
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped"
                style="background-color: #e6f7ff; color: #000;">
                <thead style="background-color: #b3e0ff;">
                    <tr>
                        <th>No</th>
                        <th>Nama Cabang</th>
                        <th>Alamat Cabang</th>
                        <th>Kode Cabang</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cabangs as $key => $data)
                        <tr style="background-color: {{ $key % 2 == 0 ? '#ffffff' : '#e6f7ff' }};">
                            <td style="padding: 8px;">
                                {{ $loop->iteration + ($cabangs->currentPage() - 1) * $cabangs->perPage() }}</td>
                            <td style="padding: 8px;">{{ $data->nama_cabang }}</td>
                            <td style="padding: 8px;">{{ $data->alamat_cabang }}</td>
                            <td style="padding: 8px;">{{ $data->kode_cabang }}</td>
                            <td style="padding: 8px;">
                                <div class="d-flex gap-2" style="gap: 8px;">
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editModal-{{ $data->id }}">
                                        <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                            style="width: 20px; height: 20px; margin-right: 4px">
                                    </button>
                                    <form action="{{ route('cabang.destroy', $data->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <img src="{{ asset('icons/trash-outline.svg') }}" alt="Hapus"
                                                style="width: 20px; height: 20px; margin-right: 4px">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('cabang.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Data Cabang</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama_cabang">Nama Cabang:</label>
                                                <input type="text" class="form-control" id="nama_cabang"
                                                    name="nama_cabang" value="{{ $data->nama_cabang }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat_cabang">Alamat Cabang:</label>
                                                <textarea class="form-control" id="alamat_cabang" name="alamat_cabang" required>{{ $data->alamat_cabang }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode_cabang">Kode Cabang:</label>
                                                <input type="text" class="form-control" id="kode_cabang"
                                                    name="kode_cabang" value="{{ $data->kode_cabang }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>

            {{-- Tambahkan navigasi pagination --}}
            <div class="mt-3">
                {{ $cabangs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Modal Add --}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('cabang.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Data Cabang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
