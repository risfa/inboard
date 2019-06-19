<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
// include 'wa.php';



if(isset($_GET['delete'])){
  $sqldelete = mysql_query("DELETE FROM tb_mading WHERE ID_mading='$_GET[delete]'");
  $ID_mading_foto = $_GET['delete'];
  if($sqldelete){

    $notifikasiSimpan = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$$_SESSION[ID_karyawan]','Anda Telah Delete Informasi',0,'delete')");

    $filePath = "img/mading/".$ID_mading_foto.".jpg";

    // $filePath = $id_foto.".jpg";
    if (file_exists($filePath))
    {
      unlink($filePath);
      "<script>alert('Picture has been Succesfully deleted!')</script>";
    }
    else
    {
      "<script>alert('Foto tidak ada')</script>";
    }
    echo '<script type="text/javascript">
    iziToast.success({
      title: "OK",
      message: "Data has been Succesfully deleted record!",
    });
    </script>';
  }else{
    echo "<script>alert('Faile Delete')</script>";
    echo "<script>document.location.href='data_karyawan.php'</script>";
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

  ?>

  <div id="page-content">
    <div class="block full">
      <div class="block-title">
        <div class="row">
          <div class="col-md-3">
            <h2 style="font-size: 20px;margin: 13px;">Data Mading</h2>
          </div>
    
          <div class="col-md-9" style="font-size: 14px;">
            <a href="mading.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;TAMBAH DATA MADING</button></a><br>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
          <thead>
            <tr style="font-size: 14px;">
              <th style="width: 40px; font-size: 14px">Judul</th>
              <th style="width: 40px; font-size: 14px">Isi</th>
              <th style="width: 40px; font-size: 14px">Link</th>
              <th style="width: 40px; font-size: 14px">Waktu</th>
              <th style="width: 40px; font-size: 14px">Gambar</th>


              <th class="text-center" style="width: 10px;"><i class="fa fa-flash"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = mysql_query("SELECT * FROM tb_mading");
            while($data= mysql_fetch_array($sql)){
              ?>
              <tr>
                <td style="font-size: 14px"><?php echo "<b style='font-size:14px'>".$data['judul']; ?></td>
                <td style="font-size: 14px"><?php echo "<b style='font-size:14px'>".$data['isi'] ?></td>
                <td style="font-size: 14px"><?php echo "<b style='font-size:14px'>".$data['link']; ?></td>
                <td style="font-size: 14px"><?php echo "<b style='font-size:14px'>".$data['waktu'] ?></td>
                  <td>
                    <img height="100px" width="100px" src="img/mading/<?php echo $data['ID_mading'] ?>.jpg">
                  </td>

                <td>
                  <a href="mading.php?edit=<?php echo $data['ID_mading'] ?>" data-toggle="tooltip" title="Edit Mading" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                  <a href="detail_mading.php?details=<?php echo $data['ID_mading'] ?>" data-toggle="tooltip" title="Details Mading" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search"></i></a>
                  <a onclick="return confirm('Apakah anda yakin?, Aksi ini tidak dapat di ulangi')" href="data_mading.php?delete=<?php echo $data['ID_mading'] ?>" data-toggle="tooltip" title="Delete Mading" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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
