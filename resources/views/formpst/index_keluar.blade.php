@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}
    <div class="container pt-4">
        <form id="searchForm" action="{{ route('formpst.index_keluar') }}" method="GET" class="d-flex">
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
                            <th>No Surat</th>
                            <th>Nama Pemohon</th>
                            <th>Cabang Asal</th>
                            <th>Cabang Tujuan</th>
                            <th>Tujuan Pelatihan</th>
                            <th>Status</th>
                            <th>Status Pegawai</th>
                            <th>Action</th>
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
                                    @php
                                        $statusList = [
                                            'oke' => ['bg-success', 'Sudah Diverifikasi'],
                                            'reject' => ['bg-danger', 'Verifikasi Ditolak'],
                                            'cancel' => ['bg-dark', 'Cancel'],
                                        ];
                                        $statusBadge = $statusList[$item->acc_cabang] ?? ['bg-danger', 'Belum Diverifikasi'];
                                    @endphp
                                    <span class="badge {{ $statusBadge[0] }}">{{ $statusBadge[1] }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $anyRejected = $item->nama_pegawais->contains('acc_nm', 'tolak');
                                        $anyAccepted = $item->nama_pegawais->contains('acc_nm', 'oke');
                                    @endphp
                                    @if ($anyRejected)
                                        <span class="badge bg-danger">Pegawai Ditolak</span>
                                    @elseif ($anyAccepted)
                                        <span class="badge bg-success">Semua Pegawai Diterima</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('formpst.show', $item->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                        @if ($item->acc_bm !== 'cancel')
                                            <a href="{{ route('formpst.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-3">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
