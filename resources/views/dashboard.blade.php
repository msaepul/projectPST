@extends('layouts.main')

@section('content')
    <!-- Fonts & Animation Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            background-color: #f1f2f6;
            font-family: 'Inter', sans-serif;
        }

        .welcome-box {
            background: linear-gradient(to right, #e6f2ff, #c6dbf5, #b2d1f0);
            border-radius: 16px;
            padding: 30px 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .welcome-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .welcome-box h3, .welcome-box p {
            color: #1e293b;
        }

        .animated-image {
            animation: floatY 3s ease-in-out infinite;
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.2));
        }

        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .wave-hand {
            display: inline-block;
            animation: wave 2s infinite;
            transform-origin: 70% 70%;
        }

        @keyframes wave {
            0% { transform: rotate(0deg); }
            10% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(14deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
            60% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }

        .small-box {
            border-radius: 12px !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            background-color: #3b82f6 !important;
            color: #ffffff !important;
            transition: all 0.3s ease;
            position: relative;
        }

        .small-box:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .small-box .inner h3 {
            font-size: 30px;
            font-weight: 700;
        }

        .small-box .icon {
            font-size: 50px;
            opacity: 0.2;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .small-box-footer {
            background-color: #dbe9ff !important;
            color: #1e293b !important;
            border-radius: 0 0 12px 12px;
            font-weight: 600;
            text-shadow: none;
            transition: background-color 0.2s ease;
        }

        .small-box-footer:hover {
            background-color: #a1c2f0 !important;
            text-decoration: underline;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 15px;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, #74b9ff, #a29bfe);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 15px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 5px;
            background: #74b9ff;
            border-radius: 50%;
            width: 12px;
            height: 12px;
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
        <div class="welcome-box d-flex justify-content-between align-items-center" data-aos="fade-up">
            <div>
                <h3 class="fw-bold mb-1">Halo, {{ auth()->user()->name }} <span class="wave-hand">👋</span></h3>
                <p class="mb-0">Selamat datang di dashboard surat tugas!</p>
            </div>
            <img class="animated-image" src="{{ asset('dist/img/jordan1.png') }}" alt="Welcome" height="80">
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO')
                        @foreach ($cabangCounts as $cabang => $count)
                            <div class="col-md-4 mb-4" data-aos="fade-up">
                                <div class="small-box">
                                    <div class="inner">
                                        <h3 id="countSuratKeluarCabang{{ Str::slug($cabang) }}">{{ $count }}</h3>
                                        <p>Surat Keluar dari Cabang {{ $cabang }}</p>
                                    </div>
                                    <div class="icon"><i class="fas fa-building"></i></div>
                                    <a href="{{ route('formpst.index_keluar') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-4 mb-4" data-aos="fade-up">
                            <div class="small-box">
                                <div class="inner">
                                    <h3 id="countSuratKeluar">{{ $jumlahSuratKeluar }}</h3>
                                    <p>Jumlah Surat Keluar</p>
                                </div>
                                <div class="icon"><i class="fas fa-paper-plane"></i></div>
                                <a href="{{ route('formpst.index_keluar') }}" class="small-box-footer">
                                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up">
                            <div class="small-box">
                                <div class="inner">
                                    <h3 id="countSuratMasuk">{{ $jumlahSuratMasuk }}</h3>
                                    <p>Jumlah Surat Masuk</p>
                                </div>
                                <div class="icon"><i class="fas fa-envelope"></i></div>
                                <a href="{{ route('formpst.index_masuk') }}" class="small-box-footer">
                                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up">
                            <div class="small-box">
                                <div class="inner">
                                    <h3 id="countSuratTugas">{{ $jumlahSuratTugas }}</h3>
                                    <p>Jumlah Surat Tugas</p>
                                </div>
                                <div class="icon"><i class="fas fa-file-alt"></i></div>
                                <a href="{{ route('formpst.index_surat') }}" class="small-box-footer">
                                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card" data-aos="fade-up">
                    <div class="card-header bg-white">
                        <h3 class="card-title">
                            @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO')
                                Grafik Keberangkatan per Cabang
                            @else
                                Grafik Surat Keluar & Masuk
                            @endif
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="mainChart" height="150"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4" data-aos="fade-left">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">Timeline Keberangkatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach ($timelineDetails as $ticket)
                                @php
                                    $transport = strtolower($ticket->transport);
                                    $icon = match ($transport) {
                                        'pesawat' => 'fas fa-plane-departure',
                                        'kereta' => 'fas fa-train',
                                        'mobil', 'car' => 'fas fa-car-side',
                                        default => 'fas fa-route',
                                    };
                                @endphp

                                @foreach ($ticket->Detail_ticket as $item)
                                    <div class="timeline-item">
                                        <div class="timeline-content">
                                            <h5><i class="{{ $icon }} me-2 text-primary"></i>{{ $item->passenger_name }}</h5>
                                            <p>{{ $item->departure_airport }} → {{ $item->arrival_airport }} •
                                                {{ $item->flight_date ? \Carbon\Carbon::parse($item->flight_date)->translatedFormat('d F Y') : '-' }}
                                                •
                                                {{ $item->departure_time ? \Carbon\Carbon::parse($item->departure_time)->format('H:i') . ' WIB' : 'Tanpa Waktu' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        AOS.init();

        const animateCount = (id, target, duration) => {
            const el = document.getElementById(id);
            let val = 0;
            const step = target / (duration / 50);
            const counter = setInterval(() => {
                val += step;
                if (val >= target) {
                    el.textContent = target;
                    clearInterval(counter);
                } else {
                    el.textContent = Math.floor(val);
                }
            }, 50);
        };

        @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO')
            @foreach ($cabangCounts as $cabang => $count)
                animateCount('countSuratKeluarCabang{{ Str::slug($cabang) }}', {{ $count }}, 1500);
            @endforeach

            const cabangLabels = {!! json_encode(array_keys($cabangCounts)) !!};
            const cabangData = {!! json_encode(array_values($cabangCounts)) !!};
            const ctx = document.getElementById('mainChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: cabangLabels,
                    datasets: [{
                        label: 'Jumlah Surat Tugas',
                        data: cabangData,
                        backgroundColor: '#3b82f6',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true },
                        x: { title: { display: true, text: 'Cabang' } }
                    }
                }
            });
        @else
            animateCount('countSuratKeluar', {{ $jumlahSuratKeluar }}, 1500);
            animateCount('countSuratMasuk', {{ $jumlahSuratMasuk }}, 1500);
            animateCount('countSuratTugas', {{ $jumlahSuratTugas }}, 1500);

            new Chart(document.getElementById('mainChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Surat Keluar', 'Surat Masuk'],
                    datasets: [{
                        data: [{{ $jumlahSuratKeluar }}, {{ $jumlahSuratMasuk }}],
                        backgroundColor: ['#3b82f6', '#60d394']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        @endif
    </script>
@endsection
