<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

if (isset($_POST['simpan'])) {

    $nis    = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $jk     = $_POST['jenis_kelamin'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $kelas  = mysqli_real_escape_string($conn, $_POST['kelas']);
    $tgl    = $_POST['tanggal_lahir'];

    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
        alert('NIS sudah digunakan!');
        window.location='tambah.php';
        </script>";
        exit;
    }

    $query = mysqli_query($conn,"INSERT INTO siswa
    (nis,nama,jenis_kelamin,alamat,no_hp,kelas,tanggal_lahir)
    VALUES
    ('$nis','$nama','$jk','$alamat','$no_hp','$kelas','$tgl')");

    if(!$query){
        die("Error : ".mysqli_error($conn));
    }

    if ($query) {
        echo "<script>
        alert('Data berhasil ditambahkan');
        window.location='index.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal menambahkan data');
        </script>";
    }
}
?>

<?php include "../includes/header.php"; ?>
<?php include "../includes/navbar.php"; ?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            Tambah Data Siswa
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control">
                </div>

                <button class="btn btn-success" name="simpan">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>