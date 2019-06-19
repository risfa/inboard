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
            <div class="col-md-3">
                <h2 style="font-size: 20px;margin: 13px;">Form Lembur</h2>
            </div>
            <div class="col-md-9">
                  <a href="form_lembur.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;AJUKAN PERMOHONAN LEMBUR</button></a><br>
            </div>
          </div>
        </div>
       
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10px; text-align: center;">No</th>
                        
                        <th style="width: 40px;">Deskripsi Pekerjaan</th>
                        <th style="width: 20px;">Nama Project</th>
                        <th style="width: 20px;">Waktu Kerja <br> <h5>Mulai / Akhir</h5></th>
                        <th style="width: 20px;">Total Jam Kerja</h5></th>
                        <th style="width: 20px;">Penggantian Lembur</h5></th>
                        <th style="width: 20px;">Tanggal Lembur</th>
                        <th style="width: 20px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                   $no = 1;
                    $sql = mysql_query("SELECT * FROM tb_permohonan_lembur  WHERE ID_karyawan = '$_SESSION[ID_karyawan]'");
                    while($data = mysql_fetch_array($sql)){
                   $tgl_lembur = strtotime($data['TanggalLembur']);
                   $tanggal = strtotime(Date("d-m-Y"));
                   $diff = $tanggal - $tgl_lembur ;

                   $Tanggal = $data['TanggalLembur'];
                   $datee = new DateTime($Tanggal);
                   $date_time = $datee->format('d M Y');
                   ?>
                   <tr>
                  <td style="text-align: center;"><?php echo $no ?></td>
                  
                  <td><?php echo $data['DeskripsiPengerjaan'] ?></td>
                  <td><?php echo $data['NamaProject'] ?></td>
                  <td><?php echo $data['WaktuMulaiKerja'] ?> / <?php echo $data['WaktuSelesaiKerja']?></td>
                  <td><?php echo $data['TotalJamKerja'] ?></td>
                  <td><?php echo $data['Penggantian_Lembur'] ?></td>
                  <td><?php echo $date_time ?></td>
                  <td>
                      <?php if($data['StatusLembur']== 0){ ?>
                          <span class="btn btn-warning btn-growl" data-growl="success"><i class="fa fa-clock-o"></i> DI AJUKAN</span>
                          <a href="status_lembur.php?delete=<?php echo $data[0] ?>&leader=<?php echo $data['ApprovedBy'] ?>&id_karyawan=<?php echo $data['ID_karyawan'] ?>"><span class="btn btn-danger" style="padding:5px;">BATALKAN PERMOHONAN LEMBUR</span></a>
                      <?php }else if($data['StatusLembur']=='1'){ ?>
                          <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i> DI TERIMA</span>
                          <?php if($data['pembatalan_lembur']== 1 ){ ?>
                           <span class="btn btn-warning btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PEMBATALAN SEDANG DIPROSES</span>
                         <?php }else if($data['pembatalan_lembur']== 0 && $diff <= 0){ ?>
                          <a href="status_lembur.php?delete1=<?php echo $data[0] ?>&id_karyawan=<?php echo $data['ID_karyawan'] ?>&leader=<?php echo $data['ApprovedBy'] ?>"><span class="btn btn-danger" style="padding:5px;">BATALKAN LEMBUR</span></a>
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
