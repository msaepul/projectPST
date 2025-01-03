@extends('layouts.main')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i> List yang di setujui
    </div>
    <div class="card-body">
        <div class="list-group">
            @foreach ($grouped_pegawais as $form_id => $pegawai_group)
                <a href="{{ route('formpst.show_pegawai', $form_id) }}" class="list-group-item list-group-item-action">
                    Nomor Surat: {{ $loop->iteration }} ({{ count($pegawai_group) }} Pegawai)
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
