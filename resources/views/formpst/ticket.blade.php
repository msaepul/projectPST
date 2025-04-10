@extends('layouts.main')

@section('content')
    <div class="container">
        {{-- Form Pengajuan Tiket --}}
        <div class="card shadow-lg my-4">
            <div class="card-header bg-info text-white text-center" style="border-radius: 0;">
                <h4>FORM PENGAJUAN TIKET</h4>
            </div>
            <div class="card-body"
                style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover; border-radius: 0;">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="no_surat">No. Surat</label>
                            <select class="form-control select2" name="no_surat" id="no_surat" required>
                                <option value="" disabled selected>-- Pilih No. Surat --</option>
                                @foreach ($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->no_surat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama_pemohon">Nama Pemohon</label>
                            <input type="text" id="nama_pemohon" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="ditugaskan_oleh">Ditugaskan Oleh</label>
                            <input type="text" id="ditugaskan_oleh" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_hp">No. HP</label>
                            <input type="text" id="no_hp" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pegawai_berangkat">Pegawai yang Berangkat</label>
                        <textarea id="pegawai_berangkat" class="form-control"></textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success me-2">Submit</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>

                    <div class="p-3 mt-4" style="border-top: 2px solid rgb(0, 0, 0)">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tanggal_issued">Issued Tiket</label>
                                <input type="date" id="tanggal_issued" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_invoice">No. Invoice</label>
                                <input type="text" id="no_invoice" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="maskapai">Maskapai</label>
                                <select id="maskapai" class="form-control">
                                    <option value="">-- Pilih Maskapai --</option>
                                    <option value="001">001</option>
                                    <option value="002">002</option>
                                    <option value="003">003</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="transport">Transportasi</label>
                                <select id="transport" class="form-control">
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
                                <textarea id="lampiran" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="beban_biaya">Beban Biaya</label>
                                <select id="beban_biaya" class="form-control">
                                    <option value="">-- Beban Biaya --</option>
                                    <option value="001">Cabang 001</option>
                                    <option value="002">Cabang 002</option>
                                    <option value="003">Cabang 003</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success me-2">Submit</button>
                            <button type="button" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Card Tiket --}}
        <div class="card my-4"
            style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover; border-radius: 0;">
            <div class="card-body bg-info text-white" style="border-radius: 0;">
                <h5 class="card-title">TIKET</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tanggal_keberangkatan">Tanggal Keberangkatan</label>
                            <input type="date" id="tanggal_keberangkatan" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nominal_tiket">Nominal Tiket</label>
                            <input type="text" id="nominal_tiket" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="waktu_keberangkatan">Waktu Keberangkatan</label>
                            <input type="time" id="waktu_keberangkatan" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rute">Rute</label>
                            <div class="d-flex align-items-center">
                                <input type="text" id="rute1" class="form-control me-2">
                                <span>Ke</span>
                                <input type="text" id="rute2" class="form-control ms-2">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="upload_tiket">Upload Tiket</label>
                            <input type="file" id="upload_tiket" class="form-control-file">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Tiket</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection