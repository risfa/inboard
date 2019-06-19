<?php
include('connect.php');

if (isset($_POST['param']) == 'total_notifikasi') {

  // echo $_POST['ID_notifikasi'];
  $queryTotalNotifikasi = mysql_query("SELECT COUNT(id_notifikasi) FROM `tb_notifikasi_log` where id_karyawan = '".$_POST['ID_notifikasi']."' AND flag_read = 0 ");
  $dataTotalNotifikasi = mysql_fetch_array($queryTotalNotifikasi);
  echo json_encode(array('status' =>true , 'data' =>  $dataTotalNotifikasi[0]));

}



 ?>
