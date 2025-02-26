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
use Carbon\Carbon;
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
        $users = User::where('cabang_asal', auth()->user()->cabang_asal)->get();
        $nm = User::where('departemen', auth()->user()->departemen)->get();
    
        $user = auth()->user();
    
        $kodeCabang = $user->cabang_asal; 

        $lastForm = Form::where('cabang_asal', $user->cabang_asal)->latest()->first();
        $lastNumber = $lastForm ? intval(substr($lastForm->no_surat, 0, 3)) : 0;
    
        // Generate nomor baru
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    
        // Konversi bulan ke format Romawi
        $month = date('n');
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        $romanMonth = $romanMonths[$month];
    
        // Format nomor surat
        $nomorSurat = "{$newNumber}/PST/{$kodeCabang}/{$romanMonth}/" . date('Y');
    
        return view('formpst.form', compact('nomorSurat', 'users', 'cabangs', 'tujuans', 'departemens', 'nama_pegawais', 'cabang_tujuans', 'nm'));
    }
    

    public function store(Request $request, $role = null)
{
    $validatedData = $request->validate([
        'no_surat' => 'required|string|max:255',
        'namaPemohon' => 'required|string|max:255',
        'cabangAsal' => 'required|string|max:255',
        'cabang_tujuan' => 'required|exists:cabangs,id',
        'tujuan' => 'required|exists:tujuans,id',
        'tanggalKeberangkatan' => 'required|date',

        'namaPegawai.*' => 'required|string|max:255', // ID pegawai
        'namaPegawaiNama.*' => 'required|string|max:255', // Nama lengkap pegawai
        'departemen.*' => 'required|string|max:255',
        'nik.*' => 'required|string|max:255',
        'uploadFile.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'tanggalBerangkat.*' => 'required|date', // Tambahkan validasi tanggal berangkat
        'tanggalKembali.*' => 'required|date|after_or_equal:tanggalBerangkat.*', // Tambahkan validasi tanggal kembali
    ]);

    // Ambil kode cabang dan tujuan dari tabel terkait
    $kodeCabangTujuan = Cabang::findOrFail($validatedData['cabang_tujuan'])->kode_cabang;
    $tujuanPenugasan = Tujuan::findOrFail($validatedData['tujuan'])->tujuan_penugasan;

    // Buat data form utama dengan menyimpan kode cabang
    $form = Form::create([
        'no_surat' => $validatedData['no_surat'],
        'nama_pemohon' => $validatedData['namaPemohon'],
        'cabang_asal' => $validatedData['cabangAsal'],
        'cabang_tujuan' => $kodeCabangTujuan, // Menyimpan kode cabang, bukan nama
        'tujuan' => $tujuanPenugasan,
        'tanggal_keberangkatan' => $validatedData['tanggalKeberangkatan'],
    ]);

    // Tentukan persetujuan berdasarkan peran
    if ($role === 'nm') {
        $form->acc_nm = 'oke';
    } else {
        $form->acc_hrd = 'oke';
    }

    $form->submitted_by_hrd = auth()->user()->nama_lengkap;
    $form->save();

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
            'tanggal_berangkat' => $request->tanggalBerangkat[$index], // Simpan tanggal berangkat
            'tanggal_kembali' => $request->tanggalKembali[$index], // Simpan tanggal kembali
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Masukkan data pegawai ke database
    Nama_pegawai::insert($namaPegawais);

    // Redirect dengan pesan sukses
    return redirect()->route('formpst.index_keluar', ['form' => $form->id])
        ->with('success', 'Data berhasil disimpan, dan persetujuan otomatis telah diberikan.');
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
    $user = User::find($id);
    return view('formpst.show', compact('form', 'data', 'user', ));
}

public function show_nm($id)
{
    $form = Form::findOrFail($id);
    $data = Nama_pegawai::where('form_id', $form->id)->get();
    $user = User::find($id);
    return view('formpst.show_nm', compact('form', 'data', 'user', ));
}

