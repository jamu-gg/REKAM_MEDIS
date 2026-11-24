<?php
/** Ambil opsi dropdown secara dinamis dari tabel pasien, dokter, dan obat. */
function opsi_relasi(mysqli $db): array
{
    return [
        'pasien' => $db->query('SELECT id_pasien, no_rm, nama_pasien FROM pasien ORDER BY nama_pasien')->fetch_all(MYSQLI_ASSOC),
        'dokter' => $db->query('SELECT id_dokter, nama_dokter, spesialisasi FROM dokter ORDER BY nama_dokter')->fetch_all(MYSQLI_ASSOC),
        'obat'   => $db->query('SELECT id_obat, nama_obat, satuan, stok FROM obat ORDER BY nama_obat')->fetch_all(MYSQLI_ASSOC),
    ];
}

/** Validasi input rekam medis. Mengembalikan [data_bersih, errors]. */
function validasi_rekam(array $in, array $opsi): array
{
    $d = [
        'id_pasien'       => (int)($in['id_pasien'] ?? 0),
        'id_dokter'       => (int)($in['id_dokter'] ?? 0),
        'id_obat'         => (int)($in['id_obat'] ?? 0),
        'tanggal_periksa' => trim($in['tanggal_periksa'] ?? ''),
        'keluhan'         => trim($in['keluhan'] ?? ''),
        'diagnosa'        => trim($in['diagnosa'] ?? ''),
        'tindakan'        => trim($in['tindakan'] ?? ''),
        'resep'           => trim($in['resep'] ?? ''),
    ];
    $e = [];

    // FK harus valid: id yang dikirim wajib ada di tabel induk
    if (!in_array($d['id_pasien'], array_map('intval', array_column($opsi['pasien'], 'id_pasien')), true)) {
        $e['id_pasien'] = 'Pilih pasien yang valid.';
    }
    if (!in_array($d['id_dokter'], array_map('intval', array_column($opsi['dokter'], 'id_dokter')), true)) {
        $e['id_dokter'] = 'Pilih dokter yang valid.';
    }
    if (!in_array($d['id_obat'], array_map('intval', array_column($opsi['obat'], 'id_obat')), true)) {
        $e['id_obat'] = 'Pilih obat yang valid.';
    }

    if (!valid_date($d['tanggal_periksa'])) {
        $e['tanggal_periksa'] = 'Tanggal pemeriksaan tidak valid.';
    } elseif ($d['tanggal_periksa'] > date('Y-m-d')) {
        $e['tanggal_periksa'] = 'Tanggal pemeriksaan tidak boleh di masa depan.';
    }

    if ($d['keluhan'] === '')  $e['keluhan']  = 'Keluhan wajib diisi.';
    if ($d['diagnosa'] === '') $e['diagnosa'] = 'Diagnosa wajib diisi.';
    if ($d['tindakan'] === '') $e['tindakan'] = 'Tindakan wajib diisi.';

    if ($d['resep'] === '') {
        $e['resep'] = 'Aturan pakai (resep) wajib diisi.';
    } elseif (mb_strlen($d['resep']) > 100) {
        $e['resep'] = 'Maksimal 100 karakter.';
    }

    return [$d, $e];
}
