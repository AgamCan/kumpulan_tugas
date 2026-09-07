<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM mata_pelajaran WHERE id_mapel='$id'");

echo "<script>

alert('Data berhasil dihapus');

window.location='index.php';

</script>";