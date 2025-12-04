<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    // Halaman login kastamer
    public function showLoginForm()
    {
        // Data 3 fotografer untuk ditampilkan di halaman login
        $fotografers = [
            [
                'nama' => 'Gayus',
                'telepon' => '0812-3456-7890',
                'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'jenis' => ['Wedding', 'Event']
            ],
            [
                'nama' => 'Budi Santoso',
                'telepon' => '0813-4567-8901',
                'foto' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'jenis' => ['Wisuda', 'Keluarga & Studio']
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'telepon' => '0814-5678-9012',
                'foto' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'jenis' => ['Corporate', 'Pre-Wedding']
            ]
        ];
        
        return view('kastamer', compact('fotografers')); // nama view form login
    }

    // Proses login pakai Auth Laravel
    public function login(Request $request)
    {
        $request->validate([
            'telepon' => 'required',
            'password' => 'required'
        ]);

        // Cari user berdasarkan telepon
        // Karena email disimpan sebagai telepon@noemail.local saat registrasi
        $email = $request->telepon . '@noemail.local';
        
        if (Auth::attempt([
            'email' => $email,
            'password' => $request->password
        ])) {
            // Jika berhasil, redirect ke halaman pesan fotografer
            return redirect()->route('pesan.fotografer');
        }

        return redirect()->back()->with('error', 'Gagal masuk: periksa kembali nomor telepon dan password.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login.form')->with('success', 'Anda telah berhasil logout.');
    }

    // Redirect ke Google OAuth
    public function redirectToGoogle()
    {
        // Validasi konfigurasi Google OAuth - cek langsung dari env untuk debugging
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        
        // Jika dari env kosong, coba dari config
        if (empty($clientId)) {
            $clientId = config('services.google.client_id');
        }
        if (empty($clientSecret)) {
            $clientSecret = config('services.google.client_secret');
        }
        
        // Debug: cek apakah config ter-load
        if (empty($clientId) || $clientId === null || trim($clientId) === '') {
            $helpMessage = 'GOOGLE_CLIENT_ID belum diisi di file .env. ' . 
                          'Buka file .env di folder Jasa-Layanan-Fotografi dan isi dengan format: ' .
                          'GOOGLE_CLIENT_ID=your-client-id-here';
            return redirect()->route('login.form')->with('error', $helpMessage);
        }
        
        if (empty($clientSecret) || $clientSecret === null || trim($clientSecret) === '') {
            $helpMessage = 'GOOGLE_CLIENT_SECRET belum diisi di file .env. ' . 
                          'Buka file .env di folder Jasa-Layanan-Fotografi dan isi dengan format: ' .
                          'GOOGLE_CLIENT_SECRET=your-client-secret-here';
            return redirect()->route('login.form')->with('error', $helpMessage);
        }
        
        // Redirect ke Google OAuth (tanpa hd agar subdomain juga bisa login)
        return resolve('Laravel\Socialite\Contracts\Factory')
            ->driver('google')
            ->redirect();
    }

    // Handle Google OAuth callback
    public function handleGoogleCallback()
    {
        try {
            // Fix SSL certificate untuk cURL - nonaktifkan verifikasi untuk development
            $socialite = resolve('Laravel\Socialite\Contracts\Factory');
            $googleUser = $socialite->driver('google')
                ->setHttpClient(new Client(['verify' => false]))
                ->stateless()
                ->user();
            $email_user = $googleUser->email;
            
            // Validasi domain email harus pcr.ac.id atau subdomain-nya (misalnya @mahasiswa.pcr.ac.id)
            // Cek apakah email berakhiran dengan .pcr.ac.id (mencakup semua subdomain)
            if (!str_ends_with($email_user, '.pcr.ac.id') && !str_ends_with($email_user, '@pcr.ac.id')) {
                return redirect()->route('login.form')
                    ->with('error', 'Login hanya diperbolehkan untuk akun dengan domain @pcr.ac.id atau subdomain-nya (misalnya @mahasiswa.pcr.ac.id)');
            }
            
            // Cari user berdasarkan email
            $user = User::where('email', $email_user)->first();
            
            if ($user) {
                // Jika user sudah ada, langsung login
                Auth::login($user);
                return redirect()->route('pesan.fotografer');
            } else {
                // Jika user belum ada, buat user baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $email_user,
                    'telepon' => '0000000000', // Default karena Google tidak memberikan telepon
                    'alamat' => '-', // Default karena Google tidak memberikan alamat
                    'password' => Hash::make(uniqid()), // Random password karena login via Google
                ]);
                
                Auth::login($user);
                return redirect()->route('pesan.fotografer');
            }
        } catch (\Exception $e) {
            return redirect()->route('login.form')
                ->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}
