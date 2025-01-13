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

class FormController extends Controller
{
    // Menampilkan Form Input
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

    // Menyimpan Data Form
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

        $form = Form::create([
            'no_surat' => $validatedData['no_surat'],
            'nama_pemohon' => $validatedData['namaPemohon'],
            'cabang_asal' => Cabang::findOrFail($validatedData['cabang_asal'])->nama_cabang,
            'cabang_tujuan' => Cabang::findOrFail($validatedData['cabang_tujuan'])->nama_cabang,
            'tujuan' => Tujuan::findOrFail($validatedData['tujuan'])->tujuan_penugasan,
            'tanggal_keberangkatan' => $validatedData['tanggalKeberangkatan'],
        ]);

        foreach ($request->namaPegawai as $index => $namaPegawai) {
            $uploadFilePath = null;
            if ($request->hasFile("uploadFile.$index")) {
                $uploadFilePath = $request->file("uploadFile.$index")->store('uploads', 'public');
            }

            Nama_pegawai::create([
                'form_id' => $form->id,
                'nama_pegawai' => $namaPegawai,
                'departemen' => $request->departemen[$index],
                'nik' => $request->nik[$index],
                'upload_file' => $uploadFilePath,
                'lama_keberangkatan' => $request->lamaKeberangkatan[$index],
            ]);
        }

        return redirect()->route('formpst.index')->with('success', 'Data berhasil disimpan.');
    }

    // Menampilkan Data Form
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

        return view('formpst.index', compact('data', 'tujuans'));
    }

    public function show($id)
{
    $form = Form::findOrFail($id); // Ambil data form berdasarkan ID
    return view('formpst.show', compact('form'));
}


    // Menampilkan Form Edit
    public function edit($id)
    {
        $data = Nama_pegawai::findOrFail($id);
        $departemens = Departemen::all();

        return view('formpst.edit', compact('data', 'departemens'));
    }

    // Memperbarui Data Pegawai
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'lama' => 'required|string|max:255',
        ]);

        $data = Nama_pegawai::findOrFail($id);

        $data->update([
            'nama_pegawai' => $validatedData['nama'],
            'nik' => $validatedData['nik'],
            'departemen' => $validatedData['departemen'],
            'lama_keberangkatan' => $validatedData['lama'],
        ]);

        return redirect()->route('formpst.show', $data->form_id)->with('success', 'Data berhasil diperbarui!');
    }

    // Menampilkan Daftar Pegawai
    public function list()
    {
        $nama_pegawais = Nama_pegawai::select('form_id', 'nama_pegawai', 'id')->get();
        $grouped_pegawais = $nama_pegawais->groupBy('form_id');

        return view('formpst.list', compact('grouped_pegawais'));
    }

    // Verifikasi Form
    public function verify($id)
    {
        $form = Form::findOrFail($id);
        $form->update(['status_verifikasi' => 'submitted']);

        return redirect()->route('formpst.list')->with('success', 'Data berhasil diverifikasi!');
    }
}
