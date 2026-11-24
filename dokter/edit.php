<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/_validasi.php';

$id  = (int)($_GET['id'] ?? 0);
$row = cari_baris($koneksi, 'dokter', 'id_dokter', $id);
if (!$row) {
    flash('error', 'Data dokter tidak ditemukan.');
    redirect('index.php');
}

$d = $row;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$d, $errors] = validasi_dokter($_POST);
    if (!$errors) {
        $st = $koneksi->prepare('UPDATE dokter SET nama_dokter=?, spesialisasi=? WHERE id_dokter=?');
        $st->bind_param('ssi', $d['nama_dokter'], $d['spesialisasi'], $id);
        if ($st->execute()) {
            flash('success', 'Perubahan data dokter berhasil disimpan.');
            redirect('index.php');
        }
        $errors['_db'] = 'Gagal memperbarui data: ' . $st->error;
    }
}

$judul = 'Edit Dokter';
$menu  = 'dokter';
$labelTombol = 'Simpan Perubahan';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head"><div><h1>Edit Dokter</h1><p>Perbarui data <b><?= e($row['nama_dokter']) ?></b>.</p></div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
