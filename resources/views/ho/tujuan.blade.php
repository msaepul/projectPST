@extends('layouts.main')

@section('content_header')
{{ Breadcrumbs::render('tujuan') }}
    <h1 class="card-title">List Tujuan Penugasan</h1>
    
    <div class="card-header">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahPenugasanModal">
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
                        <th>Tujuan Penugasan</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tujuans as $key => $item)
                        <tr style="background-color: {{ $key % 2 == 0 ? '#ffffff' : '#e6f7ff' }};">
                            <td style="padding: 8px;">{{ $key + 1 }}</td>
                            <td style="padding: 8px;">{{ $item->tujuan_penugasan }}</td>
                            <td style="padding: 8px;">
                                <div class="d-flex gap-2" style="gap: 8px;">
                                    <!-- Button Edit -->
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editModal-{{ $item->id }}">
                                        <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                            style="width: 20px; height: 20px; margin-right: 4px">
                                    </button>

                                    <!-- Modal Edit Penugasan -->
                                    <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel-{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('ho.tujuan.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel-{{ $item->id }}">Edit
                                                            Penugasan</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="tujuan_penugasan">Tujuan Penugasan</label>
                                                            <input type="text" class="form-control" id="tujuan_penugasan"
                                                                name="tujuan_penugasan"
                                                                value="{{ $item->tujuan_penugasan }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button Hapus -->
                                    <form action="{{ route('ho.tujuan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus penugasan ini?')">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Penugasan Baru --}}
    <div class="modal fade" id="tambahPenugasanModal" tabindex="-1" role="dialog"
        aria-labelledby="tambahPenugasanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('ho.tujuan.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPenugasanModalLabel">Tambah Tujuan Penugasan Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tujuan_penugasan">Tujuan Penugasan</label>
                            <input type="text" class="form-control" id="tujuan_penugasan" name="tujuan_penugasan"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
