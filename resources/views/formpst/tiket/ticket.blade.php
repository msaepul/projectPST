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
            <div class="card-header marquee-container">
                <div class="marquee-content">
                    <span id="current-date"></span> -
                    <span id="current-time"></span> &nbsp; | &nbsp;
                    FORM PENGAJUAN TIKET &nbsp; | &nbsp; Selamat Beraktivitas
                    {{ Auth::user()->name }} !!!
                </div>
            </div>


            <div class="card-body main-card-body">

                <form action="{{ route('store_ticket') }}" method="POST" enctype="multipart/form-data" id="ticketForm">
                    @csrf

                    @include('formpst.tiket._section_surat')
                    @include('formpst.tiket._section_administrasi')
                    @include('formpst.tiket._section_upload_bus')
                    @include('formpst.tiket._section_upload_kereta')
                    @include('formpst.tiket._section_upload_pesawat')
                    @include('formpst.tiket._section_submit')

                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            @if (empty($prefill))
                $('#no_surat').on('change', function() {
                    const selected = $('#no_surat option:selected');
                    const formId = selected.val();
                    const noSurat = selected.data('no_surat');

                    $('#hidden_no_surat').val(noSurat);

                    if (formId === 'lainnya') {
                        $('#lampiranSection').show();
                        $('#nama_pemohon').val('');
                        $('#yang_menugaskan').val('');
                        $('#listPegawai').html('<li class="list-group-item">Masukkan pegawai manual.</li>');
                        return;
                    }

                    $.ajax({
                        url: '{{ url('/get-pemohon') }}/' + formId,
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
                        url: '{{ url('/get-employees') }}/' + formId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(employees) {
                            const listPegawai = $('#listPegawai');
                            listPegawai.empty();

                            if (employees.length > 0) {
                                employees.forEach(employee => {
                                    listPegawai.append(`
                                    <li class="list-group-item" data-nama="${employee.nama_pegawai}" data-departemen="${employee.departemen}">
                                        ${employee.nama_pegawai} - ${employee.departemen}
                                    </li>`);
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
                });
            @endif

            function handleTicketFormSubmit(e) {
                e.preventDefault();
                console.log("SUBMIT DITEKAN");

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

                e.target.submit();
            }

            const form = document.getElementById("ticketForm");
            if (form) {
                form.addEventListener("submit", handleTicketFormSubmit);
            }

            function updateDateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
                document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID');
            }

            setInterval(updateDateTime, 1000);
            updateDateTime();

            document.getElementById('resetBtn').addEventListener('click', function() {
                document.getElementById('tickets-table-body').innerHTML = '';
                document.getElementById('tickets_data').value = '';
                document.getElementById('pegawaiContainer').innerHTML = '';
                document.getElementById('listPegawai').innerHTML =
                    '<li class="list-group-item">Pilih No. Surat untuk melihat pegawai.</li>';
                document.getElementById('manualNoSuratContainer').style.display = 'none';
            });

            // Checkbox toggle kendaraan
            const pesawatCheckbox = document.getElementById("pesawat");
            const keretaCheckbox = document.getElementById("kereta");
            const busCheckbox = document.getElementById("bus");

            const dropdownPesawat = document.getElementById("dropdown-pesawat");
            const dropdownKereta = document.getElementById("dropdown-kereta");
            const dropdownBus = document.getElementById("dropdown-bus");

            const uploadSectionPesawat = document.getElementById("upload-section-pesawat");
            const uploadSectionBus = document.getElementById("upload-section-bus");
            const uploadSectionKereta = document.getElementById("upload-section-kereta");


            function toggleDropdowns() {
                dropdownPesawat.style.display = pesawatCheckbox.checked ? "block" : "none";
                dropdownKereta.style.display = keretaCheckbox.checked ? "block" : "none";
                dropdownBus.style.display = busCheckbox.checked ? "block" : "none";
                uploadSectionPesawat.style.display = pesawatCheckbox.checked ? "block" : "none";
                uploadSectionBus.style.display = busCheckbox.checked ? "block" : "none";
                uploadSectionKereta.style.display = keretaCheckbox.checked ? "block" : "none";

            }

            pesawatCheckbox.addEventListener("change", toggleDropdowns);
            keretaCheckbox.addEventListener("change", toggleDropdowns);
            busCheckbox.addEventListener("change", toggleDropdowns);

            toggleDropdowns();
        });
    </script>
@endsection
