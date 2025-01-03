<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\Tujuan;
use App\Models\Cabang;
use App\Models\User;

class HoController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $jumlahCabang = Cabang::count();
        $jumlahDepartemen = Departemen::count();

        return view('dashboard', compact('jumlahCabang', 'jumlahDepartemen'));
    }

    // Cabang
    public function cabang()
    {
        $cabangs = Cabang::paginate(50);

        return view('ho.cabang', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'kode_cabang' => 'required|string|max:10',
        ]);

        Cabang::create($validatedData);

        return redirect()->route('ho.cabang')->with('success', 'Data cabang berhasil ditambahkan!');
    }

    public function add()
    {
        return view('ho.add_cabang');
    }

    public function edit($id)
    {
        $cabang = Cabang::findOrFail($id);

        return view('ho.cabang.edit', compact('cabang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'kode_cabang' => 'required|string|max:10',
        ]);

        $cabang = Cabang::findOrFail($id);
        $cabang->update($validated);

        return redirect()->route('ho.cabang')->with('success', 'Data cabang berhasil diubah!');
    }

    public function destroy($id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->delete();

        return redirect()->route('ho.cabang')->with('success', 'Data cabang berhasil dihapus!');
    }

    // Tujuan
    public function tujuan(Request $request)
    {
        $search = $request->input('search');
        $tujuans = Tujuan::when($search, function ($query, $search) {
            return $query->where('tujuan_penugasan', 'like', "%{$search}%");
        })->paginate(50);

        return view('ho.tujuan', compact('tujuans', 'search'));
    }

    public function storeTujuan(Request $request)
    {
        $validated = $request->validate([
            'tujuan_penugasan' => 'required|string|max:255',
        ]);

        Tujuan::create($validated);

        return redirect()->route('ho.tujuan')->with('success', 'Tujuan baru berhasil ditambahkan!');
    }

    public function editTujuan($id)
    {
        $tujuan = Tujuan::findOrFail($id);

        return view('ho.tujuan.edit', compact('tujuan'));
    }

    public function updateTujuan(Request $request, $id)
    {
        $validated = $request->validate([
            'tujuan_penugasan' => 'required|string|max:255',
        ]);

        $tujuan = Tujuan::findOrFail($id);
        $tujuan->update($validated);

        return redirect()->route('ho.tujuan')->with('success', 'Data tujuan berhasil diubah!');
    }

    public function destroyTujuan($id)
    {
        $tujuan = Tujuan::findOrFail($id);
        $tujuan->delete();

        return redirect()->route('ho.tujuan')->with('success', 'Data tujuan berhasil dihapus!');
    }

    // Departemen
    public function departemen()
    {
        $departemens = Departemen::paginate(50);

        return view('ho.departemen', compact('departemens'));
    }

    public function storeDepartemen(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'kode_departemen' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        Departemen::create($validated);

        return redirect()->route('ho.departemen')->with('success', 'Departemen baru berhasil ditambahkan!');
    }

    public function editDepartemen($id)
    {
        $departemen = Departemen::findOrFail($id);

        return view('ho.departemen.edit', compact('departemen'));
    }

    public function updateDepartemen(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'kode_departemen' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $departemen = Departemen::findOrFail($id);
        $departemen->update($validated);

        return redirect()->route('ho.departemen')->with('success', 'Data departemen berhasil diubah!');
    }

    public function destroyDepartemen($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();

        return redirect()->route('ho.departemen')->with('success', 'Data departemen berhasil dihapus!');
    }

    // User
    public function user()
    {
        $users = User::paginate(50);

        return view('ho.user', compact('users'));
    }
    public function edituser($id)
    {
        $user = User::findOrFail($id);

        return view('ho.user.edit', compact('user'));
    }

    public function updateuser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:100',
            'role' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->role = strtolower($request->role);
        $user->update($validated);

        return redirect()->route('ho.user')->with('success', 'Data user berhasil diubah!');
    }

    public function destroyuser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('ho.user')->with('success', 'Data user berhasil dihapus!');
    }
}
