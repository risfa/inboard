<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
$tahun_ini = date('Y');
$data_cuti = mysql_fetch_array(mysql_query("SELECT * FROM tb_master_cuti WHERE ID_karyawan = '$_GET[details]' AND tahun = '$tahun_ini'"));
$permohonan_cuti = mysql_fetch_array(mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_permohonan_cuti` WHERE ID_karyawan = '$_GET[details]' AND status = 'DI AJUKAN'  AND diajukan LIKE '%$tahun_ini%' "));

$cuti_terpakai = mysql_fetch_array(mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_permohonan_cuti` WHERE ID_karyawan = '$_GET[details]' AND status = 'DI TERIMA' AND diajukan LIKE '%$tahun_ini%'"));


if(isset($_GET['delete'])){
    $sql_batalkan_cuti = mysql_query("DELETE FROM tb_permohonan_cuti WHERE ID_permohonan_cuti = '$_GET[delete]'");
    if($sql_batalkan_cuti){
        $update_quota_cuti = mysql_query("UPDATE `tb_master_cuti` SET `jumlah_cuti` = jumlah_cuti + 1 WHERE `tb_master_cuti`.`ID_karyawan` = '$_GET[details]';");
        echo "<script>document.location.href='status_cuti.php'</script>";
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

 <?php 
                    $tampil_nama = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$_GET[details]'"));
                 ?>
<div id="page-content">
 <div class="block full">
        <div class="block-title">
          <div class="row">
            <div class="col-md-3">
                <h2 style="font-size: 20px;margin: 13px;"> Form Cuti</h2>
                <table class="table">
                  <tr>
                    <td>Nama Lengkap</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><strong><?php echo $tampil_nama['nama_lengkap'] ?></strong></td>
                  </tr>
                  <tr>
                    <td>Jabatan</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><strong><?php echo $tampil_nama['nama_jabatan'] ?></strong></td>
                  </tr>
                  <tr>
                    <td>Departement</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><strong><?php echo $tampil_nama['nama_department'] ?></strong></td>
                  </tr>
                </table>
            </div>
                 
            <div class="col-md-9">
                <div></div>
              
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-sm-6 col-lg-4">
            <a href="javascript:void(0)" class="widget">
              <div class="widget-content widget-content-mini text-right clearfix" style="background:#f9f9f9; border: 1px solid #ebeef2;">
                <div class="widget-icon pull-left themed-background-info">
                  <i class="gi gi-plus text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-info">
                  <strong><span data-toggle="counter" ><?php echo $data_cuti['jumlah_cuti'];  ?></span></strong>
                </h2>
                <span class="text-muted">QUOTA CUTI TAHUN <?php echo $tahun_ini; ?></span>
              </div>
            </a> -->
            <div class="col-sm-6 col-lg-4">
            <a href="javascript:void(0)" class="widget">
              <div class="widget-content widget-content-mini text-right clearfix" style="background:#f9f9f9; border: 1px solid #ebeef2;">
                <div class="widget-icon pull-left themed-background-info">
                  <i class="gi gi-plus text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-info">
                  <strong><span data-toggle="counter" ><?php echo $data_cuti['jumlah_cuti'];  ?></span></strong>
                </h2>
                <span class="text-muted">QUOTA CUTI TAHUN <?php echo $tahun_ini; ?></span>
              </div>
            </a>
          </div>
          <div class="col-sm-6 col-lg-4">
            <a href="javascript:void(0)" class="widget">
              <div class="widget-content widget-content-mini text-right clearfix" style="background:#f9f9f9; border: 1px solid #ebeef2;">
                <div class="widget-icon pull-left themed-background-danger">
                  <i class="gi gi-clock text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-danger">
                  <strong><span data-toggle="counter" data-to="2835"><?php echo $permohonan_cuti[0];  ?></span></strong>
                </h2>
                <span class="text-muted">SEDANG DI PROSES <?php echo $tahun_ini; ?> </span>
              </div>
            </a>
          </div>

          <div class="col-sm-6 col-lg-4" >
            <a href="javascript:void(0)" class="widget" style="background:#f9f9f9; border: 1px solid #ebeef2;">
              <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background-success">
                  <i class="gi gi-ok_2 text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-success">
                  <strong><?php echo $cuti_terpakai[0];  ?></strong>
                </h2>
                <span class="text-muted">QUOTA CUTI YANG SUDAH TERPAKAI <?php echo $tahun_ini; ?></span>
              </div>
            </a>
          </div>

        </div>
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        
                        <th style="width: 40px;">Keterangan </th>
                        <th style="width: 20px;">Tanggal Cuti</th>
                        <th style="width: 20px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                   $no = 1;
                    $sql = mysql_query("SELECT * FROM tb_permohonan_cuti WHERE ID_karyawan = '$_GET[details]'");
                    while($data = mysql_fetch_array($sql)){
                  $Tanggal = $data['tgl_cuti'];
              $datee = new DateTime($Tanggal);
              $date_time = $datee->format('d M Y');
                   ?>
                   <tr>
                  
                  <td><?php echo $data['keterangan'] ?></td>
                  <td><?php echo $date_time ?></td>
                  <td>
                      <?php if($data['status']=='DI AJUKAN'){ ?>
                          <span class="btn btn-warning btn-growl" data-growl="success"><i class="fa fa-clock-o"></i> DI AJUKAN</span>
                          <!-- <a href="status_cuti.php?delete=<?php echo $data[0] ?>"><span class="btn btn-danger" style="padding:5px;">BATALKAN PERMOHONAN CUTI</span></a> -->
                      <?php }else if($data['status']=='DI TERIMA'){ ?>
                          <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i> DI TERIMA</span>
                      <?php }else{ ?>
                          <span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i> DI TOLAK</span>
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
