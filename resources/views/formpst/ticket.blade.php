@extends('layouts.main')

@section('content')
    <div class="container">
        {{-- ========== FORM PENGAJUAN TIKET ========== --}}
        <div class="card shadow-lg my-4">
            <div class="card-header bg-info text-white text-center">
                <h4>FORM PENGAJUAN TIKET</h4>
            </div>
            <div class="card-body main-card-body"
                style="background: url('{{ asset('dist/img/flight.jpg') }}') no-repeat center center; background-size: cover;">

                <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data" id="ticketForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="no_surat" class="form-label">No. Surat</label>
                                <div class="input-group">
                                    <select class="form-control select2" name="no_surat" id="no_surat">
                                        <option value="" disabled {{ empty($prefill) ? 'selected' : '' }}>-- Pilih No.
                                            Surat --</option>
                                        @foreach ($forms as $form)
                                            <option value="{{ $form->id }}"
                                                {{ isset($prefill) && $prefill->id == $form->id ? 'selected' : '' }}>
                                                {{ $form->no_surat }}
                                            </option>
                                        @endforeach
                                        <option value="lainnya">lainnya</option>
                                    </select>
                                    <button type="button" id="toggleLampiran" class="btn btn-secondary btn-sm">T</button>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nama_pemohon" class="form-label">Nama Pemohon</label>
                                <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control"
                                    value="{{ old('nama_pemohon', $prefill->nama_pemohon ?? '') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="yang_menugaskan" class="form-label">Ditugaskan Oleh</label>
                                <input type="text" id="yang_menugaskan" name="assigned_By" class="form-control"
                                    value="{{ old('yang_menugaskan', $prefill->yang_menugaskan ?? '') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="tujuan" class="form-label">Tujuan Penugasan</label>
                                <input type="text" id="tujuan" name="tujuan" class="form-control"
                                    value="{{ old('tujuan', $prefill->tujuan ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" style="border-top: 6px solid #fffcfc;">

                    {{-- SECTION: ISSUED TIKET --}}
                    <div class="container my-4 d-flex justify-content-center">
                        <div class="issued p-4 w-100" style="max-width: 1000px;">
                            <h5 class="mb-4">Issued Tiket</h5>
                            <form>
                                <div class="row gx-4">
                                    <!-- Kolom Administrasi -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card p-4 h-100">
                                            <h6 class="mb-3">Administrasi Tiket</h6>
                                            <div class="mb-3">
                                                <label for="invoice" class="form-label">No invoice</label>
                                                <input type="text" id="invoice" name="invoice" class="form-control"
                                                    required />
                                                <div class="invalid-feedback">Please enter the invoice number.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="issued" class="form-label">Tanggal issued</label>
                                                <input type="date" id="issued" name="issued" class="form-control"
                                                    required />
                                                <div class="invalid-feedback">Please enter the issue date.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nominal" class="form-label">Nominal Tiket</label>
                                                <input type="number" id="nominal" name="nominal" class="form-control"
                                                    min="0" required />
                                                <div class="invalid-feedback">Please enter a valid nominal amount.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="beban_biaya" class="form-label">Beban Biaya</label>
                                                <select id="beban_biaya" name="beban_biaya" class="form-control" required>
                                                    <option value="" disabled selected>-- Pilih Cabang --</option>
                                                    @foreach ($cabangs as $cabang)
                                                        <option value="{{ $cabang->nama_cabang }}">{{ $cabang->nama_cabang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Please select cabang.</div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Kolom Transportasi -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card p-4 h-100">
                                            <h6 class="mb-3">Transportasi</h6>
                                            <div class="mb-3">
                                                <label for="agent" class="form-label">Agent</label>
                                                <select id="agent" name="agent" class="form-select" required>
                                                    <option value="" selected hidden>Pilih Agensi Perjalanan</option>
                                                    <option value="TxTravel">TxTravel</option>
                                                    <option value="Traveloka">Traveloka</option>
                                                </select>
                                                <div class="invalid-feedback">Please select an agent.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Kendaraan</label><br />
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input kendaraan-checkbox" type="checkbox"
                                                        id="bus" value="Bus" />
                                                    <label class="form-check-label" for="bus">Bus</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input kendaraan-checkbox" type="checkbox"
                                                        id="kereta" value="Kereta" />
                                                    <label class="form-check-label" for="kereta">Kereta</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input kendaraan-checkbox" type="checkbox"
                                                        id="pesawat" value="Pesawat" />
                                                    <label class="form-check-label" for="pesawat">Pesawat</label>
                                                </div>
                                                <div class="invalid-feedback d-block" id="kendaraanFeedback"
                                                    style="display:none;">
                                                    Pilih salah satu.
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="maskapai" class="form-label">Maskapai</label>
                                                <select id="maskapai" name="maskapai" class="form-control" required>
                                                    <option value="" disabled selected>-- Pilih Maskapai --</option>
                                                    @foreach ($maskapais as $maskapai)
                                                        <option value="{{ $maskapai->kode_maskapai }}">
                                                            {{ $maskapai->nama_maskapai }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Please select maskapai.</div>
                                            </div>
                                            <div>
                                                <label for="class" class="form-label">Class</label>
                                                <select id="class" name="class" class="form-select" required>
                                                    <option value="" selected hidden>Pilih Class</option>
                                                    <option value="Economy">Economy</option>
                                                    <option value="Business">Business</option>
                                                </select>
                                                <div class="invalid-feedback">Please select class.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Tiket -->
                                <div class="card p-4 shadow-sm mt-4">
                                    <h6 class="mb-3">Detail Tiket</h6>
                                    <div class="mb-3">
                                        <label for="detail_tiket" class="form-label">Input Detail Tiket</label>
                                        <input type="text" id="detail_tiket" name="detail_tiket" class="form-control"
                                            placeholder="contoh: IU672 / SUB-BEJ / 28 APR 16.00-19.00" required />
                                        <div class="invalid-feedback">Please enter ticket detail.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="file_upload" class="form-label">Upload File Tiket</label>
                                        <input type="file" id="file_upload" name="file_upload"
                                            class="form-control" />
                                        <div class="invalid-feedback">Please upload a file.</div>
                                    </div>


                                    <!-- Preview Table -->
                                    <label class="mt-3 fw-semibold">Pratinjau Tiket yang Akan Dimasukkan</label>
                                    <table class="table table-bordered table-sm" id="previewTable">
                                        <thead>
                                            <tr>
                                                <th>No Invoice</th>
                                                <th>Tanggal Issue</th>
                                                <th>Nominal</th>
                                                <th>Beban Biaya</th>
                                                <th>Agent</th>
                                                <th>Kendaraan</th>
                                                <th>Maskapai</th>
                                                <th>Class</th>
                                                <th>Detail Tiket</th>
                                                <th>Tiket</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Rows will appear here -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-primary" id="addTicketBtn">Tambah ke
                                        Tabel</button>
                                    <button type="submit" class="btn btn-success">Submit Semua</button>
                                    <button type="reset" class="btn btn-danger" id="resetBtn">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>

            <script>
                @if (empty($prefill))
                    $('#no_surat').on('change', function() {
                        let form_id = $(this).val();
                        if (form_id) {
                            if (form_id === 'lainnya') {
                                $('#lampiranSection').show();
                            } else {
                                $.ajax({
                                    url: '{{ url('/get-pemohon') }}/' + form_id,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        $('#nama_pemohon').val(data.nama_pemohon);
                                        $('#yang_menugaskan').val(data.yang_menugaskan);
                                        $('#tujuan').val(data.tujuan);
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
                (() => {
                    'use strict';

                    const ticketForm = document.getElementById('ticketForm');
                    const addTicketBtn = document.getElementById('addTicketBtn');
                    const previewTableBody = document.querySelector('#previewTable tbody');
                    const kendaraanCheckboxes = Array.from(document.querySelectorAll('.kendaraan-checkbox'));
                    const kendaraanFeedback = document.getElementById('kendaraanFeedback');
                    const resetBtn = document.getElementById('resetBtn');

                    // Validation helper to check kendaraan at least one checked
                    function validateKendaraan() {
                        const checked = kendaraanCheckboxes.some(chk => chk.checked);
                        if (!checked) {
                            kendaraanFeedback.style.display = 'block';
                        } else {
                            kendaraanFeedback.style.display = 'none';
                        }
                        return checked;
                    }

                    function validateFormForAdd() {
                        if (!ticketForm.checkValidity()) {
                            ticketForm.classList.add('was-validated');
                            return false;
                        }
                        if (!validateKendaraan()) {
                            return false;
                        }
                        return true;
                    }

                    function clearValidation() {
                        ticketForm.classList.remove('was-validated');
                        kendaraanFeedback.style.display = 'none';
                    }

                    // Add ticket to preview table
                    addTicketBtn.addEventListener('click', () => {
                        clearValidation();
                        if (!validateFormForAdd()) {
                            return;
                        }

                        // Collect values
                        const invoice = document.getElementById('invoice').value.trim();
                        const issued = document.getElementById('issued').value;
                        const nominal = document.getElementById('nominal').value.trim();
                        const bebanBiaya = document.getElementById('beban_biaya').value;
                        const agent = document.getElementById('agent').value;
                        const kendaraanSelected = kendaraanCheckboxes.filter(chk => chk.checked).map(chk => chk.value)
                            .join(', ');
                        const maskapai = document.getElementById('maskapai').value;
                        const kelas = document.getElementById('class').value;
                        const detailTiket = document.getElementById('detail_tiket').value.trim();

                        // Get the file name
                        const fileUpload = document.getElementById('file_upload');
                        const fileName = fileUpload.files.length > 0 ? fileUpload.files[0].name : 'No file uploaded';

                        // Create table row
                        const tr = document.createElement('tr');

                        tr.innerHTML = `
                            <td>${invoice}</td>
                            <td>${issued}</td>
                            <td>${nominal}</td>
                            <td>${bebanBiaya}</td>
                            <td>${agent}</td>
                            <td>${kendaraanSelected}</td>
                            <td>${maskapai}</td>
                            <td>${kelas}</td>
                            <td>${detailTiket}</td>
                            <td>${fileName}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-btn">Hapus</button>
                            </td>
                        `;

                        // Add remove functionality
                        tr.querySelector('.remove-btn').addEventListener('click', () => {
                            tr.remove();
                        });

                        // Append row
                        previewTableBody.appendChild(tr);

                        // Reset the form for next entry
                        ticketForm.reset();
                        clearValidation();
                    });

                })();
            </script>

            <style>
                .main-card-body {
                    background-color: rgba(255, 255, 255, 0.75);
                    padding: 2rem;
                    border-radius: 12px;
                }

                .container {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    max-width: 1000px;
                    margin: 0 auto;
                }


                .transparent-card {
                    background-color: rgba(255, 255, 255, 0.85);
                    backdrop-filter: saturate(90%) blur(8px);
                    border-radius: 12px;
                }

                .form-label {
                    font-weight: 600;
                    color: #333;
                }

                .form-control {
                    border: 1.5px solid #ccc;
                    border-radius: 6px;
                    padding: 10px 14px;
                    font-size: 16px;
                    transition: border-color 0.3s;
                }

                .form-control:focus {
                    border-color: #007acc;
                    outline: none;
                    box-shadow: 0 0 6px #007acc88;
                }

                .btn {
                    font-weight: 600;
                    font-size: 16px;
                    border-radius: 6px;
                    padding: 10px 18px;
                    transition: background-color 0.3s;
                    cursor: pointer;
                }

                .btn-secondary.btn-sm {
                    font-size: 12px;
                    padding: 6px 10px;
                }

                .btn:hover,
                .btn:focus {
                    background-color: #005f99 !important;
                }

                .btn-success {
                    background-color: #28a745;
                    border: none;
                    color: white;
                }

                .btn-success:hover {
                    background-color: #1e7e34;
                }

                .btn-danger {
                    background-color: #dc3545;
                    border: none;
                    color: white;
                }

                .btn-danger:hover {
                    background-color: #bd2130;
                }

                .card {
                    border-radius: 12px;
                }

                .issued {
                    width: 950px;
                }

                .shadow-sm {
                    box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 0.075) !important;
                }

                .issued {
                    background: rgba(255, 255, 255, 0.1);
                    backdrop-filter: blur(10px);
                    border-radius: 12px;
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }



                /* .h-100 {
                            height: 100%;
                        }

                        @media (max-width: 600px) {
                            .card-body.main-card-body {
                                padding: 1rem;
                            }

                            .row.gx-3 {
                                gap: 1rem;
                            }
                        } */
                h5,
                h6 {
                    font-weight: 700;
                    color: #2c3e50;
                }

                label {
                    font-weight: 600;
                }

                .table thead {
                    background-color: #3498db;
                    color: #fff;
                }

                .btn-primary {
                    background: linear-gradient(45deg, #3498db, #2980b9);
                    border: none;
                    box-shadow: 0 4px 8px #2980b9aa;
                }

                .btn-primary:hover {
                    background: linear-gradient(45deg, #2980b9, #2471a3);
                }

                #previewTable {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                }

                #previewTable thead {
                    background-color: #f8f9fa;
                }

                #previewTable th,
                #previewTable td {
                    vertical-align: middle;
                    padding: 8px;
                    border: 1px solid #dee2e6;
                    white-space: nowrap;
                    text-align: center;
                }

                #previewTable td.wrap-text {
                    white-space: normal;
                    word-wrap: break-word;
                    max-width: 200px;
                }

                .btn-delete {
                    color: white;
                    background-color: #dc3545;
                    border: none;
                    padding: 4px 10px;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .btn-delete:hover {
                    background-color: #c82333;
                }
            </style>
        @endsection
