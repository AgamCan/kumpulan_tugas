<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/layout.php';
wajib_role('admin');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';
    if ($aksi === 'tambah') {
        $st = $conn->prepare('INSERT INTO sampah (jenis_sampah, harga_per_kg) VALUES (?, ?)');
        $st->bind_param('sd', $_POST['jenis'], $_POST['harga']); $st->execute();
    } elseif ($aksi === 'ubah') {
        $st = $conn->prepare('UPDATE sampah SET jenis_sampah=?, harga_per_kg=? WHERE id_sampah=?');
        $st->bind_param('sdi', $_POST['jenis'], $_POST['harga'], $_POST['id']); $st->execute();
    } elseif ($aksi === 'hapus') {
        try { $st = $conn->prepare('DELETE FROM sampah WHERE id_sampah=?'); $st->bind_param('i', $_POST['id']); $st->execute(); }
        catch (mysqli_sql_exception $e) { flash('Tidak bisa dihapus: sudah dipakai di transaksi.'); }
    }
    header('Location: sampah.php'); exit;
}
$rows = $conn->query('SELECT * FROM sampah ORDER BY jenis_sampah');
header_html('Jenis Sampah', menu_admin()); ?>
<div class="card p-4 mb-4"><h5>Tambah Jenis Sampah</h5>
<form method="post" class="row g-2"><input type="hidden" name="aksi" value="tambah">
<div class="col-md-6"><input name="jenis" class="form-control" placeholder="Jenis sampah" required></div>
<div class="col-md-4"><input name="harga" type="number" min="0" step="100" class="form-control" placeholder="Harga per kg" required></div>
<div class="col-md-2"><button class="btn btn-success w-100">Tambah</button></div></form></div>
<div class="card p-4"><h5>Daftar Jenis, Harga & Stok</h5><div class="table-responsive"><table class="table align-middle">
<thead><tr><th>Jenis</th><th>Harga/kg</th><th>Stok (kg)</th><th></th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr><form method="post">
<td><input name="jenis" class="form-control form-control-sm" value="<?= e($r['jenis_sampah']) ?>"></td>
<td><input name="harga" type="number" step="100" class="form-control form-control-sm" value="<?= e($r['harga_per_kg']) ?>"></td>
<td><?= number_format($r['stok_kg'], 2, ',', '.') ?></td>
<td class="text-end"><input type="hidden" name="id" value="<?= $r['id_sampah'] ?>">
<button name="aksi" value="ubah" class="btn btn-sm btn-primary">Simpan</button>
<button name="aksi" value="hapus" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button></td></form></tr>
<?php endforeach; ?></tbody></table></div></div>
<?php footer_html();
