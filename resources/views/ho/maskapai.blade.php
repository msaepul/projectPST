@extends('layouts.main')

@section('content_header')
    {{ Breadcrumbs::render('departemen') }}
    <h1 class="card-title">Master Data Maskapai</h1>
@endsection

@section('content')
    <div class="alert alert-info" role="alert">
        <strong>Info:</strong> Pastikan semua data Maskapai terisi dengan lengkap dan benar.
    </div>

    <div class="card mb-4 rounded-3 shadow">
        <div class="card-header bg-light text-white py-3">
            <h4 class="mb-0 fw-bold">Data Maskapai</h4>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahMaskapaiModal">
                <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                    style="width: 20px; height: 20px; margin-right: 4px">Tambah Maskapai Baru
            </button>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover" style="width: 100%;">
                    <thead class="table-primary text-white">
                        <tr>
                            <th scope="col" style="text-align: center;">No</th>
                            <th scope="col">Nama Maskapai</th>
                            <th scope="col">Kode Maskapai</th>
                            <th scope="col">Jenis kendaraan</th>
                            <th scope="col" style="text-align: center; width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maskapais as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $item->kode_maskapai }}</td>
                                <td>{{ $item->nama_maskapai }}</td>
                                <td>{{ $item->jenis_kendaraan }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: 10px;">
                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal-{{ $item->id }}" title="Edit">
                                            <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                                style="width: 20px; height: 20px;">
                                        </button>

                                        <form action="{{ route('ho.departemen.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus departemen ini?')">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahMaskapaiModal" tabindex="-1" role="dialog"
        aria-labelledby="tambahMaskapaiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('ho.maskapai.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahMaskapaiModalLabel">Tambah Maskapai Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_maskapai">Kode Maskapai</label>
                            <input type="text" class="form-control" id="kode_maskapai" name="kode_maskapai" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_maskapai">Nama Maskapai</label>
                            <input type="text" class="form-control" id="nama_maskapai" name="nama_maskapai" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
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
</div>

@endsection
