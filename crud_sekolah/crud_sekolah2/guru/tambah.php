<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $id_mapel = $_POST['id_mapel'];

    mysqli_query($conn, "INSERT INTO guru
    (nip, nama, jenis_kelamin, alamat, no_hp, id_mapel)
    VALUES
    ('$nip', '$nama', '$jk', '$alamat', '$no_hp', '$id_mapel')");

    header("Location: index.php");
}

$mapel = mysqli_query($conn, "SELECT * FROM mata_pelajaran");

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            Tambah Guru
        </div>

        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>NIP</label>
                    <input class="form-control" name="nip" required>
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input class="form-control" name="nama" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat"></textarea>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input class="form-control" name="no_hp">
                </div>

                <div class="mb-3">
                    <label>Mata Pelajaran</label>
                    <select class="form-select" name="id_mapel">
                        <?php while ($m = mysqli_fetch_assoc($mapel)) : ?>
                            <option value="<?= $m['id_mapel']; ?>">
                                <?= $m['nama_mapel']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
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