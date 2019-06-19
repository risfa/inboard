<?php

$dbhost = 'localhost';
$dbuser = 'dapps';
$dbpass = 'l1m4d1g1t';
$dbname = 'dapps_xeniel_inboard';

mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);

$token = $_GET['token'];
$ID_karyawan = $_GET['ID_karyawan'];

// echo $token;


$selectToken = mysql_query("SELECT token from tokens where token = '$token' ");
$num_rows = mysql_num_rows($selectToken);

if ($num_rows <= 0) {
  $sql = mysql_query("INSERT INTO `tokens` (`id`, `token`, `created_at`,`ID_karyawan`) VALUES (NULL, '".$token."', CURRENT_TIMESTAMP,'".$ID_karyawan."')");
  if ($sql) {
    echo "succes";
  }
}else{
  echo "sudah ada";
}




 ?>
