<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";
include "../includes/header.php";
include "../includes/navbar.php";


$query = mysqli_query($conn, "
SELECT
    nilai.*,
    siswa.nis,
    siswa.nama,
    mata_pelajaran.nama_mapel
FROM nilai
INNER JOIN siswa
    ON nilai.id_siswa = siswa.id_siswa
INNER JOIN mata_pelajaran
    ON nilai.id_mapel = mata_pelajaran.id_mapel
ORDER BY nilai.id_nilai DESC
");

if (!$query) {
    die("Query Error : " . mysqli_error($conn));
}
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                <i class="bi bi-clipboard-data"></i>
                Data Nilai
            </h4>

            <a href="tambah.php" class="btn btn-light">
                <i class="bi bi-plus-circle"></i>
                Tambah Data
            </a>

            <a href="export_excel.php" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i>
                Export Excel
            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped" id="tabel">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Mata Pelajaran</th>
                        <th>Semester</th>
                        <th>Tahun Ajaran</th>
                        <th>Tugas</th>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>Nilai Akhir</th>
                        <th width="180">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;
                while($row = mysqli_fetch_assoc($query)):
                ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= htmlspecialchars($row['nis']); ?></td>

                    <td><?= htmlspecialchars($row['nama']); ?></td>

                    <td><?= htmlspecialchars($row['nama_mapel']); ?></td>

                    <td><?= htmlspecialchars($row['semester']); ?></td>

                    <td><?= htmlspecialchars($row['tahun_ajaran']); ?></td>

                    <td><?= $row['nilai_tugas']; ?></td>

                    <td><?= $row['nilai_uts']; ?></td>

                    <td><?= $row['nilai_uas']; ?></td>

                    <td><?= number_format($row['nilai_akhir'],2); ?></td>

                    <td>

                        <a href="edit.php?id=<?= $row['id_nilai']; ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <a href="hapus.php?id=<?= $row['id_nilai']; ?>" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>

                        <a href="cetak_pdf.php?id=<?= $row['id_siswa']; ?>" class="btn btn-danger btn-sm" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </a>

                        <a href="export_excel_peranak.php?id=<?= $row['id_siswa']; ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i>
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>