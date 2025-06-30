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
use App\Models\Ticketing;
use App\Models\Form;
use App\Models\Ticket_detail;
use App\Models\User;
use App\Models\Maskapai;
use App\Models\Nama_pegawai_t;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


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

        'namaPegawai.*'         => 'required|string|max:255', 
        'namaPegawaiNama.*'     => 'required|string|max:255', 
        'departemen.*'          => 'required|string|max:255',
        'nik.*'                 => 'required|string|max:255',
        'uploadFile.*'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'tanggalBerangkat.*'    => 'required|date', 
        'tanggalKembali.*'      => 'required|date|after_or_equal:tanggalBerangkat.*',
        'estimasi.*'            => 'required|string|max:255',

    ]);

    $kodeCabangTujuan = Cabang::findOrFail($validatedData['cabang_tujuan'])->kode_cabang;
    $tujuanPenugasan = Tujuan::findOrFail($validatedData['tujuan'])->tujuan_penugasan;
    $yangMenugaskan = User::findOrFail($validatedData['yangMenugaskan'])->nama_lengkap;

    $form = Form::create([
        'no_surat'              => $validatedData['no_surat'],
        'nama_pemohon'          => $validatedData['namaPemohon'],
        'yang_menugaskan'       => $yangMenugaskan,
        'cabang_asal'           => $validatedData['cabangAsal'],
        'cabang_tujuan'         => $kodeCabangTujuan, 
        'status_koordinasi'     => $validatedData['statusKoordinasi'],
        'tujuan'                => $tujuanPenugasan,
        'tanggal_keberangkatan' => $validatedData['tanggalKeberangkatan'],
    ]);

    // $ticketing = [
    //     'form_id'               => $form->id,
    //     'no_surat'              => $validatedData['no_surat'],
    //     'nama_pemohon'          => $validatedData['namaPemohon'],
    //     'assigned_By'           => $validatedData['yangMenugaskan'],
    // ];
    if ($role === 'nm') {
        $form->acc_nm = 'oke';
    } elseif ($validatedData['cabangAsal'] === 'HO') { // Use validated data here
        $form->acc_ho = 'oke';
    } else {
        $form->acc_hrd = 'oke';
    }
    
    if ($role === 'hrd' && $validatedData['cabangAsal'] != 'HO'){
    $form->submitted_by_hrd = auth()->user()->nama_lengkap;
    $form->save();
    } else {
    $form->submitted_by_ho = auth()->user()->nama_lengkap;
    $form->save();
    }
    $namaPegawais = [];

    foreach ($request->namaPegawai as $index => $pegawaiId) {
        $uploadFilePath = null;

        if ($request->hasFile("uploadFile.$index")) {
            $originalName = $request->file("uploadFile.$index")->getClientOriginalName();
            $uploadFilePath = $request->file("uploadFile.$index")->storeAs('uploads', $originalName, 'public');
        }

        $namaPegawais[] = [
            'form_id'           => $form->id,
            'nama_pegawai'      => $request->namaPegawaiNama[$index],
            'departemen'        => $request->departemen[$index],
            'nik'               => $request->nik[$index],
            'upload_file'       => $uploadFilePath,
            'tanggal_berangkat' => $request->tanggalBerangkat[$index],
            'tanggal_kembali'   => $request->tanggalKembali[$index],
            'estimasi'          => $request->estimasi[$index],
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }

    Nama_pegawai::insert($namaPegawais);
    // Ticketing::insert($ticketing);

    return redirect()->route('formpst.index_keluar', ['form' => $form->id])
        ->with('success', 'Data berhasil disimpan, dan persetujuan otomatis telah diberikan.');
}

