<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/layout.php';
wajib_role('pengepul');
$pid = $_SESSION['id_pengepul']; $uid = $_SESSION['id_user'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['aksi'] ?? '') === 'topup') {
        $n = (float)$_POST['nominal'];
        if ($n > 0) {
            $conn->begin_transaction();
            $st = $conn->prepare('UPDATE pengepul SET saldo_topup = saldo_topup + ? WHERE id_pengepul=?'); // saldo pengepul bertambah
            $st->bind_param('di', $n, $pid); $st->execute();
            $st = $conn->prepare("UPDATE user SET saldo = saldo + ? WHERE role='admin' ORDER BY id_user LIMIT 1"); // uang masuk ke admin
            $st->bind_param('d', $n); $st->execute();
            $conn->commit();
            flash('Top up ' . rp($n) . ' berhasil. Dana diterima oleh admin.');
        }
    } else { // beli sampah dari stok
        $ids = (int)$_POST['id_sampah']; $berat = (float)$_POST['berat'];
        $conn->begin_transaction();
        $s = $conn->query("SELECT harga_per_kg, stok_kg FROM sampah WHERE id_sampah=$ids FOR UPDATE")->fetch_assoc();
        $p = $conn->query("SELECT saldo_topup FROM pengepul WHERE id_pengepul=$pid FOR UPDATE")->fetch_assoc();
        $total = $s ? $berat * $s['harga_per_kg'] : 0;
        if (!$s || $berat <= 0) flash('Data tidak valid.');
        elseif ($berat > $s['stok_kg']) flash('Stok tidak mencukupi.');
        elseif ($total > $p['saldo_topup']) flash('Saldo top up tidak cukup.');
        else {
            $conn->query("UPDATE sampah SET stok_kg = stok_kg - $berat WHERE id_sampah=$ids");
            $conn->query("UPDATE pengepul SET saldo_topup = saldo_topup - $total WHERE id_pengepul=$pid");
            $st = $conn->prepare("INSERT INTO transaksi (id_user,id_sampah,id_pengepul,tipe,berat_kg,total_rp,status,tanggal) VALUES (?,?,?,'jual',?,?,'disetujui',CURDATE())");
            $st->bind_param('iiidd', $uid, $ids, $pid, $berat, $total); $st->execute();
            flash('Pembelian berhasil: ' . rp($total));
        }
        $conn->commit();
    }
    header('Location: dashboard.php'); exit;
}
$saldo = $conn->query("SELECT saldo_topup FROM pengepul WHERE id_pengepul=$pid")->fetch_assoc()['saldo_topup'];
$stok = $conn->query('SELECT * FROM sampah WHERE stok_kg > 0 ORDER BY jenis_sampah');
$riwayat = $conn->query("SELECT t.*, s.jenis_sampah FROM transaksi t JOIN sampah s USING(id_sampah) WHERE t.id_pengepul=$pid ORDER BY t.id_transaksi DESC");
header_html('Dashboard Pengepul', [BASE_URL . '/pengepul/dashboard.php'=>'Dashboard']); ?>
<div class="row g-3"><div class="col-lg-4">
<div class="card p-3 mb-3 bg-success text-white"><div>Saldo Top Up</div><div class="stat"><?= rp($saldo) ?></div></div>
<div class="card p-4 mb-3"><h5>Top Up Saldo</h5><form method="post"><input type="hidden" name="aksi" value="topup">
<input type="number" name="nominal" min="1000" step="1000" class="form-control mb-2" placeholder="Nominal (Rp)" required><button class="btn btn-success w-100">Top Up</button></form></div>
<div class="card p-4"><h5>Beli Sampah</h5><form method="post"><input type="hidden" name="aksi" value="beli">
<select name="id_sampah" class="form-select mb-2"><?php foreach ($stok as $s): ?><option value="<?= $s['id_sampah'] ?>"><?= e($s['jenis_sampah']) ?> — stok <?= e($s['stok_kg']) ?> kg (<?= rp($s['harga_per_kg']) ?>/kg)</option><?php endforeach; ?></select>
<input type="number" step="0.01" min="0.01" name="berat" class="form-control mb-2" placeholder="Berat (kg)" required><button class="btn btn-primary w-100">Beli</button></form></div></div>
<div class="col-lg-8"><div class="card p-4"><h5>Riwayat Pembelian</h5><div class="table-responsive"><table class="table">
<thead><tr><th>Tanggal</th><th>Sampah</th><th>Berat</th><th>Total</th></tr></thead><tbody>
<?php foreach ($riwayat as $r): ?><tr><td><?= e($r['tanggal']) ?></td><td><?= e($r['jenis_sampah']) ?></td><td><?= e($r['berat_kg']) ?> kg</td><td><?= rp($r['total_rp']) ?></td></tr><?php endforeach; ?>
</tbody></table></div></div></div></div>
<?php footer_html();
