@extends('layouts.main')
@section('content')
{{-- {{ Breadcrumbs::render('Show') }} --}}

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-list me-1"></i>
       Hasil Persetujuan
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
                @foreach ($pengajuan as $index => $row)
                <tr>
                    <td>{{ $row['nama'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][nama]" value="{{ $row['nama'] }}"></td>
                    <td>{{ $row['nik'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][nik]" value="{{ $row['nik'] }}"></td>
                    <td>{{ $row['departemen'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][departemen]" value="{{ $row['departemen'] }}"></td>
                    <td> {{ $row['lama'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][lama]" value="{{ $row['lama'] }}"></td>
                    <td>{{ $row['cabang'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][cabang]" value="{{ $row['cabang'] }}"></td>
                    <td> {{ $row['tujuan'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][tujuan]" value="{{ $row['tujuan'] }}"></td>
                </tr>
                @endforeach
            </tbody>   
        </table>
        </form>
    </div>
</div>

@endsection
