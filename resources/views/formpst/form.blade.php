@extends('layouts.main')
@section('content')

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-copy me-1"></i>
                    FORM PENGAJUAN
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_surat">Nama Surat:</label>
                            <select class="form-control @error('nama_surat') is-invalid @enderror" id="nama_surat" name="nama_surat">
                                <option value="" disabled selected>Pilih Nama Surat</option>
                                <option value="surat1">Surat 1</option>
                                <option value="surat2">Surat 2</option>
                                <option value="surat3">Surat 3</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Submit</button>
                    </form>
                </div>
            </div>
        </div>

@endsection
