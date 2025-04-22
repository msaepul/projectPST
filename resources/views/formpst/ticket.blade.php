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
                            <label for="assigned_By">Ditugaskan Oleh</label>
                            <input type="text" id="yang_menugaskan" name="assigned_By" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hp">No. HP</label>
                            <input type="text" id="hp" name="hp" class="form-control">
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label for="nama_pegawai">Pegawai yang Berangkat</label>
                        <textarea id="nama_pegawai" name="pegawai" class="form-control"></textarea>
                    </div> --}}

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success me-2">Submit</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </form>


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
                        },
                        error: function() {
                            alert('Gagal mengambil data pemohon');
                        }
                    });
                }
            });
        </script>
    @endsection
