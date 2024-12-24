<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\Tujuan;
use App\Models\Cabang;

class HoController extends Controller
{
    // Dashboard
    public function dashboard(Request $request)
    {
        $jumlahCabang = Cabang::count();
        $jumlahDepartemen = Departemen::count();

        return view('dashboard', compact('jumlahCabang', 'jumlahDepartemen'));
    }

    // Cabang
    public function cabang(Request $request)
    {
        $cabangs = Cabang::paginate(50);
        return view('ho.cabang', compact('cabangs'));
    }

    // Store Cabang
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

    // Add Cabang
    public function add(Request $request)
    {
        return view('ho.add_cabang');
    }

    // Edit Cabang
    public function edit($id)
    {
        $data = Cabang::findOrFail($id);

        return view('ho.cabang.edit', compact('data'));
    }

    // Update Cabang
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

    // Destroy Cabang
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
            $query->where('tujuan_penugasan', 'like', "%{$search}%");
        })->paginate(50);

        return view('ho.tujuan', compact('tujuans', 'search'));
    }

    // Store Tujuan
    public function storeTujuan(Request $request)
    {
        $validated = $request->validate([
            'tujuan_penugasan' => 'required|string|max:255',
        ]);

        Tujuan::create($validated);

        return redirect()->route('ho.tujuan')->with('success', 'Tujuan baru berhasil ditambahkan!');
    }

    // Edit Tujuan
    public function editTujuan($id)
    {
        $tujuan = Tujuan::findOrFail($id);

        return view('ho.tujuan.edit', compact('tujuans'));
    }

    // Update Tujuan
    public function updateTujuan(Request $request, $id)
    {
        $validated = $request->validate([
            'tujuan_penugasan' => 'required|string|max:255',
        ]);

        $tujuan = Tujuan::findOrFail($id);
        $tujuan->update($validated);

        return redirect()->route('ho.tujuan')->with('success', 'Data tujuan berhasil diubah!');
    }

    // Destroy Tujuan
    public function destroyTujuan($id)
    {
        $tujuan = Tujuan::findOrFail($id);
        $tujuan->delete();

        return redirect()->route('ho.tujuan')->with('success', 'Data tujuan berhasil dihapus!');
    }

    // Departemen
    public function departemen(Request $request)
    {
        $departemens = Departemen::paginate(50);

        return view('ho.departemen', compact('departemens'));
    }

    // Store Departemen
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

    // Edit Departemen
    public function editDepartemen($id)
    {
        $departemen = Departemen::findOrFail($id);

        return view('ho.departemen.edit', compact('departemen'));
    }

    // Update Departemen
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

    // Destroy Departemen
    public function destroyDepartemen($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();

        return redirect()->route('ho.departemen')->with('success', 'Data departemen berhasil dihapus!');
    }
}
