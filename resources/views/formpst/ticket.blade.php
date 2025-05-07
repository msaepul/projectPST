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
                    </div>

                    <hr class="my-4" style="border-top: 6px solid #fffcfc;">
                    {{-- SECTION: ISSUED TIKET --}}

                    <div class="card mt-4 transparent-card">
                        <div class="card-body">
                            <h5 class="mt-0 mb-3">Issued Tiket</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="agent">Agen</label>
                                        <select id="agent" name="agent" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Agensi Perjalanan --</option>
                                            <option value="TxTravel">TxTravel</option>
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
                                        <label for=" maskapai">Maskapai</label>
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
                                <!-- Kolom untuk Select Beban Biaya -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="beban_biaya">Beban Biaya</label>
                                        <select id="beban_biaya" name="beban_biaya" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih Cabang --</option>
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->nama_cabang }}">{{ $cabang->nama_cabang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputText">Input Rute</label>
                                        <div class="input-group">
                                            <input type="text" id="inputText" class="form-control"
                                                placeholder="Masukkan teks, contoh: IU672 / SUB BEJ / 28 APR 16.00-19.00"
                                                required />
                                            <div class="input-group-append">
                                                <button type="button" id="submitButton"
                                                    class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Kolom untuk Tabel -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Informasi Rute</label>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Rute</th>
                                                    <th>Tanggal</th>
                                                    <th>Bulan</th>
                                                    <th>Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="resultRow">
                                                    <td data-label="Kode"></td>
                                                    <td data-label="Rute"></td>
                                                    <td data-label="Tanggal"></td>
                                                    <td data-label="Bulan"></td>
                                                    <td data-label="Waktu"></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
    </div>
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
        const form = document.getElementById('inputForm');
        const resultRow = document.getElementById('resultRow');
        const submitButton = document.getElementById('submitButton');

        submitButton.addEventListener('click', function() {
            const input = document.getElementById('inputText').value.trim();

            // Split by slash first, then flatten words separated by space in each part
            const parts = input.split('/').map(s => s.trim());
            let words = [];
            parts.forEach(p => {
                const splitWords = p.split(/\s+/);
                words = words.concat(splitWords);
            });

            // Prepare columns: Kode, Rute, Tanggal, Bulan, Waktu
            while (words.length < 5) {
                words.push('');
            }

            // Assign cells
            const cells = resultRow.querySelectorAll('td');
            for (let i = 0; i < 5; i++) {
                cells[i].textContent = words[i];
            }
        });
    </script>

    <style>
        .card-body {
            /* Additional styles can be added here */
        }

        .transparent-card {
            background-color: rgba(255, 255, 255, 0.6);
            backdrop-filter: saturate(70%) blur(10px);
        }

        input[type="text"] {
            flex-grow: 1;
            padding: 10px 14px;
            font-size: 16px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #007acc;
            outline: none;
        }

        button {
            background-color: #007acc;
            color: white;
            border: none;
            padding: 10px 16px;
            font-weight: 600;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #005f99;
        }

        table {
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            width: 100%;
            max-width: 600px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px 16px;
            text-align: center;
            color: #333;
            font-weight: 600;
        }

        thead th {
            background-color: #007acc;
            color: white;
        }

        @media (max-width: 600px) {

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                border-bottom: 2px solid #ddd;
                padding-bottom: 10px;
            }

            td {
                text-align: right;
                position: relative;
                padding-left: 50%;
                border: none;
                border-bottom: 1px solid #eee;
            }

            td::before {
                position: absolute;
                top: 12px;
                left: 16px;
                width: 45%;
                padding-left: 5px;
                font-weight: bold;
                white-space: nowrap;
                content: attr(data-label);
                text-align: left;
                color: #007acc;
            }
        }
    </style>
@endsection
