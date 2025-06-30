@extends('layouts.main')

@section('content')
    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow">
            <div class="card-header bg-light py-3">
                <h4 class="Judul mb-0 fw-bold text-dark">List Keberangkatan</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-primary text-white">
                                <th scope="col" style="text-align: center;">No. surat</th>
                                <th scope="col" style="text-align: center;">Nama Pemohon</th>
                                <th scope="col" style="text-align: center;">Kendaraan</th>
                                <th scope="col" style="text-align: center;">Agent</th>
                                <th scope="col" style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->no_surat }}</td>
                                    <td>{{ $info->nama_pemohon }}</td>
                                    <td>{{ $info->kendaraan }}</td>
                                    <td>{{ $info->agent }}</td>
                                    <td class="text-center d-flex justify-content-center gap-2 text-nowrap">
                                        <button
                                            class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#ticketModal"
                                            data-id="{{ $info->id }}" data-nama="{{ $info->nama_pemohon }}">
                                            <i class="bi bi-airplane" style="font-size: 16px;"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketModalLabel">Detail Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalContent">Loading...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ticketModal = document.getElementById('ticketModal');
    let originalContent = '';

    // Fungsi konversi format tanggal: "2025-05-18" → "18 MAY 2025"
    function formatToPrettyDate(isoDateStr) {
        const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        const [year, month, day] = isoDateStr.split('-');
        const prettyMonth = months[parseInt(month, 10) - 1];
        return `${day} ${prettyMonth} ${year}`;
    }

    // Fungsi konversi format tanggal: "18 MAY 2025" → "2025-05-18"
    function convertToISODate(dateStr) {
        const months = {
            JAN: '01', FEB: '02', MAR: '03', APR: '04', MAY: '05', JUN: '06',
            JUL: '07', AUG: '08', SEP: '09', OCT: '10', NOV: '11', DEC: '12'
        };

        const parts = dateStr.trim().split(' ');
        if (parts.length === 3) {
            const day = parts[0].padStart(2, '0');
            const month = months[parts[1].toUpperCase()] || '01';
            const year = parts[2];
            return `${year}-${month}-${day}`;
        }
        return '';
    }

    ticketModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const modalContent = document.getElementById('modalContent');

        modalContent.innerHTML = 'Loading...';

        fetch(`/ticketing/detail/${id}`)
            .then(response => response.json())
            .then(data => {
                if (!data.ticket || data.details.length === 0) {
                    modalContent.innerHTML = `<p>Detail tiket untuk <strong>${nama}</strong> tidak ditemukan.</p>`;
                    return;
                }

                let html = `
                    <strong>Nama Pemohon:</strong> ${data.ticket.nama_pemohon}<br>
                    <strong>Agent:</strong> ${data.ticket.agent}<br>
                    <strong>Invoice:</strong> ${data.ticket.invoice}<br>
                    <hr>
                    <strong>Detail Tiket:</strong>
                    <ul class="list-group mt-2">
                `;

                data.details.forEach(detail => {
                    const prettyDate = formatToPrettyDate(detail.flight_date);
                    html += `
                        <li class="list-group-item" id="detail-${detail.id}">
                            <strong>Penumpang:</strong> <span class="passenger-name">${detail.passenger_name}</span><br>
                            <strong>Flight:</strong> <span class="flight-number">${detail.flight_number}</span><br>
                            <strong>Tanggal:</strong> <span class="flight-date">${prettyDate}</span><br>
                            <strong>Waktu:</strong> <span class="departure-time">${detail.departure_time}</span><br>
                            ${detail.file_name ? `
                                <a href="/storage/tickets/${detail.file_name}" target="_blank" class="btn btn-sm btn-outline-success mt-2">
                                    <i class="bi bi-file-earmark-pdf"></i> Lihat Tiket
                                </a>` : ''}
                            <button type="button" class="btn btn-sm btn-warning mt-2" onclick="openEditModal(
                                ${detail.id},
                                '${detail.passenger_name}',
                                '${detail.flight_number}',
                                '${prettyDate}',
                                '${detail.departure_time}'
                            )">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </li>
                    `;
                });

                html += '</ul>';
                modalContent.innerHTML = html;
                originalContent = html;
            })
            .catch(error => {
                console.error('Error:', error);
                modalContent.innerHTML = 'Terjadi kesalahan saat memuat data';
            });
    });

    window.openEditModal = function (detailId, passengerName, flightNumber, flightDate, departureTime) {
        const formattedDate = convertToISODate(flightDate);

        const editFormHtml = `
            <h5>Edit Detail Tiket</h5>
            <form id="editForm">
                <div class="mb-3">
                    <label for="editPassengerName" class="form-label">Nama Penumpang</label>
                    <input type="text" class="form-control" id="editPassengerName" value="${passengerName}">
                </div>
                <div class="mb-3">
                    <label for="editFlightNumber" class="form-label">Flight</label>
                    <input type="text" class="form-control" id="editFlightNumber" value="${flightNumber}">
                </div>
                <div class="mb-3">
                    <label for="editFlightDate" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="editFlightDate" value="${formattedDate}">
                </div>
                <div class="mb-3">
                    <label for="editDepartureTime" class="form-label">Waktu</label>
                    <input type="time" class="form-control" id="editDepartureTime" value="${departureTime}">
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary flex-grow-1" onclick="cancelEdit()">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-primary flex-grow-1" onclick="saveEdit(${detailId})">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        `;

        document.getElementById('modalContent').innerHTML = editFormHtml;
    };

    window.cancelEdit = function () {
        document.getElementById('modalContent').innerHTML = originalContent;
    };

    window.saveEdit = function (detailId) {
        const passengerName = document.getElementById('editPassengerName').value;
        const flightNumber = document.getElementById('editFlightNumber').value;
        const flightDate = document.getElementById('editFlightDate').value;
        const departureTime = document.getElementById('editDepartureTime').value;

        fetch(`/ticketing/detail/${detailId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                passenger_name: passengerName,
                flight_number: flightNumber,
                flight_date: flightDate,
                departure_time: departureTime,
                _method: 'PUT'
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const detailElement = document.getElementById(`detail-${detailId}`);
                if (detailElement) {
                    detailElement.querySelector('.passenger-name').textContent = passengerName;
                    detailElement.querySelector('.flight-number').textContent = flightNumber;
                    detailElement.querySelector('.flight-date').textContent = formatToPrettyDate(flightDate);
                    detailElement.querySelector('.departure-time').textContent = departureTime;
                }
                cancelEdit();
                showAlert('success', 'Detail tiket berhasil diperbarui!');
            } else {
                showAlert('danger', data.message || 'Gagal memperbarui detail tiket.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Terjadi kesalahan saat menyimpan perubahan');
        });
    };

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.classList.add('alert', `alert-${type}`, 'mt-3');
        alertDiv.textContent = message;

        const modalBody = document.querySelector('.modal-body');
        modalBody.prepend(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
});
</script>
@endsection

@endsection