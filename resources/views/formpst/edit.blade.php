@extends('layouts.main')

@section('content')
    {{-- {{ Breadcrumbs::render('Form') }} --}}

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Data Pegawai
        </div>
        <div class="card-body">
            <form action="{{ route('formpst.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- <div class="form-group row">
                    <!-- Input Cabang -->
                    <div class="col-md-6">
                        <label for="cabang">Cabang:</label>
                        <select class="form-control searchable-dropdown" name="cabang" id="cabang" required>
                            <option value="" disabled>Pilih Cabang</option>
                            @foreach ($cabangs as $cabang)
                                <option value="{{ $cabang->id }}" {{ old('cabang', $data->cabang) == $cabang->id ? 'selected' : '' }}>
                                    {{ $cabang->nama_cabang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Tujuan -->
                    <div class="col-md-6">
                        <label for="tujuan">Tujuan:</label>
                        <select class="form-control searchable-dropdown" name="tujuan" id="tujuan" required>
                            <option value="" disabled>Pilih Tujuan</option>
                            @foreach ($tujuans as $tujuan)
                                <option value="{{ $tujuan->id }}" {{ old('tujuan', $data->tujuan) == $tujuan->id ? 'selected' : '' }}>
                                    {{ $tujuan->tujuan_penugasan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                <div style="border: 2px solid #ccc; padding: 20px; margin-top: 20px; border-radius: 5px;">
                    <div class="form-group row">
                        
                        <!-- Input Nama -->
                        <div class="col-md-3">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $data->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input NIK -->
                        <div class="col-md-3">
                            <label for="nik">NIK:</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $data->nik) }}" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Departemen -->
                        <div class="col-md-3">
                            <label for="departemen">Departemen:</label>
                            <select class="form-control searchable-dropdown @error('departemen') is-invalid @enderror" id="departemen" name="departemen" required>
                                <option value="" disabled>Pilih Departemen</option>
                                @foreach ($departemens as $departemen)
                                    <option value="{{ $departemen->nama_departemen }}" {{ old('departemen', $data->departemen) == $departemen->nama_departemen ? 'selected' : '' }}>
                                        {{ $departemen->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departemen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Lama -->
                        <div class="col-md-3">
                            <label for="lama">Lama:</label>
                            <input type="date" class="form-control @error('lama') is-invalid @enderror" id="lama" name="lama" value="{{ old('lama', $data->lama) }}" required>
                            @error('lama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Update</button>
            </form>
        </div>
    </div>
@endsection
