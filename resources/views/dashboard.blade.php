@extends('layouts.main')

@section('content')
    <!-- Google Font & AOS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            background-color: #f1f2f6;
            font-family: 'Inter', sans-serif;
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
        }

        .small-box {
            border-radius: 12px !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background-color: #ffffff !important;
            color: #2d3436 !important;
        }

        .small-box:hover {
            transform: scale(1.03);
        }

        .small-box .inner h3 {
            font-size: 30px;
            font-weight: 700;
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
            padding: 10px;
            background-color: #dfe6e9;
            color: #2d3436 !important;
            border-radius: 0 0 12px 12px;
            font-weight: bold;
            text-align: center;
            display: block;
            text-decoration: none;
        }

        .bg-purple {
            background-color: #8e44ad !important;
            color: white !important;
        }

        .bg-blue {
            background-color: #3498db !important;
            color: white !important;
        }

        .bg-teal {
            background-color: #1abc9c !important;
            color: white !important;
        }

        .bg-info {
            background-color: #16a085 !important;
            color: white !important;
        }

        /* Timeline */
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

        .welcome-box {
        background: linear-gradient(to right, #d06b2c, #cbaaa4, #cbd5e0);
        border-radius: 16px;
        padding: 30px 40px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        margin-bottom: 24px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .welcome-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .welcome-box h3,
    .welcome-box p {
        color: #fff;
    }

    .animated-image {
        animation: floatY 3s ease-in-out infinite;
        filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.2));
    }

    @keyframes floatY {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-8px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    @media (max-width: 768px) {
        .welcome-box {
            flex-direction: column;
            text-align: center;
        }

        .animated-image {
            margin-top: 16px;
        }
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

    
    </style>

    <div class="container-fluid mt-4">
        <div class="welcome-box d-flex justify-content-between align-items-center" data-aos="fade-up">
            <div>
                <h3 class="fw-bold mb-1 text-white">
                    Halo, {{ auth()->user()->name }} <span class="wave-hand">👋</span>
                </h3>
                <p class="mb-0 text-white-50">Selamat datang di dashboard surat tugas!</p>
            </div>
            <img class="animated-image" src="{{ asset('dist/img/jordan1.png') }}" alt="Welcome" height="80">
        </div>
        

        <div class="row">
            <div class="col-lg-8">
                @if (auth()->user()->role != 'hrd' || auth()->user()->cabang_asal != 'HO')
                    <div class="row">
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3 id="countSuratKeluar">{{ $jumlahSuratKeluar }}</h3>
                                    <p>Jumlah Surat Keluar</p>
                                </div>
                                <div class="icon"><i class="fas fa-paper-plane"></i></div>
                                <a href="{{ route('formpst.index_keluar') }}" class="small-box-footer">Lihat Detail <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3 id="countSuratMasuk">{{ $jumlahSuratMasuk }}</h3>
                                    <p>Jumlah Surat Masuk</p>
                                </div>
                                <div class="icon"><i class="fas fa-envelope"></i></div>
                                <a href="{{ route('formpst.index_masuk') }}" class="small-box-footer">Lihat Detail <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="small-box bg-teal">
                                <div class="inner">
                                    <h3 id="countSuratTugas">{{ $jumlahSuratTugas }}</h3>
                                    <p>Jumlah Surat Tugas</p>
                                </div>
                                <div class="icon"><i class="fas fa-file-alt"></i></div>
                                <a href="{{ route('formpst.index_surat') }}" class="small-box-footer">Lihat Detail <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO')
                    <div class="row">
                        @foreach ($cabangCounts as $cabang => $count)
                            <div class="col-md-4 mb-4" data-aos="fade-up">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3 id="countSuratKeluarCabang{{ Str::slug($cabang) }}">{{ $count }}</h3>
                                        <p>Surat Keluar dari Cabang {{ $cabang }}</p>
                                    </div>
                                    <div class="icon"><i class="fas fa-building"></i></div>
                                    <a href="{{ route('formpst.index_keluar') }}" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

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
                                            <h5>
                                                <i class="{{ $icon }} me-2 text-primary"></i>
                                                {{ $item->passenger_name }}
                                            </h5>
                                            <p>
                                                {{ $item->departure_airport }} → {{ $item->arrival_airport }} •
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

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

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
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, '#74b9ff');
            gradient.addColorStop(1, '#a29bfe');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: cabangLabels,
                    datasets: [{
                        label: 'Jumlah Surat Tugas',
                        data: cabangData,
                        backgroundColor: gradient,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Cabang'
                            }
                        }
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
                        backgroundColor: ['#a29bfe', '#55efc4']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        @endif

        new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            height: 400
        }).render();
    </script>
@endsection
