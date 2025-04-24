@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="card my-4"
            style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover; border-radius: 10px;">
            <div class="card-body bg-info text-white text-center py-3">
                <h5 class="card-title m-0">DETAIL TIKET</h5>
            </div>
            <div class="card-body" style="position: relative;">
                <form>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tanggal_keberangkatan_detail">Tanggal Keberangkatan</label>
                            <input type="date" class="form-control" id="tanggal_keberangkatan_detail">
                        </div>
                        <div class="col-md-4 mb-3">
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
