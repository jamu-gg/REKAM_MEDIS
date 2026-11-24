<?php
require_once __DIR__ . '/../includes/init.php';

$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $st = $koneksi->prepare('SELECT * FROM obat WHERE nama_obat LIKE ? OR satuan LIKE ? ORDER BY id_obat DESC');
    $st->bind_param('ss', $like, $like);
} else {
    $st = $koneksi->prepare('SELECT * FROM obat ORDER BY id_obat DESC');
}
$st->execute();
$rows = $st->get_result()->fetch_all(MYSQLI_ASSOC);
$st->close();

$judul = 'Data Obat';
$menu  = 'obat';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-head">
  <div>
    <h1>Data Obat</h1>
    <p>Persediaan obat beserta satuan dan stoknya.</p>
  </div>
  <a href="tambah.php" class="btn btn-primary">+ Tambah Obat</a>
</div>

<div class="card">
  <div class="toolbar">
    <form class="search" method="get">
      <input type="search" name="q" placeholder="Cari nama obat atau satuan…" value="<?= e($q) ?>">
      <button class="btn btn-ghost" type="submit">Cari</button>
      <?php if ($q !== ''): ?><a href="index.php" class="btn btn-ghost">Reset</a><?php endif; ?>
    </form>
    <span class="hint" style="align-self:center"><?= count($rows) ?> obat</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Nama Obat</th><th>Satuan</th><th>Stok</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="5"><div class="empty"><b>Belum ada data</b>Tambahkan obat pertama Anda.</div></td></tr>
      <?php endif; ?>
      <?php foreach ($rows as $i => $r): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><strong><?= e($r['nama_obat']) ?></strong></td>
          <td><?= e($r['satuan']) ?></td>
          <td>
            <span class="badge <?= (int)$r['stok'] <= 10 ? 'badge-warn' : 'badge-teal' ?>"><?= (int)$r['stok'] ?></span>
            <?php if ((int)$r['stok'] <= 10): ?><small>stok menipis</small><?php endif; ?>
          </td>
          <td>
            <div class="actions">
              <a class="btn btn-ghost btn-sm" href="edit.php?id=<?= (int)$r['id_obat'] ?>">Edit</a>
              <form method="post" action="hapus.php" data-confirm="Hapus obat &quot;<?= e($r['nama_obat']) ?>&quot;? Tindakan ini tidak dapat dibatalkan.">
                <input type="hidden" name="id" value="<?= (int)$r['id_obat'] ?>">
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
