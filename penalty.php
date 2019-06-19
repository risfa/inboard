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
    
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    
    <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>
<?php 


    if(isset($_POST['simpan_penalty'])){
        $ID_karyawan = $_POST['ID_karyawan'];
        $Tanggal = $_POST['Tanggal'];
        $keterangan = $_POST['keterangan'];
        $Nominal_penalty = $_POST['Nominal_penalty'];
                $insert_penalty = mysql_query("INSERT INTO tb_penalty(ID_penalty,ID_karyawan,keterangan,Nominal_penalty,Tanggal) VALUES(NULL,'$_POST[ID_karyawan]','$_POST[keterangan]','$_POST[Nominal_penalty]','$_POST[Tanggal]')");
        
        if($insert_penalty){
            $sql = mysql_fetch_array(mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$ID_karyawan'"));
            //NOTIFIKASI WA
            $variable = " 
Nama Karyawan: *".$sql['nama_lengkap']."*
Jabatan: *".$sql['nama_jabatan']."*
Departement: *".$sql['nama_department']."*
Perusahaan: *".$sql['perusahaan']."*  
Tanggal Penalty: *".$Tanggal."* 
Nominal Penalty : *".$Nominal_penalty."* ";

             $message = "
Anda Mendapatkan Review Sebagai berikut : ".$variable."";

          send_wa($sql['no_telp'],$message,'PENALTY');
             //END
       echo '<script type="text/javascript">
     iziToast.success({
       title: "OK",
       message: "Data anda berhasil disimpan!",
     });
     </script>';

             echo "<script>document.location.href='data_manajemen_penalty.php'</script>";

        }else{
        echo '<script type="text/javascript">
      iziToast.error({
        title: "NO",
        message: "Gagal masukan data anda!",
      });
      </script>';

      }
    }
    if(isset($_POST['update_penalty'])){
    	$update_penalty = mysql_query("UPDATE tb_penalty SET ID_karyawan = '$_POST[ID_karyawan]', keterangan = '$_POST[keterangan]',Nominal_penalty = '$_POST[Nominal_penalty]',Tanggal = '$_POST[Tanggal]' WHERE ID_penalty = '$_GET[edit]'");
    	// $ID_mading = $_GET['edit'];
    	if($update_penalty){
    		
    		echo '<script type="text/javascript">
    iziToast.success({
      title: "OK",
      message: "Data has been Succesfully Update record!",
    });
    </script>';
    echo "<script>document.location.href='data_manajemen_penalty.php'</script>";
 
  }else{
    echo "<script>alert('Faile Delete')</script>";
    echo "<script>document.location.href='penalty.php'</script>";
    	}
    }
    if(isset($_GET['edit'])){
    	$edit_penalty = mysql_fetch_array(mysql_query("SELECT * FROM tb_penalty JOIN tb_karyawan ON tb_penalty.ID_karyawan = tb_karyawan.ID_karyawan WHERE ID_penalty = '$_GET[edit]'"));

      $ID_penalty = $_GET['edit'];
      $tampil_karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$edit_penalty[ID_karyawan]'"));
  
    }

    if(isset($_POST['ID_karyawan'])){
      $ID_karyawan = $_POST['ID_karyawan'];
      $tampil_karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$ID_karyawan'"));
        // echo "<script>alert('yeay')</script>";
    }
?>
<!-- Page content -->


<div id="page-content">
    <div class="block full">
        <div class="block-title">
            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-size: 20px;margin: 13px;">DAFTAR PENALTY KARYAWAN</h2>
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
                        <label class="col-md-3 control-label" for="example-clickable-password2">Nama Karyawan</label>
                        <div class="col-md-9">
                        <?php if(isset($_POST['ID_karyawan'])=="" && empty($_GET['edit'])){ ?>
                          <select id="ID_karyawan" name = "ID_karyawan" class="select-chosen" size="1" onchange="submit();" value="<?php echo $edit_penalty['ID_karyawan'] ?>">
                            <option value="<?php echo $edit_penalty['ID_karyawan'] ?>"><?php echo $edit_penalty['nama_lengkap']; ?></option>
                            
                            <?php 
                              $karyawan = mysql_query("SELECT * FROM tb_karyawan");
                              while($data = mysql_fetch_array($karyawan)){
                             ?>
                            <option value="<?php echo $data['ID_karyawan'] ?>"><?php echo $data['nama_lengkap'] ?></option>
                            <?php } ?>
                    
                          </select>
                        <?php }else{ ?>
                        	<div style="font-size: 15px;">
                            <input type="hidden" name="ID_karyawan" value="<?php echo $tampil_karyawan['ID_karyawan'] ?>">
                        		<input type="hidden" name="ID_karyawan_2" value="<?php echo $edit_penalty['ID_karyawan'] ?>">
                        		<?php 
                        			echo "<h4>Informasi Karyawan</h4>";
                        			echo $tampil_karyawan['nama_lengkap']."<br>".$tampil_karyawan['nama_jabatan']."<br>".$tampil_karyawan['nama_department'];
                              if(!$_GET['edit']){
                                echo "<br><a href='penalty.php'><lable class='label label-danger'>BATALKAN</label></a>";
                              }
                        		?>
                        	</div>
                        <?php } ?>

                        </div>

                    </div> 

                    

                    <div class="form-group">
                        <label class="col-md-3 control-label">Nominal Penalty</label>
                        <div class="col-md-9">
                            <input type="text"  name="Nominal_penalty" class="form-control" value="<?php echo $edit_penalty['Nominal_penalty'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Keterangan Penalty</label>
                        <div class="col-md-9">
                           <textarea name="keterangan" class="ckeditor" value="<?php echo $edit_penalty['keterangan'] ?>" required><?php echo $edit_penalty['keterangan'] ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal</label>
                        <div class="col-md-9">
                           <input type="text" id="example-datepicker-kerja" name="Tanggal" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $edit_penalty['Tanggal'] ?>" required>
                        </div>
                    </div>

              <div class="form-group form-actions" style="background: none;">
              	<div class="col-md-3">&nbsp;</div>
              <div class="col-md-8 ">
                <?php if(!$_GET['edit']){ ?>
                  <input type="submit" name="simpan_penalty" value="SIMPAN" class="btn btn-success">
                  <a href="data_manajemen_penalty.php" class="btn btn-danger">BATALKAN PENGISIAN</a>
                <?php }else{ ?>
                  <input type="submit" name="update_penalty" value="PERBAHARUI PENALTY" class="btn btn-info">
                  <a href="data_manajemen_penalty.php" class="btn btn-danger">BATALKAN PERUBAHAN</a>
                <?php } ?>                
                        </div>
                    </div>
                </div>
                <div class="col-md-5" style="font-size:15px;">
                	<p>Penting Untuk Di Perhatikan</p>
                <ol>
                	<li>Setiap selesai pengisian data, akan ada notifikasi terkait hal tersebut (penalty) ke atasan, HRD, dan orang yang terkena masalah tersebut</li>
                	<li>Penalty dapat dihapus apabila masalah tersebut sudah selesai</li>
                </ol>
                </div>
            </div>
        </form>



    </div>
</div>
<!-- END OLD PAGE CONTENT -->
</div>
</body>
</html>




<script type="text/javascript">
  $( "#ID_karyawan" ).val();
  document.getElementById('ID_karyawan').value = "<?php echo $_GET['ID_karyawan'];?>";
</script>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->

<script src="js/pages/readyDashboard.js"></script>
<!-- <script>$(function(){ ReadyDashboard.init(); });</script> -->

<?php include 'inc/template_end.php';

?>
