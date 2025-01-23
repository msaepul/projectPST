@extends('layouts.main')

@section('content')
    <div id="printable-area" class="container pt-4">
        <div class="container pt-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mb-4 mt-3" id="surat-tugas-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo" class="img-fluid"
                                        id="company-logo1">
                                </div>
                                <div class="text-center w-100">
                                    <p><strong>HEAD OFFICE JORDAN BAKERY</strong></p>
                                    <p>Jl. Batujajar No.201, Desa Laksana Mekar</p>
                                    <p>Kec. Padalarang, Kab. Bandung Barat</p>
                                </div>
                                <!-- Logo on the right -->
                                <div>
                                    <img src="{{ asset('dist/img/logo1.jpeg') }}" alt="Logo" class="img-fluid"
                                        id="company-logo">
                                </div>

                            </div>

                            <hr style="border: 2px solid rgba(68, 36, 1, 0.973); margin: 10px 0;">
                            <br>

                            <div class="letter-content">
                                <p class="text-center" id="title">SURAT TUGAS</p>
                                <p class="text-center" id="letter-number">No. 001/ST-I/2025</p>

                                <div class="mb-4">
                                    <p>Yang bertanda tangan di bawah ini :</p>
                                    <p class="person-info"><span class="label">Nama</span>: Agus Suharsono</p>
                                    <p class="person-info"><span class="label">Jabatan</span>: HRD-HO</p>
                                    <p class="person-info"><span class="label">Alamat</span>: Jl.Raya Batujajar No.201 RT
                                        02/RW
                                        05, </p>
                                    <p class="person-info"><span class="label"></span> Desa Laksana Mekar - Bandung Barat
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <p>Berdasarkan komunikasi No. {{ $form->no_surat }} :</p>
                                </div>

                                <!-- Daftar Pegawai yang Ditetapkan -->
                                <div class="mb-4">
                                    <h5 class="text-center"><strong>MENUGASKAN : </strong></h5>
                                    <table class="table table-bordered" id="pegawai-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Cabang</th>
                                                <th>Lama Keberangkatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nik }}</td>
                                                    <td>{{ $item->nama_pegawai }}</td>
                                                    <td>{{ $item->departemen }}</td>
                                                    <td>{{ $item->lama_keberangkatan }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data untuk Form ID:
                                                        {{ $targetFormId }}.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mb-4">
                                    <p>Ke cabang <strong>"{{ $form->cabang_tujuan }}"</strong> untuk
                                        <strong>"{{ $form->tujuan }}"</strong>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <p>Demikian surat tugas ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
                                </div>
                                <div class="text-right">
                                    <p>Hormat kami,</p>
                                    <p><strong>Nama Pengirim</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mb-3">
            <a href="{{ route('surat-tugas.pdf', ['id' => $form->id]) }}" class="btn btn-primary">Download PDF Surat Tugas</a>
        </div>
        
        <style>
            
            #title,
            #letter-number {
                margin: 0;
                padding: 0;
                line-height: 1;
            }
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            #surat-tugas-card {
                width: 100%;
                max-width: 21cm;
                min-height: 29.7cm;
                padding: 30px;
                border: 1px solid #000;
                box-sizing: border-box;
                margin: 0 auto;
                background-color: #fff;
            }

            #address-line {
                border-bottom: 2px solid black;
                padding-bottom: 5px;
                margin-bottom: 15px;
                font-size: 14px;
            }

            #title {
                font-size: 24px;
                font-weight: bold;
                margin-top: 20px;
            }

            #letter-number {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .person-info {
                margin-bottom: 12px;
                font-size: 14px;
            }

            .person-info .label {
                display: inline-block;
                width: 15%;
                font-weight: bold;
                text-align: left;
            }

            #pegawai-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            #pegawai-table th,
            #pegawai-table td {
                border: 1px solid #000;
                padding: 10px;
                text-align: center;
                font-size: 14px;
            }

            #pegawai-table th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            #pegawai-table td {
                vertical-align: middle;
            }

            .mb-4 {
                margin-bottom: 20px;
            }

            .text-right {
                text-align: right;
                margin-top: 30px;
                font-size: 14px;
            }

            .text-center {
                text-align: center;
            }

            /* Add custom styles for the image */
            #company-logo {
                max-height: 75px;
                vertical-align: middle;
            }

            #company-logo1 {
                max-height: 75px;
                vertical-align: left;
            }
        </style>
    </div>
@endsection
