@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="card p-4 shadow-lg" style="border: 2px solid rgb(0, 155, 182);">
            <div class="card-header text-white bg-info">
                <h4 class="text-center">FORM PENGAJUAN TIKET</h4>
            </div>

            <div class="p-3"
                style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover; border-radius: 10px; padding: 20px;">
                {{-- Section 1: Form Pengajuan --}}
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="no_surat" class="col-sm-4 col-form-label">No. Surat:</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="no_surat" id="no_surat" required>
                                        <option value="" disabled selected>-- Pilih No. Surat --</option>
                                        @foreach ($forms as $form)
                                            <option value="{{ $form->id }}">{{ $form->no_surat }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                    <input type="text" id="ditugaskan_oleh" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="no_hp" class="col-sm-4 col-form-label">No. HP:</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="no_hp" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pegawai_berangkat" class="col-sm-4 col-form-label">Pegawai yang
                                    Berangkat:</label>
                                <div class="col-sm-8">
                                    <textarea id="pegawai_berangkat" class="form-control"></textarea>
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
                                    <label for="tanggal_issued" class="col-sm-4 col-form-label">Tanggal Issued
                                        Tiket:</label>
                                    <div class="col-sm-8">
                                        <input type="date" id="tanggal_issued" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="maskapai" class="col-sm-4 col-form-label">Maskapai:</label>
                                    <div class="col-sm-8">
                                        <select id="maskapai" class="form-control">
                                            <option value="">-- Pilih Maskapai --</option>
                                            <option value="001">001</option>
                                            <option value="002">002</option>
                                            <option value="003">003</option>
                                        </select>
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
                                    <label for="transport" class="col-sm-4 col-form-label">Transportasi:</label>
                                    <div class="col-sm-8">
                                        <select id="transport" class="form-control">
                                            <option value="">-- Pilih Transportasi --</option>
                                            <option value="001">001</option>
                                            <option value="002">002</option>
                                            <option value="003">003</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="beban_biaya" class="col-sm-4 col-form-label">Beban Biaya:</label>
                                    <div class="col-sm-8">
                                        <select id="beban_biaya" class="form-control">
                                            <option value="">-- Beban Biaya --</option>
                                            <option value="001">Cabang 001</option>
                                            <option value="002">Cabang 002</option>
                                            <option value="003">Cabang 003</option>
                                        </select>
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
            </div>

            {{-- Card Ticket --}}
            <div class="card my-4"
                style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover;">
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
                                <div class="d-flex align-items-center">
                                    <input type="time" id="waktu_keberangkatan_dari" class="form-control me-2"
                                        style="width: 150px;">
                                    <span>sd</span>
                                    <input type="time" id="waktu_keberangkatan_sampai" class="form-control ms-2"
                                        style="width: 150px;">
                                </div>
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
                                <label for="upload_tiket">Upload</label>
                                <input type="file" id="upload_tiket" class="form-control-file">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Submit Tiket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endsection
