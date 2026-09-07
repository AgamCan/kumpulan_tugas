<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";
include "../includes/header.php";
include "../includes/navbar.php";

$query = mysqli_query($conn, "SELECT * FROM mata_pelajaran ORDER BY id_mapel DESC");
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-book-fill"></i> Data Mata Pelajaran
            </h4>
            <a href="tambah.php" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Tambah Data
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped" id="tabel">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mata Pelajaran</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['kode_mapel']; ?></td>
                            <td><?= $row['nama_mapel']; ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id_mapel']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="hapus.php?id=<?= $row['id_mapel']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash"></i>
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