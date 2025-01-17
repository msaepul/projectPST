@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow">
            <div class="card-header bg-primary text-white py-1">
                <h4 class="mb-0 text-center fw-bold">Form Data Permintaan</h4>
            </div>
            <div class="card-body p-4">
                <form id="suratTugasForm" action="{{ route('formpst.index') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="namaPemohon" class="form-label fw-bold">Nama Pemohon</label>
                        <input type="text" id="namaPemohon" name="namaPemohon" class="form-control"
                            value="{{ request('namaPemohon') }}" placeholder="Masukkan nama pemohon">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4 py-2">Cari Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4 rounded-3 shadow">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0 fw-bold">Hasil Pencarian</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-primary text-white">
                                <th scope="col">No Surat</th>
                                <th scope="col">Nama Pemohon</th>
                                <th scope="col">Cabang Asal</th>
                                <th scope="col">Cabang Tujuan</th>
                                <th scope="col">Tujuan Pelatihan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->no_surat }}</td>
                                    <td>{{ $item->nama_pemohon }}</td>
                                    <td>{{ $item->cabang_asal }}</td>
                                    <td>{{ $item->cabang_tujuan }}</td>
                                    <td>{{ $item->tujuan }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->status == 1 ? 'Sudah Diverifikasi' : 'Belum Diverifikasi' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('formpst.show', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
