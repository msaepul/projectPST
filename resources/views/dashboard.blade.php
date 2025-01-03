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
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-lg-4 col-md-8">
                    <div class="small-box bg-navy">
                        <div class="inner">
                            <h3 id="countCabang">0</h3>
                            <p>Jumlah Cabang Terdaftar</p>
                            <span id="loadingCabang" class="text-muted"></span>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <a href="{{ route('ho.cabang') }}" class="small-box-footer">
                            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-8">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3 id="countDepartemen">0</h3>
                            <p>Jumlah Departemen Terdaftar</p>
                            <span id="loadingDepartemen" class="text-muted"></span>
                        </div>
                        <div class="icon">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <a href="{{ route('ho.departemen') }}" class="small-box-footer">
                            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const animateCount = (elementId, targetValue, loadingId, duration) => {
                const element = document.getElementById(elementId);
                const loadingElement = document.getElementById(loadingId);
                let startValue = 0;
                const increment = targetValue / (duration / 50);
                const counter = setInterval(() => {
                    startValue += increment;
                    if (startValue >= targetValue) {
                        element.textContent = targetValue;
                        clearInterval(counter);
                        loadingElement.style.display = 'none';
                    } else {
                        element.textContent = Math.floor(startValue);
                    }
                }, 50);
            };

            animateCount('countCabang', {{ $jumlahCabang }}, 'loadingCabang', 2000);
            animateCount('countDepartemen', {{ $jumlahDepartemen }}, 'loadingDepartemen', 2000);
        });
    </script>
@endsection
