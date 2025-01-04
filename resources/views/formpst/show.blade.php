@extends('layouts.main')

@section('content')
    {{-- {{ Breadcrumbs::render('Show') }} --}}

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Data Pengajuan
        </div>
        <div class="card-body">
            <form action="{{ route('pengajuans.store') }}" method="POST">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Departemen</th>
                            <th>Lama</th>
                            <th>Cabang</th>
                            <th>Tujuan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $row)
                            <tr>
                                <td>
                                    {{ $row['nama'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][nama]"
                                        value="{{ $row['nama'] }}">
                                </td>
                                <td>
                                    {{ $row['nik'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][nik]"
                                        value="{{ $row['nik'] }}">
                                </td>
                                <td>
                                    {{ $row['departemen'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][departemen]"
                                        value="{{ $row['departemen'] }}">
                                </td>
                                <td>
                                    {{ $row['lama'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][lama]"
                                        value="{{ $row['lama'] }}">
                                </td>
                                <td>
                                    {{ $row['cabang'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][cabang]"
                                        value="{{ $row['cabang'] }}">
                                </td>
                                <td>
                                    {{ $row['tujuan'] }}
                                    <input type="hidden" name="pengajuans[{{ $index }}][tujuan]"
                                        value="{{ $row['tujuan'] }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('formpst.edit', $row['id']) }}"
                                            class="btn btn-sm btn-primary mr-2">
                                            <img src="{{ asset('icons/create-outline.svg') }}" alt="Tambah" style="width: 20px; height: 20px; margin-right: 4px">
                                            Edit
                                        </a>
                                        {{-- <form action="{{ route('formpst.destroy', $row['id']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Submit Pengajuan</button>
            </form>
        </div>
    </div>
@endsection
