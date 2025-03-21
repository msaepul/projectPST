@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="card p-4 shadow-lg" style="border: 2px solid rgb(0, 155, 182);">
            <div class="card-header text-white bg-info">
                <h4 class="text-center">FORM PENGAJUAN TIKET</h4>
            </div>

            {{-- Section 1: Form Pengajuan --}}
            <div class="p-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="no_surat" class="col-sm-4 col-form-label">No. Surat:</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_surat" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_pemohon" class="col-sm-4 col-form-label">Nama Pemohon:</label>
                            <div class="col-sm-8">
                                <input type="text" id="nama_pemohon" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ditugaskan_oleh" class="col-sm-4 col-form-label">Ditugaskan Oleh:</label>
                            <div class="col-sm-8">
                                <textarea id="ditugaskan_oleh" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="no_hp" class="col-sm-4 col-form-label">No. HP:</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_hp" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pegawai_berangkat" class="col-sm-4 col-form-label">Pegawai yang Berangkat:</label>
                            <div class="col-sm-8">
                                <textarea id="pegawai_berangkat" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Submit</button>
                    <button type="button" class="btn btn-danger">Cancel</button>
                </div>
            </div>

            {{-- Section 2: Detail Tiket --}}
            <div class="p-3 mt-4" style="border-top: 2px solid rgb(0, 155, 182)">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="tanggal_issued" class="col-sm-4 col-form-label">Tanggal Issued Tiket:</label>
                            <div class="col-sm-8">
                                <input type="date" id="tanggal_issued" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="maskapai" class="col-sm-4 col-form-label">Maskapai:</label>
                            <div class="col-sm-8">
                                <input type="text" id="maskapai" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lampiran" class="col-sm-4 col-form-label">Lampiran:</label>
                            <div class="col-sm-8">
                                <textarea id="lampiran" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="no_invoice" class="col-sm-4 col-form-label">No. Invoice:</label>
                            <div class="col-sm-8">
                                <input type="text" id="no_invoice" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kendaraan_dipilih" class="col-sm-4 col-form-label">Kendaraan yang Dipilih:</label>
                            <div class="col-sm-8">
                                <input type="text" id="kendaraan_dipilih" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="beban_biaya" class="col-sm-4 col-form-label">Beban Biaya:</label>
                            <div class="col-sm-8">
                                <input type="text" id="beban_biaya" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Submit</button>
                    <button type="button" class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>

        {{-- Card Ticket --}}
        <div class="card my-4">
            <div class="card-body bg-info text-white">
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
                            <input type="text" id="rute" class="form-control">
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
@endsection
