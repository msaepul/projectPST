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
                    <th>Tujuan Surat</th>
                    <th>Jumlah Pegawai</th>
                    <th>Status Verifikasi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grouped_pegawais as $form_id => $pegawai_group)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pegawai_group->first()->ct ?? '-' }}</td> <!-- Menampilkan tujuan surat -->
                        <td>{{ count($pegawai_group) }} Pegawai</td> 
                        <td>
                            @if ($pegawai_group->first()->status_verifikasi === 'submitted')
                                <div class="text-success">
                                    <i class="fas fa-check-circle"></i> Submitted
                                </div>
                            @elseif ($pegawai_group->first()->status_verifikasi === 'pending')
                                <div class="text-warning">
                                    <i class="fas fa-spinner fa-spin"></i> Pending
                                </div>
                            @else
                                <div class="text-danger">
                                    <i class="fas fa-times-circle"></i> Not Submitted
                                </div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('formpst.show_pegawai', $form_id) }}" class="btn btn-primary btn-sm">
                                Detail
                            </a>
                            <form action="{{ route('formpst.verify', $form_id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    Verifikasi
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
