<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mata_pelajaran WHERE id_mapel='$id'"));

if (isset($_POST['update'])) {
    $kode = $_POST['kode_mapel'];
    $nama = $_POST['nama_mapel'];

    mysqli_query($conn, "UPDATE mata_pelajaran SET
        kode_mapel='$kode',
        nama_mapel='$nama'
        WHERE id_mapel='$id'");

    echo "<script>
    alert('Data berhasil diubah');
    window.location='index.php';
    </script>";
}

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-warning">
            Edit Mata Pelajaran
        </div>

        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>Kode Mata Pelajaran</label>
                    <input type="text" name="kode_mapel" class="form-control" value="<?= $data['kode_mapel']; ?>" required>
                </div>

                <div class="mb-3">
                    <label>Nama Mata Pelajaran</label>
                    <input type="text" name="nama_mapel" class="form-control" value="<?= $data['nama_mapel']; ?>" required>
                </div>

                <button class="btn btn-warning" name="update">
                    Update
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>