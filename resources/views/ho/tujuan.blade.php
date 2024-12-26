@extends('layouts.main')

@section('content_header')
{{ Breadcrumbs::render('tujuan') }}
    <h1 class="card-title">List Tujuan Penugasan</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">List Tujuan Penugasan</h2>
        </div>
        <!-- Search Bar -->
        <div class="card-body">
            <form method="GET" action="{{ route('ho.tujuan') }}" class="form-inline mb-3">
                <div class="input-group w-50">
                    <input type="text" name="search" class="form-control" placeholder="Cari tujuan penugasan..."
                        value="{{ request()->get('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary ml-auto" data-toggle="modal"
                    data-target="#tambahPenugasanModal">
                    <i class="fas fa-plus"></i> Tambah Penugasan Baru
                </button>
            </form>
            <!-- Tabel Penugasan -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID Penugasan</th>
                        <th style="width: 50%;">Tujuan Penugasan</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tujuans as $key => $item)
                        <tr id="penugasan-{{ $item->id }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->tujuan_penugasan }}</td>
                            <td>
                                <div class="d-flex" style="gap: 8px;">
                                    <!-- Button Edit -->
                                    <button type="button" class="btn btn-sm btn-warning me-3" data-toggle="modal"
                                        data-target="#editModal-{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Form Hapus -->
                                    <form action="{{ route('ho.tujuan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus penugasan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Penugasan -->
                        <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="editModalLabel-{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel-{{ $item->id }}">Edit Penugasan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('ho.tujuan.update', $item->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="tujuan_penugasan">Tujuan Penugasan</label>
                                                <input type="text" class="form-control" id="tujuan_penugasan"
                                                    name="tujuan_penugasan" value="{{ $item->tujuan_penugasan }}" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data penugasan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modal Tambah Penugasan Baru -->
            <div class="modal fade" id="tambahPenugasanModal" tabindex="-1" role="dialog"
                aria-labelledby="tambahPenugasanModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPenugasanModalLabel">Tambah Penugasan Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('ho.tujuan.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="tujuan_penugasan">Tujuan Penugasan</label>
                                    <input type="text" class="form-control" id="tujuan_penugasan" name="tujuan_penugasan"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $tujuans->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

