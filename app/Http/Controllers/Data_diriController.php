<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\biodata;
use App\Models\user;
use Illuminate\Support\Facades\Auth;

class Data_diriController extends Controller
{
    public function biodata(Request $request)
    {
        // Ambil semua data cabang
        $users = Auth::user()::all(); // Ambil semua data user

        // Kirimkan ke view
        return view('data_diri.biodata', compact('users'));
        

    }
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pekerjaan' => 'required|string',
            'tentang' => 'required|string',
        ]);

        // Simpan data ke database
        biodata::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('data_diri.biodata')->with('success', 'Biodata Telah di update');
    }






    
}
