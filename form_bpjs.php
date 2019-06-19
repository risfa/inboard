<?php
include 'inc/config.php'; ;
include 'inc/template_start.php';
include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';


$sesion_karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$_SESSION[ID_karyawan]' "));

if(isset($_POST['insert_bpjs'])){
    $bpjs_insert = mysql_query("INSERT INTO `tb_bpjs`(`id_bpjs`,`ID_karyawan`, `nomor_kk`, `nomor_ktp`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `gender`, `status_pernikahan`, `alamat_lengkap`, `telepon`, `email`, `kewarganegaraan`, `npwp`, `faskes_tk1`, `fasker_dr_gigi`) VALUES (NULL,'$_SESSION[ID_karyawan]','$_POST[nomor_kk]','$_POST[nomor_ktp]','$_POST[nama_lengkap]','$_POST[tempat_lahir]','$_POST[tanggal_lahir]','$_POST[gender]','$_POST[status_pernikahan]','$_POST[alamat_lengkap]','$_POST[telepon]','$_POST[email]','$_POST[kewarganegaraan]','$_POST[npwp]','$_POST[faskes_tk1]','$_POST[fasker_dr_gigi]')");
    if(bpjs_insert){
        echo"<script>aler('yes')</script>";
        echo"<script>document.location.href='status_bpjs.php'</script>";
    }else{
        echo"<script>document.location.href='form_bpjs.php'</script>";
    }
}
if(isset($_POST['update_bpjs'])){
    $idbpjs= $_POST['id_bpjs'];
    $bpjs_update = mysql_query("UPDATE `tb_bpjs` SET `nomor_kk`='$_POST[nomor_kk]',`nomor_ktp`='$_POST[nomor_ktp]',`nama_lengkap`='$_POST[nama_lengkap]',`tempat_lahir`='$_POST[tempat_lahir]',`tanggal_lahir`='$_POST[tanggal_lahir]',`gender`='$_POST[gender]',`status_pernikahan`='$_POST[status_pernikahan]',`alamat_lengkap`='$_POST[alamat_lengkap]',`telepon`='$_POST[telepon]',`email`='$_POST[email]',`kewarganegaraan`='$_POST[kewarganegaraan]',`npwp`='$_POST[npwp]',`faskes_tk1`='$_POST[faskes_tk1]',`fasker_dr_gigi`='$_POST[fasker_dr_gigi]' WHERE `id_bpjs` = '$idbpjs'");
    if(bpjs_update){
        echo"<script>aler('yes')</script>";
        echo"<script>document.location.href='status_bpjs.php'</script>";
    }else{
        echo"<script>document.location.href='form_bpjs.php'</script>";
    }
}
$edit_bpjs = mysql_fetch_array(mysql_query("SELECT * FROM tb_bpjs WHERE id_bpjs = '$_GET[edit]'"));
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
                        <h2 style="font-size: 20px;margin: 13px;">Formulir BPJS</h2>
                    </div>
                    <div class="col-md-4">
                        <a href="status_bpjs.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
                    </div>
                </div>
            </div>
            <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                <div class="row" style="padding:20px;">
                    <div class="col-md-7">
                        <input type="hidden" name="id_bpjs" class="form-control" autocomplete="off" value="" required>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nomor KK</label>
                            <div class="col-md-9">
                                <input type="text" name="nomor_kk" class="form-control" autocomplete="off" value="<?php echo $edit_bpjs['nomor_kk'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">KTP/KITAS/KITAP</label>
                            <div class="col-md-9">
                                <input readonly="" type="text" class="form-control" name="nomor_ktp" value="<?php echo $sesion_karyawan['no_ktp'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Nama Lengkap</label>
                            <div class="col-md-9">
                                <input readonly="" type="text" name="nama_lengkap" class="form-control" value="<?php echo $sesion_karyawan['nama_lengkap'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Tempat Lahir</label>
                            <div class="col-md-9">
                                <input type="text" name="tempat_lahir" class="form-control" autocomplete="off" value="<?php echo $edit_bpjs['tempat_lahir'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Tanggal Lahir</label>
                            <div class="col-md-9">
                                <input readonly="" type="text" name="tanggal_lahir" class="form-control" autocomplete="off" value="<?php echo $sesion_karyawan['tgl_lahir'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control">
                                    <option selected="" value=""><?php echo $edit_bpjs['gender'] ?></option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Status Pernikahan</label>
                            <div class="col-md-9">
                                <select name="status_pernikahan" class="form-control">
                                    <option selected="" value=""><?php echo $edit_bpjs['status_pernikahan'] ?></option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Janda">Janda</option>
                                    <option value="Duda">Duda</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Alamat Lengkap (Sertakan Kode POS)</label>
                            <div class="col-md-9">
                                <textarea name="alamat_lengkap" class="form-control"><?php echo $edit_bpjs['alamat_lengkap'] ?> </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Telepon</label>
                            <div class="col-md-9">
                                <input readonly="" type="text" class="form-control" name="telepon" value="<?php echo $sesion_karyawan['no_telp'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">E-Mail</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="email" value="<?php echo $edit_bpjs['email'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Kewarganegaraan</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="kewarganegaraan" value="<?php echo $edit_bpjs['kewarganegaraan'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">NPWP</label>
                            <div class="col-md-9">
                                <input readonly="" type="text" class="form-control" name="npwp" value="<?php echo $sesion_karyawan['no_npwp'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Nama Faskes TK1</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="faskes_tk1" required="" value="<?php echo $edit_bpjs['faskes_tk1'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Nama Faskes Dokter Gigi</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="fasker_dr_gigi" required="" value="<?php echo $edit_bpjs['fasker_dr_gigi'] ?>">
                            </div>
                        </div>


                        <div class="form-group">

                            <div class="col-md-9">
                                

                                <br>
                                <?php if($_GET['edit']){ ?>
                                <input type="submit" class="btn btn-info" value="UPDATE " name="update_bpjs" id="">
                                <?php }else{ ?>
                                <input type="submit" class="btn btn-success" value="SIMPAN" name="insert_bpjs" id="">
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
