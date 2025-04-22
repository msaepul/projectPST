@extends('layouts.main')

@section('content')
    <div class="container">
        {{-- ========== FORM PENGAJUAN TIKET ========== --}}
        <div class="card shadow-lg my-4">
            <div class="card-header bg-info text-white text-center">
                <h4>FORM PENGAJUAN TIKET</h4>
            </div>
            <div class="card-body"
                 style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover;">

                <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ROW 1 --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="no_surat">No. Surat</label>
                            <select class="form-control select2" name="no_surat" id="no_surat" required>
                                <option value="" disabled selected>-- Pilih No. Surat --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama_pemohon">Nama Pemohon</label>
                            <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control">
                        </div>
                    </div>

                    {{-- ROW 2 --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="ditugaskan_oleh">Ditugaskan Oleh</label>
                            <input type="text" id="ditugaskan_oleh" name="assigned_by" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_hp">No. HP</label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control">
                        </div>
                    </div>

                    {{-- ROW 3 --}}
                    <div class="form-group">
                        <label for="pegawai_berangkat">Pegawai yang Berangkat</label>
                        <textarea id="pegawai_berangkat" name="pegawai_berangkat" class="form-control"></textarea>
                    </div>

                    {{-- SECTION: ISSUED TIKET --}}
                    <hr>
                    <h5 class="mt-4">Issued Tiket</h5>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tanggal_issued">Tanggal Issued</label>
                            <input type="date" id="tanggal_issued" name="tanggal_issued" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_invoice">No. Invoice</label>
                            <input type="text" id="no_invoice" name="no_invoice" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="maskapai">Maskapai</label>
                            <select id="maskapai" name="maskapai" class="form-control">
                                <option value="">-- Pilih Maskapai --</option>
                                <option value="001">001</option>
                                <option value="002">002</option>
                                <option value="003">003</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="transport">Transportasi</label>
                            <select id="transport" name="transport" class="form-control">
                                <option value="">-- Pilih Transportasi --</option>
                                <option value="001">001</option>
                                <option value="002">002</option>
                                <option value="003">003</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="lampiran">Lampiran</label>
                            <textarea id="lampiran" name="lampiran" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="beban_biaya">Beban Biaya</label>
                            <select id="beban_biaya" name="beban_biaya" class="form-control">
                                <option value="">-- Beban Biaya --</option>
                                <option value="001">Cabang 001</option>
                                <option value="002">Cabang 002</option>
                                <option value="003">Cabang 003</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tanggal_keberangkatan">Tanggal Keberangkatan</label>
                            <input type="date" id="tanggal_keberangkatan" name="tanggal_keberangkatan" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nominal_tiket">Nominal Tiket</label>
                            <input type="text" id="nominal_tiket" name="nominal_tiket" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="waktu_keberangkatan">Waktu Keberangkatan</label>
                            <input type="time" id="waktu_keberangkatan" name="waktu_keberangkatan" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rute">Rute</label>
                            <div class="d-flex align-items-center">
                                <input type="text" id="rute1" name="rute1" class="form-control me-2">
                                <span class="mx-2">Ke</span>
                                <input type="text" id="rute2" name="rute2" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="upload_tiket">Upload Tiket</label>
                            <input type="file" id="upload_tiket" name="upload_tiket" class="form-control-file">
                        </div>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success me-2">Submit</button>
                        <button type="reset" class="btn btn-danger">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <style>

        .card-body{
            height: 1000px;
        }
    </style>
@endsection
