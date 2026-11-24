<?php /* Partial form pasien. Variabel: $d, $errors, $labelTombol */ ?>
<form method="post" class="card form" novalidate>
  <?php if (isset($errors['_db'])): ?><div class="alert alert-error"><?= e($errors['_db']) ?></div><?php endif; ?>
  <div class="form-grid">
    <div class="field">
      <label for="no_rm">No. Rekam Medis <span class="req">*</span></label>
      <input type="text" id="no_rm" name="no_rm" maxlength="20" placeholder="mis. RM-0001" value="<?= e($d['no_rm']) ?>" class="<?= inv($errors, 'no_rm') ?>" required>
      <?= ferr($errors, 'no_rm') ?>
    </div>
    <div class="field">
      <label for="nama_pasien">Nama Pasien <span class="req">*</span></label>
      <input type="text" id="nama_pasien" name="nama_pasien" maxlength="100" value="<?= e($d['nama_pasien']) ?>" class="<?= inv($errors, 'nama_pasien') ?>" required>
      <?= ferr($errors, 'nama_pasien') ?>
    </div>
    <div class="field">
      <label>Jenis Kelamin <span class="req">*</span></label>
      <div class="radio-row">
        <label><input type="radio" name="jenis_kelamin" value="L" <?= $d['jenis_kelamin'] === 'L' ? 'checked' : '' ?>> Laki-laki</label>
        <label><input type="radio" name="jenis_kelamin" value="P" <?= $d['jenis_kelamin'] === 'P' ? 'checked' : '' ?>> Perempuan</label>
      </div>
      <?= ferr($errors, 'jenis_kelamin') ?>
    </div>
    <div class="field">
      <label for="tanggal_lahir">Tanggal Lahir <span class="req">*</span></label>
      <input type="date" id="tanggal_lahir" name="tanggal_lahir" max="<?= date('Y-m-d') ?>" value="<?= e($d['tanggal_lahir']) ?>" class="<?= inv($errors, 'tanggal_lahir') ?>" required>
      <?= ferr($errors, 'tanggal_lahir') ?>
    </div>
    <div class="field full">
      <label for="alamat">Alamat <span class="req">*</span></label>
      <textarea id="alamat" name="alamat" class="<?= inv($errors, 'alamat') ?>" required><?= e($d['alamat']) ?></textarea>
      <?= ferr($errors, 'alamat') ?>
    </div>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-primary"><?= e($labelTombol) ?></button>
    <a href="index.php" class="btn btn-ghost">Batal</a>
  </div>
</form>
