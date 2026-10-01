<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/layout.php';
wajib_role('admin');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id']; $aksi = $_POST['aksi'];
    $conn->begin_transaction();
    $st = $conn->prepare("SELECT * FROM transaksi WHERE id_transaksi=? AND tipe IN ('setor','tarik') AND status='menunggu' FOR UPDATE");
    $st->bind_param('i', $id); $st->execute();
    if ($t = $st->get_result()->fetch_assoc()) {
        if ($aksi !== 'setuju') {
            $conn->query("UPDATE transaksi SET status='ditolak' WHERE id_transaksi=$id");
            flash('Transaksi #' . $id . ' ditolak.');
        } elseif ($t['tipe'] === 'setor') {
            $adm = (float)$conn->query("SELECT saldo FROM user WHERE id_user={$_SESSION['id_user']} FOR UPDATE")->fetch_assoc()['saldo'];
            if ($adm < $t['total_rp']) {
                flash('Saldo admin (' . rp($adm) . ') tidak cukup untuk setoran #' . $id . ' sebesar ' . rp($t['total_rp']) . '. Tunggu top up pengepul.');
            } else {
                $conn->query("UPDATE user SET saldo = saldo - {$t['total_rp']} WHERE id_user = {$_SESSION['id_user']}"); // admin berkurang
                $conn->query("UPDATE user SET saldo = saldo + {$t['total_rp']} WHERE id_user = {$t['id_user']}");       // nasabah bertambah
                $conn->query("UPDATE sampah SET stok_kg = stok_kg + {$t['berat_kg']} WHERE id_sampah = {$t['id_sampah']}");
                $conn->query("UPDATE transaksi SET status='disetujui' WHERE id_transaksi=$id");
                flash('Setoran #' . $id . ' disetujui: ' . rp($t['total_rp']) . ' dipindahkan dari saldo admin ke saldo nasabah.');
            }
        } else { // tarik saldo
            $sd = (float)$conn->query("SELECT saldo FROM user WHERE id_user={$t['id_user']} FOR UPDATE")->fetch_assoc()['saldo'];
            if ($sd < $t['total_rp']) {
                flash('Saldo nasabah tidak cukup untuk penarikan #' . $id . '. Tolak transaksi ini.');
            } else {
                $conn->query("UPDATE user SET saldo = saldo - {$t['total_rp']} WHERE id_user = {$t['id_user']}");
                $conn->query("UPDATE transaksi SET status='disetujui' WHERE id_transaksi=$id");
                flash('Penarikan #' . $id . ' disetujui, serahkan uang ' . rp($t['total_rp']) . ' ke nasabah.');
            }
        }
    }
    $conn->commit();
    header('Location: transaksi.php'); exit;
}
$rows = $conn->query("SELECT t.*, u.nama, s.jenis_sampah FROM transaksi t JOIN user u USING(id_user) JOIN sampah s USING(id_sampah)
                      WHERE t.tipe IN ('setor','tarik') ORDER BY FIELD(t.status,'menunggu','disetujui','ditolak'), t.id_transaksi DESC");
$saldoAdmin = $conn->query("SELECT saldo FROM user WHERE id_user={$_SESSION['id_user']}")->fetch_assoc()['saldo'];
header_html('Transaksi Setoran', menu_admin()); ?>
<div class="card p-3 mb-3 bg-success text-white"><div>Saldo Admin</div><div class="stat"><?= rp($saldoAdmin) ?></div></div>
<div class="card p-4"><h5>Setoran & Penarikan Nasabah</h5><div class="table-responsive"><table class="table align-middle">
<thead><tr><th>#</th><th>Tanggal</th><th>Nasabah</th><th>Jenis</th><th>Sampah</th><th>Berat</th><th>Total</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach ($rows as $r): $b = ['menunggu'=>'warning','disetujui'=>'success','ditolak'=>'danger'][$r['status']]; ?>
<tr><td><?= $r['id_transaksi'] ?></td><td><?= e($r['tanggal']) ?></td><td><?= e($r['nama']) ?></td><td><span class="badge text-bg-<?= $r['tipe']==='tarik'?'warning':'info' ?>"><?= $r['tipe']==='tarik'?'Tarik':'Setor' ?></span></td>
<?php if ($r['tipe']==='tarik'): ?><td>-</td><td>-</td><?php else: ?><td><?= e($r['jenis_sampah']) ?></td><td><?= e($r['berat_kg']) ?> kg</td><?php endif; ?><td><?= rp($r['total_rp']) ?></td><td><span class="badge text-bg-<?= $b ?>"><?= e($r['status']) ?></span></td>
<td class="text-end"><?php if ($r['status']==='menunggu'): ?><form method="post" class="d-inline"><input type="hidden" name="id" value="<?= $r['id_transaksi'] ?>">
<button name="aksi" value="setuju" class="btn btn-sm btn-success">Setujui</button>
<button name="aksi" value="tolak" class="btn btn-sm btn-outline-danger">Tolak</button></form><?php endif; ?></td></tr>
<?php endforeach; ?></tbody></table></div></div>
<?php footer_html();
