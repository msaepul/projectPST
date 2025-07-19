@extends('layouts.main')

@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="mb-0 ms-2">Form Permintaan</h4>
        </div>

        <div class="card-body">
            @php
                $actionRoute = route('formpst.store', ['role' => auth()->user()->role]);
            @endphp

            <form id="suratTugasForm" action="{{ $actionRoute }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="noSurat">No. Surat</label>
                            <input type="text" class="form-control form-control-sm" name="no_surat" id="noSurat"
                                value="{{ $nomorSurat }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="namaPemohon">Nama Pemohon</label>
                            <input type="text" id="namaPemohon" name="namaPemohon" class="form-control"
                                value="{{ old('namaPemohon', Auth::user()->nama_lengkap ?? '') }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="yangMenugaskan">Ditugaskan oleh</label>
                            <select class="form-control select2" name="yangMenugaskan" required>
                                <option value="" disabled selected>Pilih Nama</option>
                                @foreach ($users as $user)
                                    @if (in_array($user->role, ['bm', 'nm']))
                                        <option value="{{ $user->id }}">
                                            {{ $user->nama_lengkap }} - {{ $user->departemen }} - {{ $user->cabang_asal }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cabangAsal">Cabang Asal</label>
                            <input type="text" id="cabangAsal" name="cabangAsal" class="form-control"
                                value="{{ old('cabangAsal', Auth::user()->cabang_asal ?? '') }}" required readonly>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cabangTujuan">Cabang Tujuan</label>
                            <select class="form-control select2" name="cabang_tujuan" required>
                                <option value="" disabled selected>Pilih Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}">
                                        {{ $cabang->nama_cabang }} / {{ $cabang->kode_cabang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tujuan">Tujuan Penugasan</label>
                            <select class="form-control select2" name="tujuan" required>
                                <option value="" disabled selected>Pilih Tujuan</option>
                                @foreach ($tujuans as $tujuan)
                                    <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan_penugasan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggalKeberangkatan">Tanggal Keberangkatan</label>
                            <input type="date" name="tanggalKeberangkatan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="statusKoordinasi">Status Koordinasi</label>
                            <input type="text" name="statusKoordinasi" class="form-control" required>
                        </div>
                    </div>
                </div>

                {{-- === Daftar Pegawai === --}}
                <div class="card mt-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 ms-2">Pegawai yang berangkat</h4>
                    </div>
                    <div class="card-body bg-body-tertiary p-4 rounded-bottom-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle table-sm text-center shadow-sm"
                                id="pegawaiTable">
                                <thead class="table-light text-secondary fw-semibold">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>NIK</th>
                                        <th>KTP</th>
                                        <th>Lama Penugasan</th>
                                        <th>Estimasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Modal Tambah Pegawai --}}
                <div class="modal " id="modalTambahPegawai" tabindex="-1" aria-labelledby="modalTambahPegawaiLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Tambah Pegawai</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label>Nama Pegawai</label>
                                        <select id="modalNamaPegawai" class="form-control select2">
                                            <option value="" disabled selected>Pilih Nama</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" data-nama="{{ $user->nama_lengkap }}"
                                                    data-nik="{{ $user->nik }}"
                                                    data-departemen="{{ $user->departemen }}">
                                                    {{ $user->nama_lengkap }} / {{ $user->departemen }} /
                                                    {{ $user->nik }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tanggal Berangkat</label>
                                        <input type="date" id="modalTanggalBerangkat" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Estimasi Hari</label>
                                        <input type="number" id="modalEstimasi" class="form-control"
                                            placeholder="Jumlah hari">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tanggal Kembali</label>
                                        <input type="date" id="modalTanggalKembali" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btnSimpanPegawai" class="btn btn-success">Tambah ke
                                    Tabel</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Tambah dan Submit --}}
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#modalTambahPegawai">
                    Tambah Pegawai
                </button>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success me-2">Submit Form</button>
                    <button type="reset" class="btn btn-secondary">Reset Form</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS Section --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            $('#modalTambahPegawai').on('shown.bs.modal', function() {
                $('#modalNamaPegawai').select2({
                    dropdownParent: $('#modalTambahPegawai'),
                    width: '100%'
                });
            });

            $('#btnSimpanPegawai').on('click', function() {
                const selected = $('#modalNamaPegawai').find(':selected');
                const id = selected.val();
                const nama = selected.data('nama');
                const nik = selected.data('nik');
                const departemen = selected.data('departemen');
                const tglBerangkat = $('#modalTanggalBerangkat').val();
                const tglKembali = $('#modalTanggalKembali').val();
                const estimasi = $('#modalEstimasi').val();

                if (!id || !tglBerangkat || !tglKembali) {
                    alert('Mohon lengkapi semua data.');
                    return;
                }

                let newRow = `
                <tr class="pegawai-row align-middle border-bottom bg-white hover-shadow-sm">
                    <td><input type="text" name="namaPegawaiNama[]" class="form-control form-control-sm" value="${nama}" required>
                        <input type="hidden" name="namaPegawai[]" value="${id}">
                    </td>
                    <td><input type="text" name="departemen[]" class="form-control form-control-sm" value="${departemen}" required></td>
                    <td><input type="text" name="nik[]" class="form-control form-control-sm" value="${nik}" required></td>
                    <td><input type="file" name="uploadFile[]" class="form-control form-control-sm bg-light border" required></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <input type="date" name="tanggalBerangkat[]" class="form-control form-control-sm bg-light border text-center" value="${tglBerangkat}" required>
                            <span class="text-muted small">s/d</span>
                            <input type="date" name="tanggalKembali[]" class="form-control form-control-sm bg-light border text-center" value="${tglKembali}" required>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <input type="number" name="estimasi[]" class="form-control form-control-sm bg-light border text-center" value="${estimasi}" required style="width: 70px;">
                            <span class="ms-1 small text-muted">hari</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove" title="Hapus Baris">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </td>
                </tr>`;

                $('#pegawaiTable tbody').append(newRow);
                $('#modalTambahPegawai select, #modalTambahPegawai input').val('');
            });

            $('#pegawaiTable').on('click', '.btn-remove', function() {
                $(this).closest('tr').remove();
            });

            $('#suratTugasForm').on('submit', function(e) {
                if ($('#pegawaiTable tbody tr').length === 0) {
                    alert('Mohon tambahkan minimal 1 pegawai.');
                    e.preventDefault();
                }
            });
        });
    </script>

    {{-- CSS Section --}}
    <style>
        .card-header {
            background-color: #3b0100;
            color: white;
        }

        .select2 {
            width: 100% !important;
        }

        #pegawaiTable th {
            background-color: #580000;
            color: #fff;
            font-weight: 600;
        }

        .pegawai-row:hover {
            background-color: #f5f5f5;
            transition: 0.3s ease;
        }

        tr.hover-shadow-sm:hover {
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            background-color: #f9f9f9;
        }

        .btn-outline-danger.btn-sm {
            border: none;
            color: #dc3545;
            background: transparent;
        }

        .btn-outline-danger.btn-sm:hover {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
@endsection
