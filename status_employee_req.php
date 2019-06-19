<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
 include 'wa.php';

if(isset($_GET['delete'])){
  $ID_lead = $_GET['ID_lead'];
  $ID_karyawan = $_GET['ID_kar'];
  $lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$ID_lead'"));
  $karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$ID_karyawan'"));

    $sql_batalkan_keluhan = mysql_query("DELETE FROM tb_employee_req WHERE ID_emp_req = '$_GET[delete]'");
    if($sql_batalkan_keluhan){
      $send_lead = send_wa($lead['no_telp'],'Hiraukan permohonan keluhan *'.$karyawan['nama_lengkap'].'* karna telah dibatalkan,terimakasih. Klik link berikut ini : ','PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
      $send_lead = send_wa('628161988871','permohonan keluhan *'.$karyawan['nama_lengkap'].'* telah dibatalkan. Klik link berikut ini : ','PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
      $send_lead = send_wa('62816767176','permohonan keluhan *'.$karyawan['nama_lengkap'].'* telah dibatalkan. Klik link berikut ini : ','PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
        echo "<script>document.location.href='status_employee_req.php'</script>";
    }
}

if(isset($_GET['selesai'])){
  $nmr_karyawan = $_GET['telpon'];
  $id_leader = $_GET['leader'];
  $nomortlp_top_leader = $_GET['telepon_atasan'];
  $id_kar = $_GET['selesai'];

  $data_top_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE no_telp = '$nomortlp_top_leader'"));

  $data_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_leader'"));

  $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_employee_req ON tb_karyawan.ID_karyawan = tb_employee_req.ID_karyawan WHERE ID_emp_req = '$id_aju'"));

  $update_status_request1 = mysql_query("UPDATE `tb_employee_req` SET `Status_request` = 'SELESAI', `Approve_By` = 'CHECKED', flag = '1' WHERE `tb_employee_req`.`ID_emp_req` = '$_GET[selesai]'");
            //KIRIM MESSAGE KE KARYAWAN
  $message_karyawan = "Permohonan keluhan anda telah selesai.TERIMAKASIH, klik link dibawah ini : ";
  // $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'PENGAUJAN KELUHAN','inboard.ardgroup.co.id');
            //END
  $kirim_ke_atasan = send_wa('628161988871',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal']."* telah selesai, klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
  $kirim_ke_atasan1 = send_wa('62816767176',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal']."* telah selesai, klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');


  if($update_status_request1){
  echo "<script>alert('yes')</script>";
  echo "<script>document.location.href='status_employee_req.php'</script>";
}else{
echo "<script>alert('no')</script>";
  echo "<script>document.location.href='status_employee_req.php'</script>";
}

}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
 <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
</head>
<body>


<div id="page-content">
 <div class="block full">
        <div class="block-title">
          <div class="row">
            <div class="col-md-3">
                <h2 style="font-size: 18px;margin: 13px;">Form Pengajuan Keluhan</h2>
            </div>
            <div class="col-md-9">
                  <a href="form_employee_request.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;AJUKAN PERMOHONAN</button></a><br>
            </div>
          </div>
        </div>
       
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10px; text-align: center;">No</th>
                        <th style="width: 40px;">Tanggal Pengajuan</th>
                        <th style="width: 40px;">Kategori</th>
                        <th style="width: 40px;">Deskripsi Keperluan</th>
                        <th style="width: 20px;">Kualifikasi</th>
                        <th style="width: 20px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                   $no = 1;
                    $sql = mysql_query("SELECT * FROM tb_employee_req WHERE ID_karyawan = '$_SESSION[ID_karyawan]'");
                    while($data = mysql_fetch_array($sql)){
                      $tgl = $data['tanggal_pengajuan'];
                      $tgl = date($tgl);
                   ?>
                   <tr>
                  <td style="text-align: center;"><?php echo $no ?></td>
                  <td><?php echo $data['tanggal_pengajuan'] ?></td>
                  <td><?php echo $data['kategori_request'] ?></td>
                  <td><?php echo $data['keterangan'] ?></td>
                  <td><?php echo $data['kualifikasi'] ?></td>
                  <td>
                      <?php if($data['Status_request']== 'DALAM PENGAJUAN'){ ?>
                          <span class="btn btn-warning btn-growl" data-growl="success"><i class="fa fa-clock-o"></i>DALAM PENGAJUAN</span>
                          <a href="status_employee_req.php?delete=<?php echo $data['ID_emp_req'] ?>&ID_lead=<?php echo $data['Approve_By'] ?>&ID_kar=<?php echo $data['ID_karyawan'] ?>"><span class="btn btn-danger" style="padding:5px;">BATALKAN PERMOHONAN</span></a>
                      <?php }else if($data['Status_request']=='DALAM PEMBAHASAN'){ ?>
                          <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i> DALAM PEMBAHASAN</span>
                        <?php }else if($data['Status_request']=='PROSES APPROVAL'){ ?>
                          <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PROSES APPROVAL</span>
                        <?php }else if($data['Status_request']=='PENGAJUAN BIAYA'){ ?>
                          <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PENGAJUAN BIAYA</span>
                        <?php }else if($data['Status_request']=='MENUNGGU ACTION KARYAWAN'){ ?>
                          <a href="status_employee_req.php?selesai=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&telepon_atasan=<?php echo $telepon_atasan['no_telp'] ?>&leader=<?php echo $_SESSION['ID_karyawan'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PROSES SELESAI</span></a>
                        <?php }else if($data['Status_request']=='SELESAI'){ ?>
                          <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>SELESAI</span>
                         <?php } else{ ?>
                          <span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i>TIDAK DAPAT DILANJUTI</span>
                      <?php } ?>
                  </td>
                  </tr>
                 <?php $no++; } ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<!-- END Page Content -->
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
