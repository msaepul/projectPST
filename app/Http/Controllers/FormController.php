<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Nama_pegawai;
use App\Models\Cabang_tujuan;
use App\Models\Tujuan;
use App\Models\Departemen;
use App\Models\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function form()
    {
        $cabangs = Cabang::all();
        $nama_pegawais = Nama_pegawai::all();
        $cabang_tujuans = Cabang_tujuan::all();
        $tujuans = Tujuan::all();
        $departemens = Departemen::all();
    
        return view('formpst.form', compact('cabangs', 'tujuans', 'departemens', 'nama_pegawais', 'cabang_tujuans'));
    }
    

     public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'cabang' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'nama' => 'required|array', 
            'nik' => 'required|array',
            'departemen' => 'required|array',
            'lama' => 'required|array',
        ]);

        // Ambil nama cabang berdasarkan ID cabang
        $cabang = Cabang::find($request->input('cabang'));
        if ($cabang) {
            $cabangNama = $cabang->nama_cabang; // Ambil nama cabang
        } else {
            return redirect()->back()->withErrors(['cabang' => 'Cabang tidak ditemukan!']);
        }

        $tujuan = Tujuan::find($request->input('tujuan'));
        if ($tujuan) {
            $tujuanNama = $tujuan->tujuan_penugasan; // Ambil nama tujuan
        } else {
            return redirect()->back()->withErrors(['tujuan' => 'Tujuan tidak ditemukan!']);
        }
        
        
        // // Menyimpan data form
        // foreach ($request->input('nama') as $index => $nama) {
        //     Form::create([
        //         'cabang' => $cabangNama, // Simpan nama cabang
        //         'tujuan' => $tujuanNama, // Simpan nama tujuan
        //         'nama' => $nama,
        //         'nik' => $request->input('nik')[$index],
        //         'departemen' => $request->input('departemen')[$index],
        //         'lama' => $request->input('lama')[$index],
        //     ]);
        // }

        foreach ($request->input('nama') as $index => $nama) {

            DB::table('nama_pegawais')->insert([
                'nama' => $nama,
                'nik' => $request->input('nik')[$index],
                'departemen' => $request->input('departemen')[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            DB::table('cabang_tujuans')->insert([
                'cabang' => $cabangNama, 
                'tujuan' => $tujuanNama, 
                'lama' => $request->input('lama')[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('formpst.show')->with('success', 'Data berhasil ditambahkan!');
    }

    
    public function show()
    {
        $nama_pegawais = Nama_pegawai::all();
        $cabang_tujuans = Cabang_tujuan::all();
    
        $data = $nama_pegawais->map(function ($pegawai, $index) use ($cabang_tujuans) {
            return [
                'nama' => $pegawai->nama,
                'nik' => $pegawai->nik,
                'departemen' => $pegawai->departemen,
                'lama' => $cabang_tujuans[$index]->lama ?? '-',
                'cabang' => $cabang_tujuans[$index]->cabang ?? '-',
                'tujuan' => $cabang_tujuans[$index]->tujuan ?? '-',
            ];
        });
    
        return view('formpst.show', compact('data'));
    }

    public function list()
    {
        $nama_pegawais = Nama_pegawai::all();
        $cabang_tujuans = Cabang_tujuan::all();
    
        $data = $nama_pegawais->map(function ($pegawai, $index) use ($cabang_tujuans) {
            return [
                'nama' => $pegawai->nama,
                'nik' => $pegawai->nik,
                'departemen' => $pegawai->departemen,
                'lama' => $cabang_tujuans[$index]->lama ?? '-',
                'cabang' => $cabang_tujuans[$index]->cabang ?? '-',
                'tujuan' => $cabang_tujuans[$index]->tujuan ?? '-',
            ];
        });
    
        return view('formpst.list', compact('data'));
    }
    

}
