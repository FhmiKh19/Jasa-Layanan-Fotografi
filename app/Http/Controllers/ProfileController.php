<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    public function show()
    {
        $user = Auth::user();
        
        // Jika user adalah pelanggan, gunakan view khusus pelanggan
        if ($user->role === 'pelanggan') {
            return view('pelanggan.profile', compact('user'));
        }
        
        // Untuk admin dan fotografer, gunakan view default
        return view('profile', compact('user'));
    }

    // Update profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_pengguna' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:pengguna,username,' . $user->id_pengguna . ',id_pengguna'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pengguna,email,' . $user->id_pengguna . ',id_pengguna'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/'],
        ]);

        // Update data dasar
        $user->nama_pengguna = $validated['nama_pengguna'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->no_hp = $validated['no_hp'] ?? null;

        // Update foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists('profiles/' . $user->foto_profil)) {
                Storage::disk('public')->delete('profiles/' . $user->foto_profil);
            }

            // Simpan foto baru
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $user->id_pengguna . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profiles', $filename, 'public');
            $user->foto_profil = $filename;
        }

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
