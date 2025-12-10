<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     * Jika sudah login, redirect ke dashboard
     */
    public function index()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user()->role);
        }
        return view('login-form');
    }

    /**
     * Proses login dengan email/username dan password
     * Support login dengan email atau username
     * Jika berhasil, redirect ke dashboard sesuai role
     */
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
        // Pastikan password di database sudah ter-hash
        if (!$user->password) {
            return back()
                ->withErrors(['email' => 'Password tidak ditemukan. Silakan reset password.'])
                ->withInput($request->except('password'))
                ->with('error', 'Login gagal!');
        }

        // Cek password dengan Hash::check
        if (Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return $this->redirectToDashboard($user->role, $user->nama_pengguna);
        }

        // Jika password tidak cocok, coba cek apakah password di database masih plain text (untuk debugging)
        // Hapus bagian ini setelah semua password sudah ter-hash dengan benar
        if ($user->password === $credentials['password']) {
            // Password masih plain text, hash ulang
            $user->password = Hash::make($credentials['password']);
            $user->save();
            
            Auth::login($user);
            $request->session()->regenerate();

            return $this->redirectToDashboard($user->role, $user->nama_pengguna);
        }

        return back()
            ->withErrors(['email' => 'Email atau password tidak sesuai.'])
            ->withInput($request->except('password'))
            ->with('error', 'Login gagal!');
    }

    /**
     * Proses logout user
     * Invalidate session dan redirect ke halaman login
     */
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

    /**
     * Tampilkan halaman registrasi
     * Jika sudah login, redirect ke dashboard
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user()->role);
        }
        return view('register-form');
    }

    /**
     * Proses registrasi user baru
     * Validasi data, buat user baru, auto login, redirect ke dashboard
     */
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

    /**
     * Proses kirim link reset password
     * Generate token dan simpan ke database
     */
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

    /**
     * Tampilkan halaman reset password
     * Token dan email diambil dari URL
     */
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

    /**
     * Proses reset password dengan token
     * Validasi token, update password, hapus token
     */
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

    /**
     * Redirect ke halaman login Google OAuth
     */
    public function redirectToGoogle()
    {
        // Fix SSL certificate issue untuk Laragon (development only)
        // Di production, pastikan SSL certificate sudah dikonfigurasi dengan benar
        $guzzleClient = new \GuzzleHttp\Client([
            'verify' => false, // Disable SSL verification untuk development
        ]);
        
        // Menggunakan Laravel Socialite untuk redirect ke Google OAuth
        return Socialite::driver('google')
            ->setHttpClient($guzzleClient)
            ->redirect();
    }

    /**
     * Handle callback dari Google OAuth
     * Jika email sudah terdaftar: login langsung
     * Jika belum terdaftar: buat akun baru (role: pelanggan), lalu login
     */
    public function handleGoogleCallback()
    {
        try {
            // Fix SSL certificate issue untuk Laragon (development only)
            $guzzleClient = new \GuzzleHttp\Client([
                'verify' => false, // Disable SSL verification untuk development
            ]);
            
            // Ambil data user dari Google menggunakan authorization code
            $googleUser = Socialite::driver('google')
                ->setHttpClient($guzzleClient)
                ->user();
            
            // Validasi: pastikan email tersedia dari Google
            if (!$googleUser->getEmail()) {
                return redirect()->route('login')
                    ->with('error', 'Email tidak ditemukan dari akun Google. Pastikan akun Google Anda memiliki email.');
            }
            
            // Cek apakah user sudah terdaftar berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // ===== KASUS 1: USER SUDAH TERDAFTAR =====
                // User sudah ada di database, langsung login
                
                // Validasi: cek status akun harus aktif
                if ($user->status_akun !== 'aktif') {
                    return redirect()->route('login')
                        ->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
                }

                // Login user dan redirect ke dashboard sesuai role
                Auth::login($user);
                return $this->redirectToDashboard($user->role, $user->nama_pengguna);
            } else {
                // ===== KASUS 2: USER BARU (BELUM TERDAFTAR) =====
                // User belum ada, buat akun baru secara otomatis
                
                // Ambil nama dari Google (getName atau getNickname, fallback ke 'User')
                $namaPengguna = $googleUser->getName() ?? $googleUser->getNickname() ?? 'User';
                
                // Bersihkan nama dari karakter yang tidak valid (hanya alphanumeric dan spasi)
                $namaPengguna = preg_replace('/[^a-zA-Z0-9\s]/', '', $namaPengguna);
                if (empty(trim($namaPengguna))) {
                    $namaPengguna = 'User'; // Fallback jika nama kosong setelah dibersihkan
                }
                
                // Buat akun baru dengan data dari Google
                $user = User::create([
                    'nama_pengguna' => $namaPengguna,
                    'username' => $this->generateUniqueUsername($googleUser->getEmail()), // Generate username unik dari email
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // Random password (tidak digunakan karena login via Google)
                    'role' => 'pelanggan', // Default role untuk user yang login via Google
                    'status_akun' => 'aktif', // Otomatis aktif
                    'tgl_dibuat' => now(),
                ]);

                // Login user yang baru dibuat dan redirect ke dashboard
                Auth::login($user);
                return $this->redirectToDashboard($user->role, $user->nama_pengguna)
                    ->with('success', 'Selamat datang ' . $user->nama_pengguna . '! Akun Anda telah dibuat melalui Google.');
            }
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // Error: Session expired atau state tidak valid (biasanya karena user refresh halaman)
            \Log::error('Google OAuth InvalidStateException: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Session expired. Silakan coba login dengan Google lagi.');
        } catch (\Exception $e) {
            // Error umum: log error dan tampilkan pesan ke user
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            \Log::error('Google OAuth Stack Trace: ' . $e->getTraceAsString());
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google: ' . $e->getMessage());
        }
    }

    /**
     * Generate username unik dari email
     * Jika username sudah ada, tambahkan angka di belakang
     */
    private function generateUniqueUsername($email)
    {
        // Ambil bagian sebelum '@' dari email sebagai base username
        $username = explode('@', $email)[0];
        $baseUsername = $username;
        $counter = 1;

        // Loop sampai mendapatkan username yang unik
        // Cek apakah username sudah digunakan di database
        while (User::where('username', $username)->exists()) {
            // Jika sudah digunakan, tambahkan angka di belakang
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Redirect ke dashboard sesuai role
     */
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
