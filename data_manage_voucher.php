<?php include 'inc/config.php';
if(empty($_SESSION[ID_karyawan])){

  echo"<script>document.location.href='login.php'</script>";
}
 ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';


if(isset($_GET['delete_voucher'])){
  $sqldelete = mysql_query("DELETE FROM tb_voucher WHERE ID_voucher='$_GET[delete_voucher]'");
  
  if($sqldelete){

    echo '<script type="text/javascript">
    iziToast.success({
      title: "OK",
      message: "Data has been Succesfully deleted record!",
    });
    </script>';
    echo "<script>document.location.href='data_manage_voucher.php'</script>";
  }else{
    echo "<script>alert('Faile Delete')</script>";
    echo "<script>document.location.href='data_manage_voucher.php'</script>";
  }

}


if(isset($_GET['setujui'])){
  $setuju = mysql_query("UPDATE tb_voucher SET status = 'disaktif' WHERE ID_voucher = '$_GET[setujui]'");

  if($setuju){

  
  $terima = $status['disaktif'] = "Permohonan Voucher Anda Telah Di Sejutui
 Berikut Kode Vouchernya : ".$_GET['voucher']."";

      $message = "".$terima."
      ";
      $nomor = $_GET['phone'];
        send_wa($nomor,$message,'VOUCHER','http://inboard.ardgroup.co.id');
        send_wa('6281291305529',$message,'VOUCHER','http://inboard.ardgroup.co.id');

  echo "<script>document.location.href='data_manage_voucher.php'</script>";
  }
}

