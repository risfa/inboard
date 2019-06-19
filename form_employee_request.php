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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>
    <?php
    $data_edit = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$_SESSION[ID_karyawan]'"));
    $ID_karyawan = $_SESSION['ID_karyawan'];

    function fetch_karyawan($id_karyawan){
     $sql = mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '".$id_karyawan."' ");
     return mysql_fetch_array($sql);
 }

 if(isset($_POST['emp_req'])){
    $tampil_data = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = 6"));
 	$data_karyawan = fetch_karyawan($_SESSION[ID_karyawan]);
 	if($_POST['kategori_request']=='Teknis'){
    $emp= mysql_query("INSERT INTO tb_employee_req(ID_emp_req,ID_karyawan,tanggal_pengajuan,kategori_request,keterangan,kualifikasi,Status_request,Approve_By) VAlUES(NULL,'$ID_karyawan','$_POST[tanggal_pengajuan]','$_POST[kategori_request]','$_POST[keterangan]','$_POST[kualifikasi]','DALAM PENGAJUAN','6')");

    $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$_POST['tanggal_pengajuan']."* 
Deskripsi Keluhan: *".$_POST['keterangan']."* 
Kualifikasi: *".$_POST['kualifikasi']."* 
Klik Link Dibawah ini :
";


             $message = "
Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";

             send_wa('6285693993232',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
             send_wa('6281291305529',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');

    $kirim_ke_atasan = send_wa('628161988871',"Keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$_POST['tanggal_pengajuan']."* Dengan Deskripsi *".$_POST['keterangan']."* Dan Kualifikasi *".$_POST['kualifikasi']."* Ditujukan kepada *".$tampil_data['nama_lengkap']."*  klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    $kirim_ke_atasan1 = send_wa('62816767176',"Keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$_POST['tanggal_pengajuan']."* Dengan Deskripsi *".$_POST['keterangan']."* Dan Kualifikasi *".$_POST['kualifikasi']."* Ditujukan kepada *".$tampil_data['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
 
    }else if($_POST['kategori_request']=='Administrasi'){
        $tampil = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = 16"));
    $emp= mysql_query("INSERT INTO tb_employee_req(ID_emp_req,ID_karyawan,tanggal_pengajuan,kategori_request,keterangan,kualifikasi,Status_request,Approve_By) VAlUES(NULL,'$ID_karyawan','$_POST[tanggal_pengajuan]','$_POST[kategori_request]','$_POST[keterangan]','$_POST[kualifikasi]','DALAM PENGAJUAN','16')");
$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$_POST['tanggal_pengajuan']."* 
Deskripsi Keluhan: *".$_POST['keterangan']."* 
Kualifikasi: *".$_POST['kualifikasi']."* 
Klik Link Dibawah ini :
";

             $message = "
Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";

             send_wa('6281316124343',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
             send_wa('6281291305529',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    $kirim_ke_atasan = send_wa('628161988871',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$_POST['tanggal_pengajuan']."* Dengan Deskripsi *".$_POST['keterangan']."* Dan Kualifikasi *".$_POST['kualifikasi']."* Ditujukan kepada *".$tampil['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    $kirim_ke_atasan1 = send_wa('62816767176',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$_POST['tanggal_pengajuan']."* Dengan Deskripsi *".$_POST['keterangan']."* Dan Kualifikasi *".$_POST['kualifikasi']."* Ditujukan kepada *".$tampil['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    }
    if($emp){
         echo '<script type="text/javascript">
        iziToast.success({
            title: "YES",
            message: "berhasil masukan data anda!",
            });
            </script>';
            echo "<script>document.location.href='status_employee_req.php'</script>";

        }else{
            echo '<script type="text/javascript">
            iziToast.error({
                title: "NO",
                message: "Gagal masukan data anda!",
                });
                </script>';
    }
}
?>
<!-- Page content -->
<div id="page-content">
    <div class="block full">
        <div class="block-title">
            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-size: 20px;margin: 13px;">Formulir Pengajuan Keluhan</h2>
                </div>
                <div class="col-md-4">
                    <a href="status_employee_req.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
                </div>
            </div>
        </div>
        <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
            <div class="row" style="padding:20px;">
                <div class="col-md-7">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Nama Lengkap</label>
                        <div class="col-md-9">
                            <input type="text" readonly name="nama_lengkap" class="form-control" value="<?php echo $data_edit['nama_lengkap'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Jabatan / Department</label>
                        <div class="col-md-9">
                            <input type="text" readonly name="nama_jabatan" class="form-control" value="<?php echo $data_edit['nama_jabatan'] ?> / <?php echo $data_edit['nama_department'] ?> " required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal</label>
                        <div class="col-md-9">
                            <input type="text" name="tanggal_pengajuan" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Kategori</label>
                        <div class="col-md-9">
                            <select  name="kategori_request" required value=""   style="width: 250px;" required="">
                                <option value=""></option>
                                <option value="Teknis">Teknis</option>
                                <option value="Administrasi">Administrasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Deskripsi Keperluan</label>
                        <div class="col-md-9">
                            <textarea name="keterangan" class="form-control" required=""></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Kualifikasi</label>
                        <div class="col-md-9">
                            <select  name="kualifikasi" required value=""   style="width: 250px;" required="">
                                <option value=""></option>
                                <option value="Sangat Penting">Sangat Penting</option>
                                <option value="Penting">Penting</option>
                                <option value="Biasa">Biasa</option>
                            </select>
                            <br>

                            <br><input type="submit" class="btn btn-success" value="AJUKAN PERMOHONAN" name="emp_req" id="">
                            <br>

                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <ol>     
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



<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyDashboard.js"></script>


<?php include 'inc/template_end.php';

?>
