<?php
include 'inc/config.php';  ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';
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
        <div class="block ">
            <div class="block-title">
                <h2>Formulir Permohonan Voucher</h2>
            </div>

            <div class="container" style="width: 100%;">
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <ol>
                                <li>Pilih kategori voucher</li>
                                <li>Tekan Request Kode Voucher</li>
                                <li>Permintaan anda akan segera di proses</li>
                                <li>Tunggu pada kolom daftar voucher saya hingga kode di decrypt</li>
                                <li>Selesai</li>
                            </ol>
                            <?php
                            if(isset($_POST['request'])){
                                $kategori_voucher = $_POST['kategori_voucher'];
                                $keterangan_voucher = $_POST['keterangan_voucher'];
                                $jenis_perjalanan = $_POST['jenis_perjalanan'];
                                $voucher = mysql_fetch_array(mysql_query("SELECT * FROM `tb_voucher` WHERE kategori_voucher = '$kategori_voucher'  ORDER BY RAND() LIMIT 1,1"));

                                $tampil = mysql_fetch_array(mysql_query("SELECT * FROM tb_voucher WHERE ID_voucher = '$voucher[0]'"));

                                $update = mysql_query("UPDATE tb_voucher SET  status = 'requested', used_by = '$_SESSION[ID_karyawan]', keterangan_voucher = '$keterangan_voucher', jenis_perjalanan = '$jenis_perjalanan' WHERE ID_voucher = '$voucher[0]'");

                                if($voucher[0]!=''){
                                    //NOTIF
                                    $voucher = mysql_fetch_array(mysql_query("SELECT keterangan_voucher FROM tb_voucher WHERE used_by = '$_SESSION[ID_karyawan]'"));
                                    $karyawan = mysql_fetch_array(mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.*, tb_voucher.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID JOIN tb_voucher ON tb_karyawan.ID_karyawan = tb_voucher.used_by WHERE ID_karyawan = '$_SESSION[ID_karyawan]' ORDER BY used_on DESC"));

                                    $variable = $karyawan['nama_lengkap']."
                                    [Jabatan] = ".$karyawan['nama_jabatan']."
                                    [Departement] = ".$karyawan['nama_department']."
                                    [Perusahaan] = ".$karyawan['perusahaan']."  
                                    [Keterangan Voucher] = ".$karyawan['keterangan_voucher']." 
                                    [Jenis Perjalanan] = ".$karyawan['jenis_perjalanan'];
                                    $message = "karyawan dengan informasi  : ".$variable."";

                                    send_wa('6289618207851',$message,'REQUEST VOUCHER','inboard.ardgroup.co.id');

                                    echo '<script type="text/javascript">
                                    iziToast.success({
                                        title: "OK",
                                        message: "Permohonan Voucher berhasil dikirim",
                                        });
                                        </script>';
                                    }else{
                                        echo"<script>alert('Gagal melakukan permohonan voucher')</script>";
                                    }

                                    echo "<script>document.location.href='formulir_voucher.php'</script>";

                                }
                                ?>
                                <script type="text/javascript">
                                   function closepopup()
                                   {
                                      if(false == my_window.closed)
                                      {
                                       my_window.close ();
                                   }
                                   else
                                   {
                                       alert('Window already closed!');
                                   }
                               }
                           </script>
                           <br> JENIS VOUCHER
                           <select name="kategori_voucher" class="form-control" required="">
                            <option value="">--Pilih--</option>
                            <option value="GRAB ARDENCY">GRAB ARDENCY</option>
                            <option value="GRAB USI">GRAB USI</option>
                            
                        </select>
                        <br> TUJUAN PENGGUNAAN
                        <select name="jenis_perjalanan" class="form-control" required="">
                            <option value="" >--Pilih--</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Proyek Baru">Proyek Baru</option>
                            <option value="Training">Training</option>
                            <option value="Event">Event</option>
                            <option value="Others">Others</option>
                            
                        </select>
                        <br> KETERANGAN
                        <input type="text" name="keterangan_voucher" class="form-control" required="">
                        <button name="request" class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;REQUEST</button>
                        <br>

                    </div>

                    <div class="col-md-6">
                        HISTORY PERMOHONAN VOUCHER<br>

                        <table class="table table-bordered" style="margin-top: 20px;">
                            <thead style="font-weight: bolder; font-size:15px;">
                                <td>No</td>
                                <td>Status</td>
                                <td>Jenis</td>
                                <td>Kode</td>
                                <td>Jenis Perjalanan</td>
                                <td>Keterangan</td>
                                <td>Tanggal Permohonan</td>
                            </thead>
                            <?php 
                            $no=1;
                            $sql = mysql_query("SELECT * FROM tb_voucher WHERE used_by = '$_SESSION[ID_karyawan]' ORDER BY used_on DESC");
                            while($data = mysql_fetch_array($sql)){
                               ?>
                               <tr>
                                <td>
                                    <?php echo $no; ?>
                                </td>
                                <td>
                                    <?php echo $data['status']; ?>
                                </td>
                                <td>
                                    <?php echo $data['kategori_voucher']; ?>
                                </td>
                                <td>
                                    <?php 
                                    if($data['status']=='disaktif'){
                                        echo $data['nomor_voucher'];
                                    }else{
                                        echo "*******";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $data['jenis_perjalanan']; ?>
                                </td>
                                <td>
                                    <?php echo $data['keterangan_voucher']; ?>
                                </td>
                                <td>
                                    <?php echo $data['used_on']; ?>
                                </td>
                            </tr>
                            <?php $no++; } ?>

                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Page Content -->
</body>

</html>

<style>

</style>
<!-- Page content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/uiTables.js"></script>
<script>
    $(function() {
        UiTables.init();
    });
</script>

                    <!-- function myFunction() {
var x = document.getElementById("textarea-ckeditor-tidak").required;
} -->

<?php include 'inc/template_end.php'; ?>
<script type="text/javascript">
    function hide_table() {

        document.getElementById("formnya").style.display = "block";
        document.getElementById("datanya").style.display = "none";

    }
</script>