<?php
// Koneksi MySQL (mysqli) + helper umum
if (session_status() === PHP_SESSION_NONE) session_start();

// Path dasar otomatis (mis. /banksampah bila disimpan di htdocs/banksampah)
$root = str_replace('\\', '/', realpath(__DIR__ . '/..'));
$docroot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
define('BASE_URL', rtrim(str_replace($docroot, '', $root), '/'));

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'banksampah_agam';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Koneksi database gagal: ' . htmlspecialchars($e->getMessage()));
}

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rp($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }

// Batasi akses halaman berdasarkan role
function wajib_role($role) {
    if (empty($_SESSION['id_user']) || $_SESSION['role'] !== $role) {
        header('Location: ' . BASE_URL . '/login.php'); exit;
    }
}
