<?php
/** Validasi input dokter. Mengembalikan [data_bersih, errors]. */
function validasi_dokter(array $in): array
{
    $d = [
        'nama_dokter'  => trim($in['nama_dokter'] ?? ''),
        'spesialisasi' => trim($in['spesialisasi'] ?? ''),
    ];
    $e = [];

    if ($d['nama_dokter'] === '') {
        $e['nama_dokter'] = 'Nama dokter wajib diisi.';
    } elseif (mb_strlen($d['nama_dokter']) > 100) {
        $e['nama_dokter'] = 'Maksimal 100 karakter.';
    }

    if ($d['spesialisasi'] === '') {
        $e['spesialisasi'] = 'Spesialisasi wajib diisi.';
    } elseif (mb_strlen($d['spesialisasi']) > 50) {
        $e['spesialisasi'] = 'Maksimal 50 karakter.';
    }

    return [$d, $e];
}
