@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="card my-4">
            <div class="card-body bg-info text-white">
                <h5 class="card-title">DETAIL TIKET</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="tanggal_keberangkatan_detail">Tanggal Keberangkatan</label>
                            <input type="date" class="form-control" id="tanggal_keberangkatan_detail">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="maskapai">Maskapai</label>
                            <input type="text" class="form-control" id="maskapai">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tujuan">Tujuan</label>
                            <input type="text" class="form-control" id="tujuan">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="waktu_keberangkatan_detail">Waktu Keberangkatan</label>
                            <input type="time" class="form-control" id="waktu_keberangkatan_detail">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lihat_tiket">Lihat Tiket</label>
                            <input type="text" class="form-control" id="lihat_tiket">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <img src="{{ asset('path/to/bus-image.png') }}" class="img-fluid mr-2" style="max-width: 100px;">
                        <img src="{{ asset('path/to/train-image.png') }}" class="img-fluid mr-2" style="max-width: 100px;">
                        <img src="{{ asset('path/to/plane-image.png') }}" class="img-fluid" style="max-width: 100px;">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit Detail Tiket</button>
                </form>
            </div>
        </div>
    </div>
@endsection
