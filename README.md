# Rekam Medis Sederhana (PHP Native + MySQLi)

## Cara menjalankan (XAMPP)
1. Salin folder `rekam_medis` ke `C:\xampp\htdocs\` (Linux: `/opt/lampp/htdocs/`).
2. Start **Apache** dan **MySQL** di XAMPP.
3. Pastikan database `db_rekam_medis` dengan 4 tabel sudah ada. Jika belum, impor `database.sql` lewat phpMyAdmin.
4. Buka http://localhost/rekam_medis/
5. Jika nama folder berbeda, ubah konstanta `BASE_URL` di `koneksi.php`.

## Struktur
- koneksi.php — koneksi MySQLi (root, tanpa password)
- includes/ — init, helpers, header (sidebar), footer
- assets/ — style.css, app.js
- pasien/, dokter/, obat/ — CRUD (index, tambah, edit, hapus)
- rekam_medis/ — riwayat (SQL JOIN), tambah (dropdown dinamis), edit, hapus
# REKAM_MEDIS
