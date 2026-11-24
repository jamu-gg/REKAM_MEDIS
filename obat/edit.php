<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/_validasi.php';

$id  = (int)($_GET['id'] ?? 0);
$row = cari_baris($koneksi, 'obat', 'id_obat', $id);
if (!$row) {
    flash('error', 'Data obat tidak ditemukan.');
    redirect('index.php');
}

$d = $row;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$d, $errors] = validasi_obat($_POST);
    if (!$errors) {
        $stok = (int)$d['stok'];
        $st = $koneksi->prepare('UPDATE obat SET nama_obat=?, satuan=?, stok=? WHERE id_obat=?');
        $st->bind_param('ssii', $d['nama_obat'], $d['satuan'], $stok, $id);
        if ($st->execute()) {
            flash('success', 'Perubahan data obat berhasil disimpan.');
            redirect('index.php');
        }
        $errors['_db'] = 'Gagal memperbarui data: ' . $st->error;
    }
}

$judul = 'Edit Obat';
$menu  = 'obat';
$labelTombol = 'Simpan Perubahan';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head"><div><h1>Edit Obat</h1><p>Perbarui data <b><?= e($row['nama_obat']) ?></b>.</p></div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
