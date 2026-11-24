<?php /* Partial form rekam medis. Variabel: $d, $errors, $opsi, $labelTombol */
$kosong = !$opsi['pasien'] || !$opsi['dokter'] || !$opsi['obat'];
?>
<?php if ($kosong): ?>
  <div class="alert alert-warn">
    Data master belum lengkap. Pastikan sudah ada minimal satu
    <a href="<?= BASE_URL ?>/pasien/tambah.php"><b>pasien</b></a>,
    <a href="<?= BASE_URL ?>/dokter/tambah.php"><b>dokter</b></a>, dan
    <a href="<?= BASE_URL ?>/obat/tambah.php"><b>obat</b></a> sebelum mencatat pemeriksaan.
  </div>
<?php endif; ?>
<form method="post" class="card form" novalidate>
  <?php if (isset($errors['_db'])): ?><div class="alert alert-error"><?= e($errors['_db']) ?></div><?php endif; ?>
  <div class="form-grid">
    <div class="field">
      <label for="id_pasien">Pasien <span class="req">*</span></label>
      <select id="id_pasien" name="id_pasien" class="<?= inv($errors, 'id_pasien') ?>" required>
        <option value="">— Pilih pasien —</option>
        <?php foreach ($opsi['pasien'] as $o): ?>
          <option value="<?= (int)$o['id_pasien'] ?>" <?= (int)$d['id_pasien'] === (int)$o['id_pasien'] ? 'selected' : '' ?>>
            <?= e($o['nama_pasien']) ?> (<?= e($o['no_rm']) ?>)
          </option>
        <?php endforeach; ?>
      </select>
      <?= ferr($errors, 'id_pasien') ?>
    </div>
    <div class="field">
      <label for="id_dokter">Dokter <span class="req">*</span></label>
      <select id="id_dokter" name="id_dokter" class="<?= inv($errors, 'id_dokter') ?>" required>
        <option value="">— Pilih dokter —</option>
        <?php foreach ($opsi['dokter'] as $o): ?>
          <option value="<?= (int)$o['id_dokter'] ?>" <?= (int)$d['id_dokter'] === (int)$o['id_dokter'] ? 'selected' : '' ?>>
            <?= e($o['nama_dokter']) ?> — <?= e($o['spesialisasi']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <?= ferr($errors, 'id_dokter') ?>
    </div>
    <div class="field">
      <label for="id_obat">Obat <span class="req">*</span></label>
      <select id="id_obat" name="id_obat" class="<?= inv($errors, 'id_obat') ?>" required>
        <option value="">— Pilih obat —</option>
        <?php foreach ($opsi['obat'] as $o): ?>
          <option value="<?= (int)$o['id_obat'] ?>" <?= (int)$d['id_obat'] === (int)$o['id_obat'] ? 'selected' : '' ?>>
            <?= e($o['nama_obat']) ?> (<?= e($o['satuan']) ?> · stok <?= (int)$o['stok'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
      <?= ferr($errors, 'id_obat') ?>
    </div>
    <div class="field">
      <label for="tanggal_periksa">Tanggal Pemeriksaan <span class="req">*</span></label>
      <input type="date" id="tanggal_periksa" name="tanggal_periksa" max="<?= date('Y-m-d') ?>" value="<?= e($d['tanggal_periksa']) ?>" class="<?= inv($errors, 'tanggal_periksa') ?>" required>
      <?= ferr($errors, 'tanggal_periksa') ?>
    </div>
    <div class="field full">
      <label for="keluhan">Keluhan <span class="req">*</span></label>
      <textarea id="keluhan" name="keluhan" class="<?= inv($errors, 'keluhan') ?>" required><?= e($d['keluhan']) ?></textarea>
      <?= ferr($errors, 'keluhan') ?>
    </div>
    <div class="field">
      <label for="diagnosa">Diagnosa <span class="req">*</span></label>
      <textarea id="diagnosa" name="diagnosa" class="<?= inv($errors, 'diagnosa') ?>" required><?= e($d['diagnosa']) ?></textarea>
      <?= ferr($errors, 'diagnosa') ?>
    </div>
    <div class="field">
      <label for="tindakan">Tindakan <span class="req">*</span></label>
      <textarea id="tindakan" name="tindakan" class="<?= inv($errors, 'tindakan') ?>" required><?= e($d['tindakan']) ?></textarea>
      <?= ferr($errors, 'tindakan') ?>
    </div>
    <div class="field full">
      <label for="resep">Resep / Aturan Pakai <span class="req">*</span></label>
      <input type="text" id="resep" name="resep" maxlength="100" placeholder="mis. 3 x 1 tablet sesudah makan" value="<?= e($d['resep']) ?>" class="<?= inv($errors, 'resep') ?>" required>
      <?= ferr($errors, 'resep') ?>
    </div>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-primary" <?= $kosong ? 'disabled' : '' ?>><?= e($labelTombol) ?></button>
    <a href="index.php" class="btn btn-ghost">Batal</a>
  </div>
</form>
