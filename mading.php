<?php
    include 'inc/config.php'; ;
    include 'inc/template_start.php';
    include 'inc/page_head.php';
    include ('Db/connect.php');
    include 'wa.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Karyawan</title>
    <!-- <script src="//cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script> -->
    <script type="text/javascript">

    </script>
     <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>
<?php
    if(isset($_POST['simpan_mading'])){
                $insert_mading = mysql_query("INSERT INTO tb_mading(ID_mading, judul,isi,link) VALUES(NULL,'$_POST[judul]','$_POST[isi]','$_POST[link]')");


$ID_mading = mysql_insert_id();
        if($insert_mading){

          $notifikasiSimpan = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$$_SESSION[ID_karyawan]','Anda Telah memasukan informasi baru',0,'insert')");

            move_uploaded_file($_FILES["fileToUpload_mading"]["tmp_name"],"img/mading/".$ID_mading.".jpg");
    
        send_wa_all($_POST['judul'],'MADING','inboard.ardgroup.co.id');

             echo "<script>document.location.href='mading.php'</script>";

        }else{
        echo '<script type="text/javascript">
      iziToast.error({
        title: "NO",
        message: "Gagal masukan data anda!",
      });
      </script>';

      }
    }
    if(isset($_POST['update'])){
    	$update_mading = mysql_query("UPDATE tb_mading SET judul = '$_POST[judul]', isi = '$_POST[isi]',link = '$_POST[link]' WHERE ID_mading = '$_GET[edit]'");
    	$ID_mading = $_GET['edit'];
    	if($update_mading){
        $selectKaryawan = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$_GET[edit]' ");
        $keterangan_update = $showKaryawan[0]."Anda Baru Saja Mengupdate Informasi ";

        $notifikasiSimpan = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$$_SESSION[ID_karyawan]','$keterangan_update',0,'update')");

    		move_uploaded_file($_FILES["fileToUpload_mading"]["tmp_name"],"img/mading/".$ID_mading.".jpg");
    

  }else{
    echo "<script>alert('Faile Delete')</script>";
    echo "<script>document.location.href='data_mading.php'</script>";
    	}
    }
    if(isset($_GET['edit'])){
    	$edit_mading = mysql_fetch_array(mysql_query("SELECT * FROM tb_mading WHERE ID_mading = '$_GET[edit]'"));
    }
?>

<!-- Page content -->


<div id="page-content">
    <div class="block full">
        <div class="block-title">
            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-size: 20px;margin: 13px;">MADING</h2>
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
                        <label class="col-md-3 control-label">JUDUL</label>
                        <div class="col-md-9">
                            <input type="text"  name="judul" class="form-control" value="<?php echo $edit_mading['judul'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">ISI</label>
                        <div class="col-md-9">
                          <textarea class="ckeditor" name="isi" id="ckeditor"><?php echo $edit_mading['isi'] ?></textarea>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">LINK</label>
                        <div class="col-md-9">
                            <input type="text"  name="link" class="form-control" value="<?php echo $edit_mading['link'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-file-input">GAMBAR MADING</label>
                        <div class="col-md-9">
                    <?php
                  if (file_get_contents("img/mading/.jpg") != '' ) {
              ?>

                  <img src="img/mading/<?php echo $_GET['edit']; ?>.jpg"  width="100px" height="100px">
              <?php
                  }else{
//                    echo "Anda Belum Upload File";
                  }
               ?>

                <div class="col-md-9">
                  <input type="file" id="fileToUpload_mading" name="fileToUpload_mading">
                </div>
              </div>

              <div class="form-group form-actions" style="background: none;">
              <div class="col-md-12 ">
                <?php if(!$_GET['edit']){ ?>
                  <input type="submit" name="simpan_mading" value="SIMPAN DATA MADING" class="btn btn-success">
                  <a href="data_mading.php" class="btn btn-danger">BATALKAN PENGISIAN</a>
                <?php }else{ ?>
                  <input type="submit" name="update" value="PERBAHARUI DATA MADING" class="btn btn-info">
                  <a href="data_mading.php" class="btn btn-danger">BATALKAN PERUBAHAN</a>
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
