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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.6/bootstrap-clockpicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.6/jquery-clockpicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.6/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>
<?php
$tahun_ini = date('Y');

$data_cuti = mysql_fetch_array(mysql_query("SELECT * FROM tb_master_cuti WHERE ID_karyawan = '$_SESSION[ID_karyawan]' AND tahun = '$tahun_ini'"));

    $data_edit = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID WHERE ID_karyawan = '$_SESSION[ID_karyawan]'"));
    $ID_karyawan = $_SESSION['ID_karyawan'];

    $cek_apakah_saya_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE ID = '$_SESSION[departement]' AND leader = '$_SESSION[ID_karyawan]'"));
    if($cek_apakah_saya_leader[0]==""){
        $cek_saya_leader = "FALSE";
    }else{
        $cek_saya_leader = "TRUE";
    }

    $cek_kepemilikan_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE ID = '$_SESSION[departement]'"));
    if($cek_kepemilikan_leader['leader']==$cek_kepemilikan_leader['top_leader']){
        $status_leader = "LEADER_UNAVAILABLE";
    }else{
        $status_leader = "LEADER_AVAILABLE";
    }

function fetch_karyawan($id_karyawan){
	$sql = mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '".$id_karyawan."' ");
	return mysql_fetch_array($sql);
}

if(isset($_POST['ajukan_meeting'])){
    function genRandStr(){
  $a = $b = $c = '';

  for($i = 0; $i < 2; $i++){
    $a .= chr(mt_rand(65, 90)); // see the ascii table why 65 to 90.
    $c .= chr(mt_rand(65, 90)); // see the ascii table why 65 to 90.
  }

  for($x = 0; $x < 3; $x++){
    $b .= mt_rand(0, 9);
  }
  return $a . $b . $c;
}
    $unique_code = genRandStr();
    $query_meeting = mysql_query("INSERT INTO `tb_meeting`(`ID_meeting`, `judul_meeting`, `tanggal_meeting`, `waktu_mulai`, `waktu_akhir`, `Lokasi`, `desk_meeting`, `kode_meeting`) VALUES (NULL,'$_POST[judul_meeting]','$_POST[tanggal_meeting]','$_POST[waktu_mulai]','$_POST[waktu_akhir]','$_POST[Lokasi]','$_POST[desk_meeting]','$unique_code')");
    if($query_meeting){
        echo"<script>alert('data berhasil disimpan')</script>";
        echo"<script>document.location.href='list_data_meeting.php'</script>";
    }else{
        echo"<script>alert('data tidak berhasil disimpan')</script>";
    }
}
?>
<!-- Page content -->
<div id="page-content">
    <div class="block full">
        <div class="block-title">
            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-size: 20px;margin: 13px;">Formulir Absensi Meeting</h2>
                </div>
                <div class="col-md-4">
                    <a href="list_data_meeting.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
                </div>
            </div>
        </div>
        <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
            <div class="row" style="padding:20px;">
                <div class="col-md-7">

                    <div class="form-group">
                        <label class="col-md-3 control-label">judul Meeting</label>
                        <div class="col-md-9">
                            <input type="text"  name="judul_meeting" class="form-control" value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal Meeting</label>
                        <div class="col-md-9">
                            <input type="text" name="tanggal_meeting" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Waktu Mulai</label>
                        <div class="col-md-9 clockpicker"  data-placement="left" data-align="top" data-autoclose="true">
                        <input type="text" name="waktu_mulai" class="form-control" value="00:00">
                        <!-- <span class="input-group-addon"> -->
                        <!-- <span class="fas fa-clock-o"></span> -->
                        <!-- </span> -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Waktu Akhir</label>
                        <div class="col-md-9 clockpicker" data-placement="left"  data-align="top" data-autoclose="true">
                        <input type="text" name="waktu_akhir" class="form-control" value="00:00">
                        <!-- <span class="input-group-addon">
                        <span class="fa-clock-o"></span>
                        </span> -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Lokasi Meeting</label>
                        <div class="col-md-9">
                            <input type="text"  name="Lokasi" class="form-control" value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Deskripsi meeting</label>
                        <div class="col-md-9">
                            <textarea name="desk_meeting" id="" cols="30" rows="3" class="form-control"></textarea>
                                <br><input type="submit" class="btn btn-success" value="AJUKAN MEETING" name="ajukan_meeting" id="">
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
