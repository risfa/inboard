<?php

$DB_host = "localhost";
$DB_user = "dapps";
$DB_pass = "l1m4d1g1t";
$DB_name = "dapps_xeniel_inboard";

 try
 {
     $db_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e)
 {
     echo "ERROR : ".$e->getMessage();
 }
?>
