<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/_validasi.php';

$d = ['nama_dokter' => '', 'spesialisasi' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$d, $errors] = validasi_dokter($_POST);
    if (!$errors) {
        $st = $koneksi->prepare('INSERT INTO dokter (nama_dokter, spesialisasi) VALUES (?,?)');
        $st->bind_param('ss', $d['nama_dokter'], $d['spesialisasi']);
        if ($st->execute()) {
            flash('success', 'Data dokter berhasil ditambahkan.');
            redirect('index.php');
        }
        $errors['_db'] = 'Gagal menyimpan data: ' . $st->error;
    }
}

$judul = 'Tambah Dokter';
$menu  = 'dokter';
$labelTombol = 'Simpan Dokter';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head"><div><h1>Tambah Dokter</h1><p>Isi data dokter baru.</p></div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
