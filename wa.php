<?php

include ('Db/connect.php');

function send_wa($nomor_tujuan,$message,$jenis,$link){
  $INSTANCE_ID = '10';  // TODO: Replace it with your gateway instance ID here
  $CLIENT_ID = "risfa@limadigit.com";  // TODO: Replace it with your Forever Green client ID here
  $CLIENT_SECRET = "f0ee0b9166c34b8e940d8c55462a741e";   // TODO: Replace it with your Forever Green client secret here

  $link = $link;
  $postData = array(
    'number' => $nomor_tujuan,  // TODO: Specify the recipient's number here. NOT the gateway number
    'message' => '['.$jenis.'] '.$message.$link
  );
  $headers = array(
    'Content-Type: application/json',
    'X-WM-CLIENT-ID: '.$CLIENT_ID,
    'X-WM-CLIENT-SECRET: '.$CLIENT_SECRET
  );
  $url = 'http://api.whatsmate.net/v3/whatsapp/single/text/message/' . $INSTANCE_ID;
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
  $response = curl_exec($ch);
  // echo "Response: ".$response;
  curl_close($ch);

}

function send_image_wa(){
  $INSTANCE_ID = '10';  // TODO: Replace it with your gateway instance ID here
  $CLIENT_ID = "risfa@limadigit.com";  // TODO: Replace it with your Forever Green client ID here
  $CLIENT_SECRET = "f0ee0b9166c34b8e940d8c55462a741e";   // TODO: Replace it with your Forever Green client secret here

  $pathToImage = "img/mading/6.jpg";    // TODO: Replace it with the path to your image
  $imageData = file_get_contents($pathToImage);
  $base64Image = base64_encode($imageData);
  $postData = array(
    'number' => '6281284451625',  // TODO: Specify the recipient's number (NOT the gateway number) here.
    'image' => $base64Image
  );
  $headers = array(
    'Content-Type: application/json',
    'X-WM-CLIENT-ID: '.$CLIENT_ID,
    'X-WM-CLIENT-SECRET: '.$CLIENT_SECRET
  );
  $url = 'http://api.whatsmate.net/v3/whatsapp/single/image/message/' . $INSTANCE_ID;
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
  $response = curl_exec($ch);
  //echo "Response: ".$response;
  curl_close($ch);
}

function send_wa_all($message,$jenis,$link){
// $sql = mysql_query("SELECT no_telp from tb_karyawan where ID_karyawan = 23 ");
  $sql = mysql_query("SELECT no_telp from tb_karyawan");
  while ($data = mysql_fetch_array($sql)) {


      $INSTANCE_ID = '10';  // TODO: Replace it with your gateway instance ID here
      $CLIENT_ID = "risfa@limadigit.com";  // TODO: Replace it with your Forever Green client ID here
      $CLIENT_SECRET = "f0ee0b9166c34b8e940d8c55462a741e";   // TODO: Replace it with your Forever Green client secret here
      $link = 
      $link;
      $postData = array(
        'number' => $data[0],  // TODO: Specify the recipient's number here. NOT the gateway number
        'message' => '['.$jenis.'] '.$message.$link
      );
      $headers = array(
        'Content-Type: application/json',
        'X-WM-CLIENT-ID: '.$CLIENT_ID,
        'X-WM-CLIENT-SECRET: '.$CLIENT_SECRET
      );
      $url = 'http://api.whatsmate.net/v3/whatsapp/single/text/message/' . $INSTANCE_ID;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
      $response = curl_exec($ch);
      //echo "Response: ".$response;
      curl_close($ch);
  }
}
?>
