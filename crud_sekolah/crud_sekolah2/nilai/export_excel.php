<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Nilai.xls");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export Excel Nilai</title>
</head>
<body>

<h2 align="center">LAPORAN DATA NILAI SISWA</h2>

<table border="1">

    <tr style="font-weight:bold; text-align:center;">
        <th>No</th>
        <th>NIS</th>
        <th>Nama Siswa</th>
        <th>Mata Pelajaran</th>
        <th>Semester</th>
        <th>Tahun Ajaran</th>
        <th>Nilai Tugas</th>
        <th>Nilai UTS</th>
        <th>Nilai UAS</th>
        <th>Nilai Akhir</th>
    </tr>

<?php

$query = mysqli_query($conn,"
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
ORDER BY siswa.nama ASC
");

$no = 1;

while($row = mysqli_fetch_assoc($query)){
?>

<tr>

<td align="center"><?= $no++; ?></td>

<td><?= $row['nis']; ?></td>

<td><?= $row['nama']; ?></td>

<td><?= $row['nama_mapel']; ?></td>

<td><?= $row['semester']; ?></td>

<td><?= $row['tahun_ajaran']; ?></td>

<td align="center"><?= $row['nilai_tugas']; ?></td>

<td align="center"><?= $row['nilai_uts']; ?></td>

<td align="center"><?= $row['nilai_uas']; ?></td>

<td align="center"><?= $row['nilai_akhir']; ?></td>

</tr>

<?php } ?>

</table>

</body>
</html>