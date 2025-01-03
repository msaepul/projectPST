@extends('layouts.main')

@section('content')
    <div class="card-header">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tambahPenugasanModal">
            <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                style="width: 20px; height: 20px; margin-right: 4px">Tambah Data
        </button>
    </div>

    <!-- Main content -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" style="background-color: #e6f7ff; color: #000;">
                <thead style="background-color: #b3e0ff;">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr style="background-color: {{ $key % 2 == 0 ? '#ffffff' : '#e6f7ff' }};">
                            <td style="padding: 8px;">{{ $key + 1 }}</td>
                            <td style="padding: 8px;">{{ $user->name }}</td>
                            <td style="padding: 8px;">{{ $user->email }}</td>
                            <td style="padding: 8px;">{{ $user->role }}</td>
                            <td style="padding: 8px;">
                                <div class="d-flex" style="gap: 8px;">
                                    <!-- Button Edit -->
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editModal-{{ $user->id }}">
                                        <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                            style="width: 20px; height: 20px; margin-right: 4px">
                                    </button>

                                    <!-- Modal Edit User -->
                                    <div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel-{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('profile.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit User</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama User:</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ old('name', $user->name) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email:</label>
                                                            <input type="email" class="form-control" name="email"
                                                                value="{{ old('email', $user->email) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Role:</label>
                                                            <select class="form-control" name="role" required>
                                                                <option value="Admin"
                                                                    {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin
                                                                </option>
                                                                <option value="User"
                                                                    {{ $user->role == 'User' ? 'selected' : '' }}>User
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                        <div class="form-group">
                                                            <label for="role">Role :</label>
                                                            <select class="form-control" id="role" name="role"
                                                                value="{{ $user->role }} " required>
                                                                <option value="admin">admin</option>
                                                                <option value="user">user</option>
                                                            </select>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button Hapus -->
                                <form action="{{ route('profile.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <img src="{{ asset('icons/trash-outline.svg') }}" alt="Delete"
                                            style="width: 20px; height: 20px; margin-right: 4px">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="tambahPenugasanModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah User Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama User:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Role:</label>
                            <select class="form-control" name="role" required>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
