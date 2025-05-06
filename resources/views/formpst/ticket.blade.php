@extends('layouts.main')

@section('content')
    <div class="container">
        {{-- ========== FORM PENGAJUAN TIKET ========== --}}
        <div class="card shadow-lg my-4">
            <div class="card-header bg-info text-white text-center">
                <h4>FORM PENGAJUAN TIKET</h4>
            </div>
            <div class="card-body"
                style="background: url('{{ asset('dist/img/flight.jpg') }}') no-repeat center center; background-size: cover;">

                <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_surat">No. Surat</label>
                                <div class="input-group">
                                    <select class="form-control select2" name="no_surat" id="no_surat" required>
                                        <option value="" disabled {{ empty($prefill) ? 'selected' : '' }}>-- Pilih No. Surat --</option>
                                        @foreach ($forms as $form)
                                            <option value="{{ $form->id }}"
                                                {{ (isset($prefill) && $prefill->id == $form->id) ? 'selected' : '' }}>
                                                {{ $form->no_surat }}
                                            </option>
                                        @endforeach
                                        <option value="lainnya">lainnya</option>
                                    </select>
                                    <button type="button" id="toggleLampiran" class="btn btn-secondary btn-sm">T</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama_pemohon">Nama Pemohon</label>
                                <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" required
                                    value="{{ old('nama_pemohon', $prefill->nama_pemohon ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="yang_menugaskan">Ditugaskan Oleh</label>
                                <input type="text" id="yang_menugaskan" name="assigned_By" class="form-control" required
                                    value="{{ old('yang_menugaskan', $prefill->yang_menugaskan ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="hp">No. HP</label>
                                <input type="tel" id="hp" name="hp" class="form-control" pattern="[0-9]+"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="lampiranSection">
                                <label for="lampiran">Lampiran</label>
                                @for ($i = 1; $i <= 2; $i++)
                                    <div class="mb-2">
                                        <label for="lampiran_{{ $i }}" class="form-label d-block">Lampiran {{ $i }}</label>
                                        <input type="file" id="lampiran_{{ $i }}"
                                            name="lampiran_{{ $i }}" class="form-control-file"
                                            onchange="previewFile(this, 'preview-lampiran-{{ $i }}', 'file-name-lampiran-{{ $i }}')">
                                        <div id="preview-lampiran-{{ $i }}" class="mt-2 preview-area"></div>
                                        <div id="file-name-lampiran-{{ $i }}" class="mt-1 text-muted">Tidak ada file
                                            yang dipilih</div>
                                    </div>
                                @endfor
                                @for ($i = 1; $i <= 1; $i++)
                                <div class="mb-2">
                                    <label for="hp">Urgensi</label>
                                    <input type="tel" id="hp" name="hp" class="form-control" pattern="[0-9]+"
                                        required>
                                </div>
                                

                            @endfor
                                <div id="additional-attachments-lampiran"></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" style="border-top: 6px solid #fffcfc;">
                    {{-- SECTION: ISSUED TIKET --}}

                    <div class="card mt-4 transparent-card">
                        <div class="card-body">
                            <h5 class="mt-0 mb-3">Issued Tiket</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Agent">Agen</label>
                                        <select id="Agent" name="Agent" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Agensi Perjalanan --</option>
                                            <option value="TxTravel"> TxTravel</option>
                                            <option value="Traveloka">Traveloka</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_issued">Tanggal Issued</label>
                                        <input type="date" id="issued" name="issued" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transport">Transportasi</label>
                                        <select id="transport" name="transport" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Transportasi --</option>
                                            <option value="Bus">Bus</option>
                                            <option value="Kereta">Kereta</option>
                                            <option value="Pesawat">Pesawat</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maskapai">Maskapai</label>
                                        <select id="maskapai" name="maskapai" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Maskapai --</option>
                                            @foreach ($maskapais as $maskapai)
                                                <option value="{{ $maskapai->kode_maskapai }}">
                                                    {{ $maskapai->nama_maskapai }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="invoice">No Invoice</label>
                                        <input type="text" id="invoice" name="invoice" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nominal_tiket">Nominal Tiket</label>
                                        <input type="text" id="nominal" name="nominal" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="beban_biaya">Beban Biaya</label>
                                        <select id="beban_biaya" name="beban_biaya" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Cabang --</option>
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->nama_cabang }}">{{ $cabang->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="detail">Detail Perjalanan</label>
                                        <textarea id="detail" name="detail" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="upload_tiket">Upload Tiket</label>
                                        <input type="file" id="upload_tiket" name="upload_tiket" class="form-control-file">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success me-2">Submit</button>
                        <button type="reset" class="btn btn-danger">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Only fetch data if no prefill data present
        @if(empty($prefill))
            $('#no_surat').on('change', function() {
                let form_id = $(this).val();
                if (form_id) {
                    if (form_id === 'lainnya') {
                        // Show the lampiran section if "lainnya" is selected
                        $('#lampiranSection').show();
                    } else {
                        $.ajax({
                            url: '{{ url('/get-pemohon') }}/' + form_id,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                $('#nama_pemohon').val(data.nama_pemohon);
                                $('#yang_menugaskan').val(data.yang_menugaskan);
                                // Hide the lampiran section if a valid form is selected
                                $('#lampiranSection').hide();
                            },
                            error: function() {
                                alert('Gagal mengambil data pemohon');
                            }
                        });
                    }
                }
            });
        @endif
    
        document.getElementById('toggleLampiran').addEventListener('click', function() {
            var lampiranSection = document.getElementById('lampiranSection');
            if (lampiranSection.style.display === 'none' || lampiranSection.style.display === '') {
                lampiranSection.style.display = 'block'; // Show the lampiran section
            } else {
                lampiranSection.style.display = 'none'; // Hide the lampiran section
            }
        });
    
        // Initially hide the lampiran section
        document.getElementById('lampiranSection').style.display = 'none';
    </script>
    

    <style>
        .card-body {

        }

        .drop-area {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            border-radius: 10px;
            background-color: #f9f9f9;
            transition: background-color 0.3s;
        }

        .drop-area.hover {
            background-color: #e0f7fa;
        }

        #file-list div {
            margin-top: 5px;
            font-size: 14px;
            color: #333;
        }

        #file-list img {
            display: block;
            margin-top: 10px;
        }

        .transparent-card {
            background-color: rgba(255, 255, 255, 0.6);
            backdrop-filter: saturate(70%) blur(10px);
        }
    </style>
@endsection