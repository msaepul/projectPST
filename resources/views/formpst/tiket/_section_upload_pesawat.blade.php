<div class="upload-section" id="upload-section-pesawat" style="display: none;">
    <label for="pdf_files" class="form-label">Upload File Tiket PDF PESAWAT</label>
    <input type="file" name="pdf_files[]" id="pdf_files" class="form-control" accept="application/pdf" multiple>



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
</div>

<script>
    // ticket-pesawat-parser.js

    const pdfInput = document.getElementById('pdf_files');
    const errorMessage = document.getElementById('error-message');

    if (pdfInput) {
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
                    const pdf = await pdfjsLib.getDocument({
                        data: arrayBuffer
                    }).promise;

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
    }

    function showError(msg) {
        errorMessage.textContent = msg;
        errorMessage.style.display = 'block';
    }

    function parseTicketText(text, fileName) {
        const t = text.toUpperCase().replace(/\s+/g, ' ');
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
        <td><input type="text" class="form-control" name="tickets[${rowIndex}][file_name]" value="${data.fileName}"></td>
        <td><input type="text" class="form-control" name="tickets[${rowIndex}][passenger_name]" value="${data.passengerName}"></td>
        <td><input type="text" class="form-control" name="tickets[${rowIndex}][flight_number]" value="${data.flightNumber}"></td>
        <td><input type="text" class="form-control" name="tickets[${rowIndex}][flight_date]" value="${data.flightDate}"></td>
        <td><input type="text" class="form-control" name="tickets[${rowIndex}][departure_time]" value="${data.departureTime}"></td>
        <td><input type="text" class="form-control" name="tickets[${rowIndex}][departure_airport]" value="${data.departureAirport}"></td>
        <td><input type="text" class="form-control" name="tickets[${rowIndex}][arrival_airport]" value="${data.arrivalAirport}"></td>
    `;

        tbody.appendChild(row);
    }

    async function runOCR(page) {
        const viewport = page.getViewport({
            scale: 2
        });
        const canvas = document.getElementById('ocr-canvas');
        const context = canvas.getContext('2d');

        canvas.width = viewport.width;
        canvas.height = viewport.height;

        await page.render({
            canvasContext: context,
            viewport
        }).promise;

        const imageDataUrl = canvas.toDataURL('image/png');
        const {
            data: {
                text
            }
        } = await Tesseract.recognize(imageDataUrl, 'eng', {
            logger: m => console.log(m)
        });

        return text;
    }

    // Extraction logic
    function extractFlightNumber(text) {
        const match = text.match(/\b([A-Z]{2})[-\s]?(\d{1,4})\b/);
        return match ? `${match[1]} ${match[2]}` : null;
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

        match = text.match(
            /\b(?:MING|SEN|SEL|RAB|KAM|JUM|SAB|MINGGU|SENIN|SELASA|RABU|KAMIS|JUMAT|SABTU)\s+(\d{1,2})\s+([A-Z]+)\s+(\d{4})/
            );
        if (match) {
            const bulanMap = {
                'januari': 'JAN',
                'februari': 'FEB',
                'maret': 'MAR',
                'april': 'APR',
                'mei': 'MAY',
                'juni': 'JUN',
                'juli': 'JUL',
                'agustus': 'AUG',
                'september': 'SEP',
                'oktober': 'OCT',
                'november': 'NOV',
                'desember': 'DEC'
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
        let airports = text.match(
            /\b(CGK|SUB|DPS|JKT|BDO|LOP|SOC|HLP|KNO|UPG|DJJ|PLM|PNK|PKU|JOG|SRG|BPN|BDJ|MDC|KOE|LBJ|TIM|AMQ)\b/);
        if (airports) return airports[0];
        let match = text.match(/(?:DEP|FROM|ORIGIN)[:\s]*([A-Z]{3})/);
        return match ? match[1] : null;
    }

    function extractArrivalAirport(text) {
        let airports = text.match(
            /\b(CGK|SUB|DPS|JKT|BDO|LOP|SOC|HLP|KNO|UPG|DJJ|PLM|PNK|PKU|JOG|SRG|BPN|BDJ|MDC|KOE|LBJ|TIM|AMQ)\b/gi);
        return airports && airports.length > 1 ? airports[1] : null;
    }

    function capitalizeWords(str) {
        return str.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase());
    }
</script>
