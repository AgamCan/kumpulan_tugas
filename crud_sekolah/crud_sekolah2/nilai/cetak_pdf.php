<?php

require('../fpdf/fpdf.php');
include('../config/koneksi.php');

$id = $_GET['id'];

$siswa = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT *
    FROM siswa
    WHERE id_siswa='$id'
"));

$pdf = new FPDF();

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,'LAPORAN NILAI SISWA',0,1,'C');

$pdf->SetFont('Arial','',11);

$pdf->Cell(35,8,'Nama');
$pdf->Cell(5,8,':');
$pdf->Cell(70,8,$siswa['nama']);
$pdf->Ln();

$pdf->Cell(35,8,'NIS');
$pdf->Cell(5,8,':');
$pdf->Cell(70,8,$siswa['nis']);
$pdf->Ln();

$pdf->Cell(35,8,'Kelas');
$pdf->Cell(5,8,':');
$pdf->Cell(70,8,$siswa['kelas']);
$pdf->Ln();

$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(10,8,'No',1);
$pdf->Cell(55,8,'Mata Pelajaran',1);
$pdf->Cell(20,8,'Tugas',1);
$pdf->Cell(20,8,'UTS',1);
$pdf->Cell(20,8,'UAS',1);
$pdf->Cell(25,8,'Akhir',1);
$pdf->Cell(40,8,'Semester',1);

$pdf->Ln();

$data = mysqli_query($conn,"
SELECT
nilai.*,
mata_pelajaran.nama_mapel
FROM nilai
JOIN mata_pelajaran
ON nilai.id_mapel=mata_pelajaran.id_mapel
WHERE nilai.id_siswa='$id'
");

$pdf->SetFont('Arial','',10);

$no=1;

while($d=mysqli_fetch_assoc($data)){

$pdf->Cell(10,8,$no++,1);
$pdf->Cell(55,8,$d['nama_mapel'],1);
$pdf->Cell(20,8,$d['nilai_tugas'],1);
$pdf->Cell(20,8,$d['nilai_uts'],1);
$pdf->Cell(20,8,$d['nilai_uas'],1);
$pdf->Cell(25,8,$d['nilai_akhir'],1);
$pdf->Cell(40,8,$d['semester'],1);

$pdf->Ln();

}

$pdf->Ln(15);

$pdf->Cell(120);

$pdf->Cell(60,8,'Mengetahui',0,1,'C');

$pdf->Cell(120);

$pdf->Cell(60,8,'Kepala Sekolah',0,1,'C');

$pdf->Ln(20);

$pdf->Cell(120);

$pdf->Cell(60,8,'__________________',0,1,'C');

$pdf->Output();

?>