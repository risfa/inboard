<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';
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
  $nomor_Top_leader = fetch_karyawan($cek_kepemilikan_leader['top_leader']);
  $nomor_leader = fetch_karyawan($cek_kepemilikan_leader['leader']);
if(isset($_GET['terima'])){
  $nmr_karyawan = $_GET['telpon'];
  $nomortlp_top_leader = $_GET['telepon_atasan'];
  $id_leader = $_GET['idleader'];
  $id_top_leader = $_GET['top_leader'];
  $id_cuti = $_GET['terima'];

  $data_top_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE no_telp = '$nomortlp_top_leader'"));

  $data_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_leader'"));

  $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_cuti ON tb_karyawan.ID_karyawan = tb_permohonan_cuti.ID_karyawan WHERE no_telp = '$nmr_karyawan' AND ID_permohonan_cuti = '$id_cuti'"));

  $update_status_cuti = mysql_query("UPDATE `tb_permohonan_cuti` SET `accept_by` = 'CHECKED', approved_by = 'CHECKED',status = 'DI TERIMA' WHERE `tb_permohonan_cuti`.`ID_permohonan_cuti` = '$_GET[terima]';");
            //KIRIM MESSAGE KE KARYAWAN
  $message_karyawan = $status['CHECKED'] = "Pemohonan Cuti Anda Pada Tanggal *".$data_pemohon['tgl_cuti']."* Telah Di Setujui Oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'CUTI','inboard.ardgroup.co.id');
            //END

            //KIRIM MESSAGE KE TOP LEADER
  $kirim_ke_atasan = send_wa($nomortlp_top_leader,"Permohonan cuti *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tgl_cuti']."* telah disetujui oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ",'CUTI','inboard.ardgroup.co.id');
            //END

            //KIRIM MESSAGE KE LEADER
  $kirim_ke_atasan = send_wa($data_leader['no_telp'],"Permohonan cuti *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tgl_cuti']."* telah disetujui oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ",'CUTI','inboard.ardgroup.co.id');
            //END

            // SEND MESSAGE KE HR
  $message_HR = "Permohonan cuti *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tgl_cuti']."* telah disetujui oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ";
  $kirim_feedback_ke_HR = send_wa('6281316124343',$message_HR,'CUTI','inboard.ardgroup.co.id');
            //END
  echo "<script>document.location.href='form_control_cuti.php'</script>";

}

if(isset($_GET['tolak'])){
  $telp = $_GET['ditolak'];

  $get_data_karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_cuti WHERE ID_permohonan_cuti = '$_GET[tolak]'"));
  $delete_permohonan_cuti = mysql_query("UPDATE `tb_permohonan_cuti` SET `status` = 'DI TOLAK' WHERE `tb_permohonan_cuti`.`ID_permohonan_cuti` = '$_GET[tolak]';");
  $update_quota_cuti = mysql_query("UPDATE `tb_master_cuti` SET `jumlah_cuti` = jumlah_cuti + 1 WHERE `tb_master_cuti`.`ID_karyawan` = '$get_data_karyawan[ID_karyawan]';");
  $message = $status['CHECKED'] = "Ssssttt.. untuk permohonan cuti tanggal ".$get_data_karyawan['tgl_cuti'].", *".$_SESSION['nama_lengkap']."* Minta Kamu Untuk Ngobrol, Klik Link Dibawah ini";
  $kirim_feedback_ke_karyawan = send_wa($telp,$message,'CUTI','inboard.ardgroup.co.id');


  echo "<script>document.location.href='form_control_cuti.php'</script>";

            //KIRIM PEMBERITAHUAN BAHWA DI TOLAK
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
  ?>

  <div id="page-content">
   <div class="block full">
    <div class="block-title">
      <div class="row">
        <div class="col-md-8">
          <h2 style="font-size: 20px;margin: 13px;">HALAMAN PERSETUJUAN CUTI</h2>
        </div>
        <div class="col-md-4">

         <br>
         <?php 
         $sql_cek = mysql_query("SELECT * FROM tb_permohonan_cuti WHERE pembatalan_cuti = 1");
         $cek_batal_cuti = mysql_num_rows($sql_cek);
         // while($batal_cuti = mysql_fetch_array($sql_cek)){
         if($_SESSION['ID_karyawan'] == 16){
           if($cek_batal_cuti){
            ?>
            <a href="#modal-fade" class="btn btn-effect-ripple btn-danger" data-toggle="modal" style="float:right; ">PERMOHONAN PEMBATALAN CUTI</a>
          <?php  }}else { ?>

          <?php } ?>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
        <thead>
          <tr>
            <th class="text-center" style="width: 10px; text-align: center;">No</th>
            <th> Nama </th>
            <th>Jabatan</th>
            <th>Perusahaan</th>
            <th>Keterangan </th>
            <th style="width: 20px;">Tanggal Cuti</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          if($cek_saya_leader == "TRUE"){
           $sql = mysql_query("SELECT `tb_permohonan_cuti`.*, tb_jabatan.nama_jabatan, tb_department.nama_department,tb_karyawan.* FROM tb_permohonan_cuti JOIN tb_karyawan ON tb_permohonan_cuti.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE departement = '$_SESSION[departement]' AND accept_by = '$_SESSION[ID_karyawan]' AND tb_permohonan_cuti.status = 'DI AJUKAN'");
         }
         if($cek_saya_top_leader == "TRUE"){
           $sql = mysql_query("SELECT `tb_permohonan_cuti`.*, tb_jabatan.nama_jabatan, tb_department.nama_department,tb_karyawan.* FROM tb_permohonan_cuti JOIN tb_karyawan ON tb_permohonan_cuti.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE departement IN(SELECT ID FROM tb_department WHERE top_leader =  '$_SESSION[ID_karyawan]') AND approved_by = '$_SESSION[ID_karyawan]' AND accept_by = 'CHECKED'  AND tb_permohonan_cuti.status = 'DI AJUKAN'");
         }

         while($data = mysql_fetch_array($sql)){
           $telepon_atasan = fetch_karyawan($data['approved_by']);
           ?>
           <tr>
            <td style="text-align: center;"><?php echo $no ?></td>
            <td><?php echo $data['nama_lengkap'] ?></td>
            <td><?php echo $data['nama_jabatan']."<br>". $data['nama_department'] ?></td>
            <td> <?php echo $data['perusahaan'] ?></td>
            <td> <?php echo $data['keterangan'] ?></td>
            <td>  <?php echo $data['tgl_cuti'] ?></td>
            <td>  
              <?php if($cek_saya_top_leader=="TRUE"){ ?>
               <a href="form_control_cuti.php?terima=<?php echo $data[0] ?>&telpon=<?php echo $data['no_telp'] ?>&telepon_atasan=<?php echo $telepon_atasan['no_telp'] ?>&top_leader=<?php echo $_SESSION['ID_karyawan']?>&idleader=<?php echo $_SESSION['ID_karyawan'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>TERIMA PERMOHONAN</span></a>
             <?php }else{ ?>
               <a href="form_control_cuti.php?terima=<?php echo $data[0] ?>&telpon=<?php echo $data['no_telp'] ?>&telepon_atasan=<?php echo $telepon_atasan['no_telp'] ?>&idleader=<?php echo $_SESSION['ID_karyawan'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>SETUJUI PERMOHONAN</span></a>
             <?php } ?>

             <a href="form_control_cuti.php?tolak=<?php echo $data[0] ?>&ditolak=<?php echo $data['no_telp'] ?>"><span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i> NGOBROL YUK</span></a>
           </td>


         </tr>
         <?php $no++; } ?>
       </tbody>

     </table>
   </div>
 </div>
</div>
<!-- END Page Content -->
<form method="post">
  <div id="modal-fade" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title"><strong> Permohonan Pembatalan Cuti Karyawan </strong></h3>
        </div>
        <div class="modal-body" style="height:auto;">
          <table class="table table-striped">
            <thead style="font-weight: bolder;">
              <td>No</td>
              <td>Nama</td>
              <td>Perusahaan</td>
              <td>Keterangan</td>
              <td>Tanggal Cuti</td>
            </thead>
            <?php
                        //TERIMA PEMBATALAN CUTI
            if(isset($_GET['delete_pembatalan'])){
              $telp_karyawan = $_GET['telp'];
              $get_data_karyawan1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_cuti WHERE ID_permohonan_cuti = '$_GET[delete_pembatalan]'"));
              $delete_batal = mysql_query("DELETE FROM tb_permohonan_cuti WHERE ID_permohonan_cuti = '$_GET[delete_pembatalan]'");
              if($delete_batal){
                $update_quota_cuti = mysql_query("UPDATE `tb_master_cuti` SET `jumlah_cuti` = jumlah_cuti + 1 WHERE `tb_master_cuti`.`ID_karyawan` = '$get_data_karyawan1[ID_karyawan]'");
                $kirim_feedback_ke_karyawan = send_wa($telp_karyawan,'PEMBATALAN CUTI ANDA TELAH DI SETUJUI, klik link dibawah ini : ','CUTI','inboard.ardgroup.co.id');
                echo "<script>document.location.href='form_control_cuti.php'</script>";
              }
            }
                            //TOLAK PEMBATALAN CUTI
            if(isset($_GET['tolak_pembatalan'])){
              $telp_karyawan1 = $_GET['telpon'];
              $tolak = mysql_query("UPDATE tb_permohonan_cuti SET pembatalan_cuti = 0 WHERE ID_permohonan_cuti = '$_GET[tolak_pembatalan]'");
              if($tolak){
                $kirim_feedback_ke_karyawan = send_wa($telp_karyawan1,'PEMBATALAN CUTI ANDA DI TOLAK, klik link dibawah ini : ','CUTI','inboard.ardgroup.co.id');

                echo "<script>document.location.href='form_control_cuti.php'</script>";
              }
            }
            $No= 1; 
            $tampil_data = mysql_query("SELECT tb_permohonan_cuti.*,tb_karyawan.*,tb_jabatan.*, tb_department.* FROM tb_permohonan_cuti JOIN tb_karyawan ON tb_permohonan_cuti.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE pembatalan_cuti = 1");
            while($tampil = mysql_fetch_array($tampil_data)){
             ?>
             <tr>
              <td><?php echo $No++; ?></td>
              <td><?php echo "<b>".$tampil['nama_lengkap']."</b><br>[".$tampil['nama_jabatan']."]<br>[".$tampil['nama_department']."]";  ?></td>
              <td><?php echo $tampil['perusahaan'] ?></td>
              <td><?php echo $tampil['keterangan'] ?></td>
              <td><?php echo $tampil['tgl_cuti'] ?></td>
              <td>
                <a onclick="return confirm('Apakah anda yakin? Aksi ini tidak dapat di ulangi')" href="form_control_cuti.php?delete_pembatalan=<?php echo $tampil['ID_permohonan_cuti'] ?>&telp=<?php echo $tampil['no_telp'] ?>" data-toggle="tooltip" title="Terima" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-check"></i></a>
                <a onclick="return confirm('Apakah anda yakin? Aksi ini tidak dapat di ulangi')" href="form_control_cuti.php?tolak_pembatalan=<?php echo $tampil['ID_permohonan_cuti'] ?>&telpon=<?php echo $tampil['no_telp'] ?>" data-toggle="tooltip" title="Delete" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-close"></i></a>
              </td>
            </tr>
          <?php } ?>
        </table>
      </div>

    </div>
  </div>
</div>
</form>
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