public function surat_tugas($id)
{
    $form = Form::findOrFail($id);
    $users = User::all();

    $data = Nama_pegawai::where('form_id', $form->id)->get();

    return view('formpst.surat_tugas', compact('form', 'data','users'));
}


    public function submit(Request $request, $id)
{
    $form = Form::findOrFail($id);
    $user = auth()->user()->nama_lengkap; // Mengambil nama user yang sedang login
    
    switch ($request->action) {
        case 'acc_bm':
            $form->acc_bm = 'oke';
            $form->submitted_by_bm = $user;
            $form->save();
    
            return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan BM berhasil disimpan.');
    
        case 'reject_bm':
            $form->acc_bm = 'reject';
            $form->submitted_by_bm = $user;
            $form->save();
    
            return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan BM ditolak.');
    
        case 'cancel':
            $form->acc_bm = 'cancel';
            $form->acc_hrd = 'cancel';
            $form->acc_ho = 'cancel';
            $form->acc_cabang = 'cancel';
            $form->submitted_by_bm = $user;
            $form->submitted_by_hrd = $user;
            $form->submitted_by_ho = $user;
            $form->submitted_by_cabang = $user;
            $form->save();
    
            return redirect()->route('formpst.index_keluar')->with('success', 'Semua persetujuan telah dibatalkan.');

    
        case 'acc_ho':
            if ($form->acc_hrd !== 'oke') {
                return redirect()->back()->with('error', 'HRD belum menyetujui.');
            }
            $form->acc_ho = 'oke';
            $form->submitted_by_ho = $user;
            $form->save();
    
            return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan HO berhasil disimpan.');
    
        case 'reject_ho':
            if ($form->acc_hrd !== 'oke') {
                return redirect()->back()->with('error', 'HRD belum menyetujui.');
            }
            $form->acc_ho = 'reject';
            $form->submitted_by_ho = $user;
            $form->save();
    
            return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan HO ditolak.');
    
        case 'acc_cabang':
            if ($form->acc_ho !== 'oke') {
                return redirect()->back()->with('error', 'HO belum menyetujui.');
            }
            $form->acc_cabang = 'oke';
            $form->submitted_by_cabang = $user;
            $form->save();
    
            return redirect()->route('formpst.index_masuk')->with('success', 'Persetujuan Cabang berhasil disimpan.');
    
        case 'reject_cabang':
            if ($form->acc_ho !== 'oke') {
                return redirect()->back()->with('error', 'HO belum menyetujui.');
            }
            $form->acc_cabang = 'reject';
            $form->submitted_by_cabang = $user;
            $form->save();
    
            return redirect()->route('formpst.index_masuk')->with('success', 'Persetujuan Cabang ditolak.');
    
        default:
            return redirect()->back()->with('error', 'Aksi tidak valid.');
    }
}

public function submit_nm(Request $request, $id)
{
    $form = Form::findOrFail($id);
    $user = auth()->user()->nama_lengkap; // Mengambil nama user yang sedang login
    
    switch ($request->action) {
        case 'acc_ho':
            $form->acc_ho = 'oke';
            $form->submitted_by_ho = $user;
            $form->save();
    
            return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan BM berhasil disimpan.');
    
            case 'reject_ho':
                if ($form->acc_hrd !== 'oke') {
                    return redirect()->back()->with('error', 'HRD belum menyetujui.');
                }
                $form->acc_ho = 'reject';
                $form->submitted_by_ho = $user;
                $form->save();
        
                return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan HO ditolak.');

        case 'cancel':
            $form->acc_bm = 'cancel';
            $form->acc_hrd = 'cancel';
            $form->acc_ho = 'cancel';
            $form->acc_cabang = 'cancel';
            $form->submitted_by_bm = $user;
            $form->submitted_by_hrd = $user;
            $form->submitted_by_ho = $user;
            $form->submitted_by_cabang = $user;
            $form->save();
    
            return redirect()->route('formpst.index_keluar')->with('success', 'Semua persetujuan telah dibatalkan.');

 
        case 'acc_cabang':
            if ($form->acc_ho !== 'oke') {
                return redirect()->back()->with('error', 'HO belum menyetujui.');
            }
            $form->acc_cabang = 'oke';
            $form->submitted_by_cabang = $user;
            $form->save();
    
            return redirect()->route('formpst.index_masuk')->with('success', 'Persetujuan Cabang berhasil disimpan.');
    
        case 'reject_cabang':
            if ($form->acc_ho !== 'oke') {
                return redirect()->back()->with('error', 'HO belum menyetujui.');
            }
            $form->acc_cabang = 'reject';
            $form->submitted_by_cabang = $user;
            $form->save();
    
            return redirect()->route('formpst.index_masuk')->with('success', 'Persetujuan Cabang ditolak.');
    
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
        dd($request->all()); // Cek data yang dikirim sebelum diproses
    
        $form = Form::findOrFail($id);
    
        $request->validate([
            'cabang_asal' => 'required|exists:cabangs,id',
            'cabang_tujuan' => 'required|exists:cabangs,id',
            'tujuan' => 'required|exists:tujuans,id',
            'tanggal_keberangkatan' => 'required|date',
        ]);
    
        if ($request->has('nama')) {
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



}

