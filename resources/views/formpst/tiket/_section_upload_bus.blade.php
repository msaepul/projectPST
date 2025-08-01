

<div class="upload-section" id="upload-section-bus" style="display: none;">
    <label for="pdf_files_bus" class="form-label">Upload File Tiket PDF TRAVEL</label>
    <input type="file" name="pdf_files_bus[]" id="pdf_files_bus" class="form-control" accept="application/pdf" multiple
        >

    <div class="error-message" id="error-message-bus"></div>

    <div class="tabel-section">
        <table id="bus-tickets-table" border="1" cellpadding="8" cellspacing="0"
            style="border-collapse: collapse; width: 100%; max-width: 800px; margin-top: 20px;">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Nama Penumpang</th>
                    <th>Nama Bus</th>
                    <th>Tanggal</th>
                    <th>Jam Keberangkatan</th>
                    <th>Terminal Asal</th>
                    <th>Terminal Tujuan</th>
                </tr>
            </thead>
            <tbody id="bus-tickets-table-body"></tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.4.120/build/pdf.min.js"></script>
<script>
    document.getElementById('pdf_files_bus').addEventListener('change', async function(event) {
        const files = event.target.files;
        const tableBody = document.getElementById('bus-tickets-table-body');
        tableBody.innerHTML = '';

        for (const file of files) {
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

            // === PARSING SEDERHANA BUS ===
            let namaBus = (fullText.match(/Bus\s*Name\s*:\s*([A-Za-z0-9\s]+)/i) || [])[1]?.trim() ||
                'Bus Name';
            let tanggal = (fullText.match(/Departure\s*Date\s*:\s*([0-9/]+)/i) || [])[1] || '';
            let jam = (fullText.match(/Departure\s*Time\s*:\s*([0-9:]+)/i) || [])[1] || '';
            let asal = (fullText.match(/From\s*:\s*([A-Za-z\s]+)/i) || [])[1]?.trim() || '';
            let tujuan = (fullText.match(/To\s*:\s*([A-Za-z\s]+)/i) || [])[1]?.trim() || '';

            // Ambil nama penumpang (misalnya dari baris "Passenger: Nama")
            const penumpangRegex = /Passenger\s*:\s*([A-Za-z\s]+)/g;
            const penumpangs = [];
            let match;
            while ((match = penumpangRegex.exec(fullText)) !== null) {
                penumpangs.push(match[1].trim());
            }

            if (penumpangs.length === 0) penumpangs.push('Nama Penumpang');

            penumpangs.forEach(nama => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td><input type="text" class="form-control" value="${file.name}" readonly></td>
                <td><input type="text" class="form-control" value="${nama}"></td>
                <td><input type="text" class="form-control" value="${namaBus}"></td>
                <td><input type="text" class="form-control" value="${tanggal}"></td>
                <td><input type="text" class="form-control" value="${jam}"></td>
                <td><input type="text" class="form-control" value="${asal}"></td>
                <td><input type="text" class="form-control" value="${tujuan}"></td>
            `;
                tableBody.appendChild(row);
            });
        }
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
