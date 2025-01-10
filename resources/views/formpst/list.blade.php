@extends('layouts.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> List yang di setujui
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Jumlah Pegawai</th>
                        <th>Detail</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grouped_pegawais as $form_id => $pegawai_group)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ 'Nomor Surat ' . $loop->iteration }}</td>
                            <td>{{ count($pegawai_group) }}</td>
                            <td>
                                <a href="{{ route('formpst.show_pegawai', $form_id) }}"
                                    class="btn btn-primary btn-sm">Detail</a>
                            </td>
                            <td>
                                @php
                                    // Dapatkan form untuk grup saat ini
                                    $form = $forms[$form_id] ?? null;
                                @endphp

                                @if ($form)
                                    <span
                                        class="badge {{ $form->status == 'Approved' ? 'bg-success' : ($form->status == 'Rejected' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $form->status }}
                                    </span>
                                @else
                                    <span class="badge bg-warning">Pending</span> <!-- Default jika tidak ada form -->
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
