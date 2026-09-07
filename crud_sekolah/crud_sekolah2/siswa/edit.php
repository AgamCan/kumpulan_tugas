<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM siswa WHERE id_siswa='$id'");
$row  = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $nis    = $_POST['nis'];
    $nama   = $_POST['nama'];
    $jk     = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_hp  = $_POST['no_hp'];
    $kelas  = $_POST['kelas'];
    $tgl    = $_POST['tanggal_lahir'];

    mysqli_query($conn, "UPDATE siswa SET
        nis='$nis',
        nama='$nama',
        jenis_kelamin='$jk',
        alamat='$alamat',
        no_hp='$no_hp',
        kelas='$kelas',
        tanggal_lahir='$tgl'
        WHERE id_siswa='$id'
    ");

    echo "<script>
        alert('Data berhasil diubah');
        window.location='index.php';
    </script>";
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-warning">
            Edit Data Siswa
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>NIS</label>
                    <input type="text" class="form-control" name="nis" value="<?= $row['nis']; ?>">
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="nama" value="<?= $row['nama']; ?>">
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin">
                        <option value="L" <?= ($row['jenis_kelamin'] == "L") ? "selected" : ""; ?>>Laki-laki</option>
                        <option value="P" <?= ($row['jenis_kelamin'] == "P") ? "selected" : ""; ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat"><?= $row['alamat']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input class="form-control" name="no_hp" value="<?= $row['no_hp']; ?>">
                </div>

                <div class="mb-3">
                    <label>Kelas</label>
                    <input class="form-control" name="kelas" value="<?= $row['kelas']; ?>">
                </div>

                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" value="<?= $row['tanggal_lahir']; ?>">
                </div>

                <button class="btn btn-warning" name="update">Update</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>