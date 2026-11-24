<?php
// koneksi.php — file koneksi database (MySQLi) + penentu BASE_URL
mysqli_report(MYSQLI_REPORT_OFF); // matikan exception bawaan MySQLi, error ditangani manual agar pesannya ramah

// ---- Deteksi otomatis BASE_URL (alamat URL folder proyek) ----
$proyek = str_replace('\\', '/', realpath(__DIR__));                       // lokasi folder proyek di server (contoh: /www/pakBeny/rekam_medis)
$skrip  = str_replace('\\', '/', realpath($_SERVER['SCRIPT_FILENAME'] ?? '') ?: ''); // lokasi file PHP yang sedang dibuka di server
$url    = $_SERVER['SCRIPT_NAME'] ?? '';                                    // alamat URL file PHP yang sedang dibuka (contoh: /rekam_medis/index.php)
$base   = '';                                                               // nilai awal: kosong (proyek dianggap berada di akar situs)
if ($proyek !== '' && strpos($skrip, $proyek) === 0) {                      // jika file yang dibuka memang berada di dalam folder proyek
    $rel = substr($skrip, strlen($proyek));                                 // ambil bagian path setelah folder proyek (contoh: /rekam_medis/index.php)
    if ($rel !== '' && substr($url, -strlen($rel)) === $rel) {              // jika URL berakhiran sama dengan path relatif tersebut
        $base = substr($url, 0, strlen($url) - strlen($rel));               // sisa depannya adalah prefix URL proyek (bisa kosong atau /pakBeny/rekam_medis)
    }
}
define('BASE_URL', rtrim($base, '/'));                                      // simpan sebagai konstanta tanpa garis miring di akhir

$db_host = 'localhost';                     // alamat server MySQL
$db_user = 'bima';                          // username MySQL
$db_pass = 'LANTAI';                        // password MySQL
$db_name = 'db_rekam_medis';              // nama database yang dipakai

$koneksi = @new mysqli($db_host, $db_user, $db_pass, $db_name); // buka koneksi (@ menyembunyikan warning bawaan PHP)

if ($koneksi->connect_errno) {              // jika koneksi gagal (kode error bukan 0)
    http_response_code(500);                // kirim status HTTP 500 (kesalahan server)
    die('<div style="font-family:system-ui;max-width:520px;margin:15vh auto;padding:28px;border:1px solid #e2e8f0;border-radius:12px;background:#fff;color:#0f172a">
        <h2 style="margin:0 0 8px;color:#0d9488">Koneksi database gagal</h2>
        <p style="margin:0 0 12px;color:#475569">Pastikan Apache &amp; MySQL di XAMPP sudah aktif dan database <b>db_rekam_medis</b> sudah dibuat.</p>
        <code style="font-size:13px;color:#b91c1c">' . htmlspecialchars($koneksi->connect_error) . '</code></div>'); // hentikan program dan tampilkan kotak pesan error di atas
} // akhir blok if koneksi gagal

$koneksi->set_charset('utf8mb4');           // pakai charset utf8mb4 agar huruf/emoji tampil benar