<?php
include ('Db/connect.php');
include 'wa.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Send WA Repeat</title>
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
 	$data_karyawan = fetch_karyawan($_SESSION[ID_karyawan]);

    $data = mysql_query("SELECT * FROM tb_employee_req");
    $cek_data = mysql_fetch_array($data);

if($cek_data['Status_request']=='DALAM PENGAJUAN' && $cek_data['kategori_request']=='Teknis'){

$sql = mysql_query("SELECT * FROM tb_employee_req");
    $tampil = mysql_fetch_array($sql);
    $tgl_harini = date("d-m-Y");
    $tgl_pengajuan = $tampil['tanggal'];
    $Tanggal = Date("d-m-Y",strtotime('+1week',strtotime($tgl_pengajuan)));
    
    $tgl = $tampil['tanggal'];
    $Tanggl = Date("d-m-Y",strtotime('+2week',strtotime($tgl)));
    
    $tgll = $tampil['tanggal'];
    $Tanggll_sebulan = Date("d-m-Y",strtotime('+1month',strtotime($tgll)));
    
 if($tampil['kualifikasi']=='Sangat Penting' || $tgl_pengajuan == $Tanggal){

    $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$tampil['tanggal']."* 
Deskripsi Keluhan: *".$tampil['keterangan']."* 
Kualifikasi: *".$tampil['kualifikasi']."* 
Kategori a: *".$tampil['kategori_request']."* 
Klik Link Dibawah ini :
";
             $message = "
Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";

    send_wa('6281291305529',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    // $kirim_ke_atasan = send_wa('6281291305529',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$tampil['tanggal']."* Dengan Deskripsi *".$tampil['keterangan']."* Dan Kualifikasi *".$tampil['kualifikasi']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    // $kirim_ke_atasan1 = send_wa('6281291305529',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$tampil['tanggal']."* Dengan Deskripsi *".$tampil['keterangan']."* Dan Kualifikasi *".$tampil['kualifikasi']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
 
 }elseif($tampil['kualifikasi']=='Penting' || $tgl == $Tanggl){
 	$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$tampil['tanggal']."* 
Deskripsi Keluhan: *".$tampil['keterangan']."* 
Kualifikasi: *".$tampil['kualifikasi']."* 
Kategori b: *".$tampil['kategori_request']."* 
Klik Link Dibawah ini :
";
             $message = "
Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";

    send_wa('6281291305529',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    // $kirim_ke_atasan = send_wa('6281291305529',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$tampil['tanggal']."* Dengan Deskripsi *".$tampil['keterangan']."* Dan Kualifikasi *".$tampil['kualifikasi']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    // $kirim_ke_atasan1 = send_wa('6281291305529',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$tampil['tanggal']."* Dengan Deskripsi *".$tampil['keterangan']."* Dan Kualifikasi *".$tampil['kualifikasi']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');

}elseif($tampil['kualifikasi']=='Biasa' || $tgll == $Tanggll_sebulan){
	$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$tampil['tanggal']."* 
Deskripsi Keluhan: *".$tampil['keterangan']."* 
Kualifikasi: *".$tampil['kualifikasi']."* 
Kategori c: *".$tampil['kategori_request']."* 
Klik Link Dibawah ini :
";
$message = "
Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";

    send_wa('6281291305529',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
}



}elseif($cek_data['Status_request']=='DALAM PENGAJUAN' && $cek_data['kategori_request']=='Administrasi'){
    $sql_admin = mysql_query("SELECT * FROM tb_employee_req");
    $cekdata_admin = mysql_fetch_array($sql_admin);

    $tgl_skrg = date("d-m-Y");
    $tgl_pengajuan_admin = $cekdata_admin['tanggal'];
    $Tanggal_admin = Date("d-m-Y",strtotime('+5days',strtotime($tgl_pengajuan_admin)));
    

    $tgl_admin = $cekdata_admin['tanggal'];
    $Tanggl_admin = Date("d-m-Y",strtotime('+2week',strtotime($tgl_admin)));
    

    $tgll_admin = $cekdata_admin['tanggal'];
    $Tanggll_sebulan_admin = Date("d-m-Y",strtotime('+1month',strtotime($tgll_admin)));
    

if($cekdata_admin['kualifikasi']=='Sangat Penting
' || $tgl_pengajuan_admin == $Tanggal_admin){
    $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$cekdata_admin['tanggal']."* 
Deskripsi Keluhan: *".$cekdata_admin['keterangan']."* 
Kualifikasi: *".$cekdata_admin['kualifikasi']."* 
Kategori d: *".$cekdata_admin['kategori_request']."* 
Klik Link Dibawah ini :
";
             $message = "
Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";

    send_wa('6281291305529',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    // $kirim_ke_atasan = send_wa('6281291305529',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$cekdata_admin['tanggal']."* Dengan Deskripsi *".$cekdata_admin['keterangan']."* Dan Kualifikasi *".$cekdata_admin['kualifikasi']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    // $kirim_ke_atasan1 = send_wa('6281291305529',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$cekdata_admin['tanggal']."* Dengan Deskripsi *".$cekdata_admin['keterangan']."* Dan Kualifikasi *".$cekdata_admin['kualifikasi']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
 }else if($cekdata_admin['kualifikasi']=='Penting' || $tgl_admin == $Tanggl_admin){
    $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$cekdata_admin['tanggal']."* 
Deskripsi Keluhan: *".$cekdata_admin['keterangan']."* 
Kualifikasi: *".$cekdata_admin['kualifikasi']."*
Kategori e: *".$cekdata_admin['kategori_request']."* 
Klik Link Dibawah ini :
";
             $message = "
Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";

    send_wa('6281291305529',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    // $kirim_ke_atasan = send_wa('6281291305529',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$cekdata_admin['tanggal']."* Dengan Deskripsi *".$cekdata_admin['keterangan']."* Dan Kualifikasi *".$cekdata_admin['kualifikasi']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
    // $kirim_ke_atasan1 = send_wa('6281291305529',"Permohonan keluhan *".$data_karyawan['nama_lengkap']."* pada tanggal *".$cekdata_admin['tanggal']."* Dengan Deskripsi *".$cekdata_admin['keterangan']."* Dan Kualifikasi *".$cekdata_admin['kualifikasi']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
  }else if($cekdata_admin['kualifikasi']=='Biasa' && $tgll_admin == $Tanggll_sebulan_admin){
  	$variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$cekdata_admin['tanggal']."* 
Deskripsi Keluhan: *".$cekdata_admin['keterangan']."* 
Kualifikasi: *".$cekdata_admin['kualifikasi']."*
Kategori f: *".$cekdata_admin['kategori_request']."* 
Klik Link Dibawah ini :
";
             $message = "
Permohonan Keluhan Karyawan Dengan Informasi  : ".$variable."";
	send_wa('6281291305529',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
  }

}

?>
<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/uiTables.js"></script>
<script>$(function(){ UiTables.init(); });</script>

<?php include 'inc/template_end.php'; ?>

<script type="text/javascript">
 function hide_table(){

  document.getElementById("formnya").style.display = "block";
  document.getElementById("datanya").style.display = "none";

}
</script>
