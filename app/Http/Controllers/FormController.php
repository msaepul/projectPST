<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade as PDF;

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
        $cabangs = Cabang::all();
        $tujuans = Tujuan::all();
        $departemens = Departemen::all();
        $nama_pegawais = Nama_pegawai::all();
        $cabang_tujuans = Cabang_tujuan::all();

        $lastForm = Form::latest()->first();
        $lastNumber = $lastForm ? intval(substr($lastForm->no_surat, 0, 3)) : 0; 
        
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        
        $month = date('n'); 
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 
            11 => 'XI', 12 => 'XII'
        ];
        $romanMonth = $romanMonths[$month];
        
        $nomorSurat = "{$newNumber}/PST/HO/HRD/{$romanMonth}/" . date('Y');
        

        return view('formpst.form', compact('nomorSurat', 'cabangs', 'tujuans', 'departemens', 'nama_pegawais', 'cabang_tujuans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_surat' => 'required|string|max:255',
            'namaPemohon' => 'required|string|max:255',
            'cabang_asal' => 'required|exists:cabangs,id',
            'cabang_tujuan' => 'required|exists:cabangs,id',
            'tujuan' => 'required|exists:tujuans,id',
            'tanggalKeberangkatan' => 'required|date',

            'namaPegawai.*' => 'required|string|max:255',
            'departemen.*' => 'required|string|max:255',
            'nik.*' => 'required|string|max:255',
            'uploadFile.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamaKeberangkatan.*' => 'required|date',
        ]);

        $cabangAsal = Cabang::findOrFail($validatedData['cabang_asal'])->nama_cabang;
        $cabangTujuan = Cabang::findOrFail($validatedData['cabang_tujuan'])->nama_cabang;
        $tujuanPenugasan = Tujuan::findOrFail($validatedData['tujuan'])->tujuan_penugasan;

        $form = Form::create([
            'no_surat' => $validatedData['no_surat'],
            'nama_pemohon' => $validatedData['namaPemohon'],
            'cabang_asal' => $cabangAsal,
            'cabang_tujuan' => $cabangTujuan,
            'tujuan' => $tujuanPenugasan,
            'tanggal_keberangkatan' => $validatedData['tanggalKeberangkatan'],
        ]);

    $namaPegawais = [];

    foreach ($request->namaPegawai as $index => $namaPegawai) {
        $uploadFilePath = null;

            if ($request->hasFile("uploadFile.$index")) {
                $originalName = $request->file("uploadFile.$index")->getClientOriginalName();
                $uploadFilePath = $request->file("uploadFile.$index")->storeAs('uploads', $originalName, 'public');
        }

        $namaPegawais[] = [
            'form_id' => $form->id,
            'nama_pegawai' => $namaPegawai,
            'departemen' => $request->departemen[$index],
            'nik' => $request->nik[$index],
            'upload_file' => $uploadFilePath,
            'lama_keberangkatan' => $request->lamaKeberangkatan[$index],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    Nama_pegawai::insert($namaPegawais);

        return redirect()->route('formpst.index', ['form' => $form->id])
            ->with('success', 'Data berhasil disimpan.');
    }

public function index(Request $request)
{
    $query = Form::query();


    if ($request->filled('namaPemohon')) {
        $query->where('nama_pemohon', 'like', '%' . $request->namaPemohon . '%');
    }

    if ($request->filled('tujuan')) {
        $query->where('tujuan', $request->tujuan);
    }

    $data = $query->get();
    $tujuans = Tujuan::all();
    $forms = Form::all();

    return view('formpst.index', compact('data', 'tujuans','forms'));
}

public function index_masuk(Request $request)
{
    $query = Form::where('acc_ho', 'oke');
    

    if ($request->filled('namaPemohon')) {
        $query->where('nama_pemohon', 'like', '%' . $request->namaPemohon . '%');
    }

    if ($request->filled('tujuan')) {
        $query->where('tujuan', $request->tujuan);
    }

    $data = $query->get();
    $tujuans = Tujuan::all();
    $forms = Form::all();

    return view('formpst.index_masuk', compact('data', 'tujuans','forms'));
}

public function index_surat(Request $request)
{
    $query = Form::where('acc_cabang', 'oke');
    

    if ($request->filled('namaPemohon')) {
        $query->where('nama_pemohon', 'like', '%' . $request->namaPemohon . '%');
    }

    if ($request->filled('tujuan')) {
        $query->where('tujuan', $request->tujuan);
    }

    $data = $query->get();
    $tujuans = Tujuan::all();
    $forms = Form::all();

    return view('formpst.index_surat', compact('data', 'tujuans','forms'));
}

public function show($id)
{
    $form = Form::findOrFail($id);

    $data = Nama_pegawai::where('form_id', $form->id)->get();

    return view('formpst.show', compact('form', 'data'));
}

public function surat_tugas($id)
{
    $form = Form::findOrFail($id);

    $data = Nama_pegawai::where('form_id', $form->id)->get();

    return view('formpst.surat_tugas', compact('form', 'data'));
}

public function submit(Request $request, $id)
{
    $form = Form::findOrFail($id);

    switch ($request->action) {
        case 'acc_bm':
            $form->acc_bm = 'oke';
            $message = 'Persetujuan BM berhasil disimpan.';
            break;

        case 'reject_bm':
            $form->acc_bm = 'reject';
            $message = 'Persetujuan BM ditolak.';
            break;

            case 'acc_hrd':
                if ($form->acc_bm !== 'oke') {
                    return redirect()->back()->with('error', 'BM belum menyetujui.');
                }
                $form->acc_hrd = 'oke';
                $form->save(); 
                $message = 'Persetujuan HRD berhasil disimpan.';
                return redirect()->route('hrd.index_hrd')->with('success', $message);
                break;
            

        case 'reject_hrd':
            if ($form->acc_bm !== 'oke') {
                return redirect()->back()->with('error', 'BM belum menyetujui.');
            }
            $form->acc_hrd = 'reject';
            $message = 'Persetujuan HRD ditolak.';
            break;

        case 'acc_ho':
            if ($form->acc_hrd !== 'oke') {
                return redirect()->back()->with('error', 'HRD belum menyetujui.');
            }
            $form->acc_ho = 'oke';
            $form->save();
            $message = 'Persetujuan HO berhasil disimpan.';
            return redirect()->route('formpst.index_masuk')->with('success', $message);

            break;

        case 'reject_ho':
            if ($form->acc_hrd !== 'oke') {
                return redirect()->back()->with('error', 'HRD belum menyetujui.');
            }
            $form->acc_ho = 'reject';
            $message = 'Persetujuan HO ditolak.';
            break;

            case 'acc_cabang':
                if ($form->acc_ho !== 'oke') {
                    return redirect()->back()->with('error', 'HRD belum menyetujui.');
                }
                $form->acc_cabang = 'oke';
                $message = 'Persetujuan HO berhasil disimpan.';
                break;
    
            case 'reject_cabang':
                if ($form->acc_ho !== 'oke') {
                    return redirect()->back()->with('error', 'HRD belum menyetujui.');
                }
                $form->acc_cabang = 'reject';
                $message = 'Persetujuan HO ditolak.';
                break;

        default:
            return redirect()->back()->with('error', 'Aksi tidak valid.');
    }

    $form->save();

    return redirect()->back()->with('success', $message);
}

public function edit($id)
{

    $form = Form::with(['cabangAsal:id,nama_cabang', 'cabangTujuan:id,nama_cabang'])->findOrFail($id);

    $nama_pegawais = Nama_pegawai::where('form_id', $form->id)->get();
    $cabangs = Cabang::all();
    $tujuans = Tujuan::all();
    $departemens = Departemen::all();

    return view('formpst.edit', compact('form', 'nama_pegawais', 'cabangs', 'tujuans', 'departemens'));
}

public function update(Request $request, $id)
{
    $form = Form::findOrFail($id);

    $request->validate([
        'cabang_asal' => 'required|exists:cabangs,id',
        'cabang_tujuan' => 'required|exists:cabangs,id',
        'tujuan' => 'required|exists:tujuans,id',
        'tanggal_keberangkatan' => 'required|date',
    ]);

    // Ambil nama cabang berdasarkan ID
    $cabangAsal = Cabang::findOrFail($request->cabang_asal)->nama_cabang;
    $cabangTujuan = Cabang::findOrFail($request->cabang_tujuan)->nama_cabang;

    // Ambil tujuan penugasan
    $tujuanPenugasan = Tujuan::findOrFail($request->tujuan)->tujuan_penugasan;

    // Update form dengan nama cabang
    $form->update([
        'cabang_asal' => $cabangAsal,
        'cabang_tujuan' => $cabangTujuan,
        'tujuan_id' => $tujuanPenugasan,
        'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
    ]);

    // Update nama pegawai
    foreach ($request->nama as $key => $value) {
        $nama_pegawais = Nama_pegawai::find($key);
        if ($nama_pegawais) {
            $nama_pegawais->update([
                'nama_pegawai' => $value,
                'nik' => $request->nik[$key],
                'departemen' => $request->departemen[$key],
                'lama_keberangkatan' => $request->lama_keberangkatan[$key],
                'status' => $request->status[$key],
                'keterangan' => $request->keterangan[$key],
            ]);

            if ($request->hasFile("file.$key")) {
                $filePath = $request->file("file.$key")->store('uploads', 'public');
                $nama_pegawais->update(['upload_file' => $filePath]);
            }
        }
    }

    return redirect()->route('formpst.index')->with('success', 'Data berhasil diperbarui');
}




public function updateStatus($itemId, $status, Request $request)
{
    $item = Nama_pegawai::find($itemId);

    if ($item) {
        $item->acc_nm = $status;

        if ($status == 'tolak') {
            $request->validate([
                'alasan' => 'required|string|max:255',
            ]);

        
            $item->alasan = $request->alasan;
        } elseif ($status == 'oke') {
            $item->alasan = 'Diterima';
        }
                $item->save();
        

        return response()->json([
            'message' => 'Status berhasil diperbarui.',
            'status' => $status
        ]);

    }

    return response()->json([
        'message' => 'Data pegawai tidak ditemukan.'
    ], 404);
}



}
