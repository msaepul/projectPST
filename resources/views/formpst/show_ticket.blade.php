@extends('layouts.main')

@section('content')
    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow">
            <div class="card-header bg-light py-3">
                <h4 class="mb-0 fw-bold text-dark">List Keberangkatan</h4>
            </div>
            <div class="container py-4">
                <div class="row g-3">
                    @foreach ($ticketing as $info)
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-sm border-0 h-100 hover-shadow transition rounded-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="text-primary fw-bold">
                                            <i class="bi bi-file-earmark-text me-1"></i>
                                            {{ $info->no_surat ?? $info->id }}
                                        </div>
                                        <span class="badge bg-light text-dark border">
                                            {{ ucfirst($info->transport) }}
                                        </span>
                                    </div>

                                    <p class="mb-1 small text-muted">Detail Tiket</p>

                                    <div class="mb-2">
                                        <i class="bi bi-person-fill me-1"></i>
                                        <strong>Nama Pemohon:</strong> {{ $info->nama_pemohon }}
                                    </div>
                                    <div class="mb-2">
                                        <i class="bi bi-building me-1"></i>
                                        <strong>Agent:</strong> {{ $info->agent }}
                                    </div>
                                    <div class="mb-2">
                                        <i class="bi bi-airplane-engines me-1"></i>
                                        <strong>Maskapai:</strong> {{ $info->maskapai }}
                                    </div>

                                    <div class="d-grid mt-3">
                                        <button class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center gap-1 btn-detail-flight"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#flightDetailModal"
                                            data-id="{{ $info->id }}">
                                            <i class="bi bi-airplane"></i> Lihat Penerbangan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail Penerbangan --}}
    <div class="modal fade" id="flightDetailModal" tabindex="-1" aria-labelledby="flightDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="flightDetailModalLabel">Detail Penerbangan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="flight-details-content">
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .card-body p { font-size: 0.9rem; }
        .card-body i { width: 1.2rem; }
        .card { transition: all 0.3s ease; }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        .btn-detail-flight { transition: 0.3s ease; }
        .btn-detail-flight:hover {
            background-color: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }
        .hover-shadow:hover {
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
            transition: all 0.2s ease-in-out;
        }
        .transition { transition: all 0.3s ease-in-out; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailButtons = document.querySelectorAll('.btn-detail-flight');
            const detailContainer = document.getElementById('flight-details-content');

            function formatTanggal(tanggal) {
                const monthNames = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGU", "SEP", "OKT", "NOV",
                    "DES"
                ];
                const dateObj = new Date(tanggal);
                const day = String(dateObj.getDate()).padStart(2, '0');
                const month = monthNames[dateObj.getMonth()];
                const year = dateObj.getFullYear();
                return `${day} ${month} ${year}`;
            }

            function convertToInputDate(str) {
                const [day, monthStr, year] = str.split(' ');
                const monthNames = {
                    JAN: '01',
                    FEB: '02',
                    MAR: '03',
                    APR: '04',
                    MEI: '05',
                    JUN: '06',
                    JUL: '07',
                    AGU: '08',
                    SEP: '09',
                    OKT: '10',
                    NOV: '11',
                    DES: '12'
                };
                return `${year}-${monthNames[monthStr]}-${day}`;
            }

            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const ticketId = this.dataset.id;
                    detailContainer.innerHTML = '';
                    detailContainer.classList.add('loading');

                    fetch(`/get-ticket-details/${ticketId}`)
                        .then(response => response.json())
                        .then(data => {
                            const {
                                ticket,
                                details
                            } = data;
                            detailContainer.classList.remove('loading');

                            if (!details.length) {
                                detailContainer.innerHTML =
                                    '<p class="text-muted">Tidak ada data penerbangan.</p>';
                                return;
                            }

                            let html = `
                            <div class="mb-4">
                                <h5 class="fw-bold mb-0">Nama Pemohon: 
                                    <span class="text-primary">${ticket.assigned_By}</span>
                                </h5>
                            </div>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                        `;

                            details.forEach(item => {
                                html += `
                                <div class="col">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body position-relative">
                                            <button 
                                                class="btn btn-sm btn-outline-warning position-absolute top-0 end-0 m-2 btn-edit-penumpang"
                                                data-detail-id="${item.id}"
                                                data-ticket-id="${ticket.id}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <h6 class="fw-semibold text-dark mb-2">
                                                <i class="bi bi-person-badge-fill me-1 text-primary"></i>${item.passenger_name}
                                            </h6>
                                            <ul class="list-unstyled mb-0 small">
                                                <li class="mb-1"><strong>Flight No:</strong> ${item.flight_number}</li>
                                                <li class="mb-1"><strong>Tanggal:</strong> ${formatTanggal(item.flight_date)}</li>
                                                <li class="mb-1"><strong>Jam:</strong> ${item.departure_time}</li>
                                                <li class="mb-1"><strong>Asal:</strong> ${item.departure_airport}</li>
                                                <li class="mb-1"><strong>Tujuan:</strong> ${item.arrival_airport}</li>
                                                <li><strong>File:</strong> ${
                                                    item.file_name 
                                                        ? `<a href="/storage/tickets/${item.file_name}" target="_blank">Lihat File</a>` 
                                                        : '<span class="text-muted">Tidak ada</span>'
                                                }</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            `;
                            });

                            html += '</div>';
                            detailContainer.innerHTML = html;

                            // Event edit
                            document.querySelectorAll('.btn-edit-penumpang').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const card = this.closest('.card-body');
                                    const detailId = this.dataset.detailId;
                                    const ticketId = this.dataset.ticketId;

                                    const name = card.querySelector('h6')
                                        .innerText.trim();
                                    const listItems = card.querySelectorAll(
                                        'ul li');
                                    const flightNo = listItems[0].innerText
                                        .split(':')[1].trim();
                                    const flightDate = listItems[1].innerText
                                        .split(':')[1].trim();
                                    const departureTime = listItems[2].innerText
                                        .split(':')[1].trim();
                                    const departureAirport = listItems[3]
                                        .innerText.split(':')[1].trim();
                                    const arrivalAirport = listItems[4]
                                        .innerText.split(':')[1].trim();

                                    card.innerHTML = `
                                    <form class="edit-penumpang-form">
                                        <div class="mb-2">
                                            <label>Nama Penumpang</label>
                                            <input type="text" class="form-control form-control-sm" name="passenger_name" value="${name}" />
                                        </div>
                                        <div class="mb-2">
                                            <label>Flight Number</label>
                                            <input type="text" class="form-control form-control-sm" name="flight_number" value="${flightNo}" />
                                        </div>
                                        <div class="mb-2">
                                            <label>Tanggal Penerbangan</label>
                                            <input type="date" class="form-control form-control-sm" name="flight_date" value="${convertToInputDate(flightDate)}" />
                                        </div>
                                        <div class="mb-2">
                                            <label>Jam Keberangkatan</label>
                                            <input type="time" class="form-control form-control-sm" name="departure_time" value="${departureTime}" />
                                        </div>
                                        <div class="mb-2">
                                            <label>Bandara Asal</label>
                                            <input type="text" class="form-control form-control-sm" name="departure_airport" value="${departureAirport}" />
                                        </div>
                                        <div class="mb-2">
                                            <label>Bandara Tujuan</label>
                                            <input type="text" class="form-control form-control-sm" name="arrival_airport" value="${arrivalAirport}" />
                                        </div>
                                        <div class="d-flex justify-content-end gap-2 mt-3">
                                            <button type="button" class="btn btn-sm btn-secondary btn-cancel-edit">Batal</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                `;

                                    card.querySelector('.btn-cancel-edit')
                                        .addEventListener('click', () => {
                                            fetch(
                                                    `/get-ticket-details/${ticketId}`
                                                    )
                                                .then(res => res.json())
                                                .then(() => {
                                                    const modalTrigger =
                                                        document
                                                        .querySelector(
                                                            `.btn-detail-flight[data-id="${ticketId}"]`
                                                        );
                                                    modalTrigger
                                                        .click();
                                                });
                                        });

                                    card.querySelector('.edit-penumpang-form')
                                        .addEventListener('submit', function(
                                            e) {
                                            e.preventDefault();

                                            const formData = new FormData(
                                                this);
                                            fetch(`/update-ticket-detail/${detailId}`, {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: formData
                                                })
                                                .then(res => res.json())
                                                .then(res => {
                                                    if (res.success) {
                                                        alert(
                                                            'Berhasil disimpan!'
                                                            );
                                                        const
                                                            modalTrigger =
                                                            document
                                                            .querySelector(
                                                                `.btn-detail-flight[data-id="${ticketId}"]`
                                                            );
                                                        modalTrigger
                                                            .click();
                                                    } else {
                                                        alert(
                                                            'Gagal menyimpan!'
                                                            );
                                                    }
                                                })
                                                .catch(err => {
                                                    console.error(err);
                                                    alert(
                                                        'Terjadi kesalahan saat menyimpan!'
                                                        );
                                                });
                                        });
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching flight details:', error);
                            detailContainer.classList.remove('loading');
                            detailContainer.innerHTML =
                                '<p class="text-danger">Gagal memuat data.</p>';
                        });
                });
            });
        });
    </script>
@endpush
