<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\cabang;


class HoController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('ho.dashboard');
    }

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
        return view('ho.tujuan');
    }    
    public function departemen(Request $request)
    {
        return view('ho.departemen');
    }
}
