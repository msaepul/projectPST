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
                                {{-- @if ($info->nama_pemohon->contains('nama_pegawai', auth()->user()->nama_lengkap)) --}}
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
                                {{-- @endif --}}
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
        document.addEventListener('DOMContentLoaded', function() {
            const ticketModal = document.getElementById('ticketModal');

            ticketModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const modalContent = document.getElementById('modalContent');

                modalContent.innerHTML = 'Loading...';

                fetch(`/ticketing/detail/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.ticket || data.details.length === 0) {
                            modalContent.innerHTML =
                                `<p>Detail tiket untuk <strong>${nama}</strong> tidak ditemukan.</p>`;
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
                            html += `
        <li class="list-group-item">
            <strong>Penumpang:</strong> ${detail.passenger_name}<br>
            <strong>Flight:</strong> ${detail.flight_number}<br>
            <strong>Tanggal:</strong> ${detail.flight_date}<br>
            <strong>Waktu:</strong> ${detail.departure_time}<br>
            ${detail.file_name ? `
                <a href="/storage/tickets/${detail.file_name}" target="_blank" class="btn btn-sm btn-outline-success mt-2">
                    <i class="bi bi-file-earmark-pdf"></i> Lihat Tiket
                </a>
            ` : ''}

        </li>
    `;
                        });


                        html += '</ul>';

                        modalContent.innerHTML = html;
                    })

            });
        });
    </script>
@endsection
@endsection
