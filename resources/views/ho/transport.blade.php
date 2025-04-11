@extends('layouts.main')

@section('content')
    {{-- {{ Breadcrumbs::render('transport') }} --}}

    <div class="alert alert-info" role="alert">
        <strong>Info:</strong> Pastikan semua data transport terisi dengan lengkap dan benar.
    </div>

    <div class="card mb-4 rounded-3 shadow">
        <div class="card-header bg-light text-white py-3">
            <h4 class="mb-0 fw-bold">Master Data Transport</h4>
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
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Nama Transport</th>
                            <th>Kode Transport</th>
                            <th>Keterangan</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transports as $data)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration + ($transports->currentPage() - 1) * $transports->perPage() }}
                                </td>
                                <td>{{ $data->nama_transport }}</td>
                                <td>{{ $data->kode_transport }}</td>
                                <td>{{ $data->keterangan }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 10px;">
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal-{{ $data->id }}" title="Edit">
                                            <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                                style="width: 20px; height: 20px;">
                                        </button>
                                        <form action="{{ route('ho.transport.destroy', $data->id) }}" method="POST"
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
                {{ $transports->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ho.transport.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Transport</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_transport">Nama Transport:</label>
                            <input type="text" class="form-control" name="nama_transport" required>
                        </div>
                        <div class="form-group">
                            <label for="kode_transport">Kode Transport:</label>
                            <input type="text" class="form-control" name="kode_transport">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea class="form-control" name="keterangan" rows="3"></textarea>
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

    {{-- Modal Edit --}}
    @foreach ($transports as $data)
        <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1"
            aria-labelledby="editModalLabel-{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('ho.transport.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $data->id }}">Edit Transport</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_transport">Nama Transport:</label>
                                <input type="text" class="form-control" name="nama_transport"
                                    value="{{ $data->nama_transport }}" required>
                            </div>
                            <div class="form-group">
                                <label for="kode_transport">Kode Transport:</label>
                                <input type="text" class="form-control" name="kode_transport"
                                    value="{{ $data->kode_transport }}">
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan:</label>
                                <textarea class="form-control" name="keterangan" rows="3">{{ $data->keterangan }}</textarea>
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
