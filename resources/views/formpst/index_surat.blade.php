@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}
    <div class="container pt-4">
        <form id="searchForm" action="{{ route('formpst.index_masuk') }}" method="GET" class="d-flex">
            @csrf
            <input type="text" id="namaPemohon" name="namaPemohon" class="form-control me-2"
                value="{{ request('namaPemohon') }}" placeholder="Cari nama pemohon">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <div class="card mt-4 rounded-3 shadow custom-card">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold">Hasil Pencarian</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover custom-table">
                    <thead>
                        <tr class="table-primary text-white">
                            <th scope="col">No Surat</th>
                            <th scope="col">Nama Pemohon</th>
                            <th scope="col">Cabang Asal</th>
                            <th scope="col">Cabang Tujuan</th>
                            <th scope="col">Tujuan Pelatihan</th>
                            <th scope="col">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            @if (auth()->user()->cabang_asal === $item->cabang_tujuan ||
                                    auth()->user()->cabang_asal === $item->cabang_asal ||
                                    auth()->user()->role === 'admin')
                                <tr>
                                    <td>{{ $item->no_surat }}</td>
                                    <td>{{ $item->nama_pemohon }}</td>
                                    <td>{{ $item->cabang_asal }}</td>
                                    <td>{{ $item->cabang_tujuan }}</td>
                                    <td>{{ $item->tujuan }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('formpst.show', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                        <a href="{{ route('formpst.surat_tugas', ['id' => $item->id]) }}"
                                            class="btn btn-sm btn-outline-primary">Lihat Surat tugas</a>
                                    </td>
                                </tr>
                            @endif
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
