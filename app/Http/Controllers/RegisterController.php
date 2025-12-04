<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('buat-akun');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed', // field password_confirmation harus ada di form
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan user baru
        $user = User::create([
            'name' => $request->name,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'email' => $request->telepon . '@noemail.local', // jika tidak memakai email, simpan placeholder
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login.form')->with('success', 'Akun berhasil dibuat. Silakan masuk.');
    }
}
