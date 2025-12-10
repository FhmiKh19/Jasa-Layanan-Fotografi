-- ============================================
-- SCRIPT UNTUK MEMBERSIHKAN TABLE YANG TIDAK PERLU
-- Jasa Layanan Fotografi
-- ============================================
-- 
-- ⚠️ PERHATIAN: BACKUP DATABASE DULU SEBELUM MENJALANKAN SCRIPT INI! ⚠️
-- 
-- Table yang AKAN DIHAPUS:
-- 1. users - tidak digunakan, karena pakai table 'pengguna'
-- 2. cache - tidak digunakan (tidak ada penggunaan cache di code)
-- 3. cache_locks - tidak digunakan (tidak ada penggunaan cache di code)
-- 4. jobs - tidak digunakan (tidak ada penggunaan queue di code)
-- 5. job_batches - tidak digunakan (tidak ada penggunaan queue di code)
-- 6. failed_jobs - tidak digunakan (tidak ada penggunaan queue di code)
--
-- Table yang TETAP DIPERTAHANKAN:
-- ✓ pengguna (user table utama)
-- ✓ layanan
-- ✓ pesanan
-- ✓ portofolio
-- ✓ testimoni
-- ✓ password_reset_tokens (untuk reset password)
-- ✓ sessions (untuk session Laravel)
-- ============================================

-- 1. Hapus table 'users' jika ada (tidak digunakan, karena pakai 'pengguna')
DROP TABLE IF EXISTS `users`;

-- 2. Hapus table cache (tidak digunakan di aplikasi ini)
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;

-- 3. Hapus table jobs (tidak digunakan di aplikasi ini)
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;

-- ============================================
-- VERIFIKASI
-- ============================================
-- Setelah menjalankan script, table yang tersisa seharusnya:
-- - pengguna
-- - layanan
-- - pesanan
-- - portofolio
-- - testimoni
-- - password_reset_tokens
-- - sessions
-- ============================================

