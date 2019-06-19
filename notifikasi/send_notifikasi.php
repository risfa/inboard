<?php

$dbhost = 'localhost';
$dbuser = 'dapps';
$dbpass = 'l1m4d1g1t';
$dbname = 'dapps_xeniel_inboard';

mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);

// $data = mysql_fetch_array(mysql_query("SELECT * FROM `tokens`"));
$ID_karyawan = $_GET['ID_karyawan'];
$sql = mysql_query("SELECT * FROM `tokens` where ID_karyawan = '$ID_karyawan' AND flag_notif = 0 ");

$selectNamaKaryawan = mysql_fetch_array(mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$ID_karyawan' "));
while ($data = mysql_fetch_array($sql)) {


define('SERVER_API_KEY', 'AAAASWLQiNM:APA91bHal3-tQe5NzDYZzy4sGjnADkDM2-SYtR531_yP_7KbxgY56vMy3HKMtG5XGk15tjrTJWy3UC2dpKAMZ2yM9DjleppZdZONzMv7HH4G6PXKopqPq7dzhYax0FLf8ET4KlzelrE1');

// $tokens = ['d-_lXd28bGA:APA91bH0V8ex9kL_W5ITRmBZH2hJNCMf2tLgoT65U35863s5lWYpPzNW6WUkbBPPgdzIj0tipq5f-X9JPv18VJNQ4XTzNdNKhrW50tU5_jXiEaDkPGpTII1xm1daGoDC7uJY3GwqK9lf'];
$tokens = [$data[2]];

$header = [
  'Authorization: Key='. 'czMeCWHctgc:APA91bGe195kW-v5X25h8gGXS50TUvCMYzl1daDqtI63UJYsw2nYJOdIqVs_RMx5Lcsd-AvbC4RK24bdhbDLKnyoGlHXacSecFhq6In-iwMn-55KvzCLUfcdx7KUPvgS7uZXdSi0FUQd',
  // 'Authorization Key=AIzaSyAG7J-IeX9PlAss1i8aE0bfV7bXwNTTros',
  'Content-Type : Application/json'


];

$msg = [
    'title' => 'Inboard App',
    'body' => 'Hallo test Selamat datang di intranet , anda akan menerima updatean terbaru tentang informasi seputar inboard . terimakasih ',
    'icon' => 'img/logo.png'
    // 'link' => 'https://xeniel.5dapps.com/inboard/index.php',
    // 'image' => 'img/logo.png'
];

$payload = [

        // 'registration_ids' => $tokens,
        'registration_ids' => 'czMeCWHctgc:APA91bGe195kW-v5X25h8gGXS50TUvCMYzl1daDqtI63UJYsw2nYJOdIqVs_RMx5Lcsd-AvbC4RK24bdhbDLKnyoGlHXacSecFhq6In-iwMn-55KvzCLUfcdx7KUPvgS7uZXdSi0FUQd',
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

$updateFlagNotif = mysql_query("UPDATE `tokens` SET `flag_notif` = '1' WHERE `tokens`.`ID_karyawan` =  '$data[1]' ");

}
echo $response;

?>
