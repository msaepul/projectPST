<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Departemen;
use App\Models\Cabang;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $departemens = Departemen::all(); // Ambil data departemen dari database
        $cabangs = Cabang::all(); // Ambil data cabang dari database
        return view('auth.register', compact('departemens', 'cabangs')); // Kirim data departemen dan cabang ke view
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,user'],
            'nik' => ['required', 'string', 'max:20', 'unique:users'],
            'departemen' => ['required', 'string', 'max:255'],
            'cabang_asal' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:15'],
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nik' => $request->nik,
            'departemen' => $request->departemen,
            'cabang_asal' => $request->cabang_asal,
            'no_hp' => $request->no_hp,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
