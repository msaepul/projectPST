<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HrdController extends Controller
{
    public function list_hrd(Request $request)
    {
        return view('hrd.list_hrd');
    }

    public function list_bm(Request $request)
    {
        // // Ambil nomor surat terakhir
        // $lastForm = Form::latest()->first();
        // $lastNumber = $lastForm ? intval(substr($lastForm->nomor_surat, -4)) : 0;
    
        // Buat nomor surat baru
        // $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        // $nomorSurat = 'HRD/' . date('Y') . '/' . $newNumber;
        return view('hrd.list_bm');
    }

    public function list_nm(Request $request)
    {
        return view('hrd.list_nm');
    }
}
