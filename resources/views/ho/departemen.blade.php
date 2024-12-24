@extends('layouts.main')

@section('content_header')
{{ Breadcrumbs::render('departemen') }}
    <h1 class="card-title">Master Data Departemen</h1>
@endsection

@section('content')
    <div class="alert alert-info" role="alert">
        <strong>Info:</strong> Pastikan semua data departemen terisi dengan lengkap dan benar.
    </div>

    <div class="card-header">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahDepartemenModal">
            <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                style="width: 20px; height: 20px; margin-right: 4px">Tambah Departemen Baru
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped" style="border-spacing: 0; width: 100%;">
                <thead style="background-color: #b3e0ff;">
                    <tr>
                        <th style="padding: 8px;">No</th>
                        <th style="padding: 8px;">Nama Departemen</th>
                        <th style="padding: 8px;">Kode Departemen</th>
                        <th style="padding: 8px;">Keterangan</th>
                        <th style="padding: 8px; width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departemens as $key => $item)
                        <tr style="background-color: {{ $key % 2 == 0 ? '#ffffff' : '#e6f7ff' }};">
                            <td style="padding: 8px;">{{ $key + 1 }}</td>
                            <td style="padding: 8px;">{{ $item->nama_departemen }}</td>
                            <td style="padding: 8px;">{{ $item->kode_departemen }}</td>
                            <td style="padding: 8px;">{{ $item->keterangan }}</td>
                            <td style="padding: 8px;">
                                <div class="d-flex gap-2" style="gap: 10px;">
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editModal-{{ $item->id }}">
                                        <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                            style="width: 20px; height: 20px; margin-right: 4px">
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
                                                        <h5 class="modal-title" id="editModalLabel-{{ $item->id }}">
                                                            Edit Departemen</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="nama_departemen">Nama Departemen:</label>
                                                            <input type="text" class="form-control" id="nama_departemen"
                                                                name="nama_departemen"
                                                                value="{{ $item->nama_departemen }} " required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kode_departemen">Kode Departemen:</label>
                                                            <input type="text" class="form-control" id="kode_departemen"
                                                                name="kode_departemen"
                                                                value="{{ $item->kode_departemen }} " required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan:</label>
                                                            <input type="text" class="form-control" id="keterangan"
                                                                name="keterangan" value="{{ $item->keterangan }} "
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <img src="{{ asset('icons/save-outline.svg') }}" alt="Save"
                                                                style="width: 20px; height: 20px; margin-right: 4px"> Simpan
                                                            Perubahan
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
                                            <img src="{{ asset('icons/trash-outline.svg') }}" alt="Delete"
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

    <!-- Modal Tambah Departemen -->
    <div class="modal fade" id="tambahDepartemenModal" tabindex="-1" role="dialog"
        aria-labelledby="tambahDepartemenModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('ho.departemen.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDepartemenModalLabel">Tambah Departemen Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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

@section('style')
    <style>
        .table th,
        .table td {
            padding: 10px 12px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #ffffff;
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: #e6f7ff;
        }

        .table-hover tbody tr:hover {
            background-color: #b3e0ff !important;
        }
    </style>
@endsection
