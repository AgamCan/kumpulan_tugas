<?php

    session_start();

    include "../config/koneksi.php";

    $id=$_GET['id'];

    mysqli_query($conn,"DELETE FROM siswa WHERE id_siswa='$id'");

    echo "<script>

    alert('Data berhasil dihapus');

    window.location='index.php';

</script>";