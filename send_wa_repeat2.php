<?php
include ('Db/connect.php');
include 'wa.php';


    $data_edit = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan  WHERE ID_karyawan = '6'"));
   
    $ID_karyawan = $_SESSION['ID_karyawan'];

    function fetch_karyawan($id_karyawan){
     $sql = mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '".$id_karyawan."' ");
     return mysql_fetch_array($sql);
 }
  $data_karyawan2 = fetch_karyawan($_SESSION[ID_karyawan]);

    $query = mysql_query("SELECT * from tb_employee_req");
    while ($data = mysql_fetch_array($query)) {
        if (substr($data['tanggal'], 0,10) == date("Y-m-d", strtotime("-7 day")) && $data['kualifikasi'] == 'Sangat Penting') {
          // echo $data['ID_karyawan'];
          $search_karyawan = mysql_query("SELECT * from tb_karyawan where ID_karyawan = $data[ID_karyawan]");
          while ($data_karyawan = mysql_fetch_array($search_karyawan)) {
            // echo $data_karyawan['no_telp'];
            if ($data['kategori_request'] == 'Teknis') {
              // kirim pesan
                 $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* Belum Mendapatkan Respond
Klik Link Dibawah ini :
";
                               $message = "
            Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                 $send_wa =  send_wa('6285693993232',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 // print_r($send_wa);

              // end
            }else if($data['kategori_request'] == 'Administrasi'){
              // kirim pesan

                 $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* 
Klik Link Dibawah ini :
";
                               $message = "
            Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                  send_wa('6281316124343',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                  $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                  $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
              // end
            }
          }
        }else if(substr($data['tanggal'], 0,10) == date("Y-m-d", strtotime("-14 day")) && $data['kualifikasi'] == 'Penting'){
               $search_karyawan = mysql_query("SELECT * from tb_karyawan where ID_karyawan = $data[ID_karyawan]");
          while ($data_karyawan = mysql_fetch_array($search_karyawan)) {
            // echo $data_karyawan['no_telp'];
            // echo $data['kategori_request'];
            if ($data['kategori_request'] == 'Teknis') {
              // kirim pesan
 $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                 $send_wa =  send_wa('6285693993232',$message,'PENGAJUAN KELUHAN PAK HADI','inboard.ardgroup.co.id');
                 $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 // print_r($send_wa);

              // end
            }else if($data['kategori_request'] == 'Administrasi'){
              // kirim pesan
$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond
Klik Link Dibawah ini : 
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                  send_wa('6281316124343',$message,'PENGAJUAN KELUHAN MBA WATY','inboard.ardgroup.co.id');
                  $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
              // end
            }
          }



        }else if(substr($data['tanggal'], 0,10) == date("Y-m-d", strtotime("-30 day")) && $data['kualifikasi'] == 'Biasa'){
               $search_karyawan = mysql_query("SELECT * from tb_karyawan where ID_karyawan = $data[ID_karyawan]");
          while ($data_karyawan = mysql_fetch_array($search_karyawan)) {
            echo $data_karyawan['no_telp'];
            echo $data['kategori_request'];
            if ($data['kategori_request'] == 'Teknis') {
              // kirim pesan
$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond 
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                 $send_wa =  send_wa('6285693993232',$message,'PENGAJUAN KELUHAN PAK HADI','inboard.ardgroup.co.id');
                 $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                

              // end
            }else if($data['kategori_request'] == 'Administrasi'){
              // kirim pesan
$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                  send_wa('6281316124343',$message,'PENGAJUAN KELUHAN MBA WATY','inboard.ardgroup.co.id');
                  $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                  $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
              // end
            }
          }



        }else if (substr($data['tanggal'], 0,10) == date("Y-m-d", strtotime("-14 day")) && $data['kualifikasi'] == 'Sangat Penting') {
          // echo $data['ID_karyawan'];
          $search_karyawan = mysql_query("SELECT * from tb_karyawan where ID_karyawan = $data[ID_karyawan]");
          while ($data_karyawan = mysql_fetch_array($search_karyawan)) {
            // echo $data_karyawan['no_telp'];
            if ($data['kategori_request'] == 'Teknis') {
              // kirim pesan

$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                 $send_wa =  send_wa('6285693993232',$message,'PENGAJUAN KELUHAN PAK HADI','inboard.ardgroup.co.id');
                 $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 

              // end
            }else if($data['kategori_request'] == 'Administrasi'){
              // kirim pesan
 $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                  send_wa('6281316124343',$message,'PENGAJUAN KELUHAN MBA WATY','inboard.ardgroup.co.id');
                  $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                  $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
              // end
            }
          }
        }else if(substr($data['tanggal'], 0,10) == date("Y-m-d", strtotime("-28 day")) && $data['kualifikasi'] == 'Penting'){
               $search_karyawan = mysql_query("SELECT * from tb_karyawan where ID_karyawan = $data[ID_karyawan]");
          while ($data_karyawan = mysql_fetch_array($search_karyawan)) {
            // echo $data_karyawan['no_telp'];
            // echo $data['kategori_request'];
            if ($data['kategori_request'] == 'Teknis') {
              // kirim pesan
$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond 
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                 $send_wa =  send_wa('6285693993232',$message,'PENGAJUAN KELUHAN PAK HADI','inboard.ardgroup.co.id');
                 $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 

              // end
            }else if($data['kategori_request'] == 'Administrasi'){
              // kirim pesan
 $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond 
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                  send_wa('6281316124343',$message,'PENGAJUAN KELUHAN MBA WATY','inboard.ardgroup.co.id');
                  $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
              // end
            }
          }


        }else if(substr($data['tanggal'], 0,10) == date("Y-m-d", strtotime("-60 day")) && $data['kualifikasi'] == 'Biasa'){
               $search_karyawan = mysql_query("SELECT * from tb_karyawan where ID_karyawan = $data[ID_karyawan]");
          while ($data_karyawan = mysql_fetch_array($search_karyawan)) {
            echo $data_karyawan['no_telp'];
            echo $data['kategori_request'];
            if ($data['kategori_request'] == 'Teknis') {
              // kirim pesan
               $variable = "             
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond 
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                 $send_wa =  send_wa('6285693993232',$message,'PENGAJUAN KELUHAN PAK HADI','inboard.ardgroup.co.id');$kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                 // print_r($send_wa);

              // end
            }else if($data['kategori_request'] == 'Administrasi'){
              // kirim pesan
              $variable = "             
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan2['nama_jabatan']."*
Departement: *".$data_karyawan2['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$data['tanggal']."* 
Deskripsi Keluhan: *".$data['keterangan']."* 
Kualifikasi: *".$data['kualifikasi']."* 
Kategori : *".$data['kategori_request']."* belum mendapatkan respond
Klik Link Dibawah ini :
";
                               $message = "
                  Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
                  send_wa('6281316124343',$message,'PENGAJUAN KELUHAN MBA WATY','inboard.ardgroup.co.id');
                  $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
                  $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$data['tanggal']."* Dengan Deskripsi *".$data['keterangan']."* Dan Kualifikasi *".$data['kualifikasi']."* belum mendapatkan respond dari *".$data_edit['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
              // end
            }
          }

        }

    }
?>