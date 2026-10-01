<?php
require __DIR__ . '/config/koneksi.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $st = $conn->prepare('SELECT id_user, nama, password, role FROM user WHERE username = ?');
    $st->bind_param('s', $username);
    $st->execute();
    $u = $st->get_result()->fetch_assoc();

    if ($u && password_verify($password, $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['id_user'] = (int)$u['id_user'];
        $_SESSION['nama']    = $u['nama'];
        $_SESSION['role']    = $u['role'];
        if ($u['role'] === 'pengepul') { // hubungkan ke tabel pengepul via username
            $p = $conn->prepare('SELECT id_pengepul FROM pengepul WHERE username = ?');
            $p->bind_param('s', $username); $p->execute();
            $_SESSION['id_pengepul'] = (int)($p->get_result()->fetch_assoc()['id_pengepul'] ?? 0);
        }
        header('Location: ' . BASE_URL . '/index.php'); exit;
    }
    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Bank Sampah</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>body{min-height:100vh;background:linear-gradient(135deg,#14532d,#22c55e);display:flex;align-items:center}</style></head>
<body><div class="container"><div class="row justify-content-center"><div class="col-md-5 col-lg-4">
<div class="card shadow-lg border-0 rounded-4"><div class="card-body p-4">
<h4 class="fw-bold text-center mb-1">♻️ Bank Sampah</h4><p class="text-center text-muted mb-4">Silakan masuk</p>
<?php if ($error): ?><div class="alert alert-danger py-2"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<div class="mb-3"><label class="form-label">Username</label><input name="username" class="form-control" required autofocus></div>
<div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
<button class="btn btn-success w-100">Masuk</button></form></div></div></div></div></div></body></html>
