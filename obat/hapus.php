<?php
require_once __DIR__ . '/../includes/init.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    hapus_data($koneksi, 'obat', 'id_obat', (int)($_POST['id'] ?? 0), 'obat');
}
redirect('index.php');
