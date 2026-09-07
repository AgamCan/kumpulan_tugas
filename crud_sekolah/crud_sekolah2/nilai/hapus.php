<?php

session_start();

include "../config/koneksi.php";

$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM nilai WHERE id_nilai='$id'");

echo "<script>

alert('Data berhasil dihapus');

window.location='index.php';

</script>";