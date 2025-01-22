@extends('layouts.main')

@section('content')
    <div class="container-fluid pt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4 mt-3">
                    <div class="card-header bg-primary text-white py-2"></div>

                    <div class="card-body">
                        <div class="mb-4">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <a href="index.php" class="btn btn-danger">Kembali</a>
                                </div>

                                <h5 class="text-center mb-8">Form Surat Penugasan</h5>
                                <div class="form-details">
                                    <div class="detail-group">
                                        <label class="detail-label">No Surat:</label>
                                        <div class="detail-value">{{ $form->no_surat }}</div>
                                    </div>
                                    <div class="detail-group">
                                        <label class="detail-label">Cabang Asal:</label>
                                        <select name="cabang_asal" class="form-control">
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="detail-group">
                                        <label class="detail-label">Cabang Tujuan:</label>
                                        <select name="cabang_tujuan" class="form-control">
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="detail-group">
                                        <label class="detail-label">Tujuan Penugasan:</label>
                                        <select name="tujuan" class="form-control">
                                            @foreach ($tujuans as $tujuan)
                                                <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan_penugasan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="detail-group">
                                        <label class="detail-label">Tanggal Keberangkatan:</label>
                                        <div class="detail-value">{{ $form->tanggal_keberangkatan }}</div>
                                    </div>
                                </div>

                                <div class="package-container">
                                    <div class="item-table">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>NIK</th>
                                                    <th>Departemen</th>
                                                    <th>Lama Keberangkatan</th>
                                                    <th>File</th>
                                                    <th>Status</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($nama_pegawais as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="nama[{{ $item->id }}]"
                                                                value="{{ $item->nama_pegawai }}" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nik[{{ $item->id }}]"
                                                                value="{{ $item->nik }}" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="departemen[{{ $item->id }}]"
                                                                value="{{ $item->departemen }}" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="date"
                                                                name="lama_keberangkatan[{{ $item->id }}]"
                                                                value="{{ $item->lama_keberangkatan }}"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            @if ($item->upload_file)
                                                                <a href="{{ asset('storage/' . $item->upload_file) }}"
                                                                    target="_blank">Lihat File</a>
                                                            @else
                                                                Tidak ada file
                                                            @endif
                                                            <input type="file" name="file[{{ $item->id }}]"
                                                                class="form-control mt-2">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="status[{{ $item->id }}]"
                                                                value="{{ $item->status }}" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="keterangan[{{ $item->id }}]"
                                                                value="{{ $item->keterangan }}" class="form-control">
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .detail-value {
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            background-color: #fff;
            width: 100%;
        }

        .form-details {
            border: 1px solid #dee2e6;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
            background-color: #f8f9fa;
        }

        .detail-label {
            font-weight: bold;
            width: 200px;
            margin-right: 1rem;
        }

        .detail-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        select {
            width: 100%;
        }

        input[type="file"] {
            padding: 0.25rem;
            width: 100%;
        }

        table input {
            width: 100%;
        }
    </style>
@endsection
