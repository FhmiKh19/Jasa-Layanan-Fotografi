# Cara Membersihkan Table yang Tidak Perlu di phpMyAdmin

## 📋 Daftar Table yang Akan Dihapus

Berdasarkan analisis codebase, berikut table yang **TIDAK DIGUNAKAN** dan bisa dihapus:

1. ✅ **users** - Tidak digunakan (aplikasi pakai table `pengguna`)
2. ✅ **cache** - Tidak digunakan (tidak ada penggunaan cache di code)
3. ✅ **cache_locks** - Tidak digunakan (tidak ada penggunaan cache di code)
4. ✅ **jobs** - Tidak digunakan (tidak ada penggunaan queue di code)
5. ✅ **job_batches** - Tidak digunakan (tidak ada penggunaan queue di code)
6. ✅ **failed_jobs** - Tidak digunakan (tidak ada penggunaan queue di code)

## 📋 Table yang TETAP DIPERTAHANKAN

Table berikut **JANGAN DIHAPUS** karena digunakan oleh aplikasi:

- ✅ **pengguna** - Table utama untuk user
- ✅ **layanan** - Table untuk layanan fotografi
- ✅ **pesanan** - Table untuk pesanan
- ✅ **portofolio** - Table untuk portofolio
- ✅ **testimoni** - Table untuk testimoni
- ✅ **password_reset_tokens** - Untuk reset password
- ✅ **sessions** - Untuk session Laravel

## 🚀 Cara Menjalankan

### Opsi 1: Menggunakan File SQL (Recommended)

1. **Backup database dulu!** ⚠️
   - Di phpMyAdmin, pilih database Anda
   - Klik tab "Export"
   - Pilih "Quick" atau "Custom"
   - Klik "Go" untuk download backup

2. Buka file `cleanup_unused_tables.sql` di folder project

3. Di phpMyAdmin:
   - Pilih database Anda
   - Klik tab "SQL"
   - Copy-paste isi file `cleanup_unused_tables.sql`
   - Klik "Go" untuk menjalankan

4. Verifikasi:
   - Cek daftar table di phpMyAdmin
   - Pastikan hanya table yang diperlukan yang tersisa

### Opsi 2: Manual di phpMyAdmin

1. **Backup database dulu!** ⚠️

2. Di phpMyAdmin, pilih database Anda

3. Untuk setiap table yang akan dihapus:
   - Klik nama table
   - Klik tab "Operations" atau "Structure"
   - Scroll ke bawah, klik "Drop" atau "Delete"
   - Konfirmasi penghapusan

4. Table yang dihapus:
   - `users`
   - `cache`
   - `cache_locks`
   - `jobs`
   - `job_batches`
   - `failed_jobs`

## ⚠️ Peringatan Penting

- **SELALU BACKUP DATABASE DULU!**
- Pastikan Anda yakin sebelum menghapus
- Setelah dihapus, data tidak bisa dikembalikan
- Jika ragu, jangan hapus table tersebut

## ✅ Verifikasi Setelah Pembersihan

Setelah menjalankan script, pastikan table yang tersisa adalah:

```
✓ pengguna
✓ layanan
✓ pesanan
✓ portofolio
✓ testimoni
✓ password_reset_tokens
✓ sessions
```

Total: **7 table** (jika semua table tidak perlu sudah dihapus)

## 🆘 Jika Ada Masalah

Jika setelah menghapus table ada error:
1. Restore dari backup database
2. Atau jalankan migration lagi: `php artisan migrate`

