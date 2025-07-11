@extends('layouts.main')

@section('content')
    <style>
        body {
            background-color: #f1f2f6;
            font-family: 'Segoe UI', sans-serif;
        }

        .welcome-box {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-box h3 {
            color: #2d3436;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .welcome-box p {
            color: #636e72;
            font-size: 16px;
            margin: 0;
        }

        .small-box {
            border-radius: 12px !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            background-color: #ffffff !important;
            color: #2d3436 !important;
        }

        .small-box:hover {
            transform: translateY(-5px);
        }

        .small-box .inner h3 {
            font-size: 30px;
            font-weight: 700;
        }

        .small-box .inner p {
            font-size: 16px;
            margin-bottom: 0;
        }

        .small-box .icon {
            font-size: 50px;
            color: #a29bfe;
            opacity: 0.2;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .small-box-footer {
            display: block;
            padding: 10px;
            background-color: #dfe6e9;
            color: #2d3436 !important;
            border-radius: 0 0 12px 12px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
        }

        .bg-purple {
            background-color: #a29bfe !important;
            color: white !important;
        }

        .bg-blue {
            background-color: #74b9ff !important;
            color: white !important;
        }

        .bg-teal {
            background-color: #55efc4 !important;
            color: white !important;
        }

        .bg-info {
            background-color: #81ecec !important;
            color: white !important;
        }

        /* Tambahan untuk Timeline Keberangkatan */
        .timeline {
            position: relative;
            padding-left: 30px;
            margin-bottom: 40px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 12px;
            width: 2px;
            height: 100%;
            background: #ced6e0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-item::before {
            content: attr(data-icon);
            position: absolute;
            left: -8px;
            top: 0;
            font-size: 20px;
        }

        .timeline-content {
            background: #ffffff;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .timeline-content h5 {
            margin: 0 0 5px;
            font-size: 16px;
            color: #2d3436;
        }

        .timeline-content p {
            margin: 0;
            color: #636e72;
            font-size: 14px;
        }
    </style>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-8">
                @if (auth()->user()->role != 'hrd' || auth()->user()->cabang_asal != 'HO')
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="small-box bg-purple">
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
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="small-box bg-blue">
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
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
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
                @endif

                @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO')
                    <div class="row">
                        @foreach ($cabangCounts as $cabang => $count)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3 id="countSuratKeluarCabang{{ Str::slug($cabang) }}">{{ $count }}</h3>
                                        <p>Surat Keluar dari Cabang {{ $cabang }}</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <a href="{{ route('formpst.index_keluar') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="card">
                    <div class="card-header bg-white">
                        <h3 class="card-title">Grafik Keberangkatan per Cabang</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="departureChart" height="150"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">Daftar Keberangkatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon bg-primary text-white">
                                    <i class="fas fa-plane-departure"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Indah Indriani</h5>
                                    <p>Jakarta • 3 Juli 2025 • Berangkat</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-success text-white">
                                    <i class="fas fa-car-side"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Budi Santoso</h5>
                                    <p>Bandung • 4 Juli 2025 • Proses Tiket</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-warning text-white">
                                    <i class="fas fa-train"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Rani Puspita</h5>
                                    <p>Surabaya • 5 Juli 2025 • Berangkat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">Kalender</h4>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            // Animasi Box
            animateCount('countSuratTugas', {{ $jumlahSuratTugas }}, 2000);
            animateCount('countSuratMasuk', {{ $jumlahSuratMasuk }}, 2000);
            animateCount('countSuratKeluar', {{ $jumlahSuratKeluar }}, 2000);

            @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO')
                @foreach ($cabangCounts as $cabang => $count)
                    animateCount('countSuratKeluarCabang{{ Str::slug($cabang) }}', {{ $count }}, 2000);
                @endforeach
            @endif

            // Chart Keberangkatan
            const ctx = document.getElementById('departureChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Bali'],
                    datasets: [{
                        label: 'Jumlah Keberangkatan',
                        data: [12, 19, 7, 5, 9],
                        backgroundColor: '#74b9ff'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // === Tambahkan Kalender di sini ===
            var calendarEl = document.getElementById('calendar');
            if (calendarEl) { // cek kalau elemen-nya ada
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 400
                });
                calendar.render();
            }

        });
    </script>


@endsection
