@extends('layouts.main')
@section('content')

<div class="card mb-4">
    <div class="card-header">
        {{-- <i class="fas fa-list me-1"></i>  --}}
        <a href="https://example.com" data-toggle="modal" data-target="#addModal">
            <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah" style="width: 20px; height: 20px; margin-right: 5px">
        </a>
    </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td style="padding: 8px;">
                            <div class="d-flex gap-2" style="gap: 10px;">
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                    data-target="#editModal-{{ $user->id }}">
                                    <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                        style="width: 20px; height: 20px; margin-right: 4px">
                                </button>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel-{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('profile.edit', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel-{{ $user->id }}">
                                                        Edit User</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Nama :</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name"
                                                            value="{{ $user->name }} " required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email :</label>
                                                        <input type="text" class="form-control" id="email"
                                                            name="email"
                                                            value="{{ $user->email }} " required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="role">Role :</label>
                                                        <select class="form-control" id="role" name="role" value="{{ $user->role }} " required>
                                                            <option value="Admin">admin</option>
                                                            <option value="User">user</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <img src="{{ asset('icons/save-outline.svg') }}" alt="Save"
                                                            style="width: 20px; height: 20px; margin-right: 4px"> Simpan
                                                        Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- modal tambah --}}
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('profile.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama User:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="Admin">admin</option>
                            <option value="User">user</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
