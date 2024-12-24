@extends('layouts.main')
@section('content')
    {{ Breadcrumbs::render('Form') }}


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-copy me-1"></i>
            FORM PENGAJUAN
        </div>
        <div class="card-body">
            <form action="{{ route('formpst.store') }}" method="POST">
                @csrf
                <div class="form-group row">

                    <div class="col-md-6">
                        <label for="cabang">Cabang:</label>
                        <select class="form-control searchable-dropdown" name="cabang" id="cabang" required>
                            <option value="" disabled selected>Pilih Cabang</option>
                            @foreach ($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="tujuan">Tujuan:</label>
                        <select class="form-control searchable-dropdown" name="tujuan" id="tujuan" required>
                            <option value="" disabled selected>Pilih Tujuan</option>
                            @foreach ($tujuans as $tujuan)
                                <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan_penugasan }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                {{-- didalam kotak --}}
                <div style="border: 2px solid #ccc; padding: 20px; margin-top: 20px; border-radius: 5px;">
                    <div id="dynamic-fields">
                        <div class="form-group row">

                            <div class="col-md-3">
                                <label for="nama">Nama:</label>
                                <input type="text" class="form-control" name="nama[]" required>
                            </div>

                            <div class="col-md-3">
                                <label for="nik">NIK:</label>
                                <input type="text" class="form-control" name="nik[]" required>
                            </div>

                            <div class="col-md-3">
                                <label for="departemen">Departemen:</label>
                                <select class="form-control searchable-dropdown" name="departemen[]" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach ($departemens as $departemen)
                                        <option value="{{ $departemen->nama_departemen }}">
                                            {{ $departemen->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-3">
                                <label for="lama">Lama:</label>
                                <input type="date" class="form-control" name="lama[]" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mt-3" id="add-field">Tambah Nama</button>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-field').addEventListener('click', function() {
            const newField = `
                <div class="form-group row mt-3">
                    <div class="col-md-3">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" name="nama[]" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nik">NIK:</label>
                        <input type="text" class="form-control" name="nik[]" required>
                    </div>
                    <div class="col-md-3">
                                <label for="departemen">Departemen:</label>
                                <select class="form-control searchable-dropdown" name="departemen[]" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach ($departemens as $departemen)
                                        <option value="{{ $departemen->nama_departemen }}">{{ $departemen->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                    <div class="col-md-3">
                        <label for="lama">Lama:</label>
                        <input type="date" class="form-control" name="lama[]" required>
                    </div>
                </div>
            `;
            document.getElementById('dynamic-fields').insertAdjacentHTML('beforeend', newField);
        });
    </script>
@endsection
