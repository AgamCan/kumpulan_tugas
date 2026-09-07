<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

$siswa = mysqli_query($conn, "SELECT * FROM siswa");
$mapel = mysqli_query($conn, "SELECT * FROM mata_pelajaran");

if (isset($_POST['simpan'])) {
    $id_siswa = $_POST['id_siswa'];
    $id_mapel = $_POST['id_mapel'];
    $semester = $_POST['semester'];
    $tahun = $_POST['tahun_ajaran'];

    $tugas = $_POST['nilai_tugas'];
    $uts = $_POST['nilai_uts'];
    $uas = $_POST['nilai_uas'];

    $akhir = ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);

    mysqli_query($conn, "INSERT INTO nilai
    (id_siswa, id_mapel, semester, tahun_ajaran, nilai_tugas, nilai_uts, nilai_uas, nilai_akhir)
    VALUES
    ('$id_siswa', '$id_mapel', '$semester', '$tahun', '$tugas', '$uts', '$uas', '$akhir')
    ");

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
            Tambah Nilai
        </div>

        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>Siswa</label>
                    <select name="id_siswa" class="form-select">
                        <?php while ($s = mysqli_fetch_assoc($siswa)) : ?>
                            <option value="<?= $s['id_siswa']; ?>">
                                <?= $s['nis']; ?> - <?= $s['nama']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Mata Pelajaran</label>
                    <select name="id_mapel" class="form-select">
                        <?php while ($m = mysqli_fetch_assoc($mapel)) : ?>
                            <option value="<?= $m['id_mapel']; ?>">
                                <?= $m['nama_mapel']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Semester</label>
                    <select name="semester" class="form-select">
                        <option>Ganjil</option>
                        <option>Genap</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tahun Ajaran</label>
                    <input class="form-control" name="tahun_ajaran" placeholder="2026/2027">
                </div>

                <div class="row">
                    <div class="col">
                        <label>Nilai Tugas</label>
                        <input type="number" class="form-control" name="nilai_tugas">
                    </div>

                    <div class="col">
                        <label>UTS</label>
                        <input type="number" class="form-control" name="nilai_uts">
                    </div>

                    <div class="col">
                        <label>UAS</label>
                        <input type="number" class="form-control" name="nilai_uas">
                    </div>
                </div>

                <br>

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