<?php
require __DIR__ . '/config/koneksi.php';
$home = ['admin'=>BASE_URL . '/admin/dashboard.php','nasabah'=>BASE_URL . '/nasabah/dashboard.php','pengepul'=>BASE_URL . '/pengepul/dashboard.php'];
header('Location: ' . (isset($_SESSION['role']) ? $home[$_SESSION['role']] : BASE_URL . '/login.php'));
