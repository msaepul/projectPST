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

class HrdController extends Controller
{
    public function list_hrd(Request $request)
    {
        return view('hrd.list_hrd');
    }

    public function index_hrd(Request $request)
    {
        $query = Form::where('acc_hrd', 'oke');
        
    
        if ($request->filled('namaPemohon')) {
            $query->where('nama_pemohon', 'like', '%' . $request->namaPemohon . '%');
        }
    
        if ($request->filled('tujuan')) {
            $query->where('tujuan', $request->tujuan);
        }
    
        $data = $query->get();
        $tujuans = Tujuan::all();
        $forms = Form::all();
    
        return view('hrd.index_hrd', compact('data', 'tujuans','forms'));
    }

    public function list_nm(Request $request)
    {
        return view('hrd.list_nm');
    }
    
    public function show_hrd($id)
    {
        $form = Form::findOrFail($id);

        $data = Nama_pegawai::where('form_id', $form->id)->get();

        return view('hrd.show_hrd', compact('form', 'data'));
    }

    public function submitForm(Request $request, $formId)
{
    $form = Form::findOrFail($formId);

    $action = $request->input('action');

    if ($form->acc_bm == 'oke' || $form->acc_bm == 'reject') {
        if ($form->acc_hrd == 'oke' || $form->acc_hrd == 'reject') {
            return redirect()->back()->with('info', 'Form sudah disetujui sepenuhnya.');
        } else {
            $form->acc_hrd = $action == 'submit' ? 'oke' : 'reject';
        }
    } else {
        $form->acc_bm = $action == 'submit' ? 'oke' : 'reject';
    }

    $form->save();

    return redirect()->back()->with('success', 'Form berhasil disubmit!');
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
