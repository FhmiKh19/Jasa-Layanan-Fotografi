# Panduan Setup Google OAuth Login

## Langkah 1: Dapatkan Kredensial dari Google Cloud Console

1. Buka: https://console.cloud.google.com/
2. Login dengan akun Google (pastikan akun memiliki akses ke domain pcr.ac.id)
3. Buat atau pilih project
4. Buka **APIs & Services** > **OAuth consent screen**
   - Pilih **Internal** (untuk domain pcr.ac.id)
   - Isi informasi yang diperlukan
   - Klik **Save and Continue** sampai selesai
5. Buka **APIs & Services** > **Credentials**
6. Klik **Create Credentials** > **OAuth Client ID**
7. Pilih **Web Application**
8. Isi:
   - **Name**: Jasa Layanan Fotografi
   - **Authorized redirect URIs**: `http://127.0.0.1:8000/google/callback`
9. Klik **Create**
10. **SALIN** Client ID dan Client Secret

## Langkah 2: Edit File .env

1. Buka file `.env` di folder: `Jasa-Layanan-Fotografi`
2. Cari bagian:
   ```
   # Google OAuth Configuration
   GOOGLE_CLIENT_ID=
   GOOGLE_CLIENT_SECRET=
   GOOGLE_REDIRECT_URL=http://127.0.0.1:8000/google/callback
   ```
3. Isi dengan kredensial yang sudah disalin:
   ```
   # Google OAuth Configuration
   GOOGLE_CLIENT_ID=123456789-abcdefghijklmnop.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=GOCSPX-abcdefghijklmnopqrstuvwxyz
   GOOGLE_REDIRECT_URL=http://127.0.0.1:8000/google/callback
   ```
   **GANTI** dengan kredensial Anda yang sebenarnya!

4. **PENTING**: 
   - Jangan ada spasi sebelum/sesudah tanda `=`
   - Jangan gunakan tanda kutip
   - Pastikan tidak ada karakter tersembunyi

## Langkah 3: Clear Cache

Jalankan di terminal:
```bash
cd Jasa-Layanan-Fotografi
php artisan config:clear
```

## Langkah 4: Test

1. Buka: http://127.0.0.1:8000
2. Klik tombol **"Login dengan Google"**
3. Pilih akun dengan domain @pcr.ac.id
4. Login berhasil!

## Troubleshooting

### Error: "GOOGLE_CLIENT_ID belum diisi"
- Pastikan sudah mengisi nilai di file .env
- Pastikan tidak ada spasi sebelum/sesudah tanda `=`
- Jalankan: `php artisan config:clear`

### Error: "invalid_client"
- Pastikan Client ID dan Client Secret sudah benar
- Pastikan Authorized redirect URI sudah sesuai: `http://127.0.0.1:8000/google/callback`

### Error: "Access blocked"
- Pastikan OAuth consent screen sudah dikonfigurasi
- Pastikan menggunakan akun dengan domain @pcr.ac.id

