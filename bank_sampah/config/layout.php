<?php
function header_html($judul, $menu = []) { ?>
<!DOCTYPE html>
<html lang="id"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($judul) ?> - Bank Sampah</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>body{background:#f2f7f3}.navbar{background:linear-gradient(90deg,#14532d,#16a34a)}
.card{border:0;border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,.06)}.stat{font-size:1.6rem;font-weight:700}</style>
</head><body>
<nav class="navbar navbar-expand-md navbar-dark mb-4"><div class="container">
<a class="navbar-brand fw-bold" href="#">♻️ Bank Sampah</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nv"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nv"><ul class="navbar-nav me-auto">
<?php foreach ($menu as $url => $label): ?><li class="nav-item"><a class="nav-link" href="<?= e($url) ?>"><?= e($label) ?></a></li><?php endforeach; ?>
</ul><span class="navbar-text me-3"><?= e($_SESSION['nama'] ?? '') ?></span>
<a class="btn btn-sm btn-light" href="<?= BASE_URL ?>/logout.php">Keluar</a></div></div></nav>
<div class="container pb-5">
<?php if (!empty($_SESSION['flash'])): ?><div class="alert alert-info"><?= e($_SESSION['flash']) ?></div><?php unset($_SESSION['flash']); endif;
}
function footer_html() { ?>
</div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html>
<?php }
function menu_admin() { return [BASE_URL . '/admin/dashboard.php'=>'Dashboard',BASE_URL . '/admin/sampah.php'=>'Jenis & Stok Sampah',BASE_URL . '/admin/transaksi.php'=>'Setoran & Penarikan']; }
function flash($m) { $_SESSION['flash'] = $m; }
