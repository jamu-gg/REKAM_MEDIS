<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/_validasi.php';

$d = ['no_rm' => '', 'nama_pasien' => '', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '', 'alamat' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$d, $errors] = validasi_pasien($koneksi, $_POST);
    if (!$errors) {
        $st = $koneksi->prepare('INSERT INTO pasien (no_rm, nama_pasien, jenis_kelamin, tanggal_lahir, alamat) VALUES (?,?,?,?,?)');
        $st->bind_param('sssss', $d['no_rm'], $d['nama_pasien'], $d['jenis_kelamin'], $d['tanggal_lahir'], $d['alamat']);
        if ($st->execute()) {
            flash('success', 'Data pasien berhasil ditambahkan.');
            redirect('index.php');
        }
        $errors['_db'] = 'Gagal menyimpan data: ' . $st->error;
    }
}

$judul = 'Tambah Pasien';
$menu  = 'pasien';
$labelTombol = 'Simpan Pasien';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head"><div><h1>Tambah Pasien</h1><p>Isi data pasien baru dengan lengkap.</p></div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
