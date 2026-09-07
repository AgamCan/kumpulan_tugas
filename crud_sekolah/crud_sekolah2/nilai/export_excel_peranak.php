<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: /crud_sekolah2/auth/login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Nilai_Siswa.xls");

$siswa = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT *
FROM siswa
WHERE id_siswa='$id'
"));

?>

<h2 align="center">LAPORAN NILAI SISWA</h2>

<table border="0">

<tr>
<td><b>Nama</b></td>
<td>:</td>
<td><?= $siswa['nama']; ?></td>
</tr>

<tr>
<td><b>NIS</b></td>
<td>:</td>
<td><?= $siswa['nis']; ?></td>
</tr>

<tr>
<td><b>Kelas</b></td>
<td>:</td>
<td><?= $siswa['kelas']; ?></td>
</tr>

</table>

<br>

<table border="1">

<tr>

<th>No</th>
<th>Mata Pelajaran</th>
<th>Tugas</th>
<th>UTS</th>
<th>UAS</th>
<th>Nilai Akhir</th>
<th>Semester</th>
<th>Tahun Ajaran</th>

</tr>

<?php

$data = mysqli_query($conn,"
SELECT
nilai.*,
mata_pelajaran.nama_mapel
FROM nilai
JOIN mata_pelajaran
ON nilai.id_mapel=mata_pelajaran.id_mapel

WHERE nilai.id_siswa='$id'
ORDER BY mata_pelajaran.nama_mapel
");

$no=1;

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $d['nama_mapel']; ?></td>

<td><?= $d['nilai_tugas']; ?></td>

<td><?= $d['nilai_uts']; ?></td>

<td><?= $d['nilai_uas']; ?></td>

<td><?= $d['nilai_akhir']; ?></td>

<td><?= $d['semester']; ?></td>

<td><?= $d['tahun_ajaran']; ?></td>

</tr>

<?php } ?>

</table>