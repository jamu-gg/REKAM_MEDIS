<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/_validasi.php';

$d = ['nama_obat' => '', 'satuan' => '', 'stok' => '0'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$d, $errors] = validasi_obat($_POST);
    if (!$errors) {
        $stok = (int)$d['stok'];
        $st = $koneksi->prepare('INSERT INTO obat (nama_obat, satuan, stok) VALUES (?,?,?)');
        $st->bind_param('ssi', $d['nama_obat'], $d['satuan'], $stok);
        if ($st->execute()) {
            flash('success', 'Data obat berhasil ditambahkan.');
            redirect('index.php');
        }
        $errors['_db'] = 'Gagal menyimpan data: ' . $st->error;
    }
}

$judul = 'Tambah Obat';
$menu  = 'obat';
$labelTombol = 'Simpan Obat';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head"><div><h1>Tambah Obat</h1><p>Isi data obat baru.</p></div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
