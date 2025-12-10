<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserManagementController extends Controller
{
    /**
     * Tampilkan daftar semua user aktif
     * Support filter role dan search
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'fotografer', 'pelanggan'])
            ->where('status_akun', 'aktif'); // Hanya tampilkan user aktif

        // Filter berdasarkan role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pengguna', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('tgl_dibuat', 'desc')->paginate(10);

        // Statistik (hanya user aktif)
        $stats = [
            'total' => User::whereIn('role', ['admin', 'fotografer', 'pelanggan'])->where('status_akun', 'aktif')->count(),
            'admin' => User::where('role', 'admin')->where('status_akun', 'aktif')->count(),
            'fotografer' => User::where('role', 'fotografer')->where('status_akun', 'aktif')->count(),
            'pelanggan' => User::where('role', 'pelanggan')->where('status_akun', 'aktif')->count(),
        ];

        return view('admin.user-management', compact('users', 'stats'));
    }

    /**
     * Tampilkan form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update data user
     * Password opsional (jika diisi akan di-update)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pengguna,username,' . $id . ',id_pengguna',
            'email' => 'required|email|max:255|unique:pengguna,email,' . $id . ',id_pengguna',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,fotografer,pelanggan',
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ]);

        $user->nama_pengguna = $request->nama_pengguna;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user ' . $user->nama_pengguna . ' berhasil diperbarui.');
    }

    /**
     * Tampilkan form tambah user baru
     */
    public function create()
    {
        return view('admin.create-user');
    }

    /**
     * Simpan user baru ke database
     * Password di-hash, status otomatis aktif
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pengguna,username',
            'email' => 'required|email|max:255|unique:pengguna,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,fotografer,pelanggan',
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ]);

        User::create([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_akun' => 'aktif',
            'tgl_dibuat' => now(),
        ]);

        $roleLabel = ucfirst($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun ' . $roleLabel . ' ' . $request->nama_pengguna . ' berhasil ditambahkan.');
    }

    /**
     * Hapus user dari database
     * Tidak bisa hapus akun sendiri
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Pastikan bukan admin yang sedang login
        if ($user->id_pengguna === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $namaUser = $user->nama_pengguna;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun ' . $namaUser . ' berhasil dihapus.');
    }
}
