<?php include ('connect.php');
include '../wa.php';


$tahun_ini = date('Y');
$data_cuti = mysql_fetch_array(mysql_query("SELECT * FROM tb_master_cuti WHERE ID_karyawan = '$_SESSION[ID_karyawan]' AND tahun = '$tahun_ini'"));
$permohonan_cuti = mysql_fetch_array(mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_permohonan_cuti` WHERE ID_karyawan = '$_SESSION[ID_karyawan]' AND status = 'DI AJUKAN'  AND diajukan LIKE '%$tahun_ini%' "));

$cuti_terpakai = mysql_fetch_array(mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_permohonan_cuti` WHERE ID_karyawan = '$_SESSION[ID_karyawan]' AND status = 'DI TERIMA' AND diajukan LIKE '%$tahun_ini%'"));


$cek_apakah_saya_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE ID = '$_SESSION[departement]' AND leader = '$_SESSION[ID_karyawan]'"));
if($cek_apakah_saya_leader[0]==""){
  $cek_saya_leader = "FALSE";
}else{
  $cek_saya_leader = "TRUE";
}

$cek_apakah_saya_top_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE top_leader = '$_SESSION[ID_karyawan]'"));
if($cek_apakah_saya_top_leader[0]==""){
  $cek_saya_top_leader = "FALSE";
}else{
  $cek_saya_top_leader = "TRUE";
}

function fetch_karyawan($id_karyawan){
  $sql = mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '".$id_karyawan."' ");
  return mysql_fetch_array($sql);
}

if (isset($_GET['tolak'])){
  $telp = $_GET['ditolak'];

  $get_data_karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_cuti WHERE ID_permohonan_cuti = '$_GET[tolak]'"));
  $delete_permohonan_cuti = mysql_query("UPDATE `tb_permohonan_cuti` SET `status` = 'DI TOLAK' WHERE `tb_permohonan_cuti`.`ID_permohonan_cuti` = '$_GET[tolak]';");
  $update_quota_cuti = mysql_query("UPDATE `tb_master_cuti` SET `jumlah_cuti` = jumlah_cuti + 1 WHERE `tb_master_cuti`.`ID_karyawan` = '$get_data_karyawan[ID_karyawan]';");

  $message = $status['CHECKED'] = "Ssssttt.. untuk permohonan cuti tanggal ".$get_data_karyawan['tgl_cuti'].", *".$_SESSION['nama_lengkap']."* Minta Kamu Untuk Ngobrol, Klik Link Dibawah ini";
  $kirim_feedback_ke_karyawan = send_wa($telp,$message,'CUTI');


  echo "<script>document.location.href='https://xeniel.5dapps.com/inboard/otu/otu_respond.php'</script>";

            //KIRIM PEMBERITAHUAN BAHWA DI TOLAK

}

if(isset($_GET['terima'])){
  $nmr_karyawan = $_GET['telpon'];
  $id_leader = $_GET['leader'];
  $nomortlp_top_leader = $_GET['telepon_atasan'];
  $id_cuti = $_GET['terima'];

  $data_top_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE no_telp = '$nomortlp_top_leader'"));

  $data_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_leader'"));

  $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_cuti ON tb_karyawan.ID_karyawan = tb_permohonan_cuti.ID_karyawan WHERE no_telp = '$nmr_karyawan' AND ID_permohonan_cuti = '$id_cuti'"));

  $update_status_cuti = mysql_query("UPDATE `tb_permohonan_cuti` SET `accept_by` = 'CHECKED', approved_by = 'CHECKED',status = 'DI TERIMA' WHERE `tb_permohonan_cuti`.`ID_permohonan_cuti` = '$_GET[terima]';");
            //KIRIM MESSAGE KE KARYAWAN
  $message_karyawan = $status['CHECKED'] = "Pemohonan Cuti Anda Pada Tanggal *".$data_pemohon['tgl_cuti']."* Telah Di Setujui Oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'CUTI');
            //END


            //KIRIM MESSAGE KE TOP LEADER
  $kirim_ke_atasan = send_wa($nomortlp_top_leader,"Permohonan cuti *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tgl_cuti']."* telah disetujui oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ",'CUTI');
            //END

            // SEND MESSAGE KE HR
  $message_HR = "Permohonan cuti *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tgl_cuti']."* telah disetujui oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ";
  $kirim_feedback_ke_HR = send_wa('6281316124343',$message_HR,'CUTI');
            //END
  echo "<script>document.location.href='https://xeniel.5dapps.com/inboard/otu/otu_respond.php'</script>";

}
?>
<!DOCTYPE html>
<html>
<head>
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
 <title></title>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
 <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
 <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
</head>
<body>
  <?php
  ?>
  <br><br><br>
  <div class="container">
    <div class="row">
      <div class="col-1"></div>
      <div class="col-4"><img class="img-fluid" src="../img/inboard_logo.png"></div>
      <div class="col-6" style="margin-top: auto;"> <h5>INBOARD One Time Use Page</h5></div>
    </div>
    <br>
    <div class="row">
      <div class="col-1"></div>
      <div class="col-11">
        Berikut permohonan pembatalan lembur dengan informasi sebagai berikut:
        <br><br>
        <?php 
        if(isset($_GET['delete_pembatalan'])){
          $telp_karyawan = $_GET['telp'];
          $delete_batal = mysql_query("DELETE FROM tb_permohonan_lembur WHERE ID_master_lembur = '$_GET[delete_pembatalan]'");
          if($delete_batal){

            $kirim_feedback_ke_karyawan = send_wa($telp_karyawan,'PEMBATALAN LEMBUR ANDA TELAH DI SETUJUI, klik link dibawah ini : ','LEMBUR','inboard.ardgroup.co.id');
            echo "<script>document.location.href='https://xeniel.5dapps.com/inboard/otu/otu_respond.php'</script>";
          }
        }
                            //TOLAK PEMBATALAN CUTI
        if(isset($_GET['tolak_pembatalan'])){
          $telp_karyawan1 = $_GET['telpon'];
          $tolak = mysql_query("UPDATE tb_permohonan_lembur SET pembatalan_lembur = 0 WHERE ID_master_lembur = '$_GET[tolak_pembatalan]'");
          if($tolak){
            $kirim_feedback_ke_karyawan = send_wa($telp_karyawan1,'PEMBATALAN LEMBUR ANDA DI TOLAK, klik link dibawah ini : ','LEMBUR','inboard.ardgroup.co.id');

            echo "<script>document.location.href='https://xeniel.5dapps.com/inboard/otu/otu_review.php'</script>";
          }
        }
        $No= 1; 
        $tampil_data = mysql_query("SELECT tb_permohonan_lembur.*,tb_karyawan.*,tb_jabatan.*, tb_department.* FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_permohonan_lembur.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE pembatalan_lembur = 1 AND ID_master_lembur='$_GET[ID]'");
        while($data = mysql_fetch_array($tampil_data)){
          ?>
          <table class="table-responsive">
            <tr>
              <td>Nama </td>
              <td>:</td>
              <td style="text-align: center;"><?php echo $data['nama_lengkap'] ?></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>:</td>
              <td style="text-align: center:"><?php echo $data['nama_jabatan'] ?></td>
            </tr>
            <tr>
              <td>Tanggal Lembur </td>
              <td>:</td>
              <td><?php echo $data['TanggalLembur'] ?></td>
            </tr>
            <tr>
              <td>Deskripsi Pengerjaan </td>
              <td>:</td>
              <td><?php echo $data['DeskripsiPengerjaan'] ?></td>
            </tr>
          </table>

        </div>
      </div>
      <br><br>
      <div class="row">
        <div class="col-1"></div>
        <div class="col-5">
          <a onclick="return confirm('Apakah anda yakin? Aksi ini tidak dapat di ulangi')" href="https://xeniel.5dapps.com/inboard/otu/otu_pembatalan_lembur.php?delete_pembatalan=<?php echo $data['ID_master_lembur'] ?>&telp=<?php echo $data['no_telp'] ?>" data-toggle="tooltip" title="Terima" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-check">TERIMA</i></a>

        </div>
        <div class="col-1"></div>
        <div class="col-5">
          <a onclick="return confirm('Apakah anda yakin? Aksi ini tidak dapat di ulangi')" href="https://xeniel.5dapps.com/inboard/otu/otu_pembatalan_lembur.php?tolak_pembatalan=<?php echo $data['ID_master_lembur'] ?>&telpon=<?php echo $data['no_telp'] ?>" data-toggle="tooltip" title="Delete" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-close">NGOBROL YUK</i></a>
        </div>
      </div>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Load and execute javascript code used only in this page -->
    <script src="js/pages/uiTables.js"></script>
  </body>
  </html>
  <!-- Page content -->
  <?php include 'inc/page_footer.php'; ?>
  <?php include 'inc/template_scripts.php'; ?>

  <!-- Load and execute javascript code used only in this page -->
  <script src="js/pages/uiTables.js"></script>
  <script>$(function(){ UiTables.init(); });</script>

  <?php include 'inc/template_end.php'; ?>

  <script type="text/javascript">
   function hide_table(){

    document.getElementById("formnya").style.display = "block";
    document.getElementById("datanya").style.display = "none";

  }
</script>
