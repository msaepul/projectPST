@extends('layouts.main')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i> Data Pegawai dan Form (Form ID: {{ $targetFormId }})
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
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ $item['nik'] }}</td>
                        <td>{{ $item['departemen'] }}</td>
                        <td>{{ $item['lama'] }}</td>
                        <td>{{ $item['cabang'] }}</td>
                        <td>{{ $item['tujuan'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data untuk Form ID: {{ $targetFormId }}.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
