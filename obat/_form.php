<?php /* Partial form obat. Variabel: $d, $errors, $labelTombol */ ?>
<form method="post" class="card form" novalidate>
  <?php if (isset($errors['_db'])): ?><div class="alert alert-error"><?= e($errors['_db']) ?></div><?php endif; ?>
  <div class="form-grid">
    <div class="field full">
      <label for="nama_obat">Nama Obat <span class="req">*</span></label>
      <input type="text" id="nama_obat" name="nama_obat" maxlength="100" placeholder="mis. Paracetamol 500 mg" value="<?= e($d['nama_obat']) ?>" class="<?= inv($errors, 'nama_obat') ?>" required>
      <?= ferr($errors, 'nama_obat') ?>
    </div>
    <div class="field">
      <label for="satuan">Satuan <span class="req">*</span></label>
      <input type="text" id="satuan" name="satuan" maxlength="30" list="daftar-satuan" placeholder="Tablet, kapsul, sirup…" value="<?= e($d['satuan']) ?>" class="<?= inv($errors, 'satuan') ?>" required>
      <datalist id="daftar-satuan">
        <option value="Tablet"><option value="Kapsul"><option value="Sirup"><option value="Salep"><option value="Botol"><option value="Strip">
      </datalist>
      <?= ferr($errors, 'satuan') ?>
    </div>
    <div class="field">
      <label for="stok">Stok <span class="req">*</span></label>
      <input type="number" id="stok" name="stok" min="0" step="1" value="<?= e($d['stok']) ?>" class="<?= inv($errors, 'stok') ?>" required>
      <?= ferr($errors, 'stok') ?>
    </div>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-primary"><?= e($labelTombol) ?></button>
    <a href="index.php" class="btn btn-ghost">Batal</a>
  </div>
</form>
