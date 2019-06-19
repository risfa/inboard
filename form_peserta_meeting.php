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


if(isset($_POST['absen_meeting'])){
    $id_karyawan = $_POST['ID_karyawan'];
    $code = $_POST['uniq_code'];
    $query_meeting = mysql_query("SELECT * FROM tb_meeting");
    $CekCode = false;
    $meeting = mysql_num_rows($query_meeting);
    while($data_meeting = mysql_fetch_array($query_meeting)){
        $tgl_meeting = strtotime($data_meeting['tanggal_meeting']);
        $tgl_skrg = strtotime(Date("d-m-Y"));
        $diff = $tgl_skrg - $tgl_meeting ;
        // echo"baba".$data_meeting['kode_meeting'];
        if($data_meeting['kode_meeting'] == $code && $diff == 0){
            $insert_peserta = mysql_query("INSERT INTO `tb_peserta_absensi`(`ID_absensi`, `ID_karyawan`, `ID_meeting`, `uniq_code`) VALUES (NULL,'$_SESSION[ID_karyawan]','$data_meeting[ID_meeting]','$_POST[uniq_code]')");
            $CekCode = true;
            echo"<script>alert('Terimakasih Kamu Telah Mengikuti Meeting Ini!')</script>";
        }
        // else {
        //     echo"<script>alert('Maaf Kode Yang Anda Masukan Sudah Tidak Berlaku!')</script>";
        // }
        
    }

    if($CekCode == false){
        echo"<script>alert('Kode Tidak Ditemukan!')</script>";
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
                    <a href="data_absen_meeting.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
                </div>
            </div>
        </div>
        <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
            <div class="row" style="padding:20px;">
                <div class="col-md-7">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Masukan Kode</label>
                        <div class="col-md-9">
                            <input type="text" name="uniq_code" class="form-control">
                                <br><input type="submit" class="btn btn-success" value="ABSEN MEETING" name="absen_meeting" id="">
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
