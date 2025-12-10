# 🚀 Panduan Setup Google OAuth - Step by Step

## Langkah 1: Aktifkan Google Identity API

1. Di Google Cloud Console, klik menu **☰** (hamburger menu) di kiri atas
2. Pilih **APIs & Services** → **Library**
3. Di search box, ketik: **"Google Identity"** atau **"Google+ API"**
4. Pilih **"Google Identity Services API"** atau **"Google+ API"**
5. Klik tombol **"Enable"** atau **"Aktifkan"**

## Langkah 2: Buat OAuth Consent Screen

1. Klik menu **☰** → **APIs & Services** → **OAuth consent screen**
2. Pilih **External** (untuk testing) atau **Internal** (jika punya Google Workspace)
3. Klik **Create**
4. Isi form:
   - **App name**: `Jasa Layanan Fotografi` (atau nama aplikasi Anda)
   - **User support email**: Email Anda
   - **Developer contact information**: Email Anda
5. Klik **Save and Continue**
6. Di halaman **Scopes**, klik **Save and Continue** (skip dulu)
7. Di halaman **Test users**, klik **Save and Continue** (skip dulu)
8. Klik **Back to Dashboard**

## Langkah 3: Buat OAuth 2.0 Client ID

1. Klik menu **☰** → **APIs & Services** → **Credentials**
2. Klik tombol **+ CREATE CREDENTIALS** di atas
3. Pilih **OAuth client ID**
4. Jika diminta, pilih **Web application** sebagai Application type
5. Isi form:
   - **Name**: `Jasa Fotografi Web Client` (atau nama bebas)
   - **Authorized JavaScript origins**: 
     ```
     http://localhost:8000
     http://127.0.0.1:8000
     ```
   - **Authorized redirect URIs**: 
     ```
     http://localhost:8000/auth/google/callback
     http://127.0.0.1:8000/auth/google/callback
     ```
6. Klik **Create**
7. **PENTING**: Copy **Client ID** dan **Client Secret** yang muncul di popup
   - Jangan tutup popup sampai Anda sudah copy kedua nilai ini!

## Langkah 4: Update File .env

1. Buka file `.env` di project Laravel Anda
2. Tambahkan atau update baris berikut:
   ```env
   GOOGLE_CLIENT_ID=paste-client-id-di-sini
   GOOGLE_CLIENT_SECRET=paste-client-secret-di-sini
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```
3. Simpan file `.env`

## Langkah 5: Clear Cache Laravel

Jalankan di terminal/command prompt:
```bash
php artisan config:clear
php artisan cache:clear
```

## Langkah 6: Test Login dengan Google

1. Buka aplikasi Laravel di browser: `http://localhost:8000`
2. Klik tombol **"Login dengan Google"**
3. Pilih akun Google Anda
4. Berikan izin akses
5. Anda akan di-redirect kembali dan otomatis login!

## ⚠️ Troubleshooting

### Error: "redirect_uri_mismatch"
- Pastikan redirect URI di `.env` sama persis dengan yang di-set di Google Cloud Console
- Pastikan tidak ada spasi atau karakter tambahan
- Pastikan menggunakan `http://` untuk development (bukan `https://`)

### Error: "invalid_client"
- Pastikan `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` sudah benar
- Pastikan tidak ada spasi di awal/akhir
- Clear cache: `php artisan config:clear`

### Error: "access_denied"
- User membatalkan proses login
- Coba lagi dan pastikan memberikan izin akses

### Error: "OAuth consent screen belum dikonfigurasi"
- Pastikan sudah selesai setup OAuth consent screen di Langkah 2

## 📝 Catatan Penting

- **Development**: Gunakan `http://localhost:8000` atau `http://127.0.0.1:8000`
- **Production**: Ganti dengan domain Anda yang menggunakan `https://`
- **Jangan commit** file `.env` ke repository (sudah ada di `.gitignore`)
- Simpan **Client Secret** dengan aman, jangan share ke publik

## 🎉 Selesai!

Setelah semua langkah selesai, login dengan Google sudah siap digunakan!

