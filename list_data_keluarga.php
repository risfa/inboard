<?php include 'inc/config.php';?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');

$dataKaryawan = mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_karyawan` where status = 1 ");
$jumlahDataKaryawanAktif = mysql_fetch_array($dataKaryawan);

$dataKaryawanDisaktif = mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_karyawan` where status = 0");
$jumlahDataKaryawanDisaktif = mysql_fetch_array($dataKaryawanDisaktif);

$sqlTotalKaryawan = mysql_query("SELECT COUNT(ID_karyawan) FROM `tb_karyawan`");
$totalKaryawan = mysql_fetch_array($sqlTotalKaryawan);
// end
if(isset($_GET['delete'])){
    $selectNamaKaryawan = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan='$_GET[delete]' ");
    $dataNamaKaryawan = mysql_fetch_array($selectNamaKaryawan);
    $sqldelete = mysql_query("DELETE FROM tb_karyawan WHERE ID_karyawan='$_GET[delete]'");
    $delete = mysql_query("DELETE FROM tb_bank WHERE ID_karyawan='$_GET[delete]'");
    $delete = mysql_query("DELETE FROM tb_login WHERE ID_karyawan='$_GET[delete]'");

    $ID_karyawan_foto = $_GET['delete'];
    if($sqldelete){


        $keterangan_status = 'Anda baru saja mendelete akun '.$dataNamaKaryawan[0];


        $notifikasiSimpan = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_GET[delete]','$keterangan_status',0,'delete')");

        $filePath = "img/KTP/".$ID_karyawan_foto.".jpg";
        $filePath = "img/PasFoto/".$ID_karyawan_foto.".jpg";
        $filePath = "img/akta/".$ID_karyawan_foto.".jpg";
        $filePath = "img/CV/".$ID_karyawan_foto.".jpg";

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
<div id="page-content">
    <div class="block full">
        <div class="block-title">
            <div class="row">
                <div class="col-md-3">
                    <h2 style="font-size: 20px;margin: 13px;">Data Keluarga Karyawan</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- <div class="col-sm-6 col-lg-4">
                <a href="list_data_karyawan.php?aktif=true" class="widget">
                    <div class="widget-content widget-content-mini text-right clearfix" style="background:#f9f9f9; border: 1px solid #ebeef2;">
                        <div class="widget-icon pull-left themed-background-success">
                            <i class="fa fa-users" style="color: #fff;"></i>
                        </div>
                        <h2 class="widget-heading h3 ">

                            <strong><span data-toggle="counter" data-to="2835"><?php echo $jumlahDataKaryawanAktif[0]; ?></span></strong>
                        </h2>
                        <span class="text-muted">Karyawan Aktif</span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-4">
                <a href="list_data_karyawan.php?disaktif=true" class="widget">
                    <div class="widget-content widget-content-mini text-right clearfix" style="background:#f9f9f9; border: 1px solid #ebeef2;">
                        <div class="widget-icon pull-left themed-background-danger">
                            <i class="fa fa-users" style="color: #fff;"></i>
                        </div>
                        <h2 class="widget-heading h3 ">
                            <strong><span data-toggle="counter" data-to="2835"><?php echo $jumlahDataKaryawanDisaktif[0]; ?></span></strong>
                        </h2>
                        <span class="text-muted">Karyawan Tidak Aktif</span>
                    </div>
                </a>
            </div> -->

            <!-- <div class="col-sm-6 col-lg-4" >
                <a href="list_data_karyawan.php?all=true" class="widget" style="background:#f9f9f9; border: 1px solid #ebeef2;">
                    <div class="widget-content widget-content-mini text-right clearfix">
                        <div class="widget-icon pull-left themed-background-info">
                            <i class="fa fa-users" style="color: #fff;"></i>
                        </div>
                        <h2 class="widget-heading h3">
                            <strong><span data-toggle="counter" data-to="75"><?php echo $totalKaryawan[0]; ?></span></strong>
                        </h2>
                        <span class="text-muted">Total Karyawan</span>
                    </div>
                </a>
            </div> -->

        </div>
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                <tr>
                    <th style="width: 20px;">Nama Karyawan</th>
                    <th style="width: 20px;">NIK</th>
                    <th style="width: 40px;">Nama / Jenis Kelamin</th>
                    <th style="width: 20px;">Tanggal Lahir</th>
                    <th style="width: 20px;">Hubungan</th>
                    <th style="width: 20px;">Alamat Keluarga</th>
                    <th style="width: 20px;">Telp Keluarga</th>
                    <th style="width: 20px;">faskes_tk1</th>
                    <th style="width: 20px;">faskes dr gigi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $sql_keluarga = mysql_query("SELECT * FROM tb_keluarga JOIN tb_karyawan ON tb_keluarga.ID_karyawan = tb_karyawan.ID_karyawan ORDER BY tb_keluarga.ID_keluarga DESC");

                while($data= mysql_fetch_array($sql_keluarga)){
                    ?>
                    <tr>
                        <td><?php echo $data['nik']; ?></td>
                        <td><?php echo $data['nama']."<br>".$data['jenis_kelamin'] ?></td>
                        <td><?php echo $data['tanggal_lahir']; ?></td>
                        <td><?php echo $data['hubungan']?></td>
                        <td><?php echo $data['alamat_keluarga'] ?></td>
                        <td><?php echo $data['telp_keluarga']?></td>
                        <td><?php echo $data['faskes_tk1']?></td>
                        <td><?php echo $data['faskes_dr_gigi']?></td>
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
