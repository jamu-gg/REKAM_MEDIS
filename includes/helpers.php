<?php
/** Escape output HTML */
function e($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

/** Set / ambil pesan flash (berhasil / gagal) */
function flash($type = null, $msg = null)
{
    if ($type !== null) {
        $_SESSION['flash'] = ['t' => $type, 'm' => $msg];
        return null;
    }
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function tgl($d): string
{
    return $d ? date('d/m/Y', strtotime($d)) : '-';
}

function valid_date(string $d): bool
{
    $x = DateTime::createFromFormat('Y-m-d', $d);
    return $x && $x->format('Y-m-d') === $d;
}

/** Pesan error di bawah field */
function ferr(array $errors, string $k): string
{
    return isset($errors[$k]) ? '<small class="field-error">' . e($errors[$k]) . '</small>' : '';
}

function inv(array $errors, string $k): string
{
    return isset($errors[$k]) ? ' invalid' : '';
}

/** Ambil satu baris berdasarkan PK */
function cari_baris(mysqli $db, string $tabel, string $pk, int $id): ?array
{
    $st = $db->prepare("SELECT * FROM `$tabel` WHERE `$pk` = ?");
    $st->bind_param('i', $id);
    $st->execute();
    $row = $st->get_result()->fetch_assoc();
    $st->close();
    return $row ?: null;
}

/** Hapus data + tangani aturan relasi (FK RESTRICT, errno 1451) */
function hapus_data(mysqli $db, string $tabel, string $pk, int $id, string $label): void
{
    $st = $db->prepare("DELETE FROM `$tabel` WHERE `$pk` = ?");
    $st->bind_param('i', $id);
    if ($st->execute()) {
        if ($st->affected_rows > 0) {
            flash('success', "Data $label berhasil dihapus.");
        } else {
            flash('error', "Data $label tidak ditemukan.");
        }
    } elseif ($st->errno === 1451) {
        flash('error', "Data $label tidak dapat dihapus karena masih digunakan pada catatan rekam medis.");
    } else {
        flash('error', 'Gagal menghapus data: ' . $st->error);
    }
    $st->close();
}
