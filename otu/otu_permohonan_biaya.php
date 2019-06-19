<?php include ('connect.php');
      include '../wa.php';


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
        $cek_sql = mysql_query("SELECT * FROM tb_permohonan_biaya_master WHERE ID_master_pb='$_GET[ID]'");
        $PB = mysql_fetch_array($cek_sql);
        if(mysql_num_rows($cek_sql)==''){
        echo"Pengajuan yang Anda klik sudah dibatalkan oleh yang mengajukan. Terima kasih atas responnya.";
        }else if($PB['status_pb']=='DITERIMA LEADER'){
          echo"<script>window.location.href='https://xeniel.5dapps.com/inboard/otu/otu_respond.php'</script>";
        }else{

        if(isset($_GET['tolak'])){
            $telp = $_GET['ditolak'];
            $IDlead = $_GET['lead'];
            
            $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE ID_master_pb ='$_GET[tolak]'"));
            $Tanggal = $data_kar['tanggal_pengajuan'];
            $date = new DateTime($Tanggal);
            $date_time = $date->format('d M Y');
            
            $data_lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan ='$IDlead'"));
            $approve = mysql_query("UPDATE `tb_permohonan_biaya_master` SET status_pb='REVISI' WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[tolak]'");

            if($approve){
             $kirim_feedback_ke_karyawan = send_wa($data_kar['no_telp'],"Permohonan Biaya Pada Tanggal *".$date_time."* Anda Diminta Revisi Oleh *".$data_lead['nama_lengkap']."*, Klik link berikut ini : ",'PERMOHONAN BIAYA','inboard.ardgroup.co.id');

        echo "<script>document.location.href='https://xeniel.5dapps.com/inboard/otu/otu_review.php'</script>";
      }
    }

        if(isset($_GET['terima'])){
          $nmr_karyawan = $_GET['telpon'];
          $id_leader = $_GET['leader'];
          $idleader = $_GET['top_leader'];
          $nomortlp_top_leader = $_GET['telepon_atasan'];
          $id_PB = $_GET['terima'];

          $data_top_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE no_telp = '$nomortlp_top_leader'"));

          $data_lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$idleader'"));

          $approve = mysql_query("UPDATE `tb_permohonan_biaya_master` SET leader_check = 'CHECKED', status_pb='DITERIMA LEADER', status_pb_finance ='MENUNGGU FINANCE' WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[terima]'");

      $data_finan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '11' "));

      $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE ID_master_PB='$id_PB'"));

      $Tanggal = $data_kar['tanggal_pengajuan'];
        $date = new DateTime($Tanggal);
        $date_time = $date->format('d M Y');
        
      if($approve){
             $kirim_feedback_ke_karyawan = send_wa($data_kar['no_telp'],"Permohonan Biaya Pada Tanggal *".$date_time."* Anda Sudah Diapprove Oleh *".$data_lead['nama_lengkap']."* Dan Menunggu approval *".$data_finan['nama_lengkap']."*, klik link dibawah ini : ",'PERMOHONAN BIAYA','inboard.ardgroup.co.id');

             $kirim_feedback_ke_finance = send_wa('6281288011397',"Permohonan Biaya *".$data_kar['nama_lengkap']."* Pada Tanggal *".$date_time."* Sudah Diterima Oleh *".$data_lead['nama_lengkap']."* Sekarangan giliran anda, klik link dibawah ini : ",'PERMOHONAN BIAYA','inboard.ardgroup.co.id');
             //  6285921429594 6281288011397
        echo "<script>document.location.href='https://xeniel.5dapps.com/inboard/otu/otu_respond.php'</script>";
        }
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
    Berikut permohonan biaya dengan informasi sebagai berikut:
    <br><br>
    <?php 
        $sql_approve = mysql_query("SELECT * FROM tb_permohonan_biaya_master JOIN tb_karyawan ON tb_permohonan_biaya_master.id_pemohon = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE status_pb='DI AJUKAN' AND tb_permohonan_biaya_master.ID_master_pb = '$_GET[ID]'");
        $data = mysql_fetch_array($sql_approve);
        // while(){
        $data_tampil = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_biaya_master JOIN tb_karyawan ON tb_permohonan_biaya_master.approved_by = tb_karyawan.ID_karyawan WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[ID]'"));
        $detail = mysql_fetch_array(mysql_query("SELECT SUM(jumlah) as jumlah, uraian FROM `tb_permohonan_biaya_detail` WHERE tb_permohonan_biaya_detail.ID_master_pb = '$_GET[ID]'"));
          $Tanggal = $data['tanggal_pengajuan'];
          $datee = new DateTime($Tanggal);
          $date_time = $datee->format('d M Y');
          $telepon_atasan = fetch_karyawan($data['approved_by']);
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
        <td>Proyek</td>
        <td>:</td>
        <td><?php echo $data['nama_proyek'] ?></td>
       </tr>
       <tr>
        <td>Kualifikasi</td>
        <td>:</td>
        <td><?php echo $data['kualifikasi'] ?></td>
       </tr>
       <tr>
        <td>Kategori</td>
        <td>:</td>
        <td><?php echo $data['kategori'] ?></td>
       </tr>
       <tr>
        <td>DiTujukan</td>
        <td>:</td>
        <td><?php echo $data_tampil['nama_lengkap'] ?></td>
       </tr>
       <tr>
        <td>Catatan</td>
        <td>:</td>
        <td><?php echo $data['note'] ?></td>
       </tr>
       <tr>
        <td>Jumlah</td>
        <td>:</td>
        <td>Rp <?php echo number_format($detail['jumlah']) ?></td>
       </tr>
    </table>
    <br>
    <table class="table" >
      <tr>
        <td>No</td>
        <td>Uraian Kebutuhan</td>
        <td>Harga</td>
      </tr>
      <?php 
        $No = 1;
        $pb_detail = mysql_query("SELECT * FROM tb_permohonan_biaya_detail WHERE ID_master_PB = '$data[0]'");
        while($tampil = mysql_fetch_array($pb_detail)){
       ?>
      <tr>
        <td><?php echo $No++; ?></td>
        <td><?php echo $tampil['uraian']; ?></td>
        <td><?php echo $tampil['jumlah']; ?></td>
      </tr>
      <?php } ?>
    </table>
  
  </div>
  </div>
  <br><br>
  <div class="row">
    <div class="col-1"></div>
    <div class="col-5">
      <a href="https://xeniel.5dapps.com/inboard/otu/otu_permohonan_biaya.php?ID=<?php echo $data['ID_master_pb'] ?>&terima=<?php echo $data[0] ?>&telpon=<?php echo $data['no_telp'] ?>&telepon_atasan=<?php echo $telepon_atasan['no_telp'] ?>&top_leader=<?php echo $data['approved_by'] ?>&leader=<?php echo $_GET['leader'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>SETUJUI PERMOHONAN</span></a>
    
  </div>
  <br>
  <div class="col-1"></div>
  <div class="col-5"><a href="https://xeniel.5dapps.com/inboard/otu/otu_permohonan_biaya.php?ID=<?php echo $data['ID_master_pb'] ?>&tolak=<?php echo $data[0] ?>&ditolak=<?php echo $data['no_telp'] ?>&lead=<?php echo $data['approved_by'] ?>"><span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i> NGOBROL YUK</span></a>
  </div>
</div>
<?php  } ?>

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
