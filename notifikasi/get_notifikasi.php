<?php

$dbhost = 'localhost';
$dbuser = 'dapps';
$dbpass = 'l1m4d1g1t';
$dbname = 'dapps_xeniel_inboard';

mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);

$array = array();
// array_push($array,11,12,13);
// $array[] = 12;
// $array[] = 13;
// $array[] = 14;

$query = mysql_connect("SELECT * from tb_notifikasi_log   ");
while ($data = mysql_query($query)) {
  $array[] = $data[0];
}

// echo $array[0];
print_r($array)
// echo $array;


 ?>
