<?php include 'inc/config.php';
// $template['header_link'] = 'UI ELEMENTS'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');



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
  <?php

  ?>

  <div id="page-content">
    <div class="block full">
      <div class="block-title">
        <div class="row">
          <div class="col-md-3">
            <h2 style="font-size: 20px;margin: 13px;">Notifikasi</h2>
          </div>
          
        </div>
      </div>
      <div class="row">

      <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
          <thead>
            <tr>
              <th style="width: 10px;">Tanggal</th>
              <th style="width: 10px;">No</th>
              <th style="width: 40%;">Info</th>
              <th style="width: 20px;">Dari</th>
              <th style="width: 20px;">Log</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = mysql_query("SELECT * FROM `tb_notifikasi_log` JOIN tb_karyawan ON tb_notifikasi_log.child_id_karyawan = tb_karyawan.ID_karyawan ORDER BY id_notifikasi DESC ");
            while($data= mysql_fetch_array($sql)){
              $child_query = mysql_fetch_array(mysql_query("SELECT tb_karyawan.nama_lengkap FROM tb_karyawan JOIN tb_notifikasi_log ON tb_karyawan.ID_karyawan = tb_notifikasi_log.child_id_karyawan WHERE tb_karyawan.ID_karyawan  = '$data[id_karyawan]'"));
              //echo $child_query;
              ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $data['waktu']; ?></td>
                <td><?php echo $data['keterangan'] ?></td>
                <td><?php echo $child_query['nama_lengkap'] ?></td>
                <td style="font-size: 15px;"><label style="font-weight: bolder; font-size: 11px;"><i style="font-size: 7px; margin-right: 5px;" class="fa fa-circle" aria-hidden="true"></i></label><?php echo $data['msg'] ?></td>    
                
              </tr>
              <?php
              $no++;
            }
            ?>
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
