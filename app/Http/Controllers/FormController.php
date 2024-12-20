<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function form()
    {
        // Mengambil data cabang untuk ditampilkan pada form
        $cabangs = Cabang::all();
        return view('formpst.form', compact('cabangs'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'cabang' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'nama' => 'required|array', 
            'nik' => 'required|array',
            'departemen' => 'required|array',
            'lama' => 'required|array',
        ]);

        // Buat batch_id unik
        $batchId = Str::uuid(); // Menggunakan UUID untuk membuat batch ID yang lebih unik

        // Menyimpan data untuk setiap inputan dalam array
        foreach ($request->input('nama') as $index => $nama) {
            Form::create([
                'batch_id' => $batchId,
                'cabang' => $request->input('cabang'),
                'tujuan' => $request->input('tujuan'),
                'nama' => $nama,
                'nik' => $request->input('nik')[$index],
                'departemen' => $request->input('departemen')[$index],
                'lama' => $request->input('lama')[$index],
            ]);
        }

        // Redirect dengan batch_id
        return redirect()->route('formpst.batch', ['batchId' => $batchId])->with('success', 'Data berhasil ditambahkan!');
    }

    public function showBatch($batchId)
    {
        $forms = DB::table('forms')->get();
        return view('formpst.show', ['forms' => $forms]);
    }
}
