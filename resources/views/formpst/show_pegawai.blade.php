@extends('layouts.main')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i> Data Pegawai
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Departemen</th>
                    <th>Lama</th>
                    <th>Cabang</th>
                    <th>Tujuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nama_pegawais as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
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
