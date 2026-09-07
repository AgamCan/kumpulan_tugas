<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM nilai WHERE id_nilai='$id'"));

$siswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama ASC");
$mapel = mysqli_query($conn, "SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");

if (isset($_POST['update'])) {

    $id_siswa = $_POST['id_siswa'];
    $id_mapel = $_POST['id_mapel'];
    $semester = $_POST['semester'];
    $tahun = $_POST['tahun_ajaran'];

    $tugas = $_POST['nilai_tugas'];
    $uts = $_POST['nilai_uts'];
    $uas = $_POST['nilai_uas'];

    $akhir = ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);

    mysqli_query($conn, "UPDATE nilai SET

        id_siswa='$id_siswa',
        id_mapel='$id_mapel',
        semester='$semester',
        tahun_ajaran='$tahun',
        nilai_tugas='$tugas',
        nilai_uts='$uts',
        nilai_uas='$uas',
        nilai_akhir='$akhir'

        WHERE id_nilai='$id'
    ");

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

        <div class="card-header bg-warning text-dark">
            <h4>Edit Data Nilai</h4>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label>Siswa</label>

                    <select name="id_siswa" class="form-select">

                        <?php while($s = mysqli_fetch_assoc($siswa)): ?>

                        <option value="<?= $s['id_siswa']; ?>"
                        <?= ($data['id_siswa'] == $s['id_siswa']) ? "selected" : ""; ?>>

                            <?= $s['nis']; ?> - <?= $s['nama']; ?>

                        </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label>Mata Pelajaran</label>

                    <select name="id_mapel" class="form-select">

                        <?php while($m = mysqli_fetch_assoc($mapel)): ?>

                        <option value="<?= $m['id_mapel']; ?>"
                        <?= ($data['id_mapel'] == $m['id_mapel']) ? "selected" : ""; ?>>

                            <?= $m['nama_mapel']; ?>

                        </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label>Semester</label>

                    <select name="semester" class="form-select">

                        <option value="Ganjil"
                        <?= ($data['semester'] == "Ganjil") ? "selected" : ""; ?>>
                            Ganjil
                        </option>

                        <option value="Genap"
                        <?= ($data['semester'] == "Genap") ? "selected" : ""; ?>>
                            Genap
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label>Tahun Ajaran</label>

                    <input
                        type="text"
                        name="tahun_ajaran"
                        class="form-control"
                        value="<?= $data['tahun_ajaran']; ?>"
                        required>

                </div>

                <div class="row">

                    <div class="col-md-4">

                        <label>Nilai Tugas</label>

                        <input
                            type="number"
                            name="nilai_tugas"
                            class="form-control"
                            value="<?= $data['nilai_tugas']; ?>"
                            required>

                    </div>

                    <div class="col-md-4">

                        <label>Nilai UTS</label>

                        <input
                            type="number"
                            name="nilai_uts"
                            class="form-control"
                            value="<?= $data['nilai_uts']; ?>"
                            required>

                    </div>

                    <div class="col-md-4">

                        <label>Nilai UAS</label>

                        <input
                            type="number"
                            name="nilai_uas"
                            class="form-control"
                            value="<?= $data['nilai_uas']; ?>"
                            required>

                    </div>

                </div>

                <br>

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