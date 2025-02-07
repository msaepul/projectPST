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
                            <th scope="col">No Surat</th>
                            <th scope="col">Nama Pemohon</th>
                            <th scope="col">Cabang Asal</th>
                            <th scope="col">Cabang Tujuan</th>
                            <th scope="col">Tujuan Pelatihan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Status Pegawai</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            @if (auth()->user()->cabang_asal === $item->cabang_asal ||
                                    auth()->user()->role === 'admin' ||
                                    auth()->user()->cabang_asal === 'Head Office')
                                <tr>
                                    <td>{{ $item->no_surat }}</td>
                                    <td>{{ $item->nama_pemohon }}</td>
                                    <td>{{ $item->cabang_asal }}</td>
                                    <td>{{ $item->cabang_tujuan }}</td>
                                    <td>{{ $item->tujuan }}</td>
                                    <td class="text-center">
                                        @if ($item->acc_cabang == 'oke')
                                            <span class="badge bg-success">Sudah Diverifikasi</span>
                                        @elseif ($item->acc_cabang == 'reject')
                                            <span class="badge bg-warning bg-danger">Verifikasi Di tolak Cabang</span>
                                        @elseif ($item->acc_hrd== 'oke')
                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi BM</span>
                                        @elseif ($item->acc_bm == 'oke')
                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi HO</span>
                                        @elseif ($item->acc_bm == 'reject')
                                            <span class="badge bg-warning bg-danger">Verifikasi Di tolak BM</span>
                                        @elseif ($item->acc_ho== 'oke')
                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi Cabang</span>
                                        @elseif ($item->acc_ho == 'reject')
                                            <span class="badge bg-warning bg-danger">Verifikasi Di tolak HO</span>
                                        @elseif ($item->acc_bm == 'cancel')
                                            <span class="badge bg-warning bg-danger">Cancel</span>
                                        @elseif ($item->acc_ho == 'cancel')
                                            <span class="badge bg-warning bg-danger">Cancel</span>
                                        @elseif ($item->acc_cabang == 'cancel')
                                            <span class="badge bg-warning bg-danger">Cancel</span>
                                        @else
                                            <span class="badge bg-danger">Belum Diverifikasi</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @php
                                            $anyRejected = false;
                                            $anyAccepted = false;
                                        @endphp

                                        @foreach ($item->nama_pegawais as $pegawai)
                                            @if ($pegawai->acc_nm == 'tolak')
                                                @php
                                                    $anyRejected = true;
                                                @endphp
                                                <span class="badge bg-danger">Pegawai Ditolak:
                                                    {{ $pegawai->nama_pegawai }}</span>
                                            @elseif ($pegawai->acc_nm == 'oke')
                                                @php
                                                    $anyAccepted = true;
                                                @endphp
                                            @endif
                                        @endforeach

                                        @if (!$anyRejected && !$anyAccepted && $item->acc_bm != 'cancel' && $item->acc_bm != 'reject')
                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                        @elseif (!$anyRejected && $anyAccepted)
                                            <span class="badge bg-success">Semua Pegawai Diterima</span>
                                        @endif
                                        @if ($item->acc_bm == 'cancel' || $item->acc_bm == 'reject')
                                            <span class="badge bg-danger">Cancel</span>
                                        @endif
                                    </td>


                                    <td class="text-center">
                                        <div style="display: flex; justify-content: center; gap: 10px;">
                                            <a href="{{ route('formpst.show', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                style="width: 90px; text-align: center;">Lihat Detail</a>

                                            @if ($item->acc_bm != 'cancel')
                                                <a href="{{ route('formpst.edit', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    style="width: 90px; text-align: center;">Edit</a>
                                            @endif
                                        </div>
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
