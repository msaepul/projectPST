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
use App\Models\Maskapai;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $month = date('n');
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        $romanMonth = $romanMonths[$month];

        $nomorSurat = "{$newNumber}/PST/{$kodeCabang}/{$romanMonth}/" . date('Y');

        return view('formpst.form', compact('nomorSurat', 'users', 'cabangs', 'tujuans', 'departemens', 'nama_pegawais', 'cabang_tujuans', 'nm'));
    }


    public function store(Request $request, $role = null)
{
    $validatedData = $request->validate([
        'no_surat'              => 'required|string|max:255',
        'namaPemohon'           => 'required|string|max:255',
        'yangMenugaskan'        => 'required|string|max:255',
        'cabangAsal'            => 'required|string|max:255',
        'cabang_tujuan'         => 'required|exists:cabangs,id',
        'tujuan'                => 'required|exists:tujuans,id',
        'statusKoordinasi'      => 'required|string|max:255',
        'tanggalKeberangkatan'  => 'required|date',

        'namaPegawai.*'         => 'required|string|max:255', // ID pegawai
        'namaPegawaiNama.*'     => 'required|string|max:255', // Nama lengkap pegawai
        'departemen.*'          => 'required|string|max:255',
        'nik.*'                 => 'required|string|max:255',
        'uploadFile.*'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'tanggalBerangkat.*'    => 'required|date', // Tambahkan validasi tanggal berangkat
        'tanggalKembali.*'      => 'required|date|after_or_equal:tanggalBerangkat.*', // Tambahkan validasi tanggal kembali
    ]);

    $kodeCabangTujuan = Cabang::findOrFail($validatedData['cabang_tujuan'])->nama_cabang;
    $tujuanPenugasan = Tujuan::findOrFail($validatedData['tujuan'])->tujuan_penugasan;

    $form = Form::create([
        'no_surat'              => $validatedData['no_surat'],
        'nama_pemohon'          => $validatedData['namaPemohon'],
        'yang_menugaskan'       => $validatedData['yangMenugaskan'],
        'cabang_asal'           => $validatedData['cabangAsal'],
        'cabang_tujuan'         => $kodeCabangTujuan, // Menyimpan kode cabang, bukan nama
        'status_koordinasi'     => $validatedData['statusKoordinasi'],
        'tujuan'                => $tujuanPenugasan,
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
        'form_id'           => $form->id,
        'nama_pegawai'      => $request->namaPegawaiNama[$index],
        'departemen'        => $request->departemen[$index],
        'nik'               => $request->nik[$index],
        'upload_file'       => $uploadFilePath,
        'tanggal_berangkat' => $request->tanggalBerangkat[$index],
        'tanggal_kembali'   => $request->tanggalKembali[$index],
        'created_at'        => now(),
        'updated_at'        => now(),
    ];
}

// Masukkan data pegawai ke database
Nama_pegawai::insert($namaPegawais);

// Redirect dengan pesan sukses
return redirect()->route('formpst.index_keluar', ['form' => $form->id])
    ->with('success', 'Data berhasil disimpan, dan persetujuan otomatis telah diberikan.');
}

public function edit($id)
    {
        $form           = Form::findOrFail($id);
        $cabangs        = Cabang::all();
        $tujuans        = Tujuan::all();
        $nama_pegawais  = Nama_pegawai::where('form_id', $id)->get();

        return view('formpst.edit', compact('form', 'cabangs', 'tujuans', 'nama_pegawais'));
    }

