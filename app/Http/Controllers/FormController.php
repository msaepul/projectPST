<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Nama_pegawai;
use App\Models\Cabang_tujuan;
use App\Models\Tujuan;
use App\Models\Departemen;
use App\Models\Form;

use App\Models\User;
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
        $users = User::all();

        $lastForm = Form::where('cabang_asal', auth()->user()->cabang_asal)->latest()->first();
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


        return view('formpst.form', compact('nomorSurat','users', 'cabangs', 'tujuans', 'departemens', 'nama_pegawais', 'cabang_tujuans'));
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

        'namaPegawai.*' => 'required|string|max:255', // ID pegawai
        'namaPegawaiNama.*' => 'required|string|max:255', // Nama lengkap pegawai
        'departemen.*' => 'required|string|max:255',
        'nik.*' => 'required|string|max:255',
        'uploadFile.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'lamaKeberangkatan.*' => 'required|date',
    ]);

    // Ambil nama cabang dan tujuan dari tabel terkait
    $cabangAsal = Cabang::findOrFail($validatedData['cabang_asal'])->nama_cabang;
    $cabangTujuan = Cabang::findOrFail($validatedData['cabang_tujuan'])->nama_cabang;
    $tujuanPenugasan = Tujuan::findOrFail($validatedData['tujuan'])->tujuan_penugasan;

    // Buat data form utama
    $form = Form::create([
        'no_surat' => $validatedData['no_surat'],
        'nama_pemohon' => $validatedData['namaPemohon'],
        'cabang_asal' => $cabangAsal,
        'cabang_tujuan' => $cabangTujuan,
        'tujuan' => $tujuanPenugasan,
        'tanggal_keberangkatan' => $validatedData['tanggalKeberangkatan'],
    ]);

    // Siapkan data pegawai untuk insert batch
    $namaPegawais = [];

    foreach ($request->namaPegawai as $index => $pegawaiId) {
        $uploadFilePath = null;

        // Upload file jika ada
        if ($request->hasFile("uploadFile.$index")) {
            $originalName = $request->file("uploadFile.$index")->getClientOriginalName();
            $uploadFilePath = $request->file("uploadFile.$index")->storeAs('uploads', $originalName, 'public');
        }

        // Tambahkan data ke array
        $namaPegawais[] = [
            'form_id' => $form->id,
            'nama_pegawai' => $request->namaPegawaiNama[$index], // Nama lengkap pegawai
            'departemen' => $request->departemen[$index],
            'nik' => $request->nik[$index],
            'upload_file' => $uploadFilePath,
            'lama_keberangkatan' => $request->lamaKeberangkatan[$index],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Masukkan data pegawai ke database
    Nama_pegawai::insert($namaPegawais);

    // Redirect dengan pesan sukses
    return redirect()->route('formpst.index_keluar', ['form' => $form->id])
        ->with('success', 'Data berhasil disimpan.');
}


public function index_keluar(Request $request)
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

    return view('formpst.index_keluar', compact('data', 'tujuans','forms'));
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
public function generatePdf($targetFormId)
    {
        try {
            // Ambil data form berdasarkan ID
            $form = Form::findOrFail($targetFormId);

            // Ambil data pegawai yang ditugaskan (pastikan relasi di model sudah benar)
            $data = Nama_pegawai::where('form_id', $targetFormId)->get();

            if (!$form || $data->isEmpty()) {
                // Log jika data tidak ditemukan
                Log::error("Data form atau data pegawai tidak ditemukan untuk form ID: {$targetFormId}");
                abort(404, 'Data tidak ditemukan.');
            }

            // Set options untuk DOMPDF (opsional, tapi disarankan)
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true); // Aktifkan jika view PDF menggunakan kode PHP
            $options->set('chroot', public_path()); // Penting untuk path gambar relatif

            // Inisialisasi DOMPDF dengan options
            $dompdf = new \Dompdf\Dompdf($options);

            // Load HTML dari view dan kirimkan data
            $html = View::make('formpst.surat_tugas_pdf', compact('form', 'data', 'targetFormId'))->render(); //gunakan view::make agar bisa di render dengan benar

            // Load HTML ke DOMPDF
            $dompdf->loadHtml($html);

            // Set ukuran kertas dan orientasi
            $dompdf->setPaper('A4', 'portrait');

            // Render PDF
            $dompdf->render();

            return $dompdf->stream('surat_tugas_' . $form->no_surat . '.pdf', ['Attachment' => 0]); 
        } catch (\Exception $e) {
            Log::error("Error saat generate PDF untuk form ID: {$targetFormId}. Error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat membuat PDF. Silakan coba lagi.'); 
        }
    }

public function submit(Request $request, $id)
{
    $form = Form::findOrFail($id);

    switch ($request->action) {
        case 'acc_bm':
            $form->acc_bm = 'oke';
            $form->save();

            $message = 'Persetujuan BM berhasil disimpan.';
            return redirect()->route('formpst.index_keluar')->with('success', $message);

        case 'reject_bm':
            $form->acc_bm = 'reject';
            $form->save();

            $message = 'Persetujuan BM ditolak.';
            return redirect()->route('formpst.index_keluar')->with('success', $message);

        case 'cancel':
            // Reset semua status persetujuan
            $form->acc_bm = 'cancel';
            $form->acc_hrd = 'cancel';
            $form->acc_ho = 'cancel';
            $form->acc_cabang = 'cancel';
            $form->save();

            $message = 'Semua persetujuan telah dibatalkan.';
            return redirect()->route('formpst.index_keluar')->with('success', $message);

        case 'acc_hrd':
            if ($form->acc_bm !== 'oke') {
                return redirect()->back()->with('error', 'BM belum menyetujui.');
            }
            $form->acc_hrd = 'oke';
            $form->save();
            $message = 'Persetujuan HRD berhasil disimpan.';
            return redirect()->route('hrd.index_hrd_cabang')->with('success', $message);

        case 'reject_hrd':
            if ($form->acc_bm !== 'oke') {
                return redirect()->back()->with('error', 'BM belum menyetujui.');
            }
            $form->acc_hrd = 'reject';
            $form->save();

            $message = 'Persetujuan HRD ditolak.';
            return redirect()->route('hrd.index_hrd_cabang')->with('success', $message);

        case 'acc_ho':
            if ($form->acc_hrd !== 'oke') {
                return redirect()->back()->with('error', 'HRD belum menyetujui.');
            }
            $form->acc_ho = 'oke';
            $form->save();
            $message = 'Persetujuan HO berhasil disimpan.';
            return redirect()->route('hrd.index_hrd')->with('success', $message);

        case 'reject_ho':
            if ($form->acc_hrd !== 'oke') {
                return redirect()->back()->with('error', 'HRD belum menyetujui.');
            }
            $form->acc_ho = 'reject';
            $form->save();
            $message = 'Persetujuan HO ditolak.';

            return redirect()->route('hrd.index_hrd')->with('success', $message);

        case 'acc_cabang':
            if ($form->acc_ho !== 'oke') {
                return redirect()->back()->with('error', 'HO belum menyetujui.');
            }
            $form->acc_cabang = 'oke';
            $form->save();

            $message = 'Persetujuan Cabang berhasil disimpan.';
            return redirect()->route('formpst.index_masuk')->with('success', $message);

        case 'reject_cabang':
            if ($form->acc_ho !== 'oke') {
                return redirect()->back()->with('error', 'HO belum menyetujui.');
            }
            $form->acc_cabang = 'reject';
            $form->save();

            $message = 'Persetujuan Cabang ditolak.';
            return redirect()->route('formpst.index_masuk')->with('success', $message);

        default:
            return redirect()->back()->with('error', 'Aksi tidak valid.');
    }
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
        'acc_bm' => '',
        'acc_hrd' => '',
        'acc_ho' => '',
        'acc_cabang' => '',

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
                'acc_nm' => '',
                'alasan' => '',
            ]);

            if ($request->hasFile("file.$key")) {
                $filePath = $request->file("file.$key")->store('uploads', 'public');
                $nama_pegawais->update(['upload_file' => $filePath]);
            }
        }
    }

    return redirect()->route('formpst.index_keluar')->with('success', 'Data berhasil diperbarui');
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

