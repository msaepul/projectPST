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
        return redirect()->route('formpst.list')->with('success', 'Pengajuan berhasil disimpan!');
    }
    public function show()
    {
        $nama_pegawais = Nama_pegawai::all();
        $cabang_tujuans = Cabang_tujuan::all();
    
        $data = $nama_pegawais->map(function ($pegawai, $index) use ($cabang_tujuans) {
            return [
                'nama' => $pegawai->nama,
                'nik' => $pegawai->nik,
                'departemen' => $pegawai->departemen,
                'lama' => $cabang_tujuans[$index]->lama ?? '-',
                'cabang' => $cabang_tujuans[$index]->cabang ?? '-',
                'tujuan' => $cabang_tujuans[$index]->tujuan ?? '-',
            ];
        });
    
        return view('formpst.list', compact('data'));
    }
}
