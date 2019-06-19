<?php
 session_start();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$cari = strpos($actual_link,"login");


if (!$cari){
	if($_SESSION['username']==" "){
		echo "<script>alert('SESI ANDA SUDAH HABIS, SILAHKAN LOGIN')</script>";
 		echo "<script>document.location.href='login.php'</script>";
	}
}else if($cari){
	if($_SESSION['username']!=""){
 		echo "<script>document.location.href='index.php'</script>";
	}
}else if($_GET['logout']==1){
session_destroy();
// session_unset();
}

/**
 * @var informasi untuk koneksi database
 */
$dbhost = 'localhost';
$dbuser = 'dapps';
$dbpass = 'l1m4d1g1t';
$dbname = 'dapps_xeniel_inboard';

mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);

?>
