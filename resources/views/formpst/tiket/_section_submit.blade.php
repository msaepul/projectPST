<div class="d-flex justify-content-end gap-2 mt-4">
    <button type="button" class="btn btn-success" id="submitAllBtn">Submit Semua</button>
    <button type="reset" class="btn btn-danger" id="resetBtn">Reset</button>
</div>

<script>
    document.getElementById('submitAllBtn').addEventListener('click', async function (e) {
        const form = document.getElementById('ticketForm');
        const formData = new FormData(form);
    
        // Ambil file PDF dari input pesawat
        const pesawatFiles = document.getElementById('pdf_files')?.files || [];
        for (let i = 0; i < pesawatFiles.length; i++) {
            formData.append(`tickets[${i}][file_upload]`, pesawatFiles[i]);
        }
    
        // Ambil file PDF dari input kereta
        const keretaFiles = document.getElementById('train_pdf_files')?.files || [];
        for (let i = 0; i < keretaFiles.length; i++) {
            formData.append(`train_tickets[${i}][file_upload]`, keretaFiles[i]);
        }
    
        // Kirim manual pakai fetch
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
        });
    
        if (response.ok) {
            window.location.href = "{{ route('formpst.show_ticket') }}"; // arahkan ke halaman list tiket
        } else {
            alert('Gagal menyimpan data');
        }
    });
    </script>
    