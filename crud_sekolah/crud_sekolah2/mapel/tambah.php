<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_mapel'];
    $nama = $_POST['nama_mapel'];

    mysqli_query($conn, "INSERT INTO mata_pelajaran(kode_mapel, nama_mapel)
    VALUES('$kode', '$nama')");

    echo "<script>
    alert('Data berhasil ditambahkan');
    window.location='index.php';
    </script>";
}

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            Tambah Mata Pelajaran
        </div>

        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>Kode Mata Pelajaran</label>
                    <input type="text" name="kode_mapel" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Mata Pelajaran</label>
                    <input type="text" name="nama_mapel" class="form-control" required>
                </div>

                <button class="btn btn-success" name="simpan">
                    Simpan
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>