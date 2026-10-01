<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/layout.php';
wajib_role('nasabah');
$uid = $_SESSION['id_user'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['aksi'] ?? '') === 'tarik') { // ajukan penarikan saldo (menunggu persetujuan admin)
        $n = (float)$_POST['nominal'];
        $sd = (float)$conn->query("SELECT saldo FROM user WHERE id_user=$uid")->fetch_assoc()['saldo'];
        $pend = (float)$conn->query("SELECT COALESCE(SUM(total_rp),0) v FROM transaksi WHERE id_user=$uid AND tipe='tarik' AND status='menunggu'")->fetch_assoc()['v'];
        $idp = (int)$conn->query('SELECT MIN(id_sampah) v FROM sampah')->fetch_assoc()['v']; // kolom id_sampah wajib terisi (FK)
        if ($n <= 0) flash('Nominal tidak valid.');
        elseif ($n > $sd - $pend) flash('Saldo tidak cukup (termasuk penarikan lain yang masih menunggu).');
        elseif (!$idp) flash('Data jenis sampah belum ada, hubungi admin.');
        else {
            $st = $conn->prepare("INSERT INTO transaksi (id_user,id_sampah,tipe,berat_kg,total_rp,status,tanggal) VALUES (?,?,'tarik',0,?,'menunggu',CURDATE())");
            $st->bind_param('iid', $uid, $idp, $n); $st->execute();
            flash('Permintaan tarik saldo ' . rp($n) . ' dikirim, menunggu persetujuan admin.');
        }
        header('Location: dashboard.php'); exit;
    }
    $ids = (int)$_POST['id_sampah']; $berat = (float)$_POST['berat'];
    $s = $conn->prepare('SELECT harga_per_kg FROM sampah WHERE id_sampah=?'); $s->bind_param('i', $ids); $s->execute();
    if (($h = $s->get_result()->fetch_assoc()) && $berat > 0) {
        $total = $berat * $h['harga_per_kg'];
        $st = $conn->prepare("INSERT INTO transaksi (id_user,id_sampah,tipe,berat_kg,total_rp,status,tanggal) VALUES (?,?,'setor',?,?,'menunggu',CURDATE())");
        $st->bind_param('iidd', $uid, $ids, $berat, $total); $st->execute();
        flash('Setoran dikirim, menunggu persetujuan admin.');
    }
    header('Location: dashboard.php'); exit;
}
$saldo = $conn->query("SELECT saldo FROM user WHERE id_user=$uid")->fetch_assoc()['saldo'];
$sampah = $conn->query('SELECT * FROM sampah ORDER BY jenis_sampah');
$riwayat = $conn->query("SELECT t.*, s.jenis_sampah FROM transaksi t JOIN sampah s USING(id_sampah) WHERE t.id_user=$uid ORDER BY t.id_transaksi DESC");
header_html('Dashboard Nasabah', [BASE_URL . '/nasabah/dashboard.php'=>'Dashboard']); ?>
<div class="row g-3"><div class="col-lg-4">
<div class="card p-3 mb-3 bg-success text-white"><div>Saldo Anda</div><div class="stat"><?= rp($saldo) ?></div></div>
<div class="card p-4 mb-3"><h5>Setor Sampah</h5><form method="post">
<div class="mb-2"><label class="form-label">Jenis</label><select name="id_sampah" class="form-select" id="js">
<?php foreach ($sampah as $s): ?><option value="<?= $s['id_sampah'] ?>" data-h="<?= $s['harga_per_kg'] ?>"><?= e($s['jenis_sampah']) ?> (<?= rp($s['harga_per_kg']) ?>/kg)</option><?php endforeach; ?></select></div>
<div class="mb-2"><label class="form-label">Berat (kg)</label><input type="number" step="0.01" min="0.01" name="berat" id="br" class="form-control" required></div>
<div class="mb-3 text-muted">Estimasi: <b id="es">Rp 0</b></div><button class="btn btn-success w-100">Kirim Setoran</button></form></div>
<div class="card p-4"><h5>Tarik Saldo</h5><form method="post"><input type="hidden" name="aksi" value="tarik">
<input type="number" name="nominal" min="1000" step="500" class="form-control mb-2" placeholder="Nominal (Rp)" required>
<button class="btn btn-warning w-100">Ajukan Penarikan</button>
<div class="form-text">Penarikan akan diproses setelah disetujui admin.</div></form></div></div>
<div class="col-lg-8"><div class="card p-4"><h5>Riwayat Transaksi</h5><div class="table-responsive"><table class="table">
<thead><tr><th>Tanggal</th><th>Keterangan</th><th>Berat</th><th>Total</th><th>Status</th></tr></thead><tbody>
<?php foreach ($riwayat as $r): $b = ['menunggu'=>'warning','disetujui'=>'success','ditolak'=>'danger'][$r['status']]; ?>
<tr><td><?= e($r['tanggal']) ?></td><?php if ($r['tipe']==='tarik'): ?><td>Tarik Saldo</td><td>-</td><?php else: ?><td>Setor: <?= e($r['jenis_sampah']) ?></td><td><?= e($r['berat_kg']) ?> kg</td><?php endif; ?><td><?= rp($r['total_rp']) ?></td><td><span class="badge text-bg-<?= $b ?>"><?= e($r['status']) ?></span></td></tr>
<?php endforeach; ?></tbody></table></div></div></div></div>
<script>const js=document.getElementById('js'),br=document.getElementById('br'),es=document.getElementById('es');
function hit(){es.textContent='Rp '+Math.round((br.value||0)*js.selectedOptions[0].dataset.h).toLocaleString('id-ID')}
js.onchange=br.oninput=hit;</script>
<?php footer_html();
