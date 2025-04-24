@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="card shadow-lg my-4">
            <div class="card-header bg-info text-white text-center">
                <h4>Form Pengajuan Tiket</h4>
            </div>
            <div class="card-body" style="background: url('{{ asset('dist/img/aag.jpg') }}') no-repeat center center; background-size: cover;">
                <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" required>
                        </div>
                    </div>

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
                                <option value="Bus">Bus</option>
                                <option value="Kereta">Kereta</option>
                                <option value="Pesawat">Pesawat</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="lampiran">Lampiran</label>
                            <div id="drop-area" class="drop-area">
                                <p>Seret dan jatuhkan file di sini atau <span id="file-upload">klik untuk memilih file</span></p>
                                <input type="file" id="lampiran" name="lampiran" class="form-control" style="display: none;" accept="image/*" />
                            </div>
                            <div id="file-list"></div>
                            <div id="image-preview" class="mt-2"></div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="beban_biaya">Beban Biaya</label>
                            <select id="beban_biaya" name="beban_biaya" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Cabang --</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->nama_cabang }}">{{ $cabang->nama_cabang }}</option>
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
                            <label for="tiket">Upload Tiket</label>
                            <input type="file" id="tiket" name="tiket" class="form-control-file" required>
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
    const imagePreview = document.getElementById('image-preview');

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
        fileList.innerHTML = ''; 
        imagePreview.innerHTML = ''; 

        for (let i = 0; i < files.length; i++) {
            const fileItem = document.createElement('div');
            fileItem.textContent = files[i].name;
            fileList.appendChild(fileItem);

            if (files[i].type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(files[i]);
                img.style.width = '100px'; 
                img.style.height = 'auto'; 
                img.style.marginTop = '10px';
                imagePreview.appendChild(img);
            }
        }
    }
    </script>

    <style>
       .card-body {
    height: 850px; 
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.8); 
}

.drop-area {
    border: 2px dashed #007bff;
    border-radius: 5px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s; 
}

.drop-area.hover {
    border-color: #0056b3; 
}

#image-preview img {
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    max-width: 100%; 
    height: auto; 
}

.form-control {
    border-radius: 5px; /* Rounded corners for inputs */
    border: 1px solid #ced4da; /* Standard border color */
    transition: border-color 0.3s; /* Smooth transition for focus effect */
}

.form-control:focus {
    border-color: #007bff; /* Change border color on focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add shadow on focus */
}

.btn {
    border-radius: 5px; /* Rounded corners for buttons */
    padding: 10px 20px; /* Add padding for better button size */
    font-size: 16px; /* Increase font size */
}

.btn-success {
    background-color: #28a745; /* Green background */
    border: none; /* Remove border */
}

.btn-danger {
    background-color: #dc3545; /* Red background */
    border: none; /* Remove border */
}

.btn:hover {
    opacity: 0.9; /* Slightly fade buttons on hover */
}

h4, h5 {
    color: #000000; /* Change header color to match theme */
}

hr {
    border-top: 2px solid #000000; /* Change hr color to match theme */
}

.form-group label {
    font-weight: bold; /* Make labels bold */
    color: #333; /* Darker color for labels */
}
 
    </style>
@endsection