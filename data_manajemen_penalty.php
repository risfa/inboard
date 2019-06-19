<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
?>

<?php 
	if(isset($_GET['delete_penalty'])){
		$delete = mysql_query("DELETE FROM tb_penalty WHERE ID_penalty = '$_GET[delete_penalty]'");
		if($delete){
			echo '<script type="text/javascript">
    iziToast.success({
      title: "OK",
      message: "Data has been Succesfully Delete!",
    });
    </script>';
    echo "<script>document.location.href='data_manajemen_penalty.php'</script>";
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
          <div class="col-md-4">
            <h2 style="font-size: 20px;margin: 13px;">Data Manajemen Penalty</h2>
          </div>
          <div class="col-md-8">
            <a href="penalty.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;TAMBAH DATA PENALTY</button></a><br>
             
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
          <thead>
            <tr>
              <th style="width: 20px;">No</th>
              <th style="width: 40px;">Nama</th>
              <th style="width: 20px;">Depatement / Jabatan</th>
              <th style="width: 20px;">Keterangan Penalty</th>
              <th style="width: 20px;">Nominal Penalty</th>
              <th style="width: 20px;">Tanggal</th>

              <th class="text-center" style="width: 10px;"><i class="fa fa-flash"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = mysql_query("SELECT * FROM tb_penalty JOIN tb_karyawan ON tb_penalty.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_department ON tb_karyawan.departement = tb_department.ID JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID");
            while($data= mysql_fetch_array($sql)){
              ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo "<b>".$data['nama_lengkap']."</b>"?></td>
                <td><?php echo "<b>".$data['nama_department']."</b><br>[".$data['nama_jabatan']."]";  ?></td>
                <td><?php echo $data['keterangan']; ?></td>
                <td><?php echo $data['Nominal_penalty']?></td>
                <td><?php echo "<b>".$data['Tanggal']."</b>"; ?></td>
                <td>
                  <a href="penalty.php?edit=<?php echo $data['ID_penalty'] ?>" data-toggle="tooltip" title="Edit Penalty" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>

                  <a href="detail_penalty.php?details=<?php echo $data['ID_penalty'] ?>" data-toggle="tooltip" title="Details Penalty" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search"></i></a>

                  <a onclick="return confirm('Apakah anda yakin?, Aksi ini tidak dapat di ulangi')" href="data_manajemen_penalty.php?delete_penalty=<?php echo $data['ID_penalty'] ?>" data-toggle="tooltip" title="Delete Penalty" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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
                    <h3 class="modal-title"><strong> Permohonan Perubahan Data Karyawan </strong></h3>
                </div>
                <div class="modal-body" style="height:auto;">
                    <table class="table table-striped">
                        <thead style="font-weight: bolder;">
                            <td>No</td>
                            <td>Nama</td>
                            <td>Keluhan</td>
                            <td>Waktu</td>
                        </thead>
                        <?php
                          $No= 1; 
                          $tampil_data = mysql_query("SELECT tb_ubah_data.*,tb_karyawan.*,tb_jabatan.*, tb_department.* FROM tb_ubah_data JOIN tb_karyawan ON tb_ubah_data.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_department.ID = tb_karyawan.departement");
                           while($tampil = mysql_fetch_array($tampil_data)){
                         ?>
                        <tr>
                            <td><?php echo $No++; ?></td>
                            <td><?php echo "<b>".$tampil['nama_lengkap']."</b><br>[".$tampil['nama_jabatan']."]<br>[".$tampil['nama_department']."]";  ?></td>
                            <td><?php echo $tampil['keterangan'] ?></td>
                            <td><?php echo $tampil['waktu'] ?></td>
                            <td>
                              <a onclick="return confirm('Apakah anda yakin? Aksi ini tidak dapat di ulangi')" href="data_karyawan.php?delete_notifikasi=<?php echo $tampil['ID_ubah_data'] ?>" data-toggle="tooltip" title="Delete" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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
