<?php
require_once __DIR__ . '/../includes/init.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    hapus_data($koneksi, 'pasien', 'id_pasien', (int)($_POST['id'] ?? 0), 'pasien');
}
redirect('index.php');
