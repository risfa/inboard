<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';

if(isset($_GET['delete'])){
  $id_leader = $_GET['leader'];
  $idKaryawan = $_GET['id_karyawan'];
  $leader1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$id_leader'"));
  $karyawan1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_cuti  WHERE ID_karyawan = '$idKaryawan'"));
  $karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$idKaryawan'"));

  $sql_batalkan_lembur = mysql_query("DELETE FROM tb_permohonan_lembur WHERE ID_master_lembur = '$_GET[delete]'");

  $telp_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$karyawan[leader]'"));

  $cc_ke_leader = send_wa($leader1['no_telp'],"Abaikan Pengajuan *".$karyawan['nama_lengkap']."* Karna Telah membatalkan Pengajuan, klik link berikut ini : ",'LEMBUR','inboard.ardgroup.co.id');

  if($sql_batalkan_lembur){
    echo "<script>document.location.href='status_lembur.php'</script>";
  }
}

if(isset($_GET['delete1'])){
  $id= $_GET['delete1'];
  $update_batal = mysql_query("UPDATE tb_permohonan_lembur SET pembatalan_lembur = 1 WHERE `tb_permohonan_lembur`.`ID_master_lembur` = '$_GET[delete1]'");
  if($update_batal){
    $idKaryawan = $_GET['id_karyawan'];
    $id_leader = $_GET['leader'];
    $karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$idKaryawan'"));

    $karyawan2 = mysql_fetch_array(mysql_query("SELECT * FROM `tb_karyawan` JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$idKaryawan'"));
    $telp_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$karyawan2[leader]'"));
    $karyawan1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_cuti  WHERE ID_karyawan = '$idKaryawan'"));
    $kirim_ke_karyawan = send_wa($karyawan['no_telp'],"Permohonan pembatalan Lembur anda sedang di proses, klik link dibawah ini : ",'LEMBUR','inboard.ardgroup.co.id');

    $kirim_ke_HR = send_wa('6281316124343',"Karyawan Dengan Nama *".$karyawan['nama_lengkap']."* Meminta pembatalan Cuti Pada Tanggal ".$karyawan1['TanggalLembur'].", klik link dibawah ini : ",'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_pembatalan_lembur.php?ID='.$id.'');
    $cc_ke_leader = send_wa($telp_leader['no_telp'],"Karyawan Dengan Nama *".$karyawan['nama_lengkap']."* Meminta pembatalan Lembur Pada Tanggal ".$karyawan1['TanggalLembur'].", klik link dibawah ini : ",'LEMBUR','inboard.ardgroup.co.id');

    echo "<script>document.location.href='status_lembur.php'</script>";
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
        <div class="col-md-8">
          <h2 style="font-size: 20px;margin: 13px;">Daftar SOP Perusahaan</h2>
        </div>
        <div class="col-md-4">
          <a href="form_sop.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;TAMBAH SOP PERUSAHAAN</button></a><br>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
        <thead>
          <tr>
            <!-- <th class="text-center" style="width: 10px; text-align: center;">No</th> -->

            <th style="width: 40px;">Judul SOP</th>
            <th style="width: 20px;">Keterangan</th>
            <th style="width: 20px;">Aksi</h5></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $sql = mysql_query("SELECT * FROM tb_sop_perusahaan");
          while($data = mysql_fetch_array($sql)){
           ?>
           <tr>
            <td><?php echo $data['judul_sop'] ?></td>
            <td><?php echo $data['keterangan_sop'] ?></td>
            <td>
              <a href="img/Sop_Perusahaan/<?php echo $data['id_sop_perusahaan'] ?>.pdf" target="blank"><label class="label label-info"><i class="fa fa-download"></i>&nbsp; KLIK UNTUK DOWNLOAD FILE</label></a>
              <?php if($_SESSION['ID_karyawan']=='16'){ ?>
              <a href="form_sop.php?edit=<?php echo $data['id_sop_perusahaan'] ?>"><label class="label label-warning"><i class="fa fa-pencil"></i>&nbsp; EDIT SOP</label></a>
              <?php } ?>
              <?php if($_SESSION['ID_karyawan']=='22'){ ?>
              <a href="form_sop.php?edit=<?php echo $data['id_sop_perusahaan'] ?>"><label class="label label-warning"><i class="fa fa-pencil"></i>&nbsp; EDIT SOP</label></a>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
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