public function update(Request $request, $id)
    {
        $request->validate([
            'cabang_tujuan'         => 'required|exists:cabangs,id',
            'tujuan'                => 'required|exists:tujuans,tujuan_penugasan',
            'tanggal_keberangkatan' => 'required|date',
            'nama.*'                => 'required|string',
            'nik.*'                 => 'required|string',
            'departemen.*'          => 'required|string',
            'lama_keberangkatan'    => 'required|array',
            'lama_keberangkatan.*.tanggal_berangkat' => 'required|date',
            'lama_keberangkatan.*.tanggal_kembali' => 'nullable|date',
            'status.*'              => 'nullable|string',
            'keterangan.*'          => 'nullable|string',
            'file.*'                => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $form = Form::findOrFail($id);
        $cabang = Cabang::findOrFail($request->cabang_tujuan);

        $form->update([
            'cabang_tujuan'         => $cabang->kode_cabang,
            'tujuan'                => $request->tujuan, // Simpan tujuan langsung
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
        ]);

        // Update data pegawai
        foreach ($request->nama as $pegawai_id => $nama) {
            $pegawai = Nama_pegawai::findOrFail($pegawai_id);
            $pegawai->update([
                'nama_pegawai'      => $nama,
                'nik'               => $request->nik[$pegawai_id],
                'departemen'        => $request->departemen[$pegawai_id],
                'tanggal_berangkat' => $request->lama_keberangkatan[$pegawai_id]['tanggal_berangkat'] ?? now()->toDateString(),
                'tanggal_kembali'   => $request->lama_keberangkatan[$pegawai_id]['tanggal_kembali'] ?? now()->toDateString(),
                'status'            => $request->status[$pegawai_id] ?? null,
                'keterangan'        => $request->keterangan[$pegawai_id] ?? null,
            ]);

            // Jika ada file yang diunggah, simpan
            if ($request->hasFile("file.$pegawai_id")) {
                // Hapus file lama jika ada
                if ($pegawai->upload_file) {
                    Storage::disk('public')->delete($pegawai->upload_file);
                }

                // Simpan file baru
                $filePath = $request->file("file.$pegawai_id")->store('uploads', 'public');
                $pegawai->update(['upload_file' => $filePath]);

            }
        }
    return redirect()->route('formpst.index_keluar')->with('success', 'Data berhasil diperbarui!');

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
    $reason = $request->input('reason', null); // Mengambil alasan jika ada


    switch ($request->action) {
        case 'acc_bm':
            $form->acc_bm = 'oke';
            $form->submitted_by_bm = $user;
            $form->save();

            return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan BM berhasil disimpan.');

        case 'reject_bm':
            if (!$reason) {
                return redirect()->back()->with('error', 'Harap isi alasan penolakan.');
            }
            $form->acc_bm = 'reject';
            $form->submitted_by_bm = $user;
            $form->reason_bm = $reason; // Menyimpan alasan penolakan BM
            $form->save();

            return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan BM ditolak.');

        case 'cancel':
            if (!$reason) {
                return redirect()->back()->with('error', 'Harap isi alasan pembatalan.');
            }
            $form->acc_bm       = 'cancel';
            $form->acc_hrd      = 'cancel';
            $form->acc_ho       = 'cancel';
            $form->acc_cabang   = 'cancel';
            $form->submitted_by_bm      = $user;
            $form->submitted_by_hrd     = $user;
            $form->submitted_by_ho      = $user;
            $form->submitted_by_cabang  = $user;
            $form->cancel_reason        = $reason; // Menyimpan alasan pembatalan
            $form->save();

            return redirect()->route('formpst.index_keluar')->with('success', 'Semua persetujuan telah dibatalkan.');

        case 'acc_ho':
            if ($form->acc_hrd !== 'oke') {
                return redirect()->back()->with('error', 'HRD belum menyetujui.');
            }
            $form->acc_ho           = 'oke';
            $form->submitted_by_ho  = $user;
            $form->save();

            return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan HO berhasil disimpan.');

        case 'reject_ho':
            if (!$reason) {
                return redirect()->back()->with('error', 'Harap isi alasan penolakan.');
            }
            if ($form->acc_hrd !== 'oke') {
                return redirect()->back()->with('error', 'HRD belum menyetujui.');
            }
            $form->acc_ho = 'reject';
            $form->submitted_by_ho = $user;
            $form->reason_ho = $reason; // Menyimpan alasan penolakan HO
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
            if (!$reason) {
                return redirect()->back()->with('error', 'Harap isi alasan penolakan.');
            }
            if ($form->acc_ho !== 'oke') {
                return redirect()->back()->with('error', 'HO belum menyetujui.');
            }
            $form->acc_cabang = 'reject';
            $form->submitted_by_cabang = $user;
            $form->reason_cabang = $reason; // Menyimpan alasan penolakan Cabang
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
    $reason = $request->input('reason', null); // Mengambil alasan jika ada


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
                $form->reason_ho = $reason; // Menyimpan alasan penolakan BM
                $form->save();

                return redirect()->route('formpst.index_keluar')->with('success', 'Persetujuan HO ditolak.');

        case 'cancel':
            $form->acc_bm           = 'cancel';
            $form->acc_hrd          = 'cancel';
            $form->acc_ho           = 'cancel';
            $form->acc_cabang       = 'cancel';
            $form->submitted_by_bm  = $user;
            $form->submitted_by_hrd = $user;
            $form->submitted_by_ho  = $user;
            $form->submitted_by_cabang = $user;
            $form->cancel_reason    = $reason; // Menyimpan alasan pembatalan
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
            $form->reason_cabang = $reason; // Menyimpan alasan penolakan Cabang
            $form->save();

            return redirect()->route('formpst.index_masuk')->with('success', 'Persetujuan Cabang ditolak.');

        default:
            return redirect()->back()->with('error', 'Aksi tidak valid.');
    }
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




public function ticket()
    {
        $cabangs = Cabang::all();
        $tujuans = Tujuan::all();
        $departemens = Departemen::all();
        $nama_pegawais = Nama_pegawai::all();
        $maskapais = Maskapai::all();

        $forms = Form::all();
        return view('formpst.ticket', compact( 'cabangs', 'tujuans', 'departemens', 'nama_pegawais','forms', 'maskapais'));
}

public function store_ticket(Request $request)
{
    $validatedData = $request->validate([
        'no_surat'       => 'required|string|max:255',
        'nama_pemohon'   => 'required|string|max:255',
        'assigned_By'    => 'required|string|max:255',
        'hp'             => 'required|string|max:20',
        'pegawai'        => 'required|string|max:255',
        'issued'         => 'required|date',
        'maskapai'       => 'required|string|max:255',
        'lampiran'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'invoice'        => 'required|string|max:255',
        'transport'      => 'required|string|max:255',
        'beban_biaya'    => 'required|string|max:255',
        'keberangkatan'  => 'required|date',
        'nominal'        => 'required|numeric',
        'waktu'          => 'required|string|max:255',
        'rute'           => 'required|string|max:255',
        'rute_tujuan'    => 'required|string|max:255',
        'tiket'          => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    // Upload file ke storage
    $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
    $tiketPath    = $request->file('tiket')->store('tiket', 'public');

    // Simpan ke database
    $ticketing = Ticketing::create([
        'no_surat'      => $validatedData['no_surat'],
        'nama_pemohon'  => $validatedData['nama_pemohon'],
        'assigned_By'   => $validatedData['assigned_By'],
        'hp'            => $validatedData['hp'],
        'pegawai'       => $validatedData['pegawai'],
        'issued'        => $validatedData['issued'],
        'maskapai'      => $validatedData['maskapai'],
        'lampiran'      => $lampiranPath,
        'invoice'       => $validatedData['invoice'],
        'transport'     => $validatedData['transport'],
        'beban_biaya'   => $validatedData['beban_biaya'],
        'keberangkatan' => $validatedData['keberangkatan'],
        'nominal'       => $validatedData['nominal'],
        'waktu'         => $validatedData['waktu'],
        'rute'          => $validatedData['rute'],
        'rute_tujuan'   => $validatedData['rute_tujuan'],
        'tiket'         => $tiketPath,
    ]);

    return redirect()->back()->with('success', 'Data tiket berhasil disimpan!');
}
// YourController.php
public function getPemohon($id)
{
    $form = Form::find($id);
    $nama_pegawais = Nama_pegawai::find($form_id);
    return response()->json([
        'nama_pemohon' => $form->nama_pemohon,
        'yang_menugaskan' => $form->yang_menugaskan,
        'nama_pegawai' => $nama_pegawais->nama_pegawai,


    ]);
}



public function show_ticket()
    {
        return view('formpst.show_ticket');
}


}
