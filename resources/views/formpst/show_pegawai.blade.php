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
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Departemen</th>
                    <th>Lama Tugas</th>
                    <th>Cabang</th>
                    <th>Tujuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nama_pegawais as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data->nik }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->departemen }}</td>
                        <td>{{ $data->lama }}</td>
                        <td>{{ $data->form->cabang ?? 'Tidak ada' }}</td>
                        <td>{{ $data->form->tujuan ?? 'Tidak ada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
