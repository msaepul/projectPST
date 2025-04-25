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
                                <select class="form-control select2" name="no_surat" id="no_surat" required>
                                    <option value="" disabled selected>-- Pilih No. Surat --</option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form->id }}">{{ $form->no_surat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pemohon">Nama Pemohon</label>
                                <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="yang_menugaskan">Ditugaskan Oleh</label>
                                <input type="text" id="yang_menugaskan" name="assigned_By" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hp">No. HP</label>
                                <input type="text" id="hp" name="hp" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" style="border-top: 6px solid #fffcfc;">
                    {{-- SECTION: ISSUED TIKET --}}
                    <h5 class="mt-0 mb-3">Issued Tiket</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_issued">Tanggal Issued</label>
                                <input type="date" id="issued" name="issued" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="invoice">No. Invoice</label>
                                <input type="text" id="invoice" name="invoice" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="maskapai">Maskapai</label>
                                <select id="maskapai" name="maskapai" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Maskapai --</option>
                                    @foreach ($maskapais as $maskapai)
                                        <option value="{{ $maskapai->kode_maskapai }}">{{ $maskapai->nama_maskapai }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_keberangkatan">Tanggal Keberangkatan</label>
                                <input type="date" id="keberangkatan" name="keberangkatan" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="waktu_keberangkatan">Waktu Keberangkatan</label>
                                <input type="time" id="waktu" name="waktu" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominal_tiket">Nominal Tiket</label>
                                <input type="text" id="nominal" name="nominal" class="form-control" required>
                            </div>
                        </div>
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rute">Rute</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" id="rute" name="rute" class="form-control me-2"
                                        placeholder="Dari" required>
                                    <span class="mx-2">Ke</span>
                                    <input type="text" id="rute_tujuan" name="rute_tujuan" class="form-control"
                                        placeholder="Tujuan" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lampiran" class="form-label"><strong>Lampiran</strong></label>
                                <div id="drop-area" class="border p-3 text-center"
                                    style="border-style: dashed; border-radius: 10px;">
                                    <p>Seret dan jatuhkan file di sini atau <span class="text-primary"
                                            style="cursor: pointer;"
                                            onclick="document.getElementById('lampiran').click()">klik untuk memilih
                                            file</span></p>
                                    <input type="file" id="lampiran" name="lampiran" class="form-control d-none"
                                        onchange="handleFiles(event)">
                                    <div id="file-list" class="mt-2"></div>
                                </div>
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
                        {{-- Anda bisa menambahkan kolom kosong jika ingin elemen terakhir tidak memenuhi satu baris penuh --}}
                        <div class="col-md-6">
                            {{-- Kosong --}}
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

        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('lampiran');
        const fileList = document.getElementById('file-list');

        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', handleFiles);

        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('hover');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('hover');
        });

        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('hover');
            const files = event.dataTransfer.files;
            handleFiles({
                target: {
                    files
                }
            });
        });

        function handleFiles(event) {
            const files = event.target.files;
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = ''; // Clear previous preview

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                const fileItem = document.createElement('div');
                fileItem.classList.add('mb-2');

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '150px';
                        img.style.objectFit = 'contain';
                        img.classList.add('img-thumbnail');
                        fileItem.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileItem.textContent = file.name;
                }

                fileList.appendChild(fileItem);
            }
        }
    </script>

    <style>
        .card-body {
            /* Anda bisa mengatur tinggi card body sesuai kebutuhan */
            /* height: 1000px; */
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
    </style>
@endsection
