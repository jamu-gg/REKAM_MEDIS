<?php
require_once __DIR__ . '/../includes/init.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    hapus_data($koneksi, 'dokter', 'id_dokter', (int)($_POST['id'] ?? 0), 'dokter');
}
redirect('index.php');
