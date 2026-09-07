<?php
require('../fpdf/fpdf.php');
include('../config/koneksi.php');

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'LAPORAN DATA SISWA', 0, 1, 'C');

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, 'Sistem Informasi Sekolah', 0, 1, 'C');
$pdf->Cell(0, 7, 'Tanggal Cetak : ' . date('d-m-Y'), 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(10,8,'No',1,0,'C');
$pdf->Cell(25,8,'NIS',1,0,'C');
$pdf->Cell(55,8,'Nama',1,0,'C');
$pdf->Cell(25,8,'JK',1,0,'C'); 
$pdf->Cell(30,8,'Kelas',1,0,'C');
$pdf->Cell(95,8,'Alamat',1,0,'C');
$pdf->Cell(35,8,'No HP',1,1,'C');


$pdf->SetFont('Arial','',10);

$query = mysqli_query($conn,"SELECT * FROM siswa ORDER BY nama ASC");

$no = 1;

while($row = mysqli_fetch_assoc($query)){

    $pdf->Cell(10,8,$no++,1,0,'C');
    $pdf->Cell(25,8,$row['nis'],1,0);
    $pdf->Cell(55,8,$row['nama'],1,0);
    $pdf->Cell(25,8,$row['jenis_kelamin'],1,0,'C');
    $pdf->Cell(30,8,$row['kelas'],1,0,'C');
    $pdf->Cell(95,8,$row['alamat'],1,0);
    $pdf->Cell(35,8,$row['no_hp'],1,1);
}

$pdf->Ln(10);

$pdf->Cell(220);
$pdf->Cell(60,6,'Mengetahui,',0,1,'C');

$pdf->Cell(220);
$pdf->Cell(60,6,'Kepala Sekolah',0,1,'C');

$pdf->Ln(20);

$pdf->Cell(220);
$pdf->Cell(60,6,'_____________________',0,1,'C');

$pdf->Output('I','Laporan_Data_Siswa.pdf');
?>