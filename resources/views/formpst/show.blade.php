@extends('layouts.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Data Pengajuan
        </div>
        <div class="card-body">
            <form action="{{ route('pengajuans.store') }}" method="POST" id="formPengajuan">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Departemen</th>
                            <th>Lama</th>
                            <th>Cabang</th>
                            <th>Tujuan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $row)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected[{{ $index }}]" value="{{ $row['id'] }}">
                                </td>
                                <td>
                                    {{ $row['nama'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][nama]"
                                        value="{{ $row['nama'] }}">
                                </td>
                                <td>
                                    {{ $row['nik'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][nik]"
                                        value="{{ $row['nik'] }}">
                                </td>
                                <td>
                                    {{ $row['departemen'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][departemen]"
                                        value="{{ $row['departemen'] }}">
                                </td>
                                <td>
                                    {{ $row['lama'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][lama]"
                                        value="{{ $row['lama'] }}">
                                </td>
                                <td>
                                    {{ $row['cabang'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][cabang]"
                                        value="{{ $row['cabang'] }}">
                                </td>
                                <td>
                                    {{ $row['tujuan'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][tujuan]"
                                        value="{{ $row['tujuan'] }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('formpst.edit', $row['id']) }}"
                                            class="btn btn-sm btn-primary mr-2">
                                            <img src="{{ asset('icons/create-outline.svg') }}" alt="Tambah"
                                                style="width: 20px; height: 20px; margin-right: 4px"> Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger" id="submitPengajuan">
                    Submit Pengajuan
                </button>
            </form>
        </div>
    </div>

    <!-- Modal untuk menampilkan status -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Status Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="statusMessage">
                    <!-- Pesan akan ditampilkan di sini -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animasi untuk ceklis yang berputar */
        .spin-icon {
            animation: spin 1s linear infinite;
            font-size: 30px;
            color: green;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        document.getElementById('formPengajuan').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            var button = document.getElementById('submitPengajuan');
            button.disabled = true;
            button.innerHTML = 'Mengajukan...';
            button.classList.remove('btn-danger');
            button.classList.add('btn-success');
            button.innerHTML = 'Pengajuan Berhasil <i class="fas fa-check"></i>';

            var form = this;

            // Menampilkan modal dengan animasi ceklis yang berputar
            setTimeout(function() {
                var statusMessage = document.getElementById('statusMessage');
                statusMessage.innerHTML =
                    '<div class="text-center"><i class="fas fa-check-circle spin-icon"></i><br>Pengajuan berhasil dikirim!</div>';
                document.getElementById('statusModal').classList.add('show');
                document.getElementById('statusModal').style.display = 'block';

                // Setelah 2 detik, form dikirim dan modal ditutup
                setTimeout(function() {
                    // Menutup modal otomatis setelah 2 detik
                    $('#statusModal').modal('hide');
                    form.submit();
                }, 2000); // Modal menutup setelah 2 detik
            }, 1000); // Simulasikan proses pengajuan
        });
    </script>
@endsection
