@extends('layouts.main')
@section('content')
    <!-- Header Form Permintaan -->
    <div class="card mb-6 shadow-sm border-0">
        <div class="card-header bg-purple text-black">
            <h4 class="mb-0">Form Persetujuan BM</h4>
        </div>

        <div class="card-body">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Nomor Surat -->
                        <div class="d-flex align-items-center mb-3">
                            <label for="nomor_surat" class="form-label me-2 text-muted" style="width: 150px;">Nomor
                                Surat</label>
                            <span class="form-control-plaintext border-bottom">123/XYZ/2025</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Cabang Asal -->
                        <div class="d-flex align-items-center mb-3">
                            <label for="cabang_asal" class="form-label me-2 text-muted" style="width: 150px;">Cabang
                                Asal</label>
                            <span class="form-control-plaintext border-bottom">Cabang A</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Nama Pemohon -->
                        <div class="d-flex align-items-center">
                            <label for="nama_pemohon" class="form-label me-2 text-muted" style="width: 150px;">Nama
                                Pemohon</label>
                            <span class="form-control-plaintext border-bottom">John Doe</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Cabang Tujuan -->
                        <div class="d-flex align-items-center mb-3">
                            <label for="cabang" class="form-label me-2 text-muted" style="width: 150px;">Cabang
                                Tujuan</label>
                            <span class="form-control-plaintext border-bottom">Cabang A</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Tujuan Penugasan -->
                        <div class="d-flex align-items-center mb-3">
                            <label for="tujuan" class="form-label me-2 text-muted" style="width: 150px;">Tujuan
                                Penugasan</label>
                            <span class="form-control-plaintext border-bottom">Tujuan A</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Tanggal Keberangkatan -->
                        <div class="d-flex align-items-center">
                            <label for="tanggal" class="form-label me-2 text-muted" style="width: 150px;">Tanggal
                                Keberangkatan</label>
                            <span class="form-control-plaintext border-bottom">2025-01-10</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Dynamic Fields -->
            <div class="p-4 border rounded bg-light">
                <div id="dynamic-fields">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="nama" class="form-label text-muted">Nama:</label>
                            <span class="form-control-plaintext border-bottom">Nama A</span>
                        </div>

                        <div class="col-md-3">
                            <label for="nik" class="form-label text-muted">NIK:</label>
                            <span class="form-control-plaintext border-bottom">123456789</span>
                        </div>

                        <div class="col-md-3">
                            <label for="departemen" class="form-label text-muted">Departemen:</label>
                            <span class="form-control-plaintext border-bottom">Departemen A</span>
                        </div>

                        <div class="col-md-3">
                            <label for="lama" class="form-label text-muted">Lama keberangkatan:</label>
                            <span class="form-control-plaintext border-bottom">2025-01-15</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="nama" class="form-label text-muted">Nama:</label>
                            <span class="form-control-plaintext border-bottom">Nama B</span>
                        </div>

                        <div class="col-md-3">
                            <label for="nik" class="form-label text-muted">NIK:</label>
                            <span class="form-control-plaintext border-bottom">987654321</span>
                        </div>

                        <div class="col-md-3">
                            <label for="departemen" class="form-label text-muted">Departemen:</label>
                            <span class="form-control-plaintext border-bottom">Departemen B</span>
                        </div>

                        <div class="col-md-3">
                            <label for="lama" class="form-label text-muted">Lama keberangkatan:</label>
                            <span class="form-control-plaintext border-bottom">2025-01-16</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('hrd.list_hrd') }}" class="btn btn-primary">
                    Submit
                </a>
            </div>
            </form>
        </div>
    </div>
@endsection
