<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM guru WHERE id_guru='$id'");
$data = mysqli_fetch_assoc($query);

$mapel = mysqli_query($conn, "SELECT * FROM mata_pelajaran");

if (isset($_POST['update'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $id_mapel = $_POST['id_mapel'];

    $update = mysqli_query($conn, "UPDATE guru SET
        nip='$nip',
        nama='$nama',
        jenis_kelamin='$jk',
        alamat='$alamat',
        no_hp='$no_hp',
        id_mapel='$id_mapel'
        WHERE id_guru='$id'
    ");

    if ($update) {
        echo "<script>
        alert('Data Guru Berhasil Diubah');
        window.location='index.php';
        </script>";
    } else {
        echo "<script>
        alert('Data Gagal Diubah');
        </script>";
    }
}

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4>Edit Data Guru</h4>
        </div>

        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" value="<?= $data['nip']; ?>" required>
                </div>

                <div class="mb-3">
                    <label>Nama Guru</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L" <?= ($data['jenis_kelamin'] == "L") ? "selected" : ""; ?>>
                            Laki-laki
                        </option>
                        <option value="P" <?= ($data['jenis_kelamin'] == "P") ? "selected" : ""; ?>>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"><?= $data['alamat']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= $data['no_hp']; ?>">
                </div>

                <div class="mb-3">
                    <label>Mata Pelajaran</label>
                    <select name="id_mapel" class="form-select">
                        <?php while ($m = mysqli_fetch_assoc($mapel)) : ?>
                            <option value="<?= $m['id_mapel']; ?>" <?= ($data['id_mapel'] == $m['id_mapel']) ? "selected" : ""; ?>>
                                <?= $m['nama_mapel']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" name="update" class="btn btn-warning">
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