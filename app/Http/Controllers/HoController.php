<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\Tujuan;
=======

use App\Models\cabang;



class HoController extends Controller
{
    // Dashboard
    public function dashboard(Request $request)
    {
        $jumlahDepartemen = Departemen::count();

        return view('dashboard', compact('jumlahDepartemen'));
    }


    // Cabang
    public function cabang(Request $request)
    {
        return view('ho.cabang');
    }

    // Tujuan
=======
    public function cabang()
    {
        // Ambil semua data cabang
        $cabangs = Cabang::all();

        // Kirimkan ke view
        return view('ho.cabang', compact('cabangs'));
    }
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'kode_cabang' => 'required|string|max:10',
        ]);

        // Simpan data ke database
        cabang::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('ho.cabang')->with('success', 'Data cabang berhasil ditambahkan!');
    }
    public function add(Request $request)
    {
        return view('ho.add_cabang');
    }

    public function edit($id)
    {
        // Mencari data berdasarkan ID yang diberikan
        $data = canbang::findOrFail($id);

        // Mengirimkan data ke view
        return view('cabang.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'kode_cabang' => 'required|string|max:10',
        ]);

        // $cabang = Cabang::findOrFail($id);
        // $cabang->nama_cabang = $request->nama_cabang;
        // $cabang->alamat_cabang = $request->alamat_cabang;
        // $cabang->kode_cabang = $request->kode_cabang;
        // dd();


        // $cabang->save();

        $cabang = Cabang::findOrFail($id);
        $cabang->fill($request->all());
        $cabang->save();


        return redirect()->back()->with('success', 'Data cabang berhasil diubah.');
    }


    public function destroy($id)
    {
        // Mencari data berdasarkan ID yang diberikan
        $data = cabang::findOrFail($id);

        // Menghapus data dari database
        $data->delete();

        // Mengarahkan kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('ho.cabang')->with('success', 'Data berhasil dihapus!');
    }
    

    public function tujuan(Request $request)
    {
        $search = $request->input('search');
        $tujuans = Tujuan::when($search, function ($query, $search) {
            $query->where('tujuan_penugasan', 'like', "%{$search}%");
        })->paginate(5); // Menambahkan pagination, 10 data per halaman

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
        return view('ho.tujuan.edit', compact('tujuan')); // Mengedit data Tujuan
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
    public function departemen(Request $request)
    {
        $departemens = Departemen::all();
        return view('ho.departemen', compact('departemens')); // Menampilkan data Departemen
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
        return view('ho.departemen.edit', compact('departemen')); // Mengedit data Departemen
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
}
