@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4 mt-3">
                    <div class="card-header bg-primary text-white py-2" style="position: sticky; top: 0; z-index: 100;">
                        <h5 class="mb-0 text-center">Form Persetujuan Surat Tugas</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <form action="{{ route('form.submit', $form->id) }}" method="POST">
                                @csrf
                                @if ($form->acc_hrd == 'oke' || $form->acc_hrd == 'reject' || $form->acc_bm == 'reject')
                                    <a href="{{ route('formpst.index') }}" class="btn btn-success">Selesai</a>
                                @else
                                    <button type="submit" name="action" value="submit"
                                        class="btn btn-primary mr-2">Submit</button>
                                    <button type="submit" name="action" value="reject"
                                        class="btn btn-danger">Tolak</button>
                                @endif
                            </form>
                        </div>

                        <div class="form-details mb-4">
                            <div class="detail-group">
                                <label class="detail-label">No Surat:</label>
                                <div class="detail-value">{{ $form->no_surat }}</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Cabang Asal:</label>
                                <div class="detail-value">{{ $form->cabang_asal }}</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Cabang Tujuan:</label>
                                <div class="detail-value">{{ $form->cabang_tujuan }}</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Tujuan Penugasan:</label>
                                <div class="detail-value">{{ $form->tujuan }}</div>
                            </div>
                            <div class="detail-group">
                                <label class="detail-label">Tanggal Keberangkatan:</label>
                                <div class="detail-value">{{ $form->tanggal_keberangkatan }}</div>
                            </div>
                        </div>

                        @foreach ($data as $departemen => $staff)
                            <h5 class="mb-3">Departemen: {{ $departemen }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped"> {{-- Tambah class table-striped --}}
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Lama Keberangkatan</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($staff as $item)
                                            <tr>
                                                <td>{{ $item->nama_pegawai }}</td>
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->lama_keberangkatan }}</td>
                                                <td>
                                                    @if ($item->upload_file)
                                                        <a href="{{ asset('storage/' . $item->upload_file) }}"
                                                            target="_blank">Lihat File</a>
                                                    @else
                                                        Tidak ada file
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($form->acc_bm == 'oke' && $form->acc_hrd != 'oke' && $form->acc_bm != 'reject' && $form->acc_hrd != 'reject')
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-success btn-sm"
                                                                onclick="showConfirmationModal({{ $item->id }}, 'oke')">Setuju</button>
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="openRejectModal({{ $item->id }})">Tolak</button>
                                                        </div>
                                                    @endif
                                                    @include('partials.status-badge', ['item' => $item])
                                                </td>
                                                <td>
                                                    @include('partials.keterangan-badge', [
                                                        'item' => $item,
                                                    ])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                        <div class="status-bar mt-4">
                            @include('partials.status-bar', ['form' => $form])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.reject-modal')
    @include('partials.confirmation-modal')

    <script>
        // ... (Script dari jawaban sebelumnya)
    </script>

    <style>
        /* ... (Style dari jawaban sebelumnya dengan beberapa penyesuaian) */
        .table-responsive {
            margin-bottom: 20px;
            /* Spasi bawah untuk setiap tabel */
        }

        .status-bar {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            flex-wrap: wrap;
            /* Menangani tampilan di layar kecil */
        }

        .status-step {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
@endsection
