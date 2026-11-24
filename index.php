<?php
require_once __DIR__ . '/includes/init.php';

// Statistik ringkasan memakai fungsi agregat COUNT()
$stat = $koneksi->query(
    'SELECT (SELECT COUNT(*) FROM pasien)      AS total_pasien,
            (SELECT COUNT(*) FROM dokter)      AS total_dokter,
            (SELECT COUNT(*) FROM obat)        AS total_obat,
            (SELECT COUNT(*) FROM rekam_medis) AS total_rekam'
)->fetch_assoc();

// 5 pemeriksaan terbaru (JOIN)
$terbaru = $koneksi->query(
    'SELECT rm.id_rekam, rm.tanggal_periksa, rm.diagnosa, p.nama_pasien, d.nama_dokter, o.nama_obat
     FROM rekam_medis rm
     INNER JOIN pasien p ON rm.id_pasien = p.id_pasien
     INNER JOIN dokter d ON rm.id_dokter = d.id_dokter
     LEFT  JOIN obat   o ON rm.id_obat   = o.id_obat
     ORDER BY rm.tanggal_periksa DESC, rm.id_rekam DESC
     LIMIT 5'
)->fetch_all(MYSQLI_ASSOC);

$cards = [
    ['Total Pasien',       $stat['total_pasien'], '/pasien/',      'M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM21 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'],
    ['Total Dokter',       $stat['total_dokter'], '/dokter/',      'M22 12h-4l-3 9L9 3l-3 9H2'],
    ['Total Obat',         $stat['total_obat'],   '/obat/',        'M10.5 20.5l10-10a4.95 4.95 0 0 0-7-7l-10 10a4.95 4.95 0 0 0 7 7zM8.5 8.5l7 7'],
    ['Catatan Rekam Medis', $stat['total_rekam'], '/rekam_medis/', 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M16 13H8M16 17H8M10 9H8'],
];

$judul = 'Dashboard';
$menu  = 'dashboard';
require __DIR__ . '/includes/header.php';
?>
<div class="page-head">
  <div>
    <h1>Dashboard</h1>
    <p>Ringkasan data rekam medis · <?= date('d/m/Y') ?></p>
  </div>
  <a href="<?= BASE_URL ?>/rekam_medis/tambah.php" class="btn btn-primary">+ Catat Pemeriksaan</a>
</div>

<div class="stats">
  <?php foreach ($cards as $c): ?>
    <a href="<?= BASE_URL . $c[2] ?>" class="card stat" style="color:inherit">
      <div class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="<?= $c[3] ?>"/></svg></div>
      <div><strong><?= (int)$c[1] ?></strong><span><?= e($c[0]) ?></span></div>
    </a>
  <?php endforeach; ?>
</div>

<div class="card">
  <div class="panel-title">
    <h2>Pemeriksaan Terbaru</h2>
    <a href="<?= BASE_URL ?>/rekam_medis/" class="btn btn-ghost btn-sm">Lihat semua</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Tanggal</th><th>Pasien</th><th>Dokter</th><th>Diagnosa</th><th>Obat</th></tr></thead>
      <tbody>
      <?php if (!$terbaru): ?>
        <tr><td colspan="5"><div class="empty"><b>Belum ada pemeriksaan</b>Catatan terbaru akan muncul di sini.</div></td></tr>
      <?php endif; ?>
      <?php foreach ($terbaru as $r): ?>
        <tr>
          <td style="white-space:nowrap"><?= tgl($r['tanggal_periksa']) ?></td>
          <td><strong><?= e($r['nama_pasien']) ?></strong></td>
          <td><?= e($r['nama_dokter']) ?></td>
          <td class="wrap"><?= e($r['diagnosa']) ?></td>
          <td><?= $r['nama_obat'] !== null ? e($r['nama_obat']) : '—' ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
