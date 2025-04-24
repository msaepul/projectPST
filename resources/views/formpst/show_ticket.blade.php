@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="card my-4"
            style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover; border-radius: 10px;">
            <div class="card-body bg-info text-white text-center py-3">
                <h5 class="card-title m-0">DETAIL TIKET</h5>
            </div>
            <div class="card-body"
                style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover;">

                <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ROW 1 --}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="no_surat">No. Surat</label>
                            {{-- <select class="form-control select2" name="no_surat" id="no_surat" required>
                                <option value="" disabled selected>-- Pilih No. Surat --</option>
                                @foreach ($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->no_surat }}</option>
                                @endforeach
                            </select> --}}
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
                            <label for="hp">No. HP</label>
                            <input type="text" id="hp" name="hp" class="form-control">
                        </div>
                    </div>

                    {{-- ROW 3
                    <div class="form-group">
                        <label for="pegawai_berangkat">Pegawai yang Berangkat</label>
                        <textarea id="pegawai_berangkat" name="pegawai_berangkat" class="form-control"></textarea>
                    </div> --}}

                    {{-- SECTION: ISSUED TIKET --}}
                    <hr>
                    <h5 class="mt-4">Issued Tiket</h5>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tanggal_issued">Tanggal Issued</label>
                            <input type="date" id="issued" name="issued" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="invoice">No. Invoice</label>
                            <input type="text" id="invoice" name="invoice" class="form-control">
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
                        <div class="col-md-4 mb-3">
                            <label for="tujuan">Tujuan</label>
                            <input type="text" class="form-control" id="tujuan">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="waktu_keberangkatan">Waktu Keberangkatan</label>
                            <div class="d-flex align-items-center">
                                <input type="time" id="waktu_keberangkatan_dari" class="form-control me-2"
                                    style="width: 150px;">
                                <span class="mx-2">s/d</span>
                                <input type="time" id="waktu_keberangkatan_sampai" class="form-control ms-2"
                                    style="width: 150px;">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="lihat_tiket">Lihat Tiket</label>
                            <input type="text" class="form-control" id="lihat_tiket">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
