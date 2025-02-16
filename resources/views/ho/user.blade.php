@extends('layouts.main')

@section('content')
    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow">
            <div class="card-header bg-light text-white py-3">
                <h4 class="mb-0 fw-bold">Data User</h4>
            </div>

            <div class="card-body">
                <a href="{{ route('ho.user.add') }}" class="btn mb-3"
                    style="background-color: #80acca; border-color: #7ca4be; color: rgb(0, 0, 0);">
                    <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                        style="width: 20px; height: 20px; margin-right: 4px">Tambah User
                </a>

                <form method="GET" class="mb-3">
                    <label for="cabang">Filter Berdasarkan Cabang: </label>
                    <select name="cabang" id="cabang" onchange="this.form.submit()">
                        <option value="">Semua Cabang</option>
                        @foreach ($users->pluck('cabang_asal')->unique() as $cabang)
                            <option value="{{ $cabang }}" {{ request('cabang') == $cabang ? 'selected' : '' }}>{{ $cabang }}</option>
                        @endforeach
                    </select>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="table-primary text-white">
                                <th scope="col" style="text-align: center;">No</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Nama User</th>
                                <th scope="col">Email</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Cabang Asal</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Role</th>
                                <th scope="col" style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $filteredUsers = $users;
                                if (request('cabang')) {
                                    $filteredUsers = $users->where('cabang_asal', request('cabang'));
                                }
                            @endphp
                            @php $index = 1; @endphp
                            @foreach ($filteredUsers as $user)
                                @if (auth()->user()->role === 'hrd' && (auth()->user()->cabang_asal === 'Head Office' || auth()->user()->cabang_asal === $user->cabang_asal)|| auth()->user()->role === 'admin')
                                    <tr>
                                        <td class="text-center">{{ $index++ }}</td>
                                        <td>{{ $user->nama_lengkap }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->nik }}</td>
                                        <td>{{ $user->departemen }}</td>
                                        <td>{{ $user->cabang_asal }}</td>
                                        <td>{{ $user->no_hp }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                                <a href="{{ route('ho.user.edit', $user->id) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                                        style="width: 20px; height: 20px;">
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-primary" title="Upload Tanda Tangan" data-bs-toggle="modal" data-bs-target="#uploadSignatureModal{{ $user->id }}">
                                                    <img src="{{ asset('icons/upload-outline.svg') }}" alt="Upload"
                                                        style="width: 20px; height: 20px;">
                                                </button>
                                                <form action="{{ route('ho.user.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <img src="{{ asset('icons/trash-outline.svg') }}" alt="Delete"
                                                            style="width: 20px; height: 20px;">
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal Upload Tanda Tangan -->
                                    <div class="modal fade" id="uploadSignatureModal{{ $user->id }}" tabindex="-1" aria-labelledby="uploadSignatureLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadSignatureLabel{{ $user->id }}">Upload Tanda Tangan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ho.user.uploadSignature', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <label for="ttd">Upload Tanda Tangan:</label>
                                                        <input type="file" name="ttd" id="ttd" accept="image/png, image/jpeg" required>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if ($filteredUsers->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data untuk cabang yang dipilih.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
