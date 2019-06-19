<?php

$dbhost = 'localhost';
$dbuser = 'dapps';
$dbpass = 'l1m4d1g1t';
$dbname = 'dapps_xeniel_inboard';

mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);

// $data = mysql_fetch_array(mysql_query("SELECT * FROM `tokens`"));
$ID_karyawan = $_GET['ID_karyawan'];
$sql = mysql_query("SELECT * FROM `tokens` where ID_karyawan = '$ID_karyawan'");

$selectNamaKaryawan = mysql_fetch_array(mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$ID_karyawan' "));
while ($data = mysql_fetch_array($sql)) {


define('SERVER_API_KEY', 'AIzaSyAG7J-IeX9PlAss1i8aE0bfV7bXwNTTros');

// $tokens = ['dpU-OrWFuso:APA91bEiO4wpT4UroGg-OOc0W19LKrfkvPKGIgVl-8mdzuWojxBqwTJ1l_iBsuYedCjLa_WYbu5W6iGecPLUg3hELA2czSZ6pKJ_R-gzZi71bcyPcHEy6NcHDCr6gTv38rcpU2oQBNbC'];
// $tokens = ['eKiWjxfZ5X0:APA91bFAJRE_kEGsifxf3BOvCa4suNy9T4SHqAQI6pxFkNFXJsBOQn9ifLwLbZmSiYtPDU9A2kYC6wKAKEiaDxGJuKlZm-xJBNgrWP1U3d2i_EbeAk6gePQjSMIySaB-Vkh2hOebInFf'];

$tokens = [$data[2]];

$header = [
  'Authorization: Key='. SERVER_API_KEY,
  // 'Authorization Key=AIzaSyAG7J-IeX9PlAss1i8aE0bfV7bXwNTTros',
  'Content-Type : Application/json'


];

$msg = [
    'title' => 'Inboard App',
    'body' => 'Hallo Anda telah mengganti password ',
    'icon' => 'img/logo.png',
    'link' => 'https://xeniel.5dapps.com/inboard/index.php',
    'image' => 'img/logo.png'
];

$payload = [

        // 'registration_ids' => $tokens,
        'registration_ids' => $tokens,
        'data' => $msg

];

$s = curl_init();
// $curl = curl_init();
curl_setopt($s,CURLOPT_URL,"https://fcm.googleapis.com/fcm/send");
        curl_setopt($s,CURLOPT_HTTPHEADER,$header);
        curl_setopt($s,CURLOPT_POST,true);
        curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($s,CURLOPT_POSTFIELDS,json_encode($payload));




 $response =  curl_exec($s);
 $err = curl_error($s);


curl_close($curl);

// $updateFlagNotif = mysql_query("UPDATE `tokens` SET `flag_notif` = '1' WHERE `tokens`.`ID_karyawan` =  '$data[1]' ");

}
echo $response;



?>
