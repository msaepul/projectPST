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
                <form action="{{ route('store_ticket') }}" method="POST">
                    @csrf
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
                            <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="yang_menugaskan">Ditugaskan Oleh</label>
                            <input type="text" id="yang_menugaskan" name="assigned_By" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hp">No. HP</label>
                            <input type="text" id="hp" name="hp" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_pegawai">Pegawai yang Berangkat</label>
                        <textarea id="nama_pegawai" name="pegawai" class="form-control"></textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success me-2">Submit</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>

                    <div class="p-3 mt-4" style="border-top: 2px solid rgb(0, 0, 0)">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="issued">Issued Tiket</label>
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
                                <select id="maskapai" name="maskapai" class="form-control">
                                    <option value="">-- Pilih Maskapai --</option>
                                    @foreach ($maskapais as $maskapai)
                                        <option value="{{ $maskapai->kode_maskapai }}">{{ $maskapai->nama_maskapai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                                <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
                                    <option value="">-- Pilih Jenis Kendaraan --</option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Bus">Bus</option>
                                    <option value="Truk">Truk</option>
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
                                <select id="beban_biaya" name="beban_biaya" class="form-control">
                                    <option value="">-- Pilih Cabang --</option>
                                    @foreach ($cabangs as $cabang)
                                        <option value="{{ $cabang->kode_cabang }}">{{ $cabang->nama_cabang }}</option>
                                    @endforeach
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
                            <label for="keberangkatan">Tanggal Keberangkatan</label>
                            <input type="date" id="keberangkatan" name="keberangkatan" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nominal">Nominal Tiket</label>
                            <input type="text" id="nominal" name="nominal" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="waktu">Waktu Keberangkatan</label>
                            <input type="time" id="waktu" name="waktu" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rute">Rute</label>
                            <div class="d-flex align-items-center">
                                <input type="text" id="rute" name="rute" class="form-control me-2">
                                <span>Ke</span>
                                <input type="text" id="rute_tujuan" name="rute_tujuan" class="form-control ms-2">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tiket">Upload Tiket</label>
                            <input type="file" id="tiket" name="tiket" class="form-control-file">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Tiket</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#no_surat').on('change', function() {
        let form_id = $(this).val();
        if (form_id) {
            $.ajax({
                url: '{{ url('/get-pemohon') }}/' + form_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#nama_pemohon').val(data.nama_pemohon);
                    $('#yang_menugaskan').val(data.yang_menugaskan);
                    $('#nama_pegawai').val(data.nama_pegawai);
                },
                error: function() {
                    alert('Gagal mengambil data pemohon');
                }
            });
        }
    });
</script>

@endsection