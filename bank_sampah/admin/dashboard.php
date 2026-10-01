<?php
require __DIR__ . '/../config/koneksi.php';
require __DIR__ . '/../config/layout.php';
wajib_role('admin');

$periode = $_GET['periode'] ?? 'harian';
if (!in_array($periode, ['harian','bulanan','tahunan'], true)) $periode = 'harian';

// Query data grafik sesuai periode (hanya transaksi disetujui)
if ($periode === 'harian') {        // 30 hari terakhir
    $sql = "SELECT tanggal AS label, tipe, SUM(total_rp) total FROM transaksi
            WHERE status='disetujui' AND tanggal >= CURDATE() - INTERVAL 29 DAY GROUP BY tanggal, tipe ORDER BY tanggal";
} elseif ($periode === 'bulanan') { // 12 bulan terakhir
    $sql = "SELECT DATE_FORMAT(tanggal,'%Y-%m') AS label, tipe, SUM(total_rp) total FROM transaksi
            WHERE status='disetujui' AND tanggal >= DATE_FORMAT(CURDATE() - INTERVAL 11 MONTH,'%Y-%m-01')
            GROUP BY label, tipe ORDER BY label";
} else {                            // per tahun
    $sql = "SELECT YEAR(tanggal) AS label, tipe, SUM(total_rp) total FROM transaksi
            WHERE status='disetujui' GROUP BY label, tipe ORDER BY label";
}
$labels = []; $setor = []; $jual = [];
foreach ($conn->query($sql) as $r) {
    $l = (string)$r['label']; $labels[$l] = true;
    if ($r['tipe'] === 'setor') $setor[$l] = (float)$r['total'];
    if ($r['tipe'] === 'jual')  $jual[$l]  = (float)$r['total'];
}
$labels = array_keys($labels);
$dSetor = array_map(fn($l) => $setor[$l] ?? 0, $labels);
$dJual  = array_map(fn($l) => $jual[$l] ?? 0, $labels);

$stat = [
  'Saldo Admin' => rp($conn->query("SELECT saldo FROM user WHERE id_user={$_SESSION['id_user']}")->fetch_assoc()['saldo']),
  'Stok Total (kg)' => number_format($conn->query('SELECT COALESCE(SUM(stok_kg),0) v FROM sampah')->fetch_assoc()['v'], 1, ',', '.'),
  'Menunggu Persetujuan' => $conn->query("SELECT COUNT(*) v FROM transaksi WHERE tipe IN ('setor','tarik') AND status='menunggu'")->fetch_assoc()['v'],
  'Jumlah Nasabah' => $conn->query("SELECT COUNT(*) v FROM user WHERE role='nasabah'")->fetch_assoc()['v'],
];
header_html('Dashboard Admin', menu_admin());
?>
<div class="row g-3 mb-4">
<?php foreach ($stat as $k => $v): ?>
<div class="col-md-6 col-lg-3"><div class="card p-3"><div class="text-muted"><?= e($k) ?></div><div class="stat"><?= e($v) ?></div></div></div>
<?php endforeach; ?></div>

<div class="card p-4"><div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
<h5 class="mb-0">Grafik Transaksi</h5>
<form method="get"><select name="periode" class="form-select form-select-sm" onchange="this.form.submit()">
<option value="harian" <?= $periode==='harian'?'selected':'' ?>>Harian (30 hari)</option>
<option value="bulanan" <?= $periode==='bulanan'?'selected':'' ?>>Bulanan (12 bulan)</option>
<option value="tahunan" <?= $periode==='tahunan'?'selected':'' ?>>Tahunan</option></select></form></div>
<canvas id="grafik" height="110"></canvas></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('grafik'), {
  type: 'bar',
  data: { labels: <?= json_encode($labels) ?>, datasets: [
    { label: 'Setoran Nasabah (Rp)', data: <?= json_encode($dSetor) ?>, backgroundColor: '#22c55e' },
    { label: 'Penjualan ke Pengepul (Rp)', data: <?= json_encode($dJual) ?>, backgroundColor: '#0ea5e9' } ] },
  options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } } }
});
</script>
<?php footer_html();
