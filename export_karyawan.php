<?php
include ('Db/db_con.php');
// // Fungsi header dengan mengirimkan raw data excel
// header("Content-type: application/vnd-ms-excel");
 
// // Mendefinisikan nama file ekspor "hasil-export.xls"
// header("Content-Disposition: attachment; filename=tutorialweb-export.xls");
 
// // Tambahkan table
// include 'list_baru_data_karyawan.php';

$stmt=$db_con->prepare("SELECT tb_karyawan.NIP, tb_karyawan.nama_lengkap, tb_karyawan.jenis_kelamin, tb_karyawan.tgl_lahir, tb_karyawan.agama, tb_karyawan.pendidikan, tb_karyawan.no_ktp, tb_karyawan.no_npwp, tb_karyawan.perusahaan, tb_department.nama_department, tb_jabatan.nama_jabatan, tb_karyawan.mulai_bekerja, tb_karyawan.alamat, tb_karyawan.no_telp, tb_login.email, tb_bank.bank, tb_bank.nama_pemilik_bank, tb_bank.no_rek  FROM tb_karyawan JOIN tb_bank ON tb_karyawan.ID_karyawan = tb_bank.ID_karyawan JOIN tb_login ON tb_karyawan.ID_karyawan = tb_login.ID_karyawan JOIN tb_department ON tb_karyawan.departement= tb_department.ID JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID ORDER BY tb_karyawan.ID_karyawan ASC");
$stmt->execute();

$columnHeader ='';
$columnHeader = "NIP"."\t"."NAMA"."\t"."JENIS KELAMIN"."\t"."TANGGAL LAHIR"."\t"."AGAMA"."\t"."PENDIDIKAN TERAKHIR"."\t"."KTP"."\t"."NPWP"."\t"."PERUSAHAAN"."\t" ."DEPARTEMEN"."\t" ."JABATAN"."\t" ."MULAI BEKERJA"."\t" ."ALAMAT"."\t" ."TELEPON"."\t" ."EMAIL"."\t" ."BANK"."\t" ."NAMA PEMILIK BANK"."\t" ."REKENING"."\t" . "\n"."\n";


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


// header("Content-type: application/octet-stream");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Data Karyawan.xls");
header("Pragma: no-cache");
header("Expires: 0");

// echo ucwords($columnHeader)."\n".$setData."\n";
echo ucwords($columnHeader);
echo $setData;
?>