public function edit($id)
{
    $form = Form::findOrFail($id);
    
    $cabangs = Cabang::all();
    $tujuans = Tujuan::all();
    $nama_pegawais = Nama_pegawai::where('form_id', $id)->get();

    return view('formpst.edit', compact('form', 'cabangs', 'tujuans', 'nama_pegawais'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'cabang_tujuan' => 'required|exists:cabangs,id',
        'tujuan' => 'required|exists:tujuans,id', // masih pakai ID di validasi
        'tanggal_keberangkatan' => 'required|date',
        'nama.*' => 'required|string',
        'nik.*' => 'required|string',
        'departemen.*' => 'required|string',
        'lama_keberangkatan' => 'required|array',
        'lama_keberangkatan.*.tanggal_berangkat' => 'required|date',
        'lama_keberangkatan.*.tanggal_kembali' => 'nullable|date',
        'status.*' => 'nullable|string',
        'keterangan.*' => 'nullable|string',
        'file.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $form = Form::findOrFail($id);

    $cabang = Cabang::findOrFail($request->cabang_tujuan);
    $tujuanModel = Tujuan::findOrFail($request->tujuan); // ambil model tujuan

    $form->update([
        'cabang_tujuan' => $cabang->kode_cabang,
        'tujuan' => $tujuanModel->tujuan_penugasan, // simpan teks tujuan, bukan ID
        'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
        'acc_bm' => '', // Reset persetujuan BM
        'acc_ho' => '', // Reset persetujuan HO
        'acc_cabang' => '', // Reset persetujuan Cabang
        'submitted_by_bm' => '', // Reset nama BM
        'submitted_by_ho' => '', // Reset nama HO
        'submitted_by_cabang' => '', // Reset nama Cabang
        'reason_bm' => '', // Reset alasan penolakan BM
        'reason_ho' => '', // Reset alasan penolakan HO
        'reason_cabang' => '', // Reset alasan penolakan Cabang
        'cancel_reason' => '', // Reset alasan pembatalan
    ]);

    foreach ($request->nama as $pegawai_id => $nama) {
        $pegawai = Nama_pegawai::findOrFail($pegawai_id);
        $pegawai->update([
            'nama_pegawai' => $nama,
            'nik' => $request->nik[$pegawai_id],
            'departemen' => $request->departemen[$pegawai_id],
            'tanggal_berangkat' => $request->lama_keberangkatan[$pegawai_id]['tanggal_berangkat'] ?? now()->toDateString(),
            'tanggal_kembali' => $request->lama_keberangkatan[$pegawai_id]['tanggal_kembali'] ?? now()->toDateString(),
            'status' => $request->status[$pegawai_id] ?? null,
            'keterangan' => $request->keterangan[$pegawai_id] ?? null,
        ]);

        if ($request->hasFile("file.$pegawai_id")) {
            if ($pegawai->upload_file) {
                Storage::disk('public')->delete($pegawai->upload_file);
            }

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




public function ticket($id = null)

    {
        $cabangs = Cabang::all();
        $tujuans = Tujuan::all();
        $departemens = Departemen::all();
        $nama_pegawais = Nama_pegawai::all();
        $maskapais = Maskapai::all();
        $forms = Form::all();

        $prefill = null;
        if ($id) {
            $prefill = Form::find($id);
            if (!$prefill) {
                return redirect()->route('formpst.ticket')->with('error', 'Data not found');
            }
        }

        return view('formpst.ticket', compact(
            'cabangs',
            'tujuans',
            'departemens',
            'nama_pegawais',
            'forms',
            'maskapais',
            'prefill'
        ));
    }


    public function store_ticket(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string',
            'nama_pemohon' => 'required|string',
            'assigned_By' => 'required|string',
            'invoice' => 'required|string',
            'issued' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'beban_biaya' => 'required|string',
            'agent' => 'required|string',
            'maskapai' => 'required|string',
            'class' => 'required|string',
    
            'pegawai' => 'nullable|array',
            'pegawai.*.nama_pegawai' => 'required_with:pegawai|string',
            'pegawai.*.departemen' => 'required_with:pegawai|string',
    
            'tickets' => 'nullable|array',
            'tickets.*.file_name' => 'nullable|string',
            'tickets.*.passenger_name' => 'required_with:tickets|string',
            'tickets.*.flight_number' => 'required_with:tickets|string',
            'tickets.*.flight_date' => 'required_with:tickets|string',
            'tickets.*.departure_time' => 'required_with:tickets|string',
            'tickets.*.departure_airport' => 'required_with:tickets|string',
            'tickets.*.arrival_airport' => 'required_with:tickets|string',
        ]);
    
        $forms = Form::find($request->no_surat); 
        $noSuratTeks = $forms ? $forms->no_surat : null;
    
        $ticket = new Ticketing();
        $ticket->no_surat = $noSuratTeks;
        $ticket->nama_pemohon = $request->nama_pemohon;
        $ticket->assigned_By = $request->assigned_By;
        $ticket->invoice = $request->invoice;
        $ticket->issued = $request->issued;
        $ticket->nominal = $request->nominal;
        $ticket->beban_biaya = $request->beban_biaya;
        $ticket->agent = $request->agent;
    
        $kendaraan = $request->input('kendaraan');
        $ticket->kendaraan = is_array($kendaraan) ? implode(',', $kendaraan) : $kendaraan;
    
        $ticket->maskapai = $request->maskapai;
        $ticket->class = $request->class;
        $ticket->save();
    
        // Simpan data pegawai
        if ($request->filled('pegawai')) {
            foreach ($request->pegawai as $p) {
                Nama_pegawai_t::create([
                    'ticket_id' => $ticket->id,
                    'nama_pegawai' => $p['nama_pegawai'],
                    'departemen' => $p['departemen'],
                ]);
            }
        }
    
        // Ambil data tiket
        $tickets = $request->input('tickets', []);
    
        // Upload PDF dan set file_name ke array $tickets
        if ($request->hasFile('pdf_files')) {
            foreach ($request->file('pdf_files') as $index => $pdf) {
                $filename = time() . '_' . $index . '_' . $pdf->getClientOriginalName();
                $pdf->storeAs('public/tickets', $filename);
    
                if (isset($tickets[$index])) {
                    $tickets[$index]['file_name'] = $filename;
                }
            }
        }
    
        // Simpan tiket detail ke tabel
        foreach ($tickets as $detail) {
            Ticket_detail::create([
                'ticket_id' => $ticket->id,
                'file_name' => $detail['file_name'] ?? null,
                'passenger_name' => $detail['passenger_name'],
                'flight_number' => $detail['flight_number'],
                'flight_date' => $detail['flight_date'],
                'departure_time' => $detail['departure_time'],
                'departure_airport' => $detail['departure_airport'],
                'arrival_airport' => $detail['arrival_airport'],
            ]);
        }
    
        return redirect()->back()->with('success', 'Ticket dan detail berhasil disimpan.');
    }
    
    
    
    
public function getPemohon($id)
{
    $form = Form::findOrFail($id);
    // dd($form);


    return response()->json([
        'nama_pemohon' => $form->nama_pemohon,
        'yang_menugaskan' => $form->yang_menugaskan,
        // 'tujuan' => $form->tujuan,
    ]);
}

public function getEmployeesByFormId($formId)
{
    $employees = Nama_pegawai::where('form_id', $formId)->get();
    return response()->json($employees);
}

public function show_ticket()
    {
    $query = Ticketing::query();
    $data = $query->get();
    $ticketing = Ticketing::all();

        return view('formpst.show_ticket', compact( 'ticketing', 'data'));

}

public function detail_ticket()
{
    $form = Form::findOrFail();
    $ticketing = Ticketing::findOrFail();
    $data = Nama_pegawai_t::where('ticket_id', $ticket->id)->get();

    $user = User::find();
    return view('formpst.show', compact('form', 'data', 'user', 'ticketing'));
}

public function getTicketDetails($id)
{
    $ticket = Ticketing::findOrFail($id);
    $details = Ticket_detail::where('ticket_id', $id)->get();

    return response()->json([
        'ticket' => $ticket,
        'details' => $details
    ]);
}

public function updateTicketDetail(Request $request, $id)
{
    $validated = $request->validate([
        'passenger_name' => 'required|string|max:255',
        'flight_number' => 'required|string|max:255',
        'flight_date' => 'required|date',
        'departure_time' => 'required|date_format:H:i',
    ]);
    $detail = Ticket_detail::findOrFail($id);
    $detail->update($validated);
    return response()->json([
        'success' => true,
        'message' => 'Detail tiket berhasil diperbarui',
        'detail' => $detail
    ]);
}


public function exportCSV($id)
{
    $form = Form::findOrFail($id);
    $details = Nama_pegawai::where('form_id', $form->id)->get(); // ganti sesuai relasi tabel

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=form_{$form->id}_pegawai.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $callback = function () use ($details) {
        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'Nama Pegawai',
            'NIK',
            'Departemen',
            'Tanggal Berangkat',
            'Tanggal Kembali',
            'Status',
            'Keterangan'
        ]);

        foreach ($details as $item) {
            fputcsv($handle, [
                $item->nama_pegawai,
                $item->nik,
                $item->departemen,
                \Carbon\Carbon::parse($item->tanggal_berangkat)->format('d-m-Y'),
                \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y'),
                $item->acc_nm,
                $item->alasan ?? '-'
            ]);
        }

        fclose($handle);
    };

    return Response::stream($callback, 200, $headers);
}
}
