<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    public function dashboard(Request $request)
    {
        $pengajuan = Pengajuan::count();

        return view('pengajuan', compact('pengajuan'));
    }
    public function store(Request $request)
    {
        // Validasi data jika diperlukan
        $validated = $request->validate([
            'pengajuans.*.nama' => 'required|string|max:255',
            'pengajuans.*.nik' => 'required|string|max:255',
            'pengajuans.*.departemen' => 'required|string|max:255',
            'pengajuans.*.lama' => 'required|string|max:255',
            'pengajuans.*.cabang' => 'required|string|max:255',
            'pengajuans.*.tujuan' => 'required|string|max:255',
        ]);

        // Iterasi data dan simpan ke tabel `pengajuans`
        foreach ($validated['pengajuans'] as $pengajuan) {
            Pengajuan::create($pengajuan);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('formpst.show')->with('success', 'Pengajuan berhasil disimpan!');
    }
}
