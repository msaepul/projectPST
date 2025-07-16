@extends('layouts.main')

@section('content')
    {{ Breadcrumbs::render('Form') }}

    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                {{-- <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo"> --}}
                <h4 class="mb-0 ms-2">Form Permintaan</h4>
            </div>
        </div>

        <div class="card-body">
            @php
                $actionRoute = route('formpst.store', ['role' => auth()->user()->role]);
            @endphp

            <form id="suratTugasForm" action="{{ $actionRoute }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Kiri -->
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

                    <!-- Kanan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cabangTujuan">Cabang Tujuan</label>
                            <select class="form-control select2" name="cabang_tujuan" required>
                                <option value="" disabled selected>Pilih Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }} /
                                        {{ $cabang->kode_cabang }}</option>
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

                <!-- === Daftar Pegawai === -->
                <div class="card mt-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            {{-- <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo"> --}}
                            <h4 class="mb-0 ms-2">Pegawai yang berangkat</h4>
                        </div>
                    </div>

                    <div class="card-body transparent-card p-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle table-sm" id="pegawaiTable">
                                <thead class="table-light">
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
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="namaPegawai[]" class="form-control form-control-sm namaPegawai"
                                                required>
                                                <option value="" disabled selected>Pilih Nama</option>
                                                @foreach (auth()->user()->role !== 'nm' ? $users : $nm as $user)
                                                    <option value="{{ $user->id }}"
                                                        data-departemen="{{ $user->departemen }}"
                                                        data-nik="{{ $user->nik }}"
                                                        data-nama="{{ $user->nama_lengkap }}">
                                                        {{ $user->nama_lengkap }} / {{ $user->departemen }} /
                                                        {{ $user->nik }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="departemen[]"
                                                class="form-control form-control-sm departemen" readonly></td>
                                        <td><input type="text" name="nik[]" class="form-control form-control-sm nik"
                                                readonly></td>
                                        <td><input type="file" name="uploadFile[]" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="date" name="tanggalBerangkat[]"
                                                    class="form-control form-control-sm" required>
                                                <span class="mx-2">s/d</span>
                                                <input type="date" name="tanggalKembali[]"
                                                    class="form-control form-control-sm" required>
                                            </div>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <input type="number" name="estimasi[]" min="0"
                                                class="form-control form-control-sm estimasi" placeholder="Estimasi">
                                            <span class="ms-1">hari</span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-remove btn-sm">
                                                <i class="bi bi-trash" style="font-size: 16px;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary mt-3" id="add-field">Tambah Pegawai</button>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success me-2">Submit Form</button>
                    <button type="reset" class="btn btn-secondary">Reset Form</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2').select2();

                // Isi otomatis departemen dan nik
                $('#pegawaiTable').on('change', '.namaPegawai', function() {
                    const selected = $(this).find(':selected');
                    const row = $(this).closest('tr');
                    row.find('.departemen').val(selected.data('departemen'));
                    row.find('.nik').val(selected.data('nik'));
                });

                $('#add-field').on('click', function() {
                    const row = $('#pegawaiTable tbody tr:first').clone();

                    row.find('input[type="text"], input[type="number"], input[type="file"], input[type="date"]')
                        .val('');
                    row.find('select').val('');

                    $('#pegawaiTable tbody').append(row);
                });




                $('#pegawaiTable').on('click', '.btn-remove', function() {
                    if ($('#pegawaiTable tbody tr').length > 1) {
                        $(this).closest('tr').remove();
                    }
                });

                $('#suratTugasForm').on('submit', function(e) {
                    $('.namaPegawai').each(function(index) {
                        const nama = $(this).find(':selected').data('nama');
                        if (nama) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: `namaPegawaiNama[${index}]`,
                                value: nama
                            }).appendTo('#suratTugasForm');
                        }
                    });
                });
            });
        </script>
    @endpush

    <style>
        .card-header {
            background-color: #3b0100;
            color: white;
        }

        .logo {
            height: 40px;
            width: auto;
        }

        /* .select2 {
            width: 100% !important;
        } */

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-primary {
            background-color: #0415f8;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-secondary {
            background-color: #6c757d;
        }
    </style>
@endsection
