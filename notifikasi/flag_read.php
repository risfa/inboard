<?php

$dbhost = 'localhost';
$dbuser = 'dapps';
$dbpass = 'l1m4d1g1t';
$dbname = 'dapps_xeniel_inboard';

mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);

$id_notifikasi = $_POST['id_notifikasi'];

$query_flag_read = mysql_query("UPDATE tb_notifikasi_log set flag_read = 1 where id_notifikasi = '$id_notifikasi' ");
if ($query_flag_read) {
  echo "succes";
}


 ?>
