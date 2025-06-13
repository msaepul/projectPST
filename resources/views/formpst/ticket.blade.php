@extends('layouts.main')

@section('content')

    <head>
        <link rel="stylesheet" href={{ asset('css/ticket.css') }}>
        <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.4.120/build/pdf.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5.0.1/dist/tesseract.min.js"></script>
        <canvas id="ocr-canvas" style="display: none;"></canvas>

    </head>
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
                            <div class="pengajuan mb-3">
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

                        </div>
                        <div class="col-md-6">
                            <label for="pegawai" class="form-label">List Pegawai</label>

                            <div class="card mb-3">
                                <div class="card-pegawai">
                                    <ul class="list-group" id="listPegawai">
                                        <li class="list-group-item">Pilih No. Surat untuk melihat pegawai.</li>
                                    </ul>
                                </div>
                            </div>
                            <div id="pegawaiContainer">
                                <!-- Pegawai terpilih akan ditambahkan di sini -->
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" style="border-top: 6px solid #fffcfc;">

                    {{-- SECTION: ISSUED TIKET --}}
                    <div class="container my-4 d-flex justify-content-center">
                        <div class="issued p-4 w-100" style="max-width: 1000px;">
                            <h5 class="mb-4">Issued Tiket</h5>
                            <div class="row gx-4">
                                {{-- administrasi --}}
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
                                                    <option value="{{ $cabang->nama_cabang }}">
                                                        {{ $cabang->nama_cabang }}
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
                                                    id="bus" name="kendaraan[]" value="Bus" />

                                                <label class="form-check-label" for="bus">Bus</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input kendaraan-checkbox" type="checkbox"
                                                    id="kereta" name="kendaraan[]" value="kereta" />

                                                <label class="form-check-label" for="kereta">Kereta</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input kendaraan-checkbox" type="checkbox"
                                                    id="pesawat" name="kendaraan[]" value="pesawat" />

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
                                                    <option value="{{ $maskapai->nama_maskapai }}">
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

                            {{-- <div class="upload-section">
                                <label for="pdf-file">Pilih file PDF tiket pesawat:</label>
                                <input type="file" id="pdf-file" multiple accept="application/pdf" />
                            </div> --}}
                            <div class="upload-section">
                                <label for="pdf_files" class="form-label">Upload File Tiket PDF</label>
                                <input type="file" name="pdf_files[]" id="pdf_files" class="form-control" accept="application/pdf" multiple required>
                            </div>
                            
                            <div class="error-message" id="error-message"></div>

                            <div class="tabel-section">
                                <table id="tickets-table" border="1" cellpadding="8" cellspacing="0"
                                    style="border-collapse: collapse; width: 100%; max-width: 800px; margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th>Nama File</th>
                                            <th>Nama Penumpang</th>
                                            <th>Nomor Penerbangan</th>
                                            <th>Tanggal</th>
                                            <th>Waktu Keberangkatan</th>
                                            <th>Bandara Asal</th>
                                            <th>Bandara Tujuan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tickets-table-body"></tbody>
                                </table>
                            </div>

                            <input type="hidden" name="tickets_data" id="tickets_data">

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-success">Submit Semua</button>
                                <button type="reset" class="btn btn-danger" id="resetBtn">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
                document.getElementById("ticketForm").addEventListener("submit", function(e) {
            const tableRows = document.querySelectorAll("#tickets-table-body tr");
            const parsedTickets = [];
    
            tableRows.forEach(row => {
                const cells = row.querySelectorAll("td");
                parsedTickets.push({
                    nama_file: row.dataset.filename || cells[0]?.innerText || "",
                    nama_penumpang: cells[1]?.innerText || "",
                    nomor_penerbangan: cells[2]?.innerText || "",
                    tanggal: cells[3]?.innerText || "",
                    waktu_berangkat: cells[4]?.innerText || "",
                    bandara_asal: cells[5]?.innerText || "",
                    bandara_tujuan: cells[6]?.innerText || ""
                });
            });
    
            document.getElementById("tickets_data").value = JSON.stringify(parsedTickets);
    
            const container = document.getElementById('pegawaiContainer');
            container.innerHTML = '';
    
            const pegawaiList = document.querySelectorAll("#listPegawai .list-group-item");
    
            pegawaiList.forEach(function(item, index) {
                const nama = item.dataset.nama;
                const departemen = item.dataset.departemen;
    
                container.innerHTML += `
                    <input type="hidden" name="pegawai[${index}][nama_pegawai]" value="${nama}">
                    <input type="hidden" name="pegawai[${index}][departemen]" value="${departemen}">
                `;
            });
        });
    
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
    
                        $.ajax({
                            url: '{{ url('/get-employees') }}/' + form_id,
                            type: 'GET',
                            dataType: 'json',
                            success: function(employees) {
                                const listPegawai = $('#listPegawai');
                                listPegawai.empty();
                                if (employees.length > 0) {
                                    employees.forEach(employee => {
                                        listPegawai.append(
                                            `<li class="list-group-item" data-nama="${employee.nama_pegawai}" data-departemen="${employee.departemen}"> ${employee.nama_pegawai} - ${employee.departemen}</li>`
                                        );
                                    });
                                } else {
                                    listPegawai.append(
                                        '<li class="list-group-item">Tidak ada pegawai yang ditemukan.</li>'
                                    );
                                }
                            },
                            error: function() {
                                alert('Gagal mengambil data pegawai');
                            }
                        });
                    }
                }
            });
        @endif
        document.getElementById("ticketForm").addEventListener("submit", function(e) {
            const tableRows = document.querySelectorAll("#tickets-table-body tr");
            const parsedTickets = [];
    
            tableRows.forEach(row => {
                const cells = row.querySelectorAll("td");
                parsedTickets.push({
                    nama_file: row.dataset.filename || cells[0]?.innerText || "",
                    nama_penumpang: cells[1]?.innerText || "",
                    nomor_penerbangan: cells[2]?.innerText || "",
                    tanggal: cells[3]?.innerText || "",
                    waktu_berangkat: cells[4]?.innerText || "",
                    bandara_asal: cells[5]?.innerText || "",
                    bandara_tujuan: cells[6]?.innerText || ""
                });
            });
    
            document.getElementById("tickets_data").value = JSON.stringify(parsedTickets);
    
            const container = document.getElementById('pegawaiContainer');
            container.innerHTML = '';
    
            const pegawaiList = document.querySelectorAll("#listPegawai .list-group-item");
            pegawaiList.forEach(function(item, index) {
                const nama = item.dataset.nama;
                const departemen = item.dataset.departemen;
    
                container.innerHTML += `
                    <input type="hidden" name="pegawai[${index}][nama_pegawai]" value="${nama}">
                    <input type="hidden" name="pegawai[${index}][departemen]" value="${departemen}">
                `;
            });
        });
    
        const pdfInput = document.getElementById('pdf_files');
        const errorMessage = document.getElementById('error-message');
    
        pdfInput.addEventListener('change', async () => {
            errorMessage.style.display = 'none';
            document.getElementById('tickets-table-body').innerHTML = '';
    
            const files = pdfInput.files;
            if (!files.length) return;
    
            for (const file of files) {
                if (file.type !== 'application/pdf') {
                    showError('Semua file harus berformat PDF.');
                    continue;
                }
    
                try {
                    const arrayBuffer = await file.arrayBuffer();
                    const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
    
                    let fullText = '';
    
                    for (let i = 1; i <= pdf.numPages; i++) {
                        const page = await pdf.getPage(i);
                        const content = await page.getTextContent();
                        const texts = content.items.map(item => item.str).join(' ');
    
                        if (texts.trim()) {
                            fullText += texts + ' ';
                        } else {
                            const ocrText = await runOCR(page);
                            fullText += ocrText + ' ';
                        }
                    }
    
                    parseTicketText(fullText, file.name);
                } catch (e) {
                    console.error(e);
                    showError(`Gagal membaca file: ${file.name}`);
                }
            }
        });
    
        function showError(msg) {
            errorMessage.textContent = msg;
            errorMessage.style.display = 'block';
        }
    
        function parseTicketText(text, fileName) {
            const t = text.toUpperCase().replace(/\s+/g, ' ');
            console.log("Text for parsing:", t);
    
            const flightNumber = extractFlightNumber(t) || detectFlightNumberByAirline(t);
            const passengerName = extractPassengerName(t) || '-';
            const flightDate = extractFlightDate(t) || '-';
            const departureTime = extractDepartureTime(t) || '-';
            const departureAirport = extractDepartureAirport(t) || '-';
            const arrivalAirport = extractArrivalAirport(t) || '-';
    
            renderInfoRow({
                fileName,
                passengerName,
                flightNumber: flightNumber || '-',
                flightDate,
                departureTime,
                departureAirport,
                arrivalAirport
            });
        }
    
        function renderInfoRow(data) {
            const tbody = document.getElementById('tickets-table-body');
            const rowIndex = tbody.querySelectorAll('tr').length;
    
            const row = document.createElement('tr');
            row.dataset.filename = data.fileName;
    
            row.innerHTML = `
                <td>${data.fileName}<input type="hidden" name="tickets[${rowIndex}][file_name]" value="${data.fileName}"></td>
                <td>${data.passengerName}<input type="hidden" name="tickets[${rowIndex}][passenger_name]" value="${data.passengerName}"></td>
                <td>${data.flightNumber}<input type="hidden" name="tickets[${rowIndex}][flight_number]" value="${data.flightNumber}"></td>
                <td>${data.flightDate}<input type="hidden" name="tickets[${rowIndex}][flight_date]" value="${data.flightDate}"></td>
                <td>${data.departureTime}<input type="hidden" name="tickets[${rowIndex}][departure_time]" value="${data.departureTime}"></td>
                <td>${data.departureAirport}<input type="hidden" name="tickets[${rowIndex}][departure_airport]" value="${data.departureAirport}"></td>
                <td>${data.arrivalAirport}<input type="hidden" name="tickets[${rowIndex}][arrival_airport]" value="${data.arrivalAirport}"></td>
            `;
    
            tbody.appendChild(row);
        }
    
        async function runOCR(page) {
            const viewport = page.getViewport({ scale: 2 });
            const canvas = document.getElementById('ocr-canvas');
            const context = canvas.getContext('2d');
    
            canvas.width = viewport.width;
            canvas.height = viewport.height;
    
            await page.render({ canvasContext: context, viewport }).promise;
    
            const imageDataUrl = canvas.toDataURL('image/png');
            const { data: { text } } = await Tesseract.recognize(imageDataUrl, 'eng', {
                logger: m => console.log(m)
            });
    
            return text;
        }
    
        function detectFlightNumberByAirline(text) {
            const airlinePrefixes = {
                'GARUDA': 'GA',
                'LION': 'JT',
                'BATIK': 'ID',
                'CITILINK': 'QG',
                'AIR ASIA': 'QZ',
                'SRIWIJAYA': 'SJ',
                'SUPER AIR': 'IU'
            };
    
            for (const keyword in airlinePrefixes) {
                if (text.includes(keyword)) {
                    const regex = new RegExp(`\\b${airlinePrefixes[keyword]}[-\\s]?(\\d{2,4})\\b`);
                    const match = text.match(regex);
                    if (match) return `${airlinePrefixes[keyword]} ${match[1]}`;
                }
            }
    
            return null;
        }
    
        function extractFlightNumber(text) {
            const match = text.match(/\b([A-Z]{2})[-\s]?(\d{1,4})\b/);
            return match ? `${match[1]} ${match[2]}` : null;
        }
    
        function extractPassengerName(text) {
            const regexes = [
                /1\s*\.\s*Tn\.?\s+([A-Z\s]+)/i,
                /Tn\.?\s+([A-Z\s]+)/i,
                /PASSENGER\s*NAME\s*:\s*([A-Z\s]+)/i,
                /NAME\s*:\s*([A-Z\s]+)/i,
                /PASSENGER\s*:\s*([A-Z\s]+)/i,
                /PAX\s*NAME\s*:\s*([A-Z\s]+)/i,
                /([A-Z]+)\/([A-Z\s]+)\s+(MR|MRS|MS|MSTR|MISS)\b/i,
                /\b(MR|MRS|MS|MSTR|MISS)\s+([A-Z\s]{3,})\b/i,
                /(?:\d+\s*\.\s*Tn\.?|Mr\.?|Mrs\.?|Miss)?\s*([A-Z]+(?:\s+[A-Z]+)+)/
            ];
    
            for (const regex of regexes) {
                const match = text.match(regex);
                if (match) {
                    if (regex.toString().includes('\\/')) {
                        return `${capitalizeWords(match[3])}. ${capitalizeWords(match[2])} ${capitalizeWords(match[1])}`;
                    } else if (regex.toString().includes('(MR|MRS|MS|MSTR|MISS)\\s+')) {
                        return `${capitalizeWords(match[1])}. ${capitalizeWords(match[2])}`;
                    } else {
                        return capitalizeWords(match[1].trim());
                    }
                }
            }
            return null;
        }
    
        function extractFlightDate(text) {
            let match = text.match(/\b(\d{1,2})\/(\d{1,2})\/(\d{4})\b/);
            if (match) return `${match[1].padStart(2, '0')}/${match[2].padStart(2, '0')}/${match[3]}`;
    
            match = text.match(/\b(\d{1,2})-(\d{1,2})-(\d{4})\b/);
            if (match) return `${match[1].padStart(2, '0')}-${match[2].padStart(2, '0')}-${match[3]}`;
    
            match = text.match(/\b(\d{1,2})\s+(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)\s+(\d{4})\b/i);
            if (match) return `${match[1].padStart(2, '0')} ${match[2].toUpperCase()} ${match[3]}`;
    
            match = text.match(/\b(?:MING|SEN|SEL|RAB|KAM|JUM|SAB|MINGGU|SENIN|SELASA|RABU|KAMIS|JUMAT|SABTU)\s+(\d{1,2})\s+([A-Z]+)\s+(\d{4})/);
            if (match) {
                const bulanMap = {
                    'januari': 'JAN', 'februari': 'FEB', 'maret': 'MAR', 'april': 'APR', 'mei': 'MAY',
                    'juni': 'JUN', 'juli': 'JUL', 'agustus': 'AUG', 'september': 'SEP',
                    'oktober': 'OCT', 'november': 'NOV', 'desember': 'DEC'
                };
                const bulan = bulanMap[match[2].toLowerCase()];
                return bulan ? `${match[1].padStart(2, '0')} ${bulan} ${match[3]}` : null;
            }
    
            return null;
        }
    
        function extractDepartureTime(text) {
            let match = text.match(/\b(\d{2}):(\d{2})\b/);
            if (match) return `${match[1]}:${match[2]}`;
            match = text.match(/\b(\d{2})(\d{2})\b/);
            if (match && parseInt(match[1]) < 24 && parseInt(match[2]) < 60) {
                return `${match[1]}:${match[2]}`;
            }
            return null;
        }
    
        function extractDepartureAirport(text) {
            let airports = text.match(/\b(CGK|SUB|DPS|JKT|BDO|LOP|SOC|HLP|KNO|UPG|DJJ|PLM|PNK|PKU|JOG|SRG|BPN|BDJ|MDC|KOE|LBJ|TIM|AMQ)\b/);
            if (airports) return airports[0];
            let match = text.match(/(?:DEP|FROM|ORIGIN)[:\s]*([A-Z]{3})/);
            return match ? match[1] : null;
        }
    
        function extractArrivalAirport(text) {
            let airports = text.match(/\b(CGK|SUB|DPS|JKT|BDO|LOP|SOC|HLP|KNO|UPG|DJJ|PLM|PNK|PKU|JOG|SRG|BPN|BDJ|MDC|KOE|LBJ|TIM|AMQ)\b/gi);
            return airports && airports.length > 1 ? airports[1] : null;
        }
    
        function capitalizeWords(str) {
            return str.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase());
        }
    </script>
    

@endsection
