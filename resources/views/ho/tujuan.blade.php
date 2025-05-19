@extends('layouts.main')

@section('content')
    <div class="card mb-4 rounded-3 shadow">
        <div class="card-header bg-light py-3">
            <h4 class="Judul mb-0 fw-bold text-dark">Data Tujuan</h4>
        </div>
        

        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahPenugasanModal">
                <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                    style="width: 20px; height: 20px; margin-right: 4px">Tambah Data
            </button>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                    <thead class="table-primary text-white">
                        <tr>
                            <th scope="col" class="text-center" style="width: 100px;">No</th>
                            <th scope="col">Daftar Penugasan</th>
                            <th scope="col" class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tujuans as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $item->tujuan_penugasan }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 10px;">
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal-{{ $item->id }}" title="Edit">
                                            <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                                style="width: 20px; height: 20px;">
                                        </button>

                                        <form action="{{ route('ho.tujuan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus penugasan ini?')">
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
        </div>
    </div>


    <div class="modal fade" id="tambahPenugasanModal" tabindex="-1" aria-labelledby="tambahPenugasanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('ho.tujuan.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPenugasanModalLabel">Tambah Daftar Penugasan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tujuan_penugasan">Daftar Penugasan</label>
                            <input type="text" class="form-control" id="tujuan_penugasan" name="tujuan_penugasan"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($tujuans as $item)
        <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('ho.tujuan.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $item->id }}">Edit Penugasan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tujuan_penugasan">Tujuan Penugasan</label>
                                <input type="text" class="form-control" id="tujuan_penugasan" name="tujuan_penugasan"
                                    value="{{ $item->tujuan_penugasan }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
