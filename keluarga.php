<?php include 'inc/config.php'; $template['header_link'] = 'WELCOME'; 
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
if(isset($_POST['update'])){
        $sql_udpate = mysql_query("UPDATE tb_keluarga SET nama = '$_POST[nama]', jenis_kelamin = '$_POST[jenis_kelamin]', tgl_lahir = '$_POST[tgl_lahir]', hubungan = '$_POST[hubungan]', telp = '$_POST[telp]', status = '$_POST[status]', keterangan = '$_POST[keterangan]', ID_karyawan = '$_POST[ID_karyawan]' WHERE ID_keluarga = '$_GET[edit]'");
        
        if($sql_udpate){
        
            echo '<script type="text/javascript">
                 iziToast.success({
                  title: "OK",
                 message: "Data has been Succesfully Updated record!",
                   });
                   </script>';
             echo "<script>document.location.href='data_keluarga.php'</script>";
            
        }else{
            echo "<script>alert('Failed Update!')</script>";
            echo "<script>document.location.href='data_keluarga.php'</script>";
        }
    }
    if(isset($_POST['simpan'])){
        $sql_simpan = mysql_query("INSERT INTO `tb_keluarga` (`ID_keluarga`, `nama`, `jenis_kelamin`, `tgl_lahir`, `hubungan`, `telp`, `status`, `keterangan`) VALUES (null, '$_POST[nama]','$_POST[jenis_kelamin]','$_POST[tgl_lahir]','$_POST[hubungan]','$_POST[telp]','$_POST[status]','$_POST[keterangan]')");
        // $data_gambar = mysql_insert_id();
        
        if($sql_simpan == true){

            

         echo '<script type="text/javascript">
                 iziToast.success({
                  title: "OK",
                 message: "Data has been Succesfully inserted record!",
                   });
                   </script>';
       
        }else{
            echo "<script>alert('Failed save!')</script>";
            echo "<script>document.location.href='keluarga.php'</script>";
        }
    }
    if(isset($_GET['edit'])){
        $data_edit = mysql_fetch_array(mysql_query("SELECT * FROM tb_keluarga WHERE ID_keluarga = '$_GET[edit]'"));
    }
 ?>

<!-- Page content -->
<div id="page-content" style="">
    <div class="container" style="padding-left: 40px; padding-right: 40px; margin-top: 40px; margin-bottom: 25px;"> 

                <div class="col-xs-1"></div>
                <div class="col-xs-10" style="background-color: white;">
                <div class="block-title" style="background-color: white;">
                    <div class="block-options pull-right">
                        <a href="data_keluarga.php" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" title="Back to Data Karyawan"><i class="fa fa-user"></i></a>
                    </div>
                    <h2>Data Keluarga</h2>
                </div>
                <!-- END Clickable Wizard Title -->
                <br>
                <!-- Clickable Wizard Content -->
                <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                    <!-- First Step -->
                    <div id="clickable-first" class="step">
                        <!-- Step Info -->
                        <div class="form-group">
                          
                            <div class="col-xs-12">
                                <ul class="nav nav-pills nav-justified clickable-steps">
                                    <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-first"><i class="fa fa-user"></i> <strong>Data Keluarga</strong></a></li>
                                   
                                </ul>
                            </div>
                        </div>
                        <!-- END Step Info -->
                        <div class="form-group">
                            <div class="col-md-6">
                                <input type="hidden" name="ID_keluarga" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Nama Lengkap</label>
                            <div class="col-md-6">
                                <input type="text" name="nama" class="form-control" value="<?php echo $data_edit['nama'] ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-4 control-label" for="example-select">Jenis Kelamin</label>
                        <div class="col-md-6">
                            <select name="jenis_kelamin" class="form-control" size="1" value="<?php echo $data_edit['jenis_kelamin'] ?>" required>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="example-clickable-password2">Tanggal Lahir</label>
                             <div class="col-md-6">
                            <input type="text" name="tgl_lahir" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $data_edit['tgl_lahir'] ?>" required>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="example-select">Hubungan</label>
                            <div class="col-md-6">
                                <input type="text" name="hubungan" class="form-control" value="<?php echo $data_edit['hubungan'] ?>" required>
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                            <label class="col-md-4 control-label" >No Handphone</label>
                            <div class="col-md-6">
                                <input type="text"  name="telp" class="form-control" value="<?php echo $data_edit['telp'] ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" >Status</label>
                            <div class="col-md-6">
                                <input type="text"  name="status" class="form-control" value="<?php echo $data_edit['status'] ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" >Keterangan</label>
                            <div class="col-md-6">
                                <input type="text"  name="keterangan" class="form-control" value="<?php echo $data_edit['keterangan'] ?>" required>
                            </div>
                        </div>
                    <!-- END First Step -->


                    <!-- Form Buttons -->
                    <div class="form-group form-actions" style="background: none;">
                        <div class="col-md-7 col-md-offset-5">
                            <?php if(!$_GET['edit']){ ?>
                            <input type="submit" name="simpan" value="SAVE" class="btn btn-success">
                            <a href="data_keluarga.php" class="btn btn-danger">CANCEL</a>
                            <?php }else{ ?>
                            <input type="submit" name="update" value="UPDATE" class="btn btn-info">
                            <a href="data_keluarga.php" class="btn btn-danger">CANCEL</a>

                <?php } ?>
                        </div>
                    </div>
                    <!-- END Form Buttons -->
                </form>
                
                <!-- END Clickable Wizard Content -->
            </div>
            </div>  
                <div class="col-xs-1"></div>
        </div>
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