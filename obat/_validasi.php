<?php
/** Validasi input obat. Mengembalikan [data_bersih, errors]. */
function validasi_obat(array $in): array
{
    $d = [
        'nama_obat' => trim($in['nama_obat'] ?? ''),
        'satuan'    => trim($in['satuan'] ?? ''),
        'stok'      => trim((string)($in['stok'] ?? '')),
    ];
    $e = [];

    if ($d['nama_obat'] === '') {
        $e['nama_obat'] = 'Nama obat wajib diisi.';
    } elseif (mb_strlen($d['nama_obat']) > 100) {
        $e['nama_obat'] = 'Maksimal 100 karakter.';
    }

    if ($d['satuan'] === '') {
        $e['satuan'] = 'Satuan wajib diisi.';
    } elseif (mb_strlen($d['satuan']) > 30) {
        $e['satuan'] = 'Maksimal 30 karakter.';
    }

    if ($d['stok'] === '' || !ctype_digit($d['stok']) || strlen($d['stok']) > 9) {
        $e['stok'] = 'Stok harus berupa angka bulat 0 atau lebih.';
    }

    return [$d, $e];
}
