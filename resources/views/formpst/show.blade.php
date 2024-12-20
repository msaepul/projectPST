@extends('layouts.main')
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Data Pengajuan
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Departemen</th>
                        <th>Lama</th>
                        <th>Cabang</th>
                        <th>Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $data)
                        <tr>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->nik }}</td>
                            <td>{{ $data->departemen }}</td>
                            <td>{{ $data->lama }}</td>
                            <td>{{ $data->cabang }}</td>
                            <td>{{ $data->tujuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
