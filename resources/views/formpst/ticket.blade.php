@extends('layouts.main')

@section('content')
<div class="container">
    {{-- ========== FORM PENGAJUAN TIKET ========== --}}
    <div class="card shadow-lg my-4">
        <div class="card-header bg-info text-white text-center">
            <h4>Form Pengajuan Tiket</h4>
        </div>
        <div class="card-body" style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover;">
            
            <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ROW 1 --}}
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
                        <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" required>
                    </div>
                </div>

                {{-- ROW 2 --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="yang_menugaskan">Ditugaskan Oleh</label>
                        <input type="text" id="yang_menugaskan" name="assigned_By" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="hp">No. HP</label>
                        <input type="text" id="hp" name="hp" class="form-control" required>
                    </div>
                </div>

                {{-- SECTION: ISSUED TIKET --}}
                <hr>
                <h5 class="mt-4">Issued Tiket</h5>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tanggal_issued">Tanggal Issued</label>
                        <input type="date" id="tanggal_issued" name="tanggal_issued" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="invoice">No. Invoice</label>
                        <input type="text" id="invoice" name="invoice" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="maskapai">Maskapai</label>
                        <select id="maskapai" name="maskapai" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Maskapai --</option>
                            @foreach ($maskapais as $maskapai)
                                <option value="{{ $maskapai->kode_maskapai }}">{{ $maskapai->nama_maskapai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="transport">Transportasi</label>
                        <select id="transport" name="transport" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Transportasi --</option>
                            <option value="001">001</option>
                            <option value="002">002</option>
                            <option value="003">003</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="lampiran">Lampiran</label>
                        <textarea id="lampiran" name="lampiran" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="beban_biaya">Beban Biaya</label>
                        <select id="beban_biaya" name="beban_biaya" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Cabang --</option>
                            @foreach ($cabangs as $cabang)
                                <option value="{{ $cabang->kode_cabang }}">{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tanggal_keberangkatan">Tanggal Keberangkatan</label>
                        <input type="date" id="tanggal_keberangkatan" name="tanggal_keberangkatan" class="form-control" required>
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
                        <div class="d-flex align-items-center">
                            <input type="text" id="rute" name="rute" class="form-control me-2" placeholder="Dari" required>
                            <span class="mx-2">Ke</span>
                            <input type="text" id="rute_tujuan" name="rute_tujuan" class="form-control" placeholder="Tujuan" required>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="upload_tiket">Upload Tiket</label>
                        <input type="file" id="upload_tiket" name="upload_tiket" class="form-control-file" required>
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

<script>
    $('#no_surat').on('change', function () {
        let form_id = $(this).val();
        if (form_id) {
            $.ajax({
                url: '{{ url('/get-pemohon') }}/' + form_id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#nama_pemohon').val(data.nama_pemohon);
                    $('#yang_menugaskan').val(data.yang_menugaskan);
                },
                error: function () {
                    alert('Gagal mengambil data pemohon');
                }
            });
        }
    });
</script>

<style>
    .card-body {
        height: auto;
    }
</style>
@endsection