<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";
include "../includes/header.php";
include "../includes/navbar.php";

$query = mysqli_query($conn, "SELECT * FROM siswa ORDER BY id_siswa DESC");

if(!$query){
    die("Query Error : ".mysqli_error($conn));
}
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                <i class="bi bi-people-fill"></i>
                Data Siswa
            </h4>

            <div>

                <a href="tambah.php" class="btn btn-light">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Data
                </a>

                <a href="cetak_pdf.php" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Export PDF
                </a>

            </div>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped" id="tabel">

                <thead class="table-dark">

                    <tr>

                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th width="150">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($row = mysqli_fetch_assoc($query)){
                ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= htmlspecialchars($row['nis']); ?></td>

                    <td><?= htmlspecialchars($row['nama']); ?></td>

                    <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>

                    <td><?= htmlspecialchars($row['kelas']); ?></td>

                    <td><?= htmlspecialchars($row['alamat']); ?></td>

                    <td><?= htmlspecialchars($row['no_hp']); ?></td>

                    <td>

                        <a href="edit.php?id=<?= $row['id_siswa']; ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <a href="hapus.php?id=<?= $row['id_siswa']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin ingin menghapus data ini?')">

                            <i class="bi bi-trash"></i>

                        </a>

                    </td>

                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>