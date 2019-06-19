<?php

$dbhost = 'localhost';
$dbuser = 'dapps';
$dbpass = 'l1m4d1g1t';
$dbname = 'dapps_xeniel_inboard';

mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db($dbname);




function main_send($tokens,$body_msg){

  define('SERVER_API_KEY', 'AIzaSyAG7J-IeX9PlAss1i8aE0bfV7bXwNTTros');

  // $tokens = ['d-_lXd28bGA:APA91bH0V8ex9kL_W5ITRmBZH2hJNCMf2tLgoT65U35863s5lWYpPzNW6WUkbBPPgdzIj0tipq5f-X9JPv18VJNQ4XTzNdNKhrW50tU5_jXiEaDkPGpTII1xm1daGoDC7uJY3GwqK9lf'];
    $tokens = [$tokens];

  $header = [
    'Authorization: Key='. SERVER_API_KEY,
    // 'Authorization Key=AIzaSyAG7J-IeX9PlAss1i8aE0bfV7bXwNTTros',
    'Content-Type : Application/json'


  ];

  $msg = [
      'title' => 'Inboard App',
      'body' => $body_msg,
      // 'body' => 'Hallo Selamat datang di intranet , anda akan menerima updatean terbaru tentang informasi seputar inboard . terimakasih ',
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
  curl_setopt($s,CURLOPT_URL,"https://fcm.googleapis.com/fcm/send");
          curl_setopt($s,CURLOPT_HTTPHEADER,$header);
          curl_setopt($s,CURLOPT_POST,true);
          curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
          curl_setopt($s,CURLOPT_POSTFIELDS,json_encode($payload));




   $response =  curl_exec($s);
   $err = curl_error($s);


  curl_close($curl);


  echo $response;
}


function change_pwd($tokens,$body_msg){
  main_send($tokens,$body_msg);
}



?>
