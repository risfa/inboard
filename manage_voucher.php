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
    if(isset($_POST['simpan_voucher'])){
                $insert_mading = mysql_query("INSERT INTO tb_voucher(ID_voucher, judul_voucher,nomor_voucher,kategori_voucher) VALUES(NULL,'$_POST[judul_voucher]','$_POST[nomor_voucher]','$_POST[kategori_voucher]')");
        if($insert_mading){
            
       echo '<script type="text/javascript">
     iziToast.success({
       title: "OK",
       message: "Data anda berhasil disimpan!",
     });
     </script>';

             echo "<script>document.location.href='data_manage_voucher.php'</script>";

        }else{
        echo '<script type="text/javascript">
      iziToast.error({
        title: "NO",
        message: "Gagal masukan data anda!",
      });
      </script>';

      }
    }
    if(isset($_POST['update_voucher'])){
    	$update_mading = mysql_query("UPDATE tb_voucher SET judul_voucher = '$_POST[judul_voucher]', nomor_voucher = '$_POST[nomor_voucher]',kategori_voucher = '$_POST[kategori_voucher]' WHERE ID_voucher = '$_GET[edit]'");
    	// $ID_mading = $_GET['edit'];
    	if($update_mading){
    		
    		echo '<script type="text/javascript">
    iziToast.success({
      title: "OK",
      message: "Data has been Succesfully Update record!",
    });
    </script>';
    echo "<script>document.location.href='data_manage_voucher.php'</script>";
 
  }else{
    echo "<script>alert('Faile Delete')</script>";
    echo "<script>document.location.href='data_manage_voucher.php'</script>";
    	}
    }
    if(isset($_GET['edit'])){
    	$edit_mading = mysql_fetch_array(mysql_query("SELECT * FROM tb_voucher WHERE ID_voucher = '$_GET[edit]'"));
    }
?>

<!-- Page content -->


<div id="page-content">
    <div class="block full">
        <div class="block-title">
            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-size: 20px;margin: 13px;">MANAJEMEN VOUCHER</h2>
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
                        <label class="col-md-3 control-label">Judul Voucher</label>
                        <div class="col-md-9">
                            <input type="text"  name="judul_voucher" class="form-control" value="<?php echo $edit_mading['judul_voucher'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Nomor Voucher</label>
                        <div class="col-md-9">
                            <input type="text"  name="nomor_voucher" class="form-control" value="<?php echo $edit_mading['nomor_voucher'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">Kategori</label>
                        <div class="col-md-9">
                          <select name="kategori_voucher" class="form-control">
                            <option value="GRAB ARDENCY">GRAB ARDENCY</option>
                            <option value="GRAB USI">GRAB USI</option>
                          </select>
                            
                        </div>
                    </div>

              <div class="form-group form-actions" style="background: none;">
              <div class="col-md-12 ">
                <?php if(!$_GET['edit']){ ?>
                  <input type="submit" name="simpan_voucher" value="SIMPAN KODE VOUCHER" class="btn btn-success">
                  <a href="data_manage_voucher.php" class="btn btn-danger">BATALKAN PENGISIAN</a>
                <?php }else{ ?>
                  <input type="submit" name="update_voucher" value="PERBAHARUI KODE VOUCHER" class="btn btn-info">
                  <a href="data_manage_voucher.php" class="btn btn-danger">BATALKAN PERUBAHAN</a>
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
