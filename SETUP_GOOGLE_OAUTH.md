# Setup Google OAuth untuk Login

## Langkah-langkah Setup Google OAuth

### 1. Buat Google OAuth Credentials

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang sudah ada
3. Aktifkan **Google+ API** atau **Google Identity API**
4. Buka **Credentials** → **Create Credentials** → **OAuth client ID**
5. Pilih **Web application**
6. Isi form:
   - **Name**: Nama aplikasi Anda (contoh: "Jasa Layanan Fotografi")
   - **Authorized JavaScript origins**: 
     - `http://localhost:8000` (untuk development)
     - `http://127.0.0.1:8000` (untuk development)
   - **Authorized redirect URIs**:
     - `http://localhost:8000/auth/google/callback` (untuk development)
     - `http://127.0.0.1:8000/auth/google/callback` (untuk development)
     - Untuk production, tambahkan domain Anda: `https://yourdomain.com/auth/google/callback`

7. Klik **Create**
8. Copy **Client ID** dan **Client Secret**

### 2. Update File .env

Tambahkan konfigurasi berikut ke file `.env`:

```env
GOOGLE_CLIENT_ID=your-google-client-id-here
GOOGLE_CLIENT_SECRET=your-google-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**Untuk Production:**
```env
GOOGLE_CLIENT_ID=your-google-client-id-here
GOOGLE_CLIENT_SECRET=your-google-client-secret-here
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

### 3. Clear Cache

Jalankan perintah berikut untuk clear cache:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 4. Test Login dengan Google

1. Buka halaman login
2. Klik tombol "Login dengan Google"
3. Pilih akun Google yang ingin digunakan
4. Berikan izin akses
5. Anda akan di-redirect kembali ke aplikasi dan otomatis login

## Catatan Penting

- **Development**: Pastikan menggunakan `http://localhost:8000` atau `http://127.0.0.1:8000`
- **Production**: Pastikan menggunakan `https://` dan domain yang benar
- **Redirect URI**: Harus sama persis dengan yang di-set di Google Cloud Console
- **OAuth Consent Screen**: Pastikan sudah dikonfigurasi di Google Cloud Console

## Troubleshooting

### Error: "redirect_uri_mismatch"
- Pastikan redirect URI di `.env` sama persis dengan yang di-set di Google Cloud Console
- Pastikan menggunakan `http://` untuk development dan `https://` untuk production

### Error: "invalid_client"
- Pastikan `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` sudah benar
- Clear cache dengan `php artisan config:clear`

### Error: "access_denied"
- User membatalkan proses login
- Coba lagi dan pastikan memberikan izin akses

## Keamanan

- **Jangan commit** file `.env` ke repository
- Simpan `GOOGLE_CLIENT_SECRET` dengan aman
- Untuk production, gunakan environment variables yang aman

