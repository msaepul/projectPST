@extends('layouts.main')

@section('content')
    {{ Breadcrumbs::render('dashboard') }}

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="small-box bg-gray">
                    <div class="inner">
                        <h3>Selamat Datang, {{ Auth::user()->name }}</h3>
                        <p>{{ Auth::user()->role }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
            </div>
        </div>

            {{-- Jika Pegawai, hanya tampilkan box Surat Tugas --}}
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="small-box bg-gray-dark">
                        <div class="inner">
                            <h3 id="countSuratKeluar">{{ $jumlahSuratKeluar }}</h3>
                            <p>Jumlah Surat Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <a href="{{ route('formpst.index_keluar') }}" class="small-box-footer">
                            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="small-box bg-cyan">
                        <div class="inner">
                            <h3 id="countSuratMasuk">{{ $jumlahSuratMasuk }}</h3>
                            <p>Jumlah Surat Masuk</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <a href="{{ route('formpst.index_masuk') }}" class="small-box-footer">
                            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3 id="countSuratTugas">{{ $jumlahSuratTugas }}</h3>
                            <p>Jumlah Surat Tugas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <a href="{{ route('formpst.index_surat') }}" class="small-box-footer">
                            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const animateCount = (elementId, targetValue, duration) => {
                const element = document.getElementById(elementId);
                let startValue = 0;
                const increment = targetValue / (duration / 50);
                const counter = setInterval(() => {
                    startValue += increment;
                    if (startValue >= targetValue) {
                        element.textContent = targetValue;
                        clearInterval(counter);
                    } else {
                        element.textContent = Math.floor(startValue);
                    }
                }, 50);
            };

                animateCount('countSuratTugas', {{ $jumlahSuratTugas}}, 2000);
                animateCount('countCabang', {{ $jumlahCabang }}, 2000);
                animateCount('countDepartemen', {{ $jumlahDepartemen }}, 2000);
                animateCount('countSuratMasuk', {{ $jumlahSuratMasuk }}, 2000);
                animateCount('countSuratKeluar', {{ $jumlahSuratKeluar }}, 2000);
        });
    </script>
@endsection
