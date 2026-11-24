<?php
require_once __DIR__ . '/../includes/init.php';

/*
 * Riwayat pemeriksaan memakai SQL JOIN agar yang tampil adalah
 * nama pasien, nama dokter, dan nama obat (bukan angka ID).
 * INNER JOIN untuk pasien & dokter (selalu ada), LEFT JOIN untuk obat.
 */
$sql = 'SELECT rm.id_rekam, rm.tanggal_periksa, rm.keluhan, rm.diagnosa, rm.tindakan, rm.resep,
               p.nama_pasien, p.no_rm,
               d.nama_dokter, d.spesialisasi,
               o.nama_obat, o.satuan
        FROM rekam_medis rm
        INNER JOIN pasien p ON rm.id_pasien = p.id_pasien
        INNER JOIN dokter d ON rm.id_dokter = d.id_dokter
        LEFT  JOIN obat   o ON rm.id_obat   = o.id_obat';

$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $st = $koneksi->prepare($sql . ' WHERE p.nama_pasien LIKE ? OR p.no_rm LIKE ? OR d.nama_dokter LIKE ? OR rm.diagnosa LIKE ? ORDER BY rm.tanggal_periksa DESC, rm.id_rekam DESC');
    $st->bind_param('ssss', $like, $like, $like, $like);
} else {
    $st = $koneksi->prepare($sql . ' ORDER BY rm.tanggal_periksa DESC, rm.id_rekam DESC');
}
$st->execute();
$rows = $st->get_result()->fetch_all(MYSQLI_ASSOC);
$st->close();

$judul = 'Riwayat Rekam Medis';
$menu  = 'rekam';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head">
  <div>
    <h1>Riwayat Rekam Medis</h1>
    <p>Catatan pemeriksaan pasien lengkap dengan dokter dan obat.</p>
  </div>
  <a href="tambah.php" class="btn btn-primary">+ Catat Pemeriksaan</a>
</div>

<div class="card">
  <div class="toolbar">
    <form class="search" method="get">
      <input type="search" name="q" placeholder="Cari pasien, dokter, atau diagnosa…" value="<?= e($q) ?>">
      <button class="btn btn-ghost" type="submit">Cari</button>
      <?php if ($q !== ''): ?><a href="index.php" class="btn btn-ghost">Reset</a><?php endif; ?>
    </form>
    <span class="hint" style="align-self:center"><?= count($rows) ?> catatan</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>#</th><th>Tanggal</th><th>Pasien</th><th>Dokter</th><th>Obat</th><th>Keluhan</th><th>Diagnosa</th><th>Tindakan</th><th>Resep</th><th>Aksi</th></tr>
      </thead>
      <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="10"><div class="empty"><b>Belum ada catatan</b>Catat pemeriksaan pertama untuk mulai membangun riwayat.</div></td></tr>
      <?php endif; ?>
      <?php foreach ($rows as $i => $r): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td style="white-space:nowrap"><?= tgl($r['tanggal_periksa']) ?></td>
          <td style="white-space:nowrap"><strong><?= e($r['nama_pasien']) ?></strong><small class="mono"><?= e($r['no_rm']) ?></small></td>
          <td style="white-space:nowrap"><?= e($r['nama_dokter']) ?><small><?= e($r['spesialisasi']) ?></small></td>
          <td style="white-space:nowrap"><?= $r['nama_obat'] !== null ? e($r['nama_obat']) . '<small>' . e($r['satuan']) . '</small>' : '<span class="hint">—</span>' ?></td>
          <td class="wrap"><?= e($r['keluhan']) ?></td>
          <td class="wrap"><?= e($r['diagnosa']) ?></td>
          <td class="wrap"><?= e($r['tindakan']) ?></td>
          <td class="wrap"><span class="badge badge-teal" style="white-space:normal"><?= e($r['resep']) ?></span></td>
          <td>
            <div class="actions">
              <a class="btn btn-ghost btn-sm" href="edit.php?id=<?= (int)$r['id_rekam'] ?>">Edit</a>
              <form method="post" action="hapus.php" data-confirm="Hapus catatan pemeriksaan &quot;<?= e($r['nama_pasien']) ?>&quot; tanggal <?= tgl($r['tanggal_periksa']) ?>?">
                <input type="hidden" name="id" value="<?= (int)$r['id_rekam'] ?>">
                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
