<?php include ('connect.php');
      include '../wa.php';

$Query_lembur = mysql_query("SELECT * FROM tb_permohonan_lembur WHERE ID_master_lembur='$_GET[ID]'");
          $lembur = mysql_fetch_array($Query_lembur);

          if(mysql_num_rows($Query_lembur)== 0){

            echo"Pengajuan yang Anda klik sudah dibatalkan oleh yang mengajukan. Terima kasih atas responnya.";

          }else if($lembur['StatusLembur'] == '1' || ['ValidateBy']== 'CHECKED'){
            echo"<script>window.location.href='https://xeniel.5dapps.com/inboard/otu/otu_respond.php'</script>";
          }else{
          if(isset($_GET['terima_CBDO'])){
           $id = $_GET['terima_CBDO'];
           $nmr_karyawan = $_GET['telpon'];
           $id_topleader = $_GET['id_depart'];
           $ID_cbdo = $_GET['id_cbdo'];
          
          $update_status_lembur = mysql_query("UPDATE `tb_permohonan_lembur` SET ValidateBy = 'CHECKED', StatusLembur ='1' WHERE `tb_permohonan_lembur`.`ID_master_lembur` = '$_GET[terima_CBDO]'");

          $telp_topleader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$id_topleader'"));

          $nama_cbdo = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$ID_cbdo'"));

          $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_lembur ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan WHERE no_telp = '$nmr_karyawan' AND ID_master_lembur = $id"));

            //KIRIM MESSAGE KE KARYAWAN
            $message_karyawan = "Pemohonan Lembur Anda Pada Tanggal *".$data_pemohon['TanggalLembur']."* Telah Di Validasi Oleh *".$nama_cbdo['nama_lengkap']."* klik link berikut ini : ";
            $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'LEMBUR','inboard.ardgroup.co.id');
            //END
        
            // SEND MESSAGE KE ATASAN
            $message_CBDO = "Permohonan Lembur *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['TanggalLembur']."* telah divalidasi oleh *".$nama_cbdo['nama_lengkap']."* . klik link berikut ini : ";
            $kirim_feedback_ke_leader = send_wa($telp_topleader['no_telp'],$message_CBDO,'LEMBUR','inboard.ardgroup.co.id');

            $kirim_feedback_ke_HR = send_wa("6281316124343",$message_CBDO,'LEMBUR','inboard.ardgroup.co.id');
            $kirim_feedback_ke_HR = send_wa("6281291305529",$message_CBDO,'LEMBUR','inboard.ardgroup.co.id');
            //END
            
            echo "<script>document.location.href='https://xeniel.5dapps.com/inboard/otu/otu_respond.php'</script>";
        }
        //6281316124343
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
    Berikut permohonan lembur dengan informasi sebagai berikut:
    <br><br>
    <?php 
        $sql_approve_cbdo = mysql_query("SELECT `tb_permohonan_lembur`.*, tb_jabatan.nama_jabatan, tb_department.*,tb_karyawan.* FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_permohonan_lembur.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND StatusLembur='0' AND ID_master_lembur='$_GET[ID]'");
            while($data = mysql_fetch_array($sql_approve_cbdo)){
              $Tanggal = $data['TanggalLembur'];
          $datee = new DateTime($Tanggal);
          $date_time = $datee->format('d M Y');
     ?>
    <table class="table-responsive">
      <tr>
        <td>Nama </td>
        <td>:</td>
        <td><?php echo $data['nama_lengkap'] ?></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td style="text-align: center:"><?php echo $data['nama_jabatan'] ?></td>
      </tr>
      <tr>
        <td>Tanggal Lembur </td>
        <td>:</td>
        <td><?php echo $date_time ?></td>
       </tr>
       <tr>
        <td>Total Jam Kerja  </td>
        <td>:</td>
        <td><?php echo $data['TotalJamKerja'] ?></td>
       </tr>
       <tr>
        <td>Penggantian Lembur</td>
        <td>:</td>
        <td><?php echo $data['Penggantian_Lembur'] ?></td>
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
      <?php 
          if($data['StatusLembur']== 1 && $data['StatusLembur']!=0){
       ?>
       <?php }else {?>
      <a href="https://xeniel.5dapps.com/inboard/otu/otu_lembur_CBDO.php?ID=<?php echo $data['ID_master_lembur'] ?>&terima_CBDO=<?php echo $data[0] ?>&id_depart=<?php echo $data['top_leader'] ?>&telpon=<?php echo $data['no_telp'] ?>&id_cbdo=<?php echo $data['ValidateBy'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>CHECK PERMOHONAN</span></a>
      <?php } ?>
  </div>
  <div class="col-1"></div>
  <div class="col-5">
  	
  </div>
</div>
<?php } }?>

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
