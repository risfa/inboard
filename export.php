<?php
include ('Db/db_con.php');
$bulan = str_replace("_", " ", $_GET['bulan']);
$date = date('m-Y', strtotime($bulan));
// echo $date;
$stmt=$db_con->prepare("SELECT tb_karyawan.nama_lengkap,tb_jabatan.nama_jabatan,tb_department.nama_department, tb_permohonan_lembur.NamaProject,tb_permohonan_lembur.DeskripsiPengerjaan,tb_permohonan_lembur.TanggalLembur,tb_permohonan_lembur.WaktuMulaiKerja,tb_permohonan_lembur.WaktuSelesaiKerja,tb_permohonan_lembur.Penggantian_Lembur FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan JOIN tb_department ON tb_karyawan.departement = tb_department.ID JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan WHERE tb_permohonan_lembur.TanggalLembur LIKE '%-$date%'");
$stmt->execute();

$columnHeader ='';
$columnHeader = "Nama"."\t"."Jabatan"."\t"."Departemen"."\t"."Nama Project"."\t"."Deskripsi Pengerjaan"."\t"."Tanggal Lembur"."\t"."Waktu Mulai Kerja"."\t"."Waktu Selesai Kerja"."\t"."Penggantian Lembur"."\t" . "\n"."\n";


$setData='';

while($rec =$stmt->FETCH(PDO::FETCH_ASSOC))
{
  $rowData = '';
  foreach($rec as $value)
  {
    $value = '"' . $value . '"' . "\t";
    $rowData .= $value;
  }
  $setData .= trim($rowData)."\n";
}


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap Lembur Karyawan.xls");
header("Pragma: no-cache");
header("Expires: 0");

// echo ucwords($columnHeader)."\n".$setData."\n";
echo ucwords($columnHeader);
echo $setData;

?>
