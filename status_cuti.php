<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';
$tahun_ini = date('Y');
echo "test".$tahun_ini;
$data_cuti = mysql_fetch_array(mysql_query("SELECT * FROM tb_master_cuti WHERE ID_karyawan = '$_SESSION[ID_karyawan]' AND tahun = '$tahun_ini'"));
$permohonan_cuti = mysql_fetch_array(mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_permohonan_cuti` WHERE ID_karyawan = '$_SESSION[ID_karyawan]' AND status = 'DI AJUKAN'  AND diajukan LIKE '%$tahun_ini%' "));
$cuti_terpakai = mysql_fetch_array(mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_permohonan_cuti` WHERE ID_karyawan = '$_SESSION[ID_karyawan]' AND status = 'DI TERIMA' AND diajukan LIKE '%$tahun_ini%'"));


if(isset($_GET['delete'])){
  $idKaryawan = $_GET['id_karyawan'];
  $id_leader = $_GET['leader'];
  $leader1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$id_leader'"));
  $karyawan1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_cuti  WHERE ID_karyawan = '$idKaryawan'"));
  $karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$idKaryawan'"));

    $sql_batalkan_cuti = mysql_query("DELETE FROM tb_permohonan_cuti WHERE ID_permohonan_cuti = '$_GET[delete]'");

    $cc_ke_leader = send_wa($leader1['no_telp'],"Abaikan Pengajuan *".$karyawan['nama_lengkap']."* Karna Telah membatalkan Pengajuan, klik link berikut ini : ",'CUTI','inboard.ardgroup.co.id');

    if($sql_batalkan_cuti){
        $update_quota_cuti = mysql_query("UPDATE `tb_master_cuti` SET `jumlah_cuti` = jumlah_cuti + 1 WHERE `tb_master_cuti`.`ID_karyawan` = '$_SESSION[ID_karyawan]';");
        echo "<script>document.location.href='status_cuti.php'</script>";
    }
}

if(isset($_GET['delete1'])){
  $id_batal = $_GET['delete1'];
$update_batal = mysql_query("UPDATE tb_permohonan_cuti SET pembatalan_cuti = 1 WHERE `tb_permohonan_cuti`.`ID_permohonan_cuti` = '$_GET[delete1]'");
if($update_batal){

$idKaryawan = $_GET['id_karyawan'];
$id_leader = $_GET['leader'];
$karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$idKaryawan'"));

$karyawan2 = mysql_fetch_array(mysql_query("SELECT * FROM `tb_karyawan` JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$idKaryawan'"));
$telp_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$karyawan2[leader]'"));

$karyawan1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_cuti  WHERE ID_karyawan = '$idKaryawan'"));
$kirim_ke_karyawan = send_wa($karyawan['no_telp'],"Permohonan pembatalan cuti anda sedang di proses, klik link dibawah ini : ",'CUTI','http://inboard.ardgroup.co.id');

$kirim_ke_HR = send_wa('6281316124343',"Karyawan Dengan Nama *".$karyawan['nama_lengkap']."* Meminta pembatalan Cuti Pada Tanggal ".$karyawan1['tgl_cuti'].", klik link dibawah ini : ",'CUTI','https://xeniel.5dapps.com/inboard/otu/otu_permohonan_cuti.php?ID='.$id_batal.'');
$kirim_ke_HR = send_wa('6281291305529',"Karyawan Dengan Nama *".$karyawan['nama_lengkap']."* Meminta pembatalan Cuti Pada Tanggal ".$karyawan1['tgl_cuti'].", klik link dibawah ini : ",'CUTI','https://xeniel.5dapps.com/inboard/otu/otu_permohonan_cuti.php?ID='.$id_batal.'');
$cc_ke_leader = send_wa($telp_leader['no_telp'],"Karyawan Dengan Nama *".$karyawan['nama_lengkap']."* Meminta pembatalan Cuti Pada Tanggal ".$karyawan1['tgl_cuti'].", klik link dibawah ini : ",'CUTI','http://inboard.ardgroup.co.id');

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

<div id="page-content">
 <div class="block full">
        <div class="block-title">
          <div class="row">
            <div class="col-md-3">
                <h2 style="font-size: 20px;margin: 13px;">Form Cuti</h2>
            </div>
            <div class="col-md-9">
              <?php if($data_cuti['jumlah_cuti']>0 || $data_cuti['jumlah_cuti']!=""){ ?>
                  <a href="form_cuti.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;AJUKAN PERMOHONAN CUTI</button></a><br>
              <?php }else{ ?>
                  <a href="#" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-block"></i>&nbsp;QUOTA CUTI ANDA SUDAH HABIS</button></a><br>
              <?php } ?>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-lg-4">
            <a href="javascript:void(0)" class="widget">
              <div class="widget-content widget-content-mini text-right clearfix" style="background:#f9f9f9; border: 1px solid #ebeef2;">
                <div class="widget-icon pull-left themed-background-info">
                  <i class="gi gi-plus text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text-info">
                  <strong><span data-toggle="counter" ><?php echo $data_cuti['jumlah_cuti'];  ?></span></strong>
                </h2>
                <span class="text-muted">QUOTA CUTI <?php echo $tahun_ini; ?></span>
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
                <span class="text-muted">SEDANG DI PROSES</span>
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
                <span class="text-muted">QUOTA CUTI TERPAKAI <?php echo $tahun_ini; ?></span>
              </div>
            </a>
          </div>

        </div>
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10px; text-align: center;">No</th>
                        <th style="width: 40px;">Keterangan </th>
                        <th style="width: 20px;">Tanggal Cuti</th>
                        <th style="width: 20px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                   $no = 1;
                    $sql = mysql_query("SELECT * FROM tb_permohonan_cuti  WHERE ID_karyawan = '$_SESSION[ID_karyawan]'");
                    while($data = mysql_fetch_array($sql)){
                   $tgl_cuti = strtotime($data['tgl_cuti']);
                   $tanggal = strtotime(Date("d-m-Y"));
                   
                   $diff = $tanggal - $tgl_cuti ;
                  $Tanggal = $data['tgl_cuti'];
                          $datee = new DateTime($Tanggal);
                          $date_time = $datee->format('d M Y');
                    // echo "<br>".$diff;
                   ?>
                   <tr>
                  <td style="text-align: center;"><?php echo $no ?></td>
                  <td><?php echo $data['keterangan'] ?></td>
                  <td><?php echo $date_time ?></td>
                  <td>
                      <?php if($data['status']=='DI AJUKAN'){ ?>
                          <span class="btn btn-warning btn-growl" data-growl="success"><i class="fa fa-clock-o"></i> DI AJUKAN</span>
                          <a href="status_cuti.php?delete=<?php echo $data[0] ?>&id_karyawan=<?php echo $data['ID_karyawan'] ?>&leader=<?php echo $data['approved_by'] ?>"><span class="btn btn-danger" style="padding:5px;">BATALKAN PERMOHONAN CUTI</span></a>
                      <?php }else if($data['status']=='DI TERIMA'){ ?>
                          <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i> DI TERIMA</span>
                          <?php if($data['pembatalan_cuti']== 1 ){ ?>
                           <span class="btn btn-warning btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PEMBATALAN SEDANG DIPROSES</span>
                         <?php }else if($data['pembatalan_cuti']== 0 && $diff <= 0){ ?>
                          <a href="status_cuti.php?delete1=<?php echo $data[0] ?>&id_karyawan=<?php echo $data['ID_karyawan'] ?>&leader=<?php echo $data['approved_by'] ?>"><span class="btn btn-danger" style="padding:5px;">BATALKAN PERMOHONAN CUTI</span></a>
                         <?php } else{ ?>
                          <!--  <span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i>EXPIRED PEMBATALAN</span> -->
                         <?php }} else{ ?>
                          <span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i> DI REVIEW</span>
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
