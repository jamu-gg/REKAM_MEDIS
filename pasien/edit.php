<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/_validasi.php';

$id  = (int)($_GET['id'] ?? 0);
$row = cari_baris($koneksi, 'pasien', 'id_pasien', $id);
if (!$row) {
    flash('error', 'Data pasien tidak ditemukan.');
    redirect('index.php');
}

$d = $row;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$d, $errors] = validasi_pasien($koneksi, $_POST, $id);
    if (!$errors) {
        $st = $koneksi->prepare('UPDATE pasien SET no_rm=?, nama_pasien=?, jenis_kelamin=?, tanggal_lahir=?, alamat=? WHERE id_pasien=?');
        $st->bind_param('sssssi', $d['no_rm'], $d['nama_pasien'], $d['jenis_kelamin'], $d['tanggal_lahir'], $d['alamat'], $id);
        if ($st->execute()) {
            flash('success', 'Perubahan data pasien berhasil disimpan.');
            redirect('index.php');
        }
        $errors['_db'] = 'Gagal memperbarui data: ' . $st->error;
    }
}

$judul = 'Edit Pasien';
$menu  = 'pasien';
$labelTombol = 'Simpan Perubahan';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head"><div><h1>Edit Pasien</h1><p>Perbarui data <b><?= e($row['nama_pasien']) ?></b>.</p></div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
