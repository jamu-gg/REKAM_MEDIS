<?php /* Partial form dokter. Variabel: $d, $errors, $labelTombol */ ?>
<form method="post" class="card form" novalidate>
  <?php if (isset($errors['_db'])): ?><div class="alert alert-error"><?= e($errors['_db']) ?></div><?php endif; ?>
  <div class="form-grid">
    <div class="field">
      <label for="nama_dokter">Nama Dokter <span class="req">*</span></label>
      <input type="text" id="nama_dokter" name="nama_dokter" maxlength="100" placeholder="mis. dr. Andi Pratama" value="<?= e($d['nama_dokter']) ?>" class="<?= inv($errors, 'nama_dokter') ?>" required>
      <?= ferr($errors, 'nama_dokter') ?>
    </div>
    <div class="field">
      <label for="spesialisasi">Spesialisasi <span class="req">*</span></label>
      <input type="text" id="spesialisasi" name="spesialisasi" maxlength="50" list="daftar-spesialisasi" placeholder="mis. Umum" value="<?= e($d['spesialisasi']) ?>" class="<?= inv($errors, 'spesialisasi') ?>" required>
      <datalist id="daftar-spesialisasi">
        <option value="Umum"><option value="Anak"><option value="Penyakit Dalam"><option value="Gigi"><option value="Kandungan"><option value="THT"><option value="Mata">
      </datalist>
      <?= ferr($errors, 'spesialisasi') ?>
    </div>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-primary"><?= e($labelTombol) ?></button>
    <a href="index.php" class="btn btn-ghost">Batal</a>
  </div>
</form>
