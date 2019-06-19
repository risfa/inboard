<?php
    include 'inc/config.php'; ;
    include 'inc/template_start.php';
    include 'inc/page_head.php';
    include ('Db/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Karyawan</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>
<?php
   
    if(isset($_POST['update_cuti'])){
    	$update_cuti = mysql_query("UPDATE tb_master_cuti SET jumlah_cuti = '$_POST[jumlah_cuti]', tahun = '$_POST[tahun]',keterangan_cuti = '$_POST[keterangan_cuti]' WHERE ID_master_cuti = '$_GET[edit]'");
    	// $ID_mading = $_GET['edit'];
    	if($update_cuti){
    		
            $selectKaryawan = mysql_query("SELECT nama_lengkap from tb_karyawan JOIN tb_master_cuti ON tb_karyawan.ID_karyawan = tb_master_cuti.ID_karyawan where ID_master_cuti = '$_GET[edit]' ");
          $showKaryawan = mysql_fetch_array($selectKaryawan);

          $keterangan_update = "Anda Baru saja mengubah kuota cuti karyawan atas nama ".$showKaryawan[0];

          $notifikasiUpdate = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_GET[edit]','$keterangan_update',0,'update')");

    echo '<script type="text/javascript">
    iziToast.success({
      title: "OK",
      message: "Data has been Succesfully Update record!",
    });
    </script>';
    echo "<script>document.location .href='manajemen_kuota_cuti.php'</script>";
 
  }else{
    echo "<script>alert('Faile Delete')</script>";
    echo "<script>document.location.href='manajemen_kuota_cuti.php'</script>";
    	}
    }
    if(isset($_GET['edit'])){
    	$edit_cuti = mysql_fetch_array(mysql_query("SELECT * FROM `tb_master_cuti` JOIN tb_karyawan ON tb_master_cuti.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID  WHERE ID_master_cuti = '$_GET[edit]'"));
    }
?>

<!-- Page content -->


<div id="page-content">
    <div class="block full">
        <div class="block-title">
            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-size: 20px;margin: 13px;">MANAJEMEN CUTI</h2>
                </div>
                <div class="col-md-4">
                    <br>
                </div>
            </div>
        </div>
        <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
            <div class="row" style="padding:20px;">
                <div class="col-md-7">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Nama</label>
                        <div class="col-md-9">
                            <input type="text" readonly name="nama_lengkap" class="form-control" value="<?php echo $edit_cuti['nama_lengkap'] ?>" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Jabatan & Departement</label>
                        <div class="col-md-9">
                            <input type="text" readonly name="" class="form-control" value="<?php echo $edit_cuti['nama_jabatan']." - ".$edit_cuti['nama_department'] ?>" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">Kuota Cuti</label>
                        <div class="col-md-9">
                          
                            <input type="text"  name="jumlah_cuti" class="form-control" value="<?php echo $edit_cuti['jumlah_cuti'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">Tahun Cuti</label>
                        <div class="col-md-9">
                          
                            <input type="text"  name="tahun" class="form-control" value="<?php echo $edit_cuti['tahun'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">Keterangan Cuti</label>
                        <div class="col-md-9">
                          
                            <input type="text"  name="keterangan_cuti" class="form-control" value="<?php echo $edit_cuti['keterangan_cuti'] ?>" required>
                        </div>
                    </div>

              <div class="form-group form-actions" style="background: none;">
              <div class="col-md-12 ">
                <?php if(!$_GET['edit']){ ?>
                  <input type="submit" name="simpan_cuti" value="SIMPAN" class="btn btn-success">
                  <a href="manajemen_kuota_cuti.php" class="btn btn-danger">BATALKAN PENGISIAN</a>
                <?php }else{ ?>
                  <input type="submit" name="update_cuti" value="PERBAHARUI CUTI" class="btn btn-info">
                  <a href="manajemen_kuota_cuti.php" class="btn btn-danger">BATALKAN PERUBAHAN</a>
                <?php } ?>                
                        </div>
                    </div>


                </div>
                
            </div>
        </form>



    </div>
</div>
<!-- END OLD PAGE CONTENT -->
</div>
</body>
</html>



<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyDashboard.js"></script>
<!-- <script>$(function(){ ReadyDashboard.init(); });</script> -->

<?php include 'inc/template_end.php';

?>
