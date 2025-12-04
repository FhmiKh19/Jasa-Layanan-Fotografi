<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function index()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user()->role);
        }
        return view('login-form');
    }

    // Proses login user
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // Support login dengan email atau username
        $user = User::where(function($query) use ($credentials) {
            $query->where('email', $credentials['email'])
                  ->orWhere('username', $credentials['email']);
        })->first();

        // Cek apakah user ada dan status akun aktif
        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak sesuai.'])
                ->withInput($request->except('password'))
                ->with('error', 'Login gagal!');
        }

        // Cek status akun
        if ($user->status_akun !== 'aktif') {
            return back()
                ->withErrors(['email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'])
                ->withInput($request->except('password'))
                ->with('error', 'Login gagal!');
        }

        // Cek password
        if (Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return $this->redirectToDashboard($user->role, $user->nama_pengguna);
        }

        return back()
            ->withErrors(['email' => 'Email atau password tidak sesuai.'])
            ->withInput($request->except('password'))
            ->with('error', 'Login gagal!');
    }

    // Logout user
    public function logout(Request $request)
    {
        $userName = Auth::user()->nama_pengguna ?? 'User';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', "Sampai jumpa lagi, $userName! Anda telah logout.");
    }

    // Tampilkan halaman register
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user()->role);
        }
        return view('register-form');
    }

    // Proses register user
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_pengguna' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:pengguna,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pengguna,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
            ],
            'role' => ['required', 'in:pelanggan,fotografer'],
        ]);

        $user = User::create([
            'nama_pengguna' => $validated['nama_pengguna'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status_akun' => 'aktif',
            'no_hp' => $validated['no_hp'] ?? null,
            'tgl_dibuat' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectToDashboard($user->role, $user->nama_pengguna)
            ->with('success', 'Registrasi berhasil! Selamat datang ' . $user->nama_pengguna . '!');
    }

    // Tampilkan halaman lupa password
    public function showForgotPasswordForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user()->role);
        }
        return view('forgot-password-form');
    }

    // Proses kirim link reset password
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Generate token
        $token = Str::random(64);

        // Simpan token ke password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Buat link reset password
        $resetLink = url('/password/reset/' . $token . '?email=' . urlencode($request->email));

        // Untuk development, kita tampilkan link di response
        // Di production, kirim via email
        return redirect()->route('password.request')
            ->with('success', 'Link reset password telah dikirim ke email Anda!')
            ->with('reset_link', $resetLink); // Hapus ini di production, gunakan email
    }

    // Tampilkan halaman reset password
    public function showResetPasswordForm(Request $request, $token)
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user()->role);
        }

        $email = $request->query('email');

        return view('reset-password-form', [
            'token' => $token,
            'email' => $email
        ]);
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
            ],
        ]);

        // Cek token
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        // Cek apakah token sudah lebih dari 60 menit
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Token sudah kadaluarsa. Silakan request ulang.']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Hapus token
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return redirect()->route('login')
                ->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email tidak ditemukan.']);
    }

    private function redirectToDashboard($role, $nama = '')
    {
        $pesan = "Selamat datang $nama! Login berhasil.";

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', $pesan);

            case 'fotografer':
                return redirect()->route('fotografer.dashboard')->with('success', $pesan);

            case 'pelanggan':
                return redirect()->route('pelanggan.dashboard')->with('success', $pesan);
        }
    }
}
