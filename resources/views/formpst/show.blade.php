@extends('layouts.main')
@section('content')
{{ Breadcrumbs::render('Show') }}

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
                    <td> 
                        <!-- Button to trigger the modal -->
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal-{{ $index }}">
                            <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit" style="width: 20px; height: 20px; margin-right: 4px"> Edit
                        </button>
                    </td>
                </tr>

                <!-- Modal Edit for each row -->
                <div class="modal fade" id="editModal-{{ $index }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-{{ $index }}">Edit Pengajuan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="nama-{{ $index }}">Nama</label>
                                        <input type="text" class="form-control" id="nama-{{ $index }}" value="{{ $row['nama'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="nik-{{ $index }}">NIK</label>
                                        <input type="text" class="form-control" id="nik-{{ $index }}" value="{{ $row['nik'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="lama-{{ $index }}">Lama</label>
                                        <input type="text" class="form-control" id="lama-{{ $index }}" value="{{ $row['lama'] }}">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
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
