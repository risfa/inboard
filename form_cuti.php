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

    if(isset($_POST['ajukan_cuti'])){
          $nomor_Top_leader = fetch_karyawan($cek_kepemilikan_leader['top_leader']);
          $nomor_leader = fetch_karyawan($cek_kepemilikan_leader['leader']);

          $whatsappLeader = $nomor_leader['no_telp'];
          $whatsappTopLeader = $nomor_Top_leader['no_telp'];
          $Tanggal = $_POST['tgl_cuti'];
          $Keperluan_cuti = $_POST['keterangan'];
          $data_karyawan = fetch_karyawan($_SESSION[ID_karyawan]);
            if($cek_saya_leader=="TRUE"){
                $insert_cuti = mysql_query("INSERT INTO tb_permohonan_cuti(ID_permohonan_cuti,ID_karyawan,status,keterangan,tgl_cuti, accept_by, approved_by) VALUES(NULL,'$ID_karyawan','DI AJUKAN','$_POST[keterangan]','$_POST[tgl_cuti]', 'CHECKED', '$cek_kepemilikan_leader[top_leader]')");
                $ID = mysql_insert_id();
               // top_leader
               //NOTIFIKASI WHATSAPP
           

             $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Cuti: *".$Tanggal."* 
Keperluan Cuti: *".$Keperluan_cuti."* 
Klik Link Dibawah ini :
";


             $message = "
Permohonan Cuti Karyawan Dengan Informasi  : ".$variable."";

             send_wa($whatsappTopLeader,$message,'CUTI','https://xeniel.5dapps.com/inboard/otu/Otu_cuti.php?ID='.$ID.'&leader='.$nomor_Top_leader[0].'');
             send_wa('6281291305529',$message,'CUTI','https://xeniel.5dapps.com/inboard/otu/Otu_cuti.php?ID='.$ID.'&leader='.$nomor_Top_leader[0].'');
             //END

            }else{
                if($status_leader == "LEADER_UNAVAILABLE"){
                    $insert_cuti = mysql_query("INSERT INTO tb_permohonan_cuti(ID_permohonan_cuti,ID_karyawan,status,keterangan,tgl_cuti, accept_by, approved_by) VALUES(NULL,'$ID_karyawan','DI AJUKAN','$_POST[keterangan]','$_POST[tgl_cuti]', 'CHECKED', '$cek_kepemilikan_leader[top_leader]')");
                    $ID2 = mysql_insert_id();
                    //top_leader
                    //NOTIFIKASI WHATSAPP

             $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Cuti: *".$Tanggal."* 
Keperluan Cuti: *".$Keperluan_cuti."* 
Klik Link Dibawah ini :
";

             $message = "
Permohonan Cuti Karyawan Dengan Informasi  : ".$variable."";

             send_wa($whatsappTopLeader,$message,'CUTI','https://xeniel.5dapps.com/inboard/otu/Otu_cuti.php?ID='.$ID2.'&leader='.$nomor_leader[0].'');
             send_wa('6281291305529',$message,'CUTI','https://xeniel.5dapps.com/inboard/otu/Otu_cuti.php?ID='.$ID2.'&leader='.$nomor_leader[0].'');
             //END
                }else{
                    $insert_cuti = mysql_query("INSERT INTO tb_permohonan_cuti(ID_permohonan_cuti,ID_karyawan,status,keterangan,tgl_cuti, accept_by, approved_by) VALUES(NULL,'$ID_karyawan','DI AJUKAN','$_POST[keterangan]','$_POST[tgl_cuti]', '$cek_kepemilikan_leader[leader]', '$cek_kepemilikan_leader[top_leader]')");
                    $ID3 = mysql_insert_id();
                    //leader
                    //NOTIFIKASI WHATSAPP

             $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Cuti: *".$Tanggal."* 
Keperluan Cuti: *".$Keperluan_cuti."* 
Klik Link Dibawah ini :
"; 

             $message = "
Permohonan Cuti Karyawan Dengan Informasi  : ".$variable."";
            
             send_wa($whatsappLeader,$message,'CUTI','https://xeniel.5dapps.com/inboard/otu/Otu_cuti.php?ID='.$ID3.'&leader='.$nomor_leader[0].'');
             send_wa('6281291305529',$message,'CUTI','https://xeniel.5dapps.com/inboard/otu/Otu_cuti.php?ID='.$ID3.'&leader='.$nomor_leader[0].'');
             //END
                }
            }

//echo $insert_cuti;
        if($insert_cuti){
            $update_quota_cuti = mysql_query("UPDATE `tb_master_cuti` SET `jumlah_cuti` = jumlah_cuti - 1 WHERE `tb_master_cuti`.`ID_karyawan` = '$_SESSION[ID_karyawan]';");

        $sqlKaryawanCuti = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$_GET[edit]' ");
        $sqlKaryawanCuti = mysql_fetch_array($sqlKaryawanCuti);
        $keterangan_aktif = "Anda Baru saja mengajukan permohonan cuti".$sqlKaryawanCuti[0];
            $notifikasiAktif = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_SESSION[ID_karyawan]','$keterangan_aktif',0,'insert')");
            
             echo "<script>document.location.href='status_cuti.php'</script>";

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
                    <h2 style="font-size: 20px;margin: 13px;">Formulir Permohonan Cuti</h2>
                </div>
                <div class="col-md-4">
                    <a href="status_cuti.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
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
                        <label class="col-md-3 control-label">Jabatan</label>
                        <div class="col-md-9">
                            <input type="text" readonly name="nama_jabatan" class="form-control" value="<?php echo $data_edit['nama_jabatan'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal Cuti</label>
                        <div class="col-md-9">
                            <input type="text" name="tgl_cuti" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Keperluan Cuti</label>
                        <div class="col-md-9">
                            <textarea name="keterangan" id="" cols="30" rows="3" class="form-control"></textarea>
                            <?php if($data_cuti['jumlah_cuti']>0 || $data_cuti['jumlah_cuti']!=""){ ?>
                                <br><input type="submit" class="btn btn-success" value="AJUKAN PERMOHONAN CUTI" name="ajukan_cuti" id="">
                            <?php }else{ ?>
                                <a href="#" ><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-block"></i>&nbsp;QUOTA CUTI ANDA SUDAH HABIS</button></a><br>
                            <?php } ?>
                        </div>
                    </div>


                </div>
                <div class="col-md-5">
                    <b>Informasi Sebelum Mengajukan Cuti</b>
                    <ol>
                        <li>Syarat Pertama</li>
                        <li>Syarat Kedua</li>
                        <li>Syarat Ketiga</li>
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
