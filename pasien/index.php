<?php
require_once __DIR__ . '/../includes/init.php';

$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $st = $koneksi->prepare('SELECT * FROM pasien WHERE nama_pasien LIKE ? OR no_rm LIKE ? ORDER BY id_pasien DESC');
    $st->bind_param('ss', $like, $like);
} else {
    $st = $koneksi->prepare('SELECT * FROM pasien ORDER BY id_pasien DESC');
}
$st->execute();
$rows = $st->get_result()->fetch_all(MYSQLI_ASSOC);
$st->close();

$judul = 'Data Pasien';
$menu  = 'pasien';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head">
  <div>
    <h1>Data Pasien</h1>
    <p>Kelola identitas pasien yang terdaftar.</p>
  </div>
  <a href="tambah.php" class="btn btn-primary">+ Tambah Pasien</a>
</div>

<div class="card">
  <div class="toolbar">
    <form class="search" method="get">
      <input type="search" name="q" placeholder="Cari nama atau No. RM…" value="<?= e($q) ?>">
      <button class="btn btn-ghost" type="submit">Cari</button>
      <?php if ($q !== ''): ?><a href="index.php" class="btn btn-ghost">Reset</a><?php endif; ?>
    </form>
    <span class="hint" style="align-self:center"><?= count($rows) ?> pasien</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>#</th><th>No. RM</th><th>Nama Pasien</th><th>JK</th><th>Tgl Lahir</th><th>Alamat</th><th>Aksi</th></tr>
      </thead>
      <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="7"><div class="empty"><b>Belum ada data</b>Tambahkan pasien pertama Anda.</div></td></tr>
      <?php endif; ?>
      <?php foreach ($rows as $i => $r): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td class="mono"><?= e($r['no_rm']) ?></td>
          <td><strong><?= e($r['nama_pasien']) ?></strong></td>
          <td><span class="badge <?= $r['jenis_kelamin'] === 'L' ? 'badge-teal' : 'badge-slate' ?>"><?= e($r['jenis_kelamin']) ?></span></td>
          <td><?= tgl($r['tanggal_lahir']) ?></td>
          <td class="wrap"><?= e($r['alamat']) ?></td>
          <td>
            <div class="actions">
              <a class="btn btn-ghost btn-sm" href="edit.php?id=<?= (int)$r['id_pasien'] ?>">Edit</a>
              <form method="post" action="hapus.php" data-confirm="Hapus pasien &quot;<?= e($r['nama_pasien']) ?>&quot;? Tindakan ini tidak dapat dibatalkan.">
                <input type="hidden" name="id" value="<?= (int)$r['id_pasien'] ?>">
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
