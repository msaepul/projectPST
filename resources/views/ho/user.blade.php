@extends('layouts.main')

@section('content')
    <div class="container pt-4">
        <div class="card mb-4 rounded-3 shadow-lg border-0 bg-light">
            <div class="card-header bg-info text-dark py-3">
                <h4 class="mb-0 fw-bold">Data User</h4>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('ho.user.add') }}" class="btn btn-primary">
                        <img src="{{ asset('icons/duplicate-outline.svg') }}" alt="Tambah"
                            style="width: 20px; height: 20px; margin-right: 4px">Tambah User
                    </a>
                    <form method="GET" class="d-flex align-items-center">
                        <label for="cabang" class="me-2">Filter Berdasarkan Cabang: </label>
                        <select name="cabang" id="cabang" class="form-select border-info" onchange="this.form.submit()">
                            <option value="">Semua Cabang</option>
                            @foreach ($users->pluck('cabang_asal')->unique() as $cabang)
                                <option value="{{ $cabang }}" {{ request('cabang') == $cabang ? 'selected' : '' }}>
                                    {{ $cabang }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="table-responsive">
                    <table id="userTable" class="table table-light table-hover table-bordered shadow-sm rounded">
                        <thead class="table-info">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Departemen</th>
                                <th>Cabang Asal</th>
                                <th>No HP</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $user->nama_lengkap }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nik }}</td>
                                    <td>{{ $user->departemen }}</td>
                                    <td>{{ $user->cabang_asal }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" style="gap: 10px;">
                                            <a href="{{ route('ho.user.edit', $user->id) }}"
                                                class="btn btn-sm btn-warning text-white" title="Edit">
                                                <img src="{{ asset('icons/create-outline.svg') }}" alt="Edit"
                                                    style="width: 20px; height: 20px;">
                                            </a>
                                            <form action="{{ route('ho.user.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "language": {
                    "paginate": {
                        "previous": "&laquo;",
                        "next": "&raquo;"
                    }
                }
            });
        });
    </script>
@endsection