public function form_nm()
{
    // Ambil data yang mungkin diperlukan oleh view
    $cabangs = Cabang::all();
    $tujuans = Tujuan::all();
    $departemens = Departemen::all();
    $nama_pegawais = Nama_pegawai::all();
    $cabang_tujuans = Cabang_tujuan::all();
    $users = User::all();

    // Siapkan nomor surat baru jika diperlukan
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

    return view('formpst.form_nm', compact('nomorSurat', 'users', 'cabangs', 'tujuans', 'departemens', 'nama_pegawais', 'cabang_tujuans'));
}

public function store_nm(Request $request)
{
    // Validasi data dari form
    $validatedData = $request->validate([
        'no_surat' => 'required|string|max:255',
        'namaPemohon' => 'required|string|max:255',
        'cabang_asal' => 'required|exists:cabangs,id',
        'cabang_tujuan' => 'required|exists:cabangs,id',
        'tujuan' => 'required|exists:tujuans,id',
        'tanggalKeberangkatan' => 'required|date',

        'namaPegawai.*' => 'required|string|max:255', // ID pegawai
        'namaPegawaiNama.*' => 'required|string|max:255', // Nama lengkap pegawai
        'departemen.*' => 'required|string|max:255',
        'nik.*' => 'required|string|max:255',
        'uploadFile.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'lamaKeberangkatan.*' => 'required|date',
    ]);

    // Ambil nama cabang dan tujuan dari tabel terkait
    $cabangAsal = Cabang::findOrFail($validatedData['cabang_asal'])->nama_cabang;
    $cabangTujuan = Cabang::findOrFail($validatedData['cabang_tujuan'])->nama_cabang;
    $tujuanPenugasan = Tujuan::findOrFail($validatedData['tujuan'])->tujuan_penugasan;

    // Simpan data form utama
    $form = Form::create([
        'no_surat' => $validatedData['no_surat'],
        'nama_pemohon' => $validatedData['namaPemohon'],
        'cabang_asal' => $cabangAsal,
        'cabang_tujuan' => $cabangTujuan,
        'tujuan' => $tujuanPenugasan,
        'tanggal_keberangkatan' => $validatedData['tanggalKeberangkatan'],
    ]);

    // Siapkan data pegawai untuk insert batch
    $namaPegawais = [];

    foreach ($request->namaPegawai as $index => $pegawaiId) {
        $uploadFilePath = null;

        // Upload file jika ada
        if ($request->hasFile("uploadFile.$index")) {
            $originalName = $request->file("uploadFile.$index")->getClientOriginalName();
            $uploadFilePath = $request->file("uploadFile.$index")->storeAs('uploads', $originalName, 'public');
        }

        // Tambahkan data ke array
        $namaPegawais[] = [
            'form_id' => $form->id,
            'nama_pegawai' => $request->namaPegawaiNama[$index], // Nama lengkap pegawai
            'departemen' => $request->departemen[$index],
            'nik' => $request->nik[$index],
            'upload_file' => $uploadFilePath,
            'lama_keberangkatan' => $request->lamaKeberangkatan[$index],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Masukkan data pegawai ke database
    Nama_pegawai::insert($namaPegawais);

    // Redirect dengan pesan sukses
    return redirect()->route('formpst.form_nm')
        ->with('success', 'Data berhasil disimpan.');
}
}

