@extends('layouts.main')

@section('content')
    {{-- {{ Breadcrumbs::render('Edit Form') }} --}}
    <head>
        <link rel="stylesheet" href={{ asset('css/edit.css') }}>
    </head>

    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo">
                <h4 class="mb-0 ms-2">Edit Permintaan</h4>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('formpst.update', $form->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="noSurat">No. Surat</label>
                            <input type="text" class="form-control form-control-sm" id="noSurat" value="{{ $form->no_surat }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="namaPemohon">Nama Pemohon</label>
                            <input type="text" id="namaPemohon" class="form-control" value="{{ $form->nama_pemohon }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="yangMenugaskan">Ditugaskan oleh</label>
                            <input type="text" id="yangMenugaskan" name="yangMenugaskan" class="form-control" value="{{ $form->yang_menugaskan }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="cabangAsal">Cabang Asal</label>
                            <input type="text" id="cabangAsal" class="form-control" value="{{ $form->cabang_asal }}" readonly required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cabangTujuan">Cabang Tujuan</label>
                            <select class="form-control select2" name="cabang_tujuan" id="cabangTujuan" required>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}" {{ $cabang->id == $form->cabang_tujuan ? 'selected' : '' }}>
                                        {{ $cabang->nama_cabang }} / {{ $cabang->kode_cabang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tujuan">Tujuan Penugasan</label>
                            <select class="form-control select2" name="tujuan" id="tujuan" required>
                                @foreach ($tujuans as $tujuan)
                                    <option value="{{ $tujuan->id }}" {{ $tujuan->id == $form->tujuan ? 'selected' : '' }}>
                                        {{ $tujuan->tujuan_penugasan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggalKeberangkatan">Tanggal Keberangkatan</label>
                            <input type="date" id="tanggalKeberangkatan" name="tanggal_keberangkatan" class="form-control" value="{{ $form->tanggal_keberangkatan }}" required>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo">
                            <h4 class="mb-0 ms-2">Pegawai yang berangkat</h4>
                        </div>
                    </div>

                    <div class="card-body mt-4 transparent-card p-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle table-sm" id="pegawaiTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Departemen</th>
                                        <th>Lama Keberangkatan</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nama_pegawais as $item)
                                        <tr>
                                            <td>
                                                <input type="text" name="nama[{{ $item->id }}]" value="{{ old('nama.' . $item->id, $item->nama_pegawai) }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="nik[{{ $item->id }}]" value="{{ old('nik.' . $item->id, $item->nik) }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="departemen[{{ $item->id }}]" value="{{ old('departemen.' . $item->id, $item->departemen) }}" class="form-control">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="date" name="lama_keberangkatan[{{ $item->id }}][tanggal_berangkat]" value="{{ old('lama_keberangkatan.' . $item->id . '.tanggal_berangkat', $item->tanggal_berangkat) }}" class="form-control">
                                                    <span class="mx-2">s/d</span>
                                                    <input type="date" name="lama_keberangkatan[{{ $item->id }}][tanggal_kembali]" value="{{ old('lama_keberangkatan.' . $item->id . '.tanggal_kembali', $item->tanggal_kembali) }}" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($item->upload_file)
                                                        <a href="{{ asset('storage/' . $item->upload_file) }}"
                                                           target="_blank"
                                                           class="text-muted"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-placement="top"
                                                           title="Lihat File">
                                                            <i class="fas fa-file-pdf fs-5 text-danger"></i>
                                                        </a>
                                            
                                                        <label for="file-{{ $item->id }}"
                                                               class="text-primary m-0"
                                                               role="button"
                                                               data-bs-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="Ganti File">
                                                            <i class="fas fa-edit fs-5"></i>
                                                        </label>
                                                        <input type="file" name="file[{{ $item->id }}]" id="file-{{ $item->id }}" class="d-none">
                                                    @else
                                                        <label for="file-{{ $item->id }}"
                                                               class="text-primary m-0"
                                                               role="button"
                                                               data-bs-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="Upload File">
                                                            <i class="fas fa-upload fs-5"></i>
                                                        </label>
                                                        <input type="file" name="file[{{ $item->id }}]" id="file-{{ $item->id }}" class="d-none">
                                                    @endif
                                                </div>
                                            </td>
                                              
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="{{ route('formpst.index_keluar') }}" class="btn btn-danger">Kembali</a>
                </div>
                
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <style>
       
    </style>
@endsection