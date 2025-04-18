<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\Tujuan;
use App\Models\Cabang;
use App\Models\User;
use App\Models\Maskapai;
use App\Models\Transport;
use App\Models\Pengajuan;
use App\Models\Nama_pegawai;
use App\Models\Form;
use Illuminate\Support\Facades\Storage;

class HoController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $jumlahCabang = Cabang::count();
        $jumlahDepartemen = Departemen::count();

    // Hitung jumlah surat masuk (acc_ho = 'oke')

    $jumlahSuratMasuk = Form::where('acc_ho', 'oke')->where('cabang_tujuan', auth()->user()->cabang_asal)->count();

    // Hitung jumlah surat keluar (misalnya semua data Form dianggap surat keluar)
    $jumlahSuratKeluar = Form::where('cabang_asal', auth()->user()->cabang_asal)->count();

    $jumlahSuratTugas = Form::where('acc_cabang', 'oke')->where(function ($query) {$query->where('cabang_asal', auth()->user()->cabang_asal)->orWhere('cabang_tujuan', auth()->user()->cabang_asal);})->count();


    return view('dashboard', compact('jumlahCabang', 'jumlahDepartemen', 'jumlahSuratMasuk', 'jumlahSuratKeluar','jumlahSuratTugas'));
    }

    // Cabang
    public function cabang()
    {
        $cabangs = Cabang::paginate(50);

        return view('ho.cabang', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'kode_cabang' => 'required|string|max:10',
        ]);

        Cabang::create($validatedData);

        return redirect()->route('ho.cabang')->with('success', 'Data cabang berhasil ditambahkan!');
    }

    public function add()
    {
        return view('ho.add_cabang');
    }

    public function edit($id)
    {
        $cabang = Cabang::findOrFail($id);

        return view('ho.cabang.edit', compact('cabang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'alamat_cabang' => 'required|string',
            'kode_cabang' => 'required|string|max:10',
        ]);

        $cabang = Cabang::findOrFail($id);
        $cabang->update($validated);

        return redirect()->route('ho.cabang')->with('success', 'Data cabang berhasil diubah!');
    }

    public function destroy($id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->delete();

        return redirect()->route('ho.cabang')->with('success', 'Data cabang berhasil dihapus!');
    }

    // Tujuan
    public function tujuan(Request $request)
    {
        $search = $request->input('search');
        $tujuans = Tujuan::when($search, function ($query, $search) {
            return $query->where('tujuan_penugasan', 'like', "%{$search}%");
        })->paginate(50);

        return view('ho.tujuan', compact('tujuans', 'search'));
    }

    public function storeTujuan(Request $request)
    {
        $validated = $request->validate([
            'tujuan_penugasan' => 'required|string|max:255',
        ]);

        Tujuan::create($validated);

        return redirect()->route('ho.tujuan')->with('success', 'Tujuan baru berhasil ditambahkan!');
    }

    public function editTujuan($id)
    {
        $tujuan = Tujuan::findOrFail($id);

        return view('ho.tujuan.edit', compact('tujuan'));
    }

    public function updateTujuan(Request $request, $id)
    {
        $validated = $request->validate([
            'tujuan_penugasan' => 'required|string|max:255',
        ]);

        $tujuan = Tujuan::findOrFail($id);
        $tujuan->update($validated);

        return redirect()->route('ho.tujuan')->with('success', 'Data tujuan berhasil diubah!');
    }

    public function destroyTujuan($id)
    {
        $tujuan = Tujuan::findOrFail($id);
        $tujuan->delete();

        return redirect()->route('ho.tujuan')->with('success', 'Data tujuan berhasil dihapus!');
    }

    // Departemen
    public function departemen()
    {
        $departemens = Departemen::paginate(50);

        return view('ho.departemen', compact('departemens'));
    }

    public function storeDepartemen(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'kode_departemen' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        Departemen::create($validated);

        return redirect()->route('ho.departemen')->with('success', 'Departemen baru berhasil ditambahkan!');
    }

    public function editDepartemen($id)
    {
        $departemen = Departemen::findOrFail($id);

        return view('ho.departemen.edit', compact('departemen'));
    }

    public function updateDepartemen(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'kode_departemen' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $departemen = Departemen::findOrFail($id);
        $departemen->update($validated);

        return redirect()->route('ho.departemen')->with('success', 'Data departemen berhasil diubah!');
    }

    public function destroyDepartemen($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();

        return redirect()->route('ho.departemen')->with('success', 'Data departemen berhasil dihapus!');
    }

 // User
 public function user()
    {
        $users = User::paginate(50);
        return view('ho.user', compact('users'));
    }

    public function addUser()
    {
        $departemens = Departemen::all();
        $cabangs = Cabang::all();
        return view('ho.add', compact('departemens', 'cabangs'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $departemens = Departemen::all();
        $cabangs = Cabang::all();
        return view('ho.edit', compact('user', 'departemens', 'cabangs'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nik' => 'required|string|unique:users,nik,' . $id,
            'departemen' => 'required|exists:departemens,id', // Ubah validasi
            'cabang_asal' => 'required|exists:cabangs,id', // Ubah validasi
            'no_hp' => 'required|string',
            'role' => 'required|in:admin,user,bm,hrd,nm,pegawai',
            'nama_lengkap' => 'required|string|max:255',
        ]);

        // Ambil nama departemen dan cabang berdasarkan ID
        $departemen = Departemen::findOrFail($validated['departemen']);
        $cabang = Cabang::findOrFail($validated['cabang_asal']);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'departemen' => $departemen->nama_departemen, // Simpan nama departemen
            'cabang_asal' => $cabang->nama_cabang, // Simpan nama cabang
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'nama_lengkap' => $request->nama_lengkap,
        ]);

        return redirect()->route('ho.user')->with('success', 'User berhasil diperbarui!');
    }

    public function storeUser(Request $request)
{
    // Validasi input data user
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'nik' => 'required|string|unique:users,nik',
        'departemen' => 'required|exists:departemens,id',
        'cabang_asal' => 'required|exists:cabangs,id',
        'no_hp' => 'required|string',
        'role' => 'required|in:admin,user,bm,hrd,nm,pegawai',
        'nama_lengkap' => 'required|string|max:255',
    ]);

    // Ambil kode cabang dan nama departemen berdasarkan ID yang divalidasi
    $cabangAsalKode = Cabang::findOrFail($validated['cabang_asal'])->nama_cabang;
    $departemenNama = Departemen::findOrFail($validated['departemen'])->nama_departemen;

    // Membuat user baru
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'nik' => $request->nik,
        'departemen' => $departemenNama, // Menggunakan nama departemen yang valid
        'cabang_asal' => $cabangAsalKode, // Menyimpan kode cabang, bukan nama
        'no_hp' => $request->no_hp,
        'role' => $request->role,
        'nama_lengkap' => $request->nama_lengkap,
    ]);

    // Redirect dengan pesan sukses setelah user berhasil ditambahkan
    return redirect()->route('ho.user')->with('success', 'User berhasil ditambahkan!');
}
 // Fungsi untuk menghapus user
 public function destroyuser($id)
 {
     $user = User::findOrFail($id);
     $user->delete();

     return redirect()->route('ho.user')->with('success', 'Data user berhasil dihapus!');
 }
 public function uploadSignature(Request $request, $id)
 {
     $request->validate([
         'ttd' => 'required|image|mimes:png,jpg,jpeg|max:2048',
     ]);

     $user = User::findOrFail($id);

     // Hapus tanda tangan lama jika ada
     if ($user->ttd) {
         Storage::delete('public/signatures/' . $user->ttd);
     }

     // Simpan file baru
     $file = $request->file('ttd');
     $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
     $file->storeAs('public/signatures', $filename);

     // Simpan nama file ke database
     $user->ttd = $filename;
     $user->save();

     return redirect()->back()->with('success', 'Tanda tangan berhasil diunggah.');
 }
    public function maskapai()
    {
     $maskapais = Maskapai::paginate(50);

     return view('ho.maskapai', compact('maskapais'));
    }
    public function store_Maskapai(Request $request)
    {
        $validated = $request->validate([
            'kode_maskapai' => 'required|string|max:255',
            'nama_maskapai' => 'nullable|string|max:100',
            'jenis_kendaraan' => 'nullable|string|max:100',
        ]);

        Maskapai::create($validated);

        return redirect()->route('ho.maskapai')->with('success', 'Maskapai baru berhasil ditambahkan!');
    }
    public function destroy_Maskapai($id)
    {
        $maskapais = Maskapai::findOrFail($id);
        $maskapais->delete();

        return redirect()->route('ho.maskapai')->with('success', 'Data departemen berhasil dihapus!');
    }
    public function transport()
    {
     $transports = Transport::paginate(50);

     return view('ho.transport', compact('transports'));
    }

}
