<?php
include 'inc/config.php'; ;
include 'inc/template_start.php';
include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';

if(isset($_POST['insert_sop'])){
	$sop_insert=mysql_query("INSERT INTO `tb_sop_perusahaan`(`id_sop_perusahaan`, `judul_sop`, `keterangan_sop`) VALUES (NULL,'$_POST[judul_sop]','$_POST[keterangan_sop]')");
	$id_sop = mysql_insert_id();
	if($sop_insert){
		$upload = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"img/Sop_Perusahaan/".$id_sop.".pdf");
		if(upload){
			echo"<script>alert('berhasil upload gambar')</script>";
         }else{
            echo"<script>alert('tidak berhasil upload gambar')</script>";
         }

		echo "<script>alert('Berhasil Insert SOP')</script>";
		echo "<script>document.location.href='sop_perusahaan.php'</script>";
	}else{
		echo "<script>alert('Tidak Berhasil Insert SOP')</script>";
		echo "<script>document.location.href='form_sop.php'</script>";
	}
}

if(isset($_POST['update_sop'])){
	$idsop = $_POST['id_sop_perusahaan'];
	$sop_update=mysql_query("UPDATE `tb_sop_perusahaan` SET `judul_sop`='$_POST[judul_sop]',`keterangan_sop`='$_POST[keterangan_sop]' WHERE id_sop_perusahaan = '$idsop' ");
	if($sop_update){
		$update = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"img/Sop_Perusahaan/".$idsop.".pdf");
		if(update){
			echo"<script>alert('berhasil update file')</script>";
         }else{
            echo"<script>alert('tidak berhasil update file')</script>";
         }

		echo "<script>alert('Berhasil Update SOP')</script>";
		echo "<script>document.location.href='sop_perusahaan.php'</script>";
	}else{
		echo "<script>alert('Tidak Berhasil Update SOP')</script>";
		echo "<script>document.location.href='form_sop.php'</script>";
	}
}
$data_sop = mysql_fetch_array(mysql_query("SELECT * FROM tb_sop_perusahaan WHERE id_sop_perusahaan = '$_GET[edit]'"));
?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
	<script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.6/bootstrap-clockpicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.6/jquery-clockpicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.6/bootstrap-clockpicker.min.css">
	<link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>
	<!-- Page content -->
	<div id="page-content">
		<div class="block full">
			<div class="block-title">
				<div class="row">
					<div class="col-md-8">
						<h2 style="font-size: 20px;margin: 13px;">Formulir Tambah SOP</h2>
					</div>
					<div class="col-md-4">
						<a href="sop_perusahaan.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
					</div>
				</div>
			</div>
			<form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
				<div class="row" style="padding:20px;">
					<div class="col-md-7">
					<input type="hidden" name="id_sop_perusahaan" class="form-control" autocomplete="off" value="<?php echo $data_sop['id_sop_perusahaan'] ?>" required>

						<div class="form-group">
							<label class="col-md-3 control-label">JUDUL SOP</label>
							<div class="col-md-9">
								<input type="text" name="judul_sop" class="form-control" autocomplete="off" value="<?php echo $data_sop['judul_sop'] ?>" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Deskripsi SOP</label>
							<div class="col-md-9">
								<textarea name="keterangan_sop" class="form-control" required=""><?php echo $data_sop['keterangan_sop'] ?></textarea>

							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">File Pendukung</label>
							<div class="col-md-9">
								<input type="file" name="fileToUpload" id="fileToUpload">
								<?php if($_GET['edit']){?>
								<img src="img/Sop_Perusahaan/<?php echo $_GET['edit'] ?>.pdf"> 
								<?php } ?>
								<br>

								<br>
								<?php if($_GET['edit']){ ?>
								<input type="submit" class="btn btn-primary" name="update_sop" value="UPDATE">
								<?php }else{ ?>
								<input type="submit" class="btn btn-success" value="SIMPAN SOP" name="insert_sop" id="">
								<?php } ?>
								<br>

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


<script type="text/javascript">
	$('.clockpicker').clockpicker();
</script>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyDashboard.js"></script>


<?php include 'inc/template_end.php';

?>
