@extends('layouts.main')
@section('content')
    <<div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-0 rounded-lg" style="background-color: #e1e3e4;">
                    <div class="card-body text-center">
                        <h3 class="card-title">Selamat Datang, {{ Auth::user()->name }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-lg-4 col-md-8">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div
                            class="card-header bg-gradient-primary text-white d-flex align-items-center justify-content-between">
                            <h3 class="card-title mb-0">Jumlah Cabang Terdaftar</h3>
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-4"></h1>
                            <p class="text-muted">Cabang</p>
                            <a href="{{ route('ho.cabang') }}" class="btn btn-outline-primary mt-3">Lihat Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-8">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div
                            class="card-header bg-gradient-success text-white d-flex align-items-center justify-content-between">
                            <h3 class="card-title mb-0">Jumlah Departemen Terdaftar</h3>
                            <i class="fas fa-sitemap fa-2x"></i>
                        </div>
                        <div class="card-body text-center">
                            <h1 class="display-4">{{ $jumlahDepartemen }}</h1>
                            <p class="text-muted">Departemen</p>
                            <a href="{{ route('ho.departemen') }}" class="btn btn-outline-success mt-3">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection
