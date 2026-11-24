<?php
$judul = $judul ?? 'Dashboard';
$menu  = $menu ?? 'dashboard';
$flash = flash();
$nav = [
    'dashboard' => ['Dashboard',   '/',              'M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10'],
    'pasien'    => ['Pasien',      '/pasien/',       'M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM21 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75'],
    'dokter'    => ['Dokter',      '/dokter/',       'M22 12h-4l-3 9L9 3l-3 9H2'],
    'obat'      => ['Obat',        '/obat/',         'M10.5 20.5l10-10a4.95 4.95 0 0 0-7-7l-10 10a4.95 4.95 0 0 0 7 7zM8.5 8.5l7 7'],
    'rekam'     => ['Rekam Medis', '/rekam_medis/',  'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM14 2v6h6M16 13H8M16 17H8M10 9H8'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($judul) ?> · Rekam Medis</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body>
<div class="layout">
  <aside class="sidebar" id="sidebar">
    <a class="brand" href="<?= BASE_URL ?>/">
      <span class="brand-mark"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></span>
      <span><b>Rekam<em>Medis</em></b><small>Sistem pencatatan klinik</small></span>
    </a>
    <nav class="nav">
      <span class="nav-label">Menu</span>
      <?php foreach ($nav as $key => $n): ?>
        <a href="<?= BASE_URL . $n[1] ?>" class="<?= $menu === $key ? 'active' : '' ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="<?= $n[2] ?>"/></svg>
          <?= e($n[0]) ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="sidebar-foot">
      <div class="avatar">P</div>
      <div>
        <strong>Prahara</strong>
        <small>@jamu-gg · Siber School</small>
      </div>
    </div>
  </aside>

  <div class="main">
    <div class="topbar-mobile">
      <button type="button" id="btnMenu" aria-label="Buka menu">☰</button>
      <b>Rekam<span>Medis</span></b>
    </div>
    <main class="content">
      <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['t'] === 'success' ? 'success' : 'error' ?>" data-autodismiss>
          <?= e($flash['m']) ?>
        </div>
      <?php endif; ?>
