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
                <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="no_surat">No. Surat</label>
                            <select class="form-control select2" name="no_surat" id="no_surat" required>
                                <option value="" disabled selected>-- Pilih No. Surat --</option>
                                @foreach ($forms as $form)
                                    <option value="{{ $form->no_surat }}">{{ $form->no_surat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama_pemohon">Nama Pemohon</label>
                            <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" required>
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="assigned_By">Ditugaskan Oleh</label>
                            <input type="text" id="assigned_By" name="assigned_By" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hp">No. HP</label>
                            <input type="text" id="hp" name="hp" class="form-control" required>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="pegawai">Pegawai yang Berangkat</label>
                        <textarea id="pegawai" name="pegawai" class="form-control" required></textarea>
                    </div>
                
                    <hr class="my-4">
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="issued">Issued Tiket</label>
                            <input type="date" id="issued" name="issued" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="invoice">No. Invoice</label>
                            <input type="text" id="invoice" name="invoice" class="form-control" required>
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="maskapai">Maskapai</label>
                            <input type="text" id="maskapai" name="maskapai" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="transport">Transportasi</label>
                            <input type="text" id="transport" name="transport" class="form-control" required>
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="lampiran">Lampiran</label>
                            <input type="file" id="lampiran" name="lampiran" class="form-control-file" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="beban_biaya">Beban Biaya</label>
                            <select id="beban_biaya" name="beban_biaya" class="form-control" required>
                                <option value="">-- Beban Biaya --</option>
                                <option value="001">Cabang 001</option>
                                <option value="002">Cabang 002</option>
                                <option value="003">Cabang 003</option>
                            </select>
                        </div>
                    </div>
                
                    <hr class="my-4">
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="keberangkatan">Tanggal Keberangkatan</label>
                            <input type="date" id="keberangkatan" name="keberangkatan" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nominal">Nominal Tiket</label>
                            <input type="text" id="nominal" name="nominal" class="form-control" required>
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="waktu">Waktu Keberangkatan</label>
                            <input type="time" id="waktu" name="waktu" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rute">Rute</label>
                            <input type="text" id="rute" name="rute" class="form-control" placeholder="Contoh: Jakarta" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rute_tujuan">Rute Tujuan</label>
                            <input type="text" id="rute_tujuan" name="rute_tujuan" class="form-control" placeholder="Contoh: Surabaya" required>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="tiket">Upload Tiket</label>
                        <input type="file" id="tiket" name="tiket" class="form-control-file" required>
                    </div>
                
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success me-2">Submit</button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
