<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Nama_pegawai;
use App\Models\Cabang_tujuan;
use App\Models\Tujuan;
use App\Models\Departemen;
use App\Models\Pengajuan;
use App\Models\Form;
// use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function form()
    {
        // Ambil data dari tabel terkait
        $cabangs = Cabang::all();
        $tujuans = Tujuan::all();
        $departemens = Departemen::all();
        $nama_pegawais = Nama_pegawai::all();
        $cabang_tujuans = Cabang_tujuan::all();
    
        // Ambil nomor surat terakhir
        $lastForm = Form::latest()->first();
        $lastNumber = $lastForm ? intval(substr($lastForm->nomor_surat, -4)) : 0;
    
        // Buat nomor surat baru
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $nomorSurat = 'HRD/' . date('Y') . '/' . $newNumber;
    
        // Kirim data ke view
        return view('formpst.form', compact('nomorSurat', 'cabangs', 'tujuans', 'departemens', 'nama_pegawais', 'cabang_tujuans'));
    }
    

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'cabang' => 'required|exists:cabangs,id',
    //         'ct' => 'required|array|min:1',
    //         'tujuan' => 'required|exists:tujuans,id',
    //         'tp' => 'required|array|min:1',
    //         'nama' => 'required|array|min:1',
    //         'nik' => 'required|array|min:1',
    //         'departemen' => 'required|array|min:1',
    //         'lama' => 'required|array|min:1',
    //     ]);
    //     $nama_cabang = Cabang::where('id', $request->cabang)->value('nama_cabang');
    //     // $cabang_tujuan = Cabang_tujuan::where('id', $request->ct)->value('nama_cabang');
    //     $tujuan = Tujuan::where('id', $request->tujuan)->value('tujuan_penugasan');
    //     // $tujuan_penugasan = Cabang_tujuan::where('id', $request->tp)->value('tujuan_penugasan');


    // $form = Form::create([
    //     'cabang' => $nama_cabang,   
    //     'tujuan' => $tujuan,
    // ]);
    // // $cabang_tujuan = Cabang_tujuan::create([
    // //     'ct' => $cabang_tujuan,       
    // //     'tp' => $tujuan_penugasan,    
    // // ]);

    //     foreach ($request->nama as $index => $nama) {
    //         Nama_pegawai::create([
    //             'nama' => $nama,
    //             'nik' => $request->nik[$index],
    //             'departemen' => $request->departemen[$index],
    //             'lama' => $request->lama[$index],
    //             'form_id' => $form->id,  
    //         ]);
            
    //     }

    //     return redirect()->route('formpst.show')->with('success', 'Data berhasil disimpan');
    // }

    public function store(Request $request)
{
    $request->validate([
        'cabang' => 'required|exists:cabangs,id',
        'tujuan' => 'required|exists:tujuans,id',
        'nama' => 'required|array|min:1',
        'nik' => 'required|array|min:1',
        'departemen' => 'required|array|min:1',
        'lama' => 'required|array|min:1',
        // 'ct' => 'required|array|min:1',
        // 'tp' => 'required|array|min:1',
    ]);

    $nama_cabang = Cabang::where('id', $request->cabang)->value('nama_cabang');
    $tujuan = Tujuan::where('id', $request->tujuan)->value('tujuan_penugasan');

    $form = Form::create([
        'cabang' => $nama_cabang,
        'tujuan' => $tujuan,
    ]);


        foreach ($request->nama as $index => $nama) {
            Nama_pegawai::create([
                'nama' => $nama,
                'nik' => $request->nik[$index],
                'departemen' => $request->departemen[$index],
                'lama' => $request->lama[$index],
                'form_id' => $form->id,
            ]);

        }

        return redirect()->route('formpst.show')->with('success', 'Data berhasil disimpan');

    foreach ($request->nama as $index => $nama) {
        Nama_pegawai::create([
            'nama' => $nama,
            'nik' => $request->nik[$index],
            'departemen' => $request->departemen[$index],
            'lama' => $request->lama[$index],
            'ct' => $nama_cabang,
            'tp' => $tujuan,
            'form_id' => $form->id,
        ]);

    }


    return redirect()->route('formpst.show')->with('success', 'Data berhasil disimpan');
}

    


    // public function show()
    // {
    //     $idsInPengajuan = Pengajuan::pluck('nama');

    //     $nama_pegawais = Nama_pegawai::whereNotIn('nama', $idsInPengajuan)->get();

    //     $forms = Form::whereNotIn('id', $idsInPengajuan)->get();

    //     $data = $nama_pegawais->map(function ($pegawai, $index) use ($forms) {
    //         $cabangTujuan = $forms->get($index);

    //         return [
    //             'id' => $pegawai->id,
    //             'form.id' => $pegawai->form_id,
    //             'nama' => $pegawai->nama,
    //             'nik' => $pegawai->nik,
    //             'departemen' => $pegawai->departemen,
    //             'lama' => $pegawai->lama,
    //             'cabang' => $cabangTujuan->cabang ?? '-',
    //             'tujuan' => $cabangTujuan->tujuan ?? '-',
    //         ];
    //     });

    public function show()
{
    // Ambil data pengajuan untuk filter
    $idsInPengajuan = Pengajuan::pluck('nama');

    $nama_pegawais = Nama_pegawai::whereNotIn('nama', $idsInPengajuan)->get();

    // Ambil data form berdasarkan form_id pada pegawai
    $forms = Form::whereIn('id', $nama_pegawais->pluck('form_id'))->get()->keyBy('id');

    $data = $nama_pegawais->map(function ($pegawai) use ($forms) {
        $form = $forms->get($pegawai->form_id); // Ambil form berdasarkan form_id

        return [
            'id' => $pegawai->id,
            'form_id' => $pegawai->form_id,
            'nama' => $pegawai->nama,
            'nik' => $pegawai->nik,
            'departemen' => $pegawai->departemen,
            'lama' => $pegawai->lama,
            'cabang' => $form->cabang ?? '-',
            'tujuan' => $form->tujuan ?? '-',
        ];
    });

        return view('formpst.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Nama_pegawai::find($id);

        if (!$data) {
            return redirect()->route('formpst.show')->with('error', 'Data pegawai tidak ditemukan!');
        }

        $departemens = Departemen::all();

        return view('formpst.edit', compact('data', 'departemens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'lama' => 'required|string|max:255',
        ]);

        $data = Nama_pegawai::findOrFail($id);

        $data->update([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'departemen' => $request->departemen,
            'lama' => $request->lama,
        ]);

        return redirect()->route('formpst.show')->with('success', 'Data berhasil diperbarui!');
    }


    public function list(Pengajuan $post)
    {
        // Ambil semua pegawai
        $nama_pegawais = Nama_pegawai::all();

        // Ambil form berdasarkan form_id
        $forms = Form::all()->keyBy('id'); // KeyBy agar memudahkan pencarian berdasarkan form_id

        // Kelompokkan pegawai berdasarkan form_id
        $grouped_pegawais = $nama_pegawais->groupBy('form_id');

        // Kirim data forms ke tampilan
        return view('formpst.list', compact('grouped_pegawais', 'forms'));
    }

    public function list()
{
    // Ambil semua data Nama_pegawai
    $nama_pegawais = Nama_pegawai::select('form_id', 'ct', 'id')->get();

    // Kelompokkan data berdasarkan form_id
    $grouped_pegawais = $nama_pegawais->groupBy('form_id');

    // Kirim data ke view
    return view('formpst.list', compact('grouped_pegawais'));
}

    // public function list(Pengajuan $post)
    // {
    //     // Ambil hanya data pegawai yang terkait dengan form pengajuan tertentu
    //     $nama_pegawais = Nama_pegawai::where('nama', $post->id)->get();
    
    //     // Group data pegawai berdasarkan 'form_id'
    //     $grouped_pegawais = $nama_pegawais->groupBy('form_id');
    
    //     return view('formpst.list', compact('grouped_pegawais'));
    // }
    public function verify($id)
{
    // Lakukan logika verifikasi di sini, misalnya mengupdate status di database
    $form = Form::findOrFail($id);
    $form->status_verifikasi = 'submitted';
    $form->save();

    return redirect()->route('formpst.list')->with('success', 'Data berhasil diverifikasi!');
}



    }
