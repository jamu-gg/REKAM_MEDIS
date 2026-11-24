<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/_validasi.php';

$opsi = opsi_relasi($koneksi); // dropdown ditarik dinamis dari database
$d = ['id_pasien' => 0, 'id_dokter' => 0, 'id_obat' => 0, 'tanggal_periksa' => date('Y-m-d'),
      'keluhan' => '', 'diagnosa' => '', 'tindakan' => '', 'resep' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$d, $errors] = validasi_rekam($_POST, $opsi);
    if (!$errors) {
        $st = $koneksi->prepare('INSERT INTO rekam_medis (id_pasien, id_dokter, id_obat, tanggal_periksa, keluhan, diagnosa, tindakan, resep) VALUES (?,?,?,?,?,?,?,?)');
        $st->bind_param('iiisssss', $d['id_pasien'], $d['id_dokter'], $d['id_obat'], $d['tanggal_periksa'], $d['keluhan'], $d['diagnosa'], $d['tindakan'], $d['resep']);
        if ($st->execute()) {
            flash('success', 'Catatan rekam medis berhasil disimpan.');
            redirect('index.php');
        }
        $errors['_db'] = 'Gagal menyimpan data: ' . $st->error;
    }
}

$judul = 'Catat Pemeriksaan';
$menu  = 'rekam';
$labelTombol = 'Simpan Rekam Medis';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head"><div><h1>Catat Pemeriksaan</h1><p>Pilih pasien, dokter, dan obat, lalu isi hasil pemeriksaan.</p></div></div>
<?php require __DIR__ . '/_form.php'; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
