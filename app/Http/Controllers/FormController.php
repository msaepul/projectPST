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
        $cabangs = Cabang::all();
        $tujuans = Tujuan::all();
        $departemens = Departemen::all();
        $nama_pegawais = Nama_pegawai::all();
        $cabang_tujuans = Cabang_tujuan::all();

        $lastForm = Form::latest()->first();
        $lastNumber = $lastForm ? intval(substr($lastForm->no_surat, -4)) : 0;

        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $nomorSurat = 'HRD/' . date('Y') . '/' . $newNumber;

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

        // Simpan data ke tabel forms
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

        // Menambahkan data ke dalam array
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

    // Menyimpan semua data sekaligus
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

public function show($id)
{
    // Mengambil form berdasarkan ID
    $form = Form::findOrFail($id);

    // Mengambil data pegawai terkait dengan form_id
    $data = Nama_pegawai::where('form_id', $form->id)->get();

    // Kirim data ke view
    return view('formpst.show', compact('form', 'data'));
}

public function submitForm(Request $request, $formId)
{
    $form = Form::findOrFail($formId);

    // Ambil aksi yang dikirimkan (submit atau reject)
    $action = $request->input('action');

    // Cek apakah form sudah disetujui atau ditolak sepenuhnya
    if ($form->acc_bm == 'oke' || $form->acc_bm == 'reject') {
        if ($form->acc_hrd == 'oke' || $form->acc_hrd == 'reject') {
            return redirect()->back()->with('info', 'Form sudah disetujui sepenuhnya.');
        } else {
            // Jika HRD belum disetujui, sesuaikan statusnya berdasarkan aksi
            $form->acc_hrd = $action == 'submit' ? 'oke' : 'reject';
        }
    } else {
        // Jika BM belum disetujui, sesuaikan statusnya berdasarkan aksi
        $form->acc_bm = $action == 'submit' ? 'oke' : 'reject';
    }

    // Simpan perubahan ke database
    $form->save();

    // Kembalikan response dengan pesan sukses
    return redirect()->back()->with('success', 'Form berhasil disubmit!');
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

    $form->update([
        'cabang_asal' => $request->cabang_asal,
        'cabang_tujuan' => $request->cabang_tujuan,
        'tujuan_id' => $request->tujuan,
        'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
    ]);

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

        // Menyimpan perubahan
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
