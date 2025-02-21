@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="print-area" id="print-area">
            <div class="card" id="surat-tugas-card">
                <div class="card-body">
                    <div class="header">
                        <div class="logo-left">
                            <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="img-fluid">
                        </div>
                        <div class="company-info">
                            <p class="company-name"><strong>HEAD OFFICE JORDAN BAKERY</strong></p>
                            <p class="company-address">
                                Jl. Batujajar No.201, Desa Laksana Mekar<br>
                                Kec. Padalarang, Kab. Bandung Barat
                            </p>
                        </div>
                        <div class="logo-right">
                            <img src="{{ asset('dist/img/logo1.jpeg') }}" alt="Logo Jordan" class="img-fluid">
                        </div>
                    </div>

                    <hr class="header-line">
                    <div
                        style="position: absolute; top: 0; right: 0; font-size: 10pt; font-weight: bold; text-align: right;">
                        <strong>{{ $form->no_catatan_mutu }}</strong>
                    </div>

                    <div class="letter-content">
                        <p class="text-center title">SURAT TUGAS</p>
                        <p class="text-center letter-number">No. 001/ST-I/2025</p>

                        <div class="person-info">
                            <p style="margin-bottom: 0.1cm;">
                                <span class="label">Nama</span>: <strong id="selectedUser">Pilih User</strong>
                            </p>
                            <p style="margin-bottom: 0.1cm;"><span class="label">Jabatan</span>: HRD-HO</p>
                            <p style="margin-bottom: 0.1cm;"><span class="label">Alamat</span>: Jl.Raya Batujajar No.201 RT
                                02/RW 05,</p>
                            <p style="margin-left: 100px; margin-bottom: 0.1cm;">Desa Laksana Mekar - Bandung Barat</p>
                        </div>
                        <div class="reference">
                            <p>Berdasarkan Pengajuan No. {{ $form->no_surat }} :</p>
                            <hr class="header-line">
                            <div
                                style="position: absolute; top: 0; right: 0; padding: 10px; font-size: 10pt; font-weight: bold; text-align: right;">
                                HRD-32 Rev.00
                            </div>

                            <div class="assignment">
                                <h5 class="text-center" style="font-size: 12pt; margin-bottom: 0.2cm;">
                                    <strong>MENUGASKAN:</strong>
                                </h5>
                                <table class="table table-bordered" id="pegawai-table"
                                    style="width: 100%; border-collapse: collapse; font-size: 10pt;">
                                    <thead>
                                        <tr>
                                            <th style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">No
                                            </th>
                                            <th style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">NIK
                                            </th>
                                            <th style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">Nama
                                            </th>
                                            <th style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">
                                                Cabang</th>
                                            <th style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">Lama
                                                Keberangkatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">
                                                    {{ $item->nik }}
                                                </td>
                                                <td style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">
                                                    {{ $item->nama_pegawai }}
                                                </td>
                                                <td style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">
                                                    {{ $form->cabang_asal }} / {{ $item->departemen }}
                                                </td>
                                                <td style="border: 0.5pt solid #000; padding: 0.15cm; text-align: center;">
                                                    {{ $item->lama_keberangkatan }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    style="text-align: center; border: 0.5pt solid #000; padding: 0.15cm;">
                                                    Tidak ada data untuk Form ID: {{ $targetFormId }}.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="destination">
                                <p>Ke cabang <strong>"{{ $form->cabang_tujuan }}"</strong> untuk
                                    <strong>"{{ $form->tujuan }}"</strong>
                                </p>
                            </div>

                            <div class="closing">
                                <p>Demikian surat tugas ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
                            </div>

                            <div class="signature" style="display: flex; flex-direction: column; align-items: flex-end;">
                                <p>Hormat kami,</p>
                                <img id="userSignature" src="" alt="Tanda Tangan"
                                    style="width: 150px; height: auto; display: none;">
                                {{-- <p><strong id="selectedUser"> {{ $user->nama_lengkap }}
                                    </strong></p> --}}
                            </div>

                            <div
                                style="position: absolute; bottom: 0; left: 0; width: 100%; text-align: left; font-size: 10pt; font-style: italic;">
                                *Ket
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button onclick="exportToPDF()" class="btn btn-primary">Export to PDF</button>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script>
            function exportToPDF() {
                const {
                    jsPDF
                } = window.jspdf;
                let doc = new jsPDF();

                doc.text("Surat Tugas", 10, 10);
                doc.text(document.getElementById("print-area").innerText, 10, 20);

                doc.save("Surat_Tugas.pdf");
            }
        </script>

        <style>
            body {
                font-family: 'Times New Roman', serif;
                font-size: 11pt;
                /* Reduced font size */
                margin: 0;
            }

            .container {
                max-width: 21cm;
                margin: 8px auto;
                /* Further reduced margin */
            }

            #surat-tugas-card {
                padding: 0.8cm;
                /* Reduced padding */
            }

            .header {
                position: relative;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 0.2cm;
                /* Reduced margin */
            }

            .logo-left,
            .logo-right {
                width: 15%;
            }

            .logo-left img,
            .logo-right img {
                max-width: 100%;
                height: auto;
            }

            .company-info {
                text-align: center;
                width: 70%;
                /* Reduced width for balance */
            }

            .company-name {
                font-size: 14pt;
                margin-bottom: 0.1cm;
            }

            .company-address {
                font-size: 11pt;
                line-height: 1.1;
                text-align: center;
                margin: 0;
            }

            .header-line {
                border-top: 1px solid #2b2a2a;
                margin-bottom: 0.2cm;
                /* Reduced margin */
            }

            .title {
                font-size: 14pt;
                /* Slightly reduced title size */
                font-weight: bold;
                margin-bottom: 0.1cm;
                /* Reduced margin */
            }

            .letter-number {
                font-size: 10pt;
                /* Reduced letter number size */
                margin-bottom: 0.4cm;
                /* Reduced margin */
            }

            .person-info,
            .reference,
            .destination,
            .closing {
                font-size: 11pt;
                margin-bottom: 0.2cm;
                /* Reduced margin */
            }

            .person-info .label {
                display: inline-block;
                width: 2.5cm;
                /* Slightly reduced width */
                font-weight: bold;
            }

            .assignment {
                margin-bottom: 0.4cm;
                /* Reduced margin */
            }

            .table {
                width: 80%;
                border-collapse: collapse;
                font-size: 10pt;
                /* Smaller table font */
                margin-bottom: 0;
            }

            /* .table th,
            .table td {
            border: 0.5pt solid #000;
            padding: 0.1cm;
             /* Further reduced padding */
            /* text-align: center;
            } */
            */ .signature {
                margin-top: 0.3cm;
                /* Reduced margin */
            }

            .text-right {
                text-align: right;
                font-size: 11pt;
                /* Slightly reduced signature font size */
            }

            @media print {
                @page {
                    size: A4;
                    margin: 0.5cm;
                    /* Further reduced margin for print */
                }

                body {
                    font-family: 'Times New Roman', serif;
                    font-size: 8pt;
                    /* Smaller font for printing */
                }

                .container {
                    max-width: 19cm;
                    padding: 0;
                }

                #surat-tugas-card {
                    padding: 1cm;
                    /* Reduced padding for print */
                    max-width: 19cm;
                    margin: 0 auto;
                }

                .table {
                    font-size: 9pt;
                    /* Smaller font for print */
                }

                .table th,
                .table td {
                    padding: 0.08cm;
                    /* Further reduced padding */
                }

                .logo-left img,
                .logo-right img {
                    max-width: 70%;
                    /* Reduced logo size for print */
                }

                .title {
                    font-size: 12pt;
                    /* Smaller title font for print */
                }

                .letter-number {
                    font-size: 8pt;
                    /* Smaller letter number font */
                }

                .action-buttons {
                    display: none;
                    /* Hide action buttons on print */
                }
            }
        </style>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <script>
            function updateUserInfo(selectElement) {
                let selectedOption = selectElement.options[selectElement.selectedIndex];

                let nama = selectedOption.getAttribute('data-nama');
                let ttd = selectedOption.getAttribute('data-ttd');

                // Pastikan elemen ada sebelum mengubah teksnya
                let namaElement = document.getElementById('selectedUser');
                if (namaElement) {
                    namaElement.textContent = nama ? nama : "Nama Tidak Ditemukan";
                }

                // Update Gambar Tanda Tangan
                let signatureImg = document.getElementById('userSignature');
                if (signatureImg) {
                    if (ttd) {
                        signatureImg.src = "/storage/signatures/" + ttd; // Pastikan path benar
                        signatureImg.style.display = "block"; // Tampilkan gambar
                    } else {
                        signatureImg.style.display = "none"; // Sembunyikan jika tidak ada tanda tangan
                    }
                }
            }


            function exportToPDF() {
                const {
                    jsPDF
                } = window.jspdf;
                const printArea = document.getElementById('print-area');

                // Sembunyikan dropdown sebelum mengambil gambar
                const dropdown = document.getElementById('userDropdown');
                dropdown.style.display = 'none';

                html2canvas(printArea, {
                    scale: 2
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF('p', 'mm', 'a4');
                    const width = pdf.internal.pageSize.getWidth();
                    const height = (canvas.height * width) / canvas.width;
                    pdf.addImage(imgData, 'PNG', 0, 0, width, height);
                    pdf.save("surat_tugas.pdf");

                    // Tampilkan kembali dropdown setelah export selesai
                    dropdown.style.display = 'block';
                });
            }
        </script>
    @endsection