if(isset($_GET['tidak_disetujui'])){
  $setuju = mysql_query("UPDATE tb_voucher SET status = 'aktif' , keterangan_voucher = '', used_by = '', used_on ='0000-00-00 00:00:00',jenis_perjalanan = ''  WHERE ID_voucher = '$_GET[tidak_disetujui]'");
  
  echo "<script>document.location.href='data_manage_voucher.php'</script>";
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
          <div class="col-md-3">
            <h2 style="font-size: 20px;margin: 13px;">Data Voucher</h2>
          </div>
          
          <div class="col-md-9">
            <a href="manage_voucher.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;TAMBAH KODE VOUCHER</button></a><br>
             <?php
              $sql_cek = mysql_num_rows(mysql_query("SELECT * FROM tb_voucher WHERE status = 'requested'"));
              if($sql_cek > 0){
               ?>
              <a href="#modal-fade" class="btn btn-effect-ripple btn-danger" data-toggle="modal" style="float:right; ">PENGAJUAN REQUEST VOUCHER</a> 
             <?php }else{ ?>
              
            <?php } ?>
          </div>
        </div>
      </div>
      
      <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
          <thead>
            <tr>

              <th style="width: 20px;">No</th>
              <th style="width: 40px;">Judul Voucher</th>
              <th style="width: 40px;">Nomor Voucher</th>
              <th style="width: 40px;">Kategori Voucher</th>
              <th style="width: 40px;">Jenis Penggunaan Voucher</th>
              <th style="width: 40px;">Status</th>
              <th style="width: 40px;">Keterangan</th>

              <th class="text-center" style="width: 10px;"><i class="fa fa-flash"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = mysql_query("SELECT * FROM tb_voucher ORDER BY status DESC");
            while($data= mysql_fetch_array($sql)){
              $data_karyawan = mysql_fetch_array(mysql_query("SELECT tb_karyawan.*, tb_jabatan.nama_jabatan FROM tb_karyawan JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan WHERE ID_karyawan = '$data[used_by]'"));
              
              ?>
              <tr>
                <td><?php echo "<b >".$no; ?></td>
                <td><?php echo "<b >".$data['judul_voucher']; ?></td>
                <td><?php echo "<b >".$data['nomor_voucher'] ?></td>
                <td><?php echo "<b >".$data['kategori_voucher']; ?></td>
                <td><?php echo "<b >".$data['jenis_perjalanan']; ?></td>
                <td><?php echo $data_karyawan['nama_lengkap']."|".$data_karyawan['nama_jabatan']; ?><br><?php echo $data['keterangan_voucher']; ?></td>
                <td><?php
                        if($data['status']=='aktif'){
                            echo "<label class='label label-success'>AKTIF</label>";
                        }else if($data['status']=='disaktif'){
                            echo "<label class='label label-danger'>DISAKTIF</label>";
                        }else{
                            echo "<label class='label label-warning'>USED</label>";
                        }
                        echo "<br>".$data['used_on'];
                    ?></td>

                <td>
                  <a href="manage_voucher.php?edit=<?php echo $data['ID_voucher'] ?>" data-toggle="tooltip" title="Edit Voucher" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                  
                  <a onclick="return confirm('Apakah anda yakin?, Aksi ini tidak dapat di ulangi')" href="data_manage_voucher.php?delete_voucher=<?php echo $data['ID_voucher'] ?>" data-toggle="tooltip" title="Delete Voucher" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                </td>
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
<form method="post">
    <div id="modal-fade" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><strong> Permohonan Request Voucher </strong></h3>
                </div>
                <div class="modal-body" style="height:auto;">
                    <table class="table table-striped">
                        <thead style="font-weight: bolder;">
                            <td>No</td>
                            <td>Nama</td>
                            <td>Jenis Penggunaan</td>
                            <td>Keterangan</td>
                            <td>Judul Voucher</td>
                            <td>Kategori Voucher</td>
                        </thead>
                        <?php
                          $No= 1; 
                          $tampil_data = mysql_query("SELECT * FROM tb_voucher JOIN tb_karyawan ON tb_voucher.used_by = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE tb_voucher.status = 'requested'");
                           while($tampil = mysql_fetch_array($tampil_data)){
                         ?>
                        <tr>
                            <td><?php echo $No++; ?></td>
                            <td><?php echo "<b>".$tampil['nama_lengkap']."</b><br>[".$tampil['nama_jabatan']."]<br>[".$tampil['nama_department']."]<br>".$tampil['no_telp'] ; ?></td>
                            <td><?php echo $tampil['jenis_perjalanan'] ?></td>
                            <td><?php echo $tampil['keterangan_voucher'] ?></td>
                            <td><?php echo $tampil['judul_voucher'] ?></td>
                            <td><?php echo $tampil['kategori_voucher']."<br>----<br>".$tampil['nomor_voucher'] ?></td>
                            <td>
                              <a href="data_manage_voucher.php?setujui=<?php echo $tampil['ID_voucher'] ?>&phone=<?php echo $tampil['no_telp'] ?>&voucher=<?php echo $tampil['nomor_voucher'] ?>" data-toggle="tooltip" title="Setujui" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-check"></i></a>

                              <a onclick="return confirm('Apakah anda yakin? Aksi ini tidak dapat di ulangi')" href="data_manage_voucher.php?tidak_disetujui=<?php echo $tampil['ID_voucher'] ?>" data-toggle="tooltip" title="Tidak Disejutui" class="btn btn-effect-ripple btn-xs btn-warning"><i class="fa fa-close"></i></a>

                      
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
</form>


<?php
// show toast_show

if (isset($_GET['toast_show'])) {
  echo '<script type="text/javascript">
  iziToast.success({
    title: "OK",
    message: "Data has been Succesfully inserted record!",
  });

  history.pushState(
    {alert123: "test"},	// data
    "test",	// title
    "data_karyawan.php"		// url path
  )
  </script>';
}elseif (isset($_GET['toast_show_update'])) {
  echo '<script type="text/javascript">
  iziToast.success({
     title: "OK",
     message: "Data has been Succesfully Updated record!",
   });

  history.pushState(
    {alert123: "test"},	// data
    "test",	// title
    "data_karyawan.php"		// url path
  )
  </script>';
}elseif (isset($_GET['toast_show_non_aktif'])) {
  echo '<script type="text/javascript">
  iziToast.success({
    title: "OK",
    message: "Karyawan ini telah di non aktifkan",
  });
  history.pushState(
    {alert123: "test"},	// data
    "test",	// title
    "data_karyawan.php"		// url path
  )
  </script>';
}elseif (isset($_GET['toast_show_aktif'])) {
  echo '<script type="text/javascript">
  iziToast.success({
    title: "OK",
    message: "Karyawan ini telah di  aktifkan",
  });
  history.pushState(
    {alert123: "test"},	// data
    "test",	// title
    "data_karyawan.php"		// url path
  )
  </script>';
}


 ?>

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
