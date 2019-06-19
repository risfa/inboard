<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';

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

    if(isset($_GET['ceklis'])){
      $ID_req = $_GET['ceklis'];
      $IDkar = $_GET['id_karyawan'];
      $IDlead = $_GET['lead'];

      $approve = mysql_query("UPDATE `tb_permohonan_biaya_master` SET leader_check = 'CHECKED', status_pb='DITERIMA LEADER', status_pb_finance ='MENUNGGU FINANCE' WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[ceklis]'");

      $data_finan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '11' "));

      $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE ID_master_PB ='$IDkar'"));

      $data_lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan ='$IDlead'"));

      $Tanggal = $data_kar['tanggal_pengajuan'];
        $date = new DateTime($Tanggal);
        $date_time = $date->format('d M Y');
        
      if($approve){
             $kirim_feedback_ke_karyawan = send_wa($data_kar['no_telp'],"Permohonan Biaya Pada Tanggal *".$date_time."* Anda Sudah Diapprove Oleh *".$data_lead['nama_lengkap']."* Dan Menunggu approval *".$data_finan['nama_lengkap']."*, klik link dibawah ini : ",'PERMOHONAN BIAYA','inboard.ardgroup.co.id');

             $kirim_feedback_ke_finance = send_wa('6281288011397',"Permohonan Biaya *".$data_kar['nama_lengkap']."* Pada Tanggal *".$date_time."* Sudah Diterima Oleh *".$data_lead['nama_lengkap']."* Sekarangan giliran anda, klik link dibawah ini :",'PERMOHONAN BIAYA','https://xeniel.5dapps.com/inboard/otu/otu_permohonan_biaya_finance.php?ID='.$ID_req.'');
             //  6285921429594 6281288011397
        echo "<script>document.location.href='panel_kontrol_pb.php'</script>";
      }
    }

    if(isset($_GET['revisi'])){
      $IDkar = $_GET['id_karyawan'];
      $IDlead = $_GET['lead'];

      $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE ID_master_pb ='$IDkar'"));

      $data_lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan ='$IDlead'"));

      $Tanggal = $data_kar['tanggal_pengajuan'];
        $date = new DateTime($Tanggal);
        $date_time = $date->format('d M Y');
        
      $approve = mysql_query("UPDATE `tb_permohonan_biaya_master` SET status_pb='REVISI' WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[revisi]'");
      if($approve){
             $kirim_feedback_ke_karyawan = send_wa($data_kar['no_telp'],"Permohonan Biaya Pada Tanggal *".$date_time."* Anda Diminta Revisi Oleh *".$data_lead['nama_lengkap']."*, Klik link berikut ini : ",'PERMOHONAN BIAYA','inboard.ardgroup.co.id');

        echo "<script>document.location.href='panel_kontrol_pb.php'</script>";
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
            <h2 style="font-size: 20px;margin: 13px;">Panel Kontrol PB</h2>
          </div>
        </div>
      </div>

      <?php if(!$_GET['upload_bukti_transaksi']){ ?>
      <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
          <thead>
            <tr>
              <th style="width: 40px;">Nama</th>
              <th style="width: 20px;">Jabatan / Departemen<br> / Perusahaan</th>
              <th style="width: 20px;">Tanggal Pengajuan</th>
              <th style="width: 20px;">Nama Proyek</th>
              <th style="width: 20px;">Kualifikasi</th>
              <!-- <th style="width: 20px;">Action</th> -->

              <th class="text-center" style="width: 10px;"><i class="fa fa-flash"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql_approve = mysql_query("SELECT * FROM tb_permohonan_biaya_master JOIN tb_karyawan ON tb_permohonan_biaya_master.id_pemohon = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE departement IN(SELECT ID FROM tb_department WHERE status_pb='DI AJUKAN' AND top_leader = '$_SESSION[ID_karyawan]') AND approved_by = '$_SESSION[ID_karyawan]' ORDER BY ID_master_pb DESC");
              while($data = mysql_fetch_array($sql_approve)){
              ?>
              <tr>
                <td><?php echo $data['nama_lengkap'] ?></td>
                <td><?php echo $data['nama_jabatan']." /<br> ". $data['nama_department']."/<br>". $data['perusahaan'] ?></td>
                <td><?php echo $data['tanggal_pengajuan'] ?></td>
                <td><?php echo $data['nama_proyek'] ?></td>
                <td><?php echo $data['kualifikasi'] ?></td>
                
                <td>
                  <?php 
                if($data['status_pb']=='DITERIMA LEADER' || $data['status_pb_finance']=='MENUNGGU FINANCE'){
               ?>
               <a href="detail_pb.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search">DETAILS PB</i></a>
             <?php }else {?>
                  <a href="panel_kontrol_pb.php?ceklis=<?php echo $data['ID_master_pb'] ?>&id_karyawan=<?php echo $data['id_pemohon'] ?>&lead=<?php echo $data['approved_by'] ?>" data-toggle="tooltip" title="Approved" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-check">TERIMA PB</i></a>
                  <a href="panel_kontrol_pb.php?revisi=<?php echo $data['ID_master_pb'] ?>&id_karyawan=<?php echo $data['id_pemohon'] ?>&lead=<?php echo $data['approved_by'] ?>" data-toggle="tooltip" title="Revisi" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-check">REVISI PB</i></a>
                  <a href="detail_pb.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search">DETAILS PB</i></a>
              <?php } ?>
                </td>
              </tr>
              <?php
            }
            ?>
          <!-- </tbody> -->
          <?php 
              //UNTUK FINANCE PBDITERIMA 
    if(isset($_GET['terima_finance'])){
      $IDkar = $_GET['id_karyawan'];
      $IDreq = $_GET['terima_finance'];
      

      $terima_pb = mysql_query("UPDATE `tb_permohonan_biaya_master` SET status_pb_finance='PB DITERIMA' WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[terima_finance]'");
      $data_finan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '11' "));
      $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE no_telp ='$IDkar'"));
      $Tanggal = $data_kar['tanggal_pengajuan'];
        $date = new DateTime($Tanggal);
        $date_time = $date->format('d M Y');
      if($terima_pb){
        $kirim_feedback_ke_karyawan = send_wa($data_kar['no_telp'],"Permohonan Biaya Pada Tanggal *".$date_time."* Anda Sudah Diterima Oleh *".$data_finan['nama_lengkap']."* Dengan Status *".$data_kar['status_pb_finance']."* Klik link berikut ini :",'PERMOHONAN BIAYA','inboard.ardgroup.co.id');

        $kirim_feedback_ke_karyawan = send_wa('6281291305529',"Permohonan Biaya Pada Tanggal *".$date_time."* Anda Sudah Diterima Oleh *".$data_finan['nama_lengkap']."* Dengan Status *".$data_kar['status_pb_finance']."* Klik link berikut ini :",'PERMOHONAN BIAYA','inboard.ardgroup.co.id');

        echo "<script>document.location.href='panel_kontrol_pb.php'</script>";
      }
    }
    if(isset($_GET['tolak_finance'])){
      $IDkar = $_GET['id_karyawan'];
      $IDlead = $_GET['id_lead'];
      $data_finan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '11' "));
      $data_lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan ='$IDlead'"));
      $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE ID_karyawan ='$IDkar'"));
      $Tanggal = $data_kar['tanggal_pengajuan'];
        $date = new DateTime($Tanggal);
        $date_time = $date->format('d M Y');
      $tolak_pb = mysql_query("UPDATE `tb_permohonan_biaya_master` SET  status_pb_finance ='REVISI',leader_check='', finance_check='', status_pb='REVISI' WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[tolak_finance]'");
      
      if($tolak_pb){
        $kirim_feedback_ke_karyawan = send_wa($data_kar['no_telp'],"Permohonan Biaya Anda Pada Tanggal *".$date_time."* Diminta Revisi Oleh *".$data_finan['nama_lengkap']."* ",'PERMOHONAN BIAYA');

        $kirim_feedback_ke_lead = send_wa($data_lead['no_telp'],"Permohonan Biaya *".$data_kar['nama_lengkap']."* Pada Tanggal *".$date_time."* Diminta Revisi Oleh *".$data_finan['nama_lengkap']."* ",'PERMOHONAN BIAYA');
        echo "<script>document.location.href='panel_kontrol_pb.php'</script>";
      }
    }

    //PB SEDANG DIPROSES
if(isset($_GET['proses_pb'])){
  $IDkar = $_GET['id_karyawan'];
      $proses_finance = mysql_query("UPDATE `tb_permohonan_biaya_master` SET  status_pb_finance ='PB DIPROSES' WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[proses_pb]'");

      $data_finan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '11' "));
      $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE ID_karyawan ='$IDkar'"));
      $Tanggal = $data_kar['tanggal_pengajuan'];
        $date = new DateTime($Tanggal);
        $date_time = $date->format('d M Y');
      if($proses_finance){
        $kirim_feedback_ke_karyawan = send_wa($data_kar['no_telp'],"Permohonan Biaya Pada Tanggal *".$date_time."* Anda Sedang Diproses Oleh *".$data_finan['nama_lengkap']."* Dengan Status *".$data_kar['status_pb_finance']."* ",'PERMOHONAN BIAYA');
        echo "<script>document.location.href='panel_kontrol_pb.php'</script>";
      }
    }
           ?>
          <!-- <tbody> FORM ACTION UNTUK FINANCE -->
            <?php
            if($_SESSION['ID_karyawan']==11){
            $sql_approve = mysql_query("SELECT * FROM tb_permohonan_biaya_master JOIN tb_karyawan ON tb_permohonan_biaya_master.id_pemohon = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE tb_permohonan_biaya_master.status_pb='DITERIMA LEADER' ORDER BY ID_master_pb DESC");
              while($data = mysql_fetch_array($sql_approve)){
              ?>
              <tr>
                <td><?php echo $data['nama_lengkap'] ?></td>
                <td><?php echo $data['nama_jabatan']." /<br> ". $data['nama_department']."/<br>". $data['perusahaan'] ?></td>
                <td><?php echo $data['tanggal_pengajuan'] ?></td>
                <td><?php echo $data['nama_proyek'] ?></td>
                <td><?php echo $data['kualifikasi'] ?></td>
                <!-- <td><?php echo $data['jumlah_uang'] ?></td> -->
                <td>
                  <?php 
                if($data['status_pb_finance']=='MENUNGGU FINANCE'){
               ?>
               <a href="panel_kontrol_pb.php?terima_finance=<?php echo $data['ID_master_pb'] ?>&id_karyawan=<?php echo $data['no_telp'] ?>" data-toggle="tooltip" title="Approved" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-check">TERIMA PB</i></a>
               <a onclick="return confirm('Apakah anda yakin?, Aksi ini tidak dapat di ulangi')" href="panel_kontrol_pb.php?tolak_finance=<?php echo $data['ID_master_pb'] ?>&id_karyawan=<?php echo $data['id_pemohon'] ?>&id_lead=<?php echo $data['approved_by'] ?>" data-toggle="tooltip" title="Delete Karyawan" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times">TOLAK PB</i></a>
               <a target="blank" href="detail_pb.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search">DETAILS PB</i></a>
               <a target="blank" href="img/PCE/<?php echo $data['ID_master_pb'] ?>.jpg" data-toggle="tooltip" title="Details PB" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search">FILE PCE</i></a>
             <?php }elseif($data['status_pb_finance']== 'PB DITERIMA') {?>
                  <a href="panel_kontrol_pb.php?proses_pb=<?php echo $data['ID_master_pb'] ?>&id_karyawan=<?php echo $data['id_pemohon'] ?>" data-toggle="tooltip" title="Approved" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-check">PROSES PB</i></a>
                  <a target="blank" href="detail_pb.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search">DETAILS PB</i></a>
                  <a target="blank" href="img/PCE/<?php echo $data['ID_master_pb'] ?>.jpg" data-toggle="tooltip" title="Details PB" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search">FILE PCE</i></a>
              <?php }elseif($data['finance_check']!='CHECKED' || $data['status_pb_finance']=='PB DIPROSES'){ ?>
                 <a href="panel_kontrol_pb.php?upload_bukti_transaksi=<?php echo $data[0] ?>&id_karyawan=<?php echo $data['id_pemohon'] ?>&id_lead=<?php echo $data['approved_by'] ?>" class="btn btn-effect-ripple btn-danger" data-toggle="modal" style="float:right; ">UPLOAD BUKTI TRANSFER</a>
                <?php }else{ ?>
                  <a target="blank" href="detail_pb.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search">DETAILS PB</i></a>
                  <a target="blank" href="img/PCE/<?php echo $data['ID_master_pb'] ?>.jpg" data-toggle="tooltip" title="Details PB" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search">FILE PCE</i></a>
                  <?php } ?>
                </td>
              </tr>
              <?php
            }
              }
            ?>
          </tbody>
        </table>
      </div>
      <?php }else{ 

     $get_id = $_GET['upload_bukti_transaksi'];
    if(isset($_POST['upload_bukti_transaksi'])){
      $IDkar = $_GET['id_karyawan'];
      $IDlead = $_GET['id_lead'];

      $finalize_finance = mysql_query("UPDATE `tb_permohonan_biaya_master` SET  status_pb_finance ='FINALIZE', finance_check ='CHECKED' WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[upload_bukti_transaksi]'");

      $data_finan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '11' "));
      $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE ID_karyawan ='$IDkar'"));
      $data_lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan ='$IDlead'"));
      $Tanggal = $data_kar['tanggal_pengajuan'];
        $date = new DateTime($Tanggal);
        $date_time = $date->format('d-M-Y');
      if($finalize_finance){
        move_uploaded_file($_FILES["fileToUpload_trf"]["tmp_name"],"img/TRF/".$get_id.".jpg");
        $kirim_feedback_ke_karyawan = send_wa($data_kar['no_telp'],"Permohonan Biaya Pada Tanggal *".$date_time."* Anda Sudah Difinalize Oleh *".$data_finan['nama_lengkap']."* ",'PERMOHONAN BIAYA');

        $kirim_feedback_ke_leader= send_wa($data_lead['no_telp'],"Permohonan Biaya *".$data_kar['nama_lengkap']."* Pada Tanggal *".$date_time."* Sudah Difinalize Oleh *".$data_finan['nama_lengkap']."* dan Dana Sudah diteruskan",'PERMOHONAN BIAYA');
        echo"<script>alert('success upload transfer receipt')</script>";
        echo "<script>document.location.href='panel_kontrol_pb.php'</script>";
      }else{
        
        echo"<script>alert('no')</script>";
      }
    }
        ?>
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
                        <label class="col-md-3 control-label">Foto Transfer</label>
                        <div class="col-md-9">
                            <input type="file" readonly id="fileToUpload_trf" name="fileToUpload_trf" class="form-control">
                            <input type="submit" class="btn btn-success" value="FINALIZE" name="upload_bukti_transaksi" id="">
                        </div>
                    </div>
        </form>
      <?php } ?>
    </div>
  </div>
  <!-- END Page Content -->
</body>
</html>
<!-- Page content -->
<!-- <?php
// show toast_show

// if (isset($_GET['toast_show'])) {
  // echo '<script type="text/javascript">
  // iziToast.success({
  //   title: "OK",
  //   message: "Data has been Succesfully inserted record!",
  // });

  // history.pushState(
  //   {alert123: "test"},  // data
  //   "test",  // title
  //   "data_karyawan.php"    // url path
  // )
  // </script>';
// }elseif (isset($_GET['toast_show_update'])) {
  // echo '<script type="text/javascript">
  // iziToast.success({
  //    title: "OK",
  //    message: "Data has been Succesfully Updated record!",
  //  });

  // history.pushState(
  //   {alert123: "test"},  // data
  //   "test",  // title
  //   "data_karyawan.php"    // url path
  // )
  // </script>';
// }elseif (isset($_GET['toast_show_non_aktif'])) {
//   echo '<script type="text/javascript">
//   iziToast.success({
//     title: "OK",
//     message: "Karyawan ini telah di non aktifkan",
//   });
//   history.pushState(
//     {alert123: "test"},  // data
//     "test",  // title
//     "data_karyawan.php"    // url path
//   )
//   </script>';
// }elseif (isset($_GET['toast_show_aktif'])) {
//   echo '<script type="text/javascript">
//   iziToast.success({
//     title: "OK",
//     message: "Karyawan ini telah di  aktifkan",
//   });
//   history.pushState(
//     {alert123: "test"},  // data
//     "test",  // title
//     "data_karyawan.php"    // url path
//   )
//   </script>';
// }
 //?>-->

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
