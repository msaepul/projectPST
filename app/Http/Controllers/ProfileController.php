<?php


namespace App\Http\Controllers;


use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function logout(): RedirectResponse
    {
        Auth::logout(); // Logout pengguna
        return redirect('/login')->with('status', 'Anda telah berhasil logout.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string'
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);


        return redirect()->route('ho.user')->with('success', 'User berhasil ditambahkan!');


    }
    public function edit($id): View
    {
        $user = User::findOrFail($id); // Mengambil data user berdasarkan ID
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:Admin,User',
        ]);
        $user = User::findOrFail($id); // Mengambil data user berdasarkan ID
        // Mengisi data baru ke model user
        $user->fill($validatedData);
        // Reset email verification jika email berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        // Simpan perubahan
        $user->save();
        // Redirect dengan pesan sukses
        return Redirect::route('ho.user')->with('status', 'Profile updated successfully!');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        \Log::info("Menghapus user dengan ID: {$id}");
        $user = User::findOrFail($id);
        $user->delete();
        return Redirect::route('ho.user')->with('status', 'User berhasil dihapus!');
    }
}
