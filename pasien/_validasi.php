<?php
/** Validasi input pasien. Mengembalikan [data_bersih, errors]. */
function validasi_pasien(mysqli $db, array $in, int $id = 0): array
{
    $d = [
        'no_rm'         => trim($in['no_rm'] ?? ''),
        'nama_pasien'   => trim($in['nama_pasien'] ?? ''),
        'jenis_kelamin' => $in['jenis_kelamin'] ?? '',
        'tanggal_lahir' => trim($in['tanggal_lahir'] ?? ''),
        'alamat'        => trim($in['alamat'] ?? ''),
    ];
    $e = [];

    if ($d['no_rm'] === '') {
        $e['no_rm'] = 'No. rekam medis wajib diisi.';
    } elseif (mb_strlen($d['no_rm']) > 20) {
        $e['no_rm'] = 'Maksimal 20 karakter.';
    } else {
        $st = $db->prepare('SELECT id_pasien FROM pasien WHERE no_rm = ? AND id_pasien <> ?');
        $st->bind_param('si', $d['no_rm'], $id);
        $st->execute();
        $st->store_result();
        if ($st->num_rows > 0) {
            $e['no_rm'] = 'No. rekam medis sudah digunakan pasien lain.';
        }
        $st->close();
    }

    if ($d['nama_pasien'] === '') {
        $e['nama_pasien'] = 'Nama pasien wajib diisi.';
    } elseif (mb_strlen($d['nama_pasien']) > 100) {
        $e['nama_pasien'] = 'Maksimal 100 karakter.';
    }

    if (!in_array($d['jenis_kelamin'], ['L', 'P'], true)) {
        $e['jenis_kelamin'] = 'Pilih jenis kelamin.';
    }

    if (!valid_date($d['tanggal_lahir'])) {
        $e['tanggal_lahir'] = 'Tanggal lahir tidak valid.';
    } elseif ($d['tanggal_lahir'] > date('Y-m-d')) {
        $e['tanggal_lahir'] = 'Tanggal lahir tidak boleh di masa depan.';
    }

    if ($d['alamat'] === '') {
        $e['alamat'] = 'Alamat wajib diisi.';
    }

    return [$d, $e];
}
