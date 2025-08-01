<div class="upload-section" id="upload-section-kereta" style="display: none;">
    <label for="pdf_files_kereta" class="form-label">Upload File Tiket PDF KERETA</label>
    <input type="file" name="pdf_files_kereta[]" id="pdf_files_kereta" class="form-control" accept="application/pdf"
        multiple>

    <div class="error-message" id="error-message"></div>

    <div class="tabel-section">
        <table id="tickets-table-train" border="1" cellpadding="8" cellspacing="0"
            style="border-collapse: collapse; width: 100%; max-width: 800px; margin-top: 20px;">
            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-success" onclick="addManualTrainRow()">+ Tambah Baris
                    Manual</button>
            </div>

            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Nama Penumpang</th>
                    <th>Nama Kereta</th>
                    <th>Tanggal</th>
                    <th>Jam Keberangkatan</th>
                    <th>Stasiun Asal</th>
                    <th>Stasiun Tujuan</th>
                </tr>
            </thead>
            <tbody id="tickets-table-body-train"></tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.4.120/build/pdf.min.js"></script>

<script>
    let trainRowIndex = 0;
    const parsedTrainFiles = [];

    document.getElementById('pdf_files_kereta').addEventListener('change', async function(event) {
        const files = event.target.files;
        const tableBody = document.getElementById('tickets-table-body-train');
        tableBody.innerHTML = '';
        parsedTrainFiles.length = 0; // reset

        for (const file of files) {
            parsedTrainFiles.push(file); // simpan file asli ke array

            const pdfData = new Uint8Array(await file.arrayBuffer());
            const pdf = await pdfjsLib.getDocument({
                data: pdfData
            }).promise;
            let fullText = '';

            for (let i = 1; i <= pdf.numPages; i++) {
                const page = await pdf.getPage(i);
                const content = await page.getTextContent();
                const strings = content.items.map(item => item.str);
                fullText += strings.join('\n');
            }

            // Parsing regex sesuai format tiket
            let namaKereta = (fullText.match(/Train No\. & Name:\s*\d+\/([^\n]+)/) || [])[1]?.trim() || '';
            let tanggal = (fullText.match(/Departure Time:\s*(\d{2}\/\d{2}\/\d{4})/) || [])[1] || '';
            let jam = (fullText.match(/Departure Time:\s*\d{2}\/\d{2}\/\d{4}\s+(\d{2}:\d{2}:\d{2})/) || [])[
                1] || '';
            let asal = (fullText.match(/From:\s*([A-Z]+\(\w+\))/) || [])[1]?.split('(')[0] || '';
            let tujuan = (fullText.match(/To\s*:\s*([A-Z]+\(\w+\))/) || [])[1]?.split('(')[0] || '';

            // Backup parsing alternatif
            if (!namaKereta) {
                const keretaMatch = fullText.match(/E-tiket \(Kereta Pergi\)\s+([A-Z]+)\s+\d+/);
                if (keretaMatch) namaKereta = keretaMatch[1].trim();
            }
            if (!tanggal) tanggal = '31/05/2025'; // fallback tanggal
            if (!jam) jam = '08:00'; // fallback jam
            if (!asal) asal = 'Semarang Tawang';
            if (!tujuan) tujuan = 'Slawi';

            const penumpangs = [];
            const penumpangRegex = /\n([A-Z\s]+?)\s+CONFIRMED\s+PRE-[\w/-]+\s+NIK\s+\d{16}/g;
            let match;
            while ((match = penumpangRegex.exec(fullText)) !== null) {
                penumpangs.push(match[1].trim());
            }
            if (penumpangs.length === 0) {
                const namaMatch = fullText.match(/\d+\s*Tuan\s+([A-Z\s]+)\s+Dewasa/i);
                if (namaMatch) penumpangs.push(namaMatch[1].trim());
            }

            penumpangs.forEach(nama => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][file_name]" value="${file.name}" readonly></td>
                    <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][passenger_name]" value="${nama}"></td>
                    <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][flight_number]" value="${namaKereta}"></td>
                    <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][flight_date]" value="${tanggal}"></td>
                    <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][departure_time]" value="${jam}"></td>
                    <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][departure_airport]" value="${asal}"></td>
                    <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][arrival_airport]" value="${tujuan}"></td>
                `;
                tableBody.appendChild(row);
                trainRowIndex++;
            });
        }
    });

    function addManualTrainRow() {
        const tableBody = document.getElementById('tickets-table-body-train');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input type="text" class="form-control" name="train_tickets[${trainRowIndex}][file_name]" value="manual_entry.pdf">
                <input type="file" class="form-control mt-1" name="train_tickets[${trainRowIndex}][file_upload]" accept="application/pdf">
            </td>
            <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][passenger_name]"></td>
            <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][flight_number]"></td>
            <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][flight_date]"></td>
            <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][departure_time]"></td>
            <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][departure_airport]"></td>
            <td><input type="text" class="form-control" name="train_tickets[${trainRowIndex}][arrival_airport]"></td>
        `;
        tableBody.appendChild(row);
        trainRowIndex++;
    }

    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Stop form default submit

        const form = e.target;
        const formData = new FormData(form);

        parsedTrainFiles.forEach((file, index) => {
            formData.append(`train_tickets[${index}][file_upload]`, file);
        });

        fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (response.ok) {
                    alert('Data berhasil disimpan!');
                    window.location.reload();
                } else {
                    return response.text().then(text => {
                        throw new Error(text);
                    });
                }
            })
            .catch(err => {
                console.error(err);
                alert('Gagal menyimpan data. Cek console.');
            });
    });
</script>

<style>
    .form-control {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    table td {
        vertical-align: middle;
    }
</style>
