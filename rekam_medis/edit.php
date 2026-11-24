<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/_validasi.php';

$id  = (int)($_GET['id'] ?? 0);
$row = cari_baris($koneksi, 'rekam_medis', 'id_rekam', $id);
if (!$row) {
    flash('error', 'Catatan rekam medis tidak ditemukan.');
    redirect('index.php');
}

$opsi = opsi_relasi($koneksi);
$d = $row;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$d, $errors] = validasi_rekam($_POST, $opsi);
    if (!$errors) {
        $st = $koneksi->prepare('UPDATE rekam_medis SET id_pasien=?, id_dokter=?, id_obat=?, tanggal_periksa=?, keluhan=?, diagnosa=?, tindakan=?, resep=? WHERE id_rekam=?');
        $st->bind_param('iiisssssi', $d['id_pasien'], $d['id_dokter'], $d['id_obat'], $d['tanggal_periksa'], $d['keluhan'], $d['diagnosa'], $d['tindakan'], $d['resep'], $id);
        if ($st->execute()) {
            flash('success', 'Perubahan rekam medis berhasil disimpan.');
            redirect('index.php');
        }
        $errors['_db'] = 'Gagal memperbarui data: ' . $st->error;
    }
}

$judul = 'Edit Rekam Medis';
$menu  = 'rekam';
$labelTombol = 'Simpan Perubahan';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head"><div><h1>Edit Rekam Medis</h1><p>Perbarui catatan pemeriksaan #<?= (int)$id ?>.</p></div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
