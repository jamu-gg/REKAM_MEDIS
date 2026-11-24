<?php
require_once __DIR__ . '/../includes/init.php';

$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $st = $koneksi->prepare('SELECT * FROM dokter WHERE nama_dokter LIKE ? OR spesialisasi LIKE ? ORDER BY id_dokter DESC');
    $st->bind_param('ss', $like, $like);
} else {
    $st = $koneksi->prepare('SELECT * FROM dokter ORDER BY id_dokter DESC');
}
$st->execute();
$rows = $st->get_result()->fetch_all(MYSQLI_ASSOC);
$st->close();

$judul = 'Data Dokter';
$menu  = 'dokter';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head">
  <div>
    <h1>Data Dokter</h1>
    <p>Daftar dokter dan bidang spesialisasinya.</p>
  </div>
  <a href="tambah.php" class="btn btn-primary">+ Tambah Dokter</a>
</div>

<div class="card">
  <div class="toolbar">
    <form class="search" method="get">
      <input type="search" name="q" placeholder="Cari nama atau spesialisasi…" value="<?= e($q) ?>">
      <button class="btn btn-ghost" type="submit">Cari</button>
      <?php if ($q !== ''): ?><a href="index.php" class="btn btn-ghost">Reset</a><?php endif; ?>
    </form>
    <span class="hint" style="align-self:center"><?= count($rows) ?> dokter</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Nama Dokter</th><th>Spesialisasi</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="4"><div class="empty"><b>Belum ada data</b>Tambahkan dokter pertama Anda.</div></td></tr>
      <?php endif; ?>
      <?php foreach ($rows as $i => $r): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><strong><?= e($r['nama_dokter']) ?></strong></td>
          <td><span class="badge badge-teal"><?= e($r['spesialisasi']) ?></span></td>
          <td>
            <div class="actions">
              <a class="btn btn-ghost btn-sm" href="edit.php?id=<?= (int)$r['id_dokter'] ?>">Edit</a>
              <form method="post" action="hapus.php" data-confirm="Hapus dokter &quot;<?= e($r['nama_dokter']) ?>&quot;? Tindakan ini tidak dapat dibatalkan.">
                <input type="hidden" name="id" value="<?= (int)$r['id_dokter'] ?>">
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
