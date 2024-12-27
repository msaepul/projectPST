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
                    <td>{{ $row['nama'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][nama]" value="{{ $row['nama'] }}">
                    </td>
                    <td>{{ $row['nik'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][nik]" value="{{ $row['nik'] }}">
                    </td>
                    <td>{{ $row['departemen'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][departemen]" value="{{ $row['departemen'] }}">
                    </td>
                    <td>{{ $row['lama'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][lama]" value="{{ $row['lama'] }}">
                    </td>
                    <td>{{ $row['cabang'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][cabang]" value="{{ $row['cabang'] }}">
                    </td>
                    <td>{{ $row['tujuan'] }}
                        <input type="hidden" name="pengajuans[{{ $index }}][tujuan]" value="{{ $row['tujuan'] }}">
                    </td>
                    <td>
                        <!-- Tombol Edit -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal-{{ $index }}">
                            Edit
                        </button>
                    </td>
                </tr>
            
                <!-- Modal Edit -->
                <div class="modal fade" id="editModal-{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-{{ $index }}">Edit Data Pengajuan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('formpst.update', $row['id']) }}">
                                @csrf
                                @method('PUT') <!-- RESTful method -->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nama-{{ $index }}">Nama</label>
                                        <input type="text" class="form-control" id="nama-{{ $index }}" name="nama" value="{{ $row['nama'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik-{{ $index }}">NIK</label>
                                        <input type="text" class="form-control" id="nik-{{ $index }}" name="nik" value="{{ $row['nik'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="departemen-{{ $index }}">Departemen</label>
                                        <input type="text" class="form-control" id="departemen-{{ $index }}" name="departemen" value="{{ $row['departemen'] }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lama-{{ $index }}">Lama</label>
                                        <input type="text" class="form-control" id="lama-{{ $index }}" name="lama" value="{{ $row['lama'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="cabang-{{ $index }}">Cabang</label>
                                        <input type="text" class="form-control" id="cabang-{{ $index }}" name="cabang" value="{{ $row['cabang'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuan-{{ $index }}">Tujuan</label>
                                        <input type="text" class="form-control" id="tujuan-{{ $index }}" name="tujuan" value="{{ $row['tujuan'] }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
            
        </table>
        <button type="submit" class="btn btn-primary">Submit Pengajuan</button>
        </form>
    </div>
</div>

@endsection
