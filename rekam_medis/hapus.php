<?php
require_once __DIR__ . '/../includes/init.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    hapus_data($koneksi, 'rekam_medis', 'id_rekam', (int)($_POST['id'] ?? 0), 'rekam medis');
}
redirect('index.php');
