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
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
