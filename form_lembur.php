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
    $data_edit = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$_SESSION[ID_karyawan]'"));
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
   if(isset($_POST['ajukan_lembur'])){
      $nomor_Top_leader = fetch_karyawan($cek_kepemilikan_leader['top_leader']);
      $nomor_leader = fetch_karyawan($cek_kepemilikan_leader['leader']);

      $whatsappLeader = $nomor_leader['no_telp'];
      $whatsappTopLeader = $nomor_Top_leader['no_telp'];
      $Tanggal = $_POST['TanggalLembur'];
      $project = $_POST['NamaProject'];
      $des_pekerjaan = $_POST['DeskripsiPengerjaan'];
      $Mulai = $_POST['WaktuMulaiKerja'];
      $selesai = $_POST['WaktuSelesaiKerja'];
      $Total = $_POST['TotalJamKerja'];
      $data_karyawan = fetch_karyawan($_SESSION[ID_karyawan]);

      if($cek_saya_leader=="TRUE"){

        $insert_lembur = mysql_query("INSERT INTO tb_permohonan_lembur(ID_master_lembur,ID_karyawan,TanggalLembur,WaktuMulaiKerja,WaktuSelesaiKerja,TotalJamKerja,NamaProject,DeskripsiPengerjaan,Penggantian_Lembur,StatusLembur,ApprovedBy,ReceivedBy,ValidateBy) VALUES(NULL,'$ID_karyawan','$_POST[TanggalLembur]','$_POST[WaktuMulaiKerja]','$_POST[WaktuSelesaiKerja]','$_POST[TotalJamKerja]','$_POST[NamaProject]','$_POST[DeskripsiPengerjaan]','$_POST[Penggantian_Lembur]',0, '$cek_kepemilikan_leader[top_leader]','16','4')");
        $ID = mysql_insert_id();
               // top_leader
               //NOTIFIKASI WHATSAPP


        $variable = " 
        Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
        Jabatan: *".$data_karyawan['nama_jabatan']."*
        Departement: *".$data_karyawan['nama_department']."*
        Perusahaan: *".$data_karyawan['perusahaan']."*  
        Tanggal Lembur: *".$Tanggal."* 
        Waktu mulai: *".$Mulai."* 
        Waktu akhir: *".$selesai."* 
        Total Waktu: *".$Total."* 
        Nama Project: *".$project."* 
        Deskripsi pekerjaan: *".$des_pekerjaan."* 
        ";


        $message = "
        Permohonan Lembur Karyawan Dengan Informasi  : ".$variable."";

        send_wa($whatsappTopLeader,$message,'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_lembur.php?ID='.$ID.'');
        send_wa('6281291305529',$message,'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_lembur.php?ID='.$ID.'');
             //END

    }else{
        if($status_leader == "LEADER_UNAVAILABLE"){
            $insert_lembur = mysql_query("INSERT INTO tb_permohonan_lembur(ID_master_lembur,ID_karyawan,TanggalLembur,WaktuMulaiKerja,WaktuSelesaiKerja,TotalJamKerja,NamaProject,DeskripsiPengerjaan,Penggantian_Lembur,StatusLembur,ApprovedBy,ReceivedBy,ValidateBy) VALUES(NULL,'$ID_karyawan','$_POST[TanggalLembur]','$_POST[WaktuMulaiKerja]','$_POST[WaktuSelesaiKerja]','$_POST[TotalJamKerja]','$_POST[NamaProject]','$_POST[DeskripsiPengerjaan]','$_POST[Penggantian_Lembur]',0, '$cek_kepemilikan_leader[top_leader]','16','4')");
            $ID2 = mysql_insert_id();
                    //top_leader
                    //NOTIFIKASI WHATSAPP
            

            $variable = " 
            Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
            Jabatan: *".$data_karyawan['nama_jabatan']."*
            Departement: *".$data_karyawan['nama_department']."*
            Perusahaan: *".$data_karyawan['perusahaan']."*  
            Tanggal Lembur: *".$Tanggal."* 
            Waktu mulai: *".$Mulai."* 
            Waktu akhir: *".$selesai."*
            Total Waktu: *".$Total."* 
            Nama Project: *".$project."* 
            Deskripsi pekerjaan: *".$des_pekerjaan."* 
            ";

            $message = "
            Permohonan Lembur Karyawan Dengan Informasi  : ".$variable."";

            send_wa($whatsappTopLeader,$message,'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_lembur.php?ID='.$ID2.'');
            send_wa('6281291305529',$message,'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_lembur.php?ID='.$ID2.'');
             //END
        }else{
            $insert_lembur = mysql_query("INSERT INTO tb_permohonan_lembur(ID_master_lembur,ID_karyawan,TanggalLembur,WaktuMulaiKerja,WaktuSelesaiKerja,TotalJamKerja,NamaProject,DeskripsiPengerjaan,Penggantian_Lembur,StatusLembur,ApprovedBy,ReceivedBy,ValidateBy) VALUES(NULL,'$ID_karyawan','$_POST[TanggalLembur]','$_POST[WaktuMulaiKerja]','$_POST[WaktuSelesaiKerja]','$_POST[TotalJamKerja]','$_POST[NamaProject]','$_POST[DeskripsiPengerjaan]','$_POST[Penggantian_Lembur]',0, '$cek_kepemilikan_leader[leader]','16','4')");
            $ID3 = mysql_insert_id();
                    //leader
                    //NOTIFIKASI WHATSAPP
            

            $variable = " 
            Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
            Jabatan: *".$data_karyawan['nama_jabatan']."*
            Departement: *".$data_karyawan['nama_department']."*
            Perusahaan: *".$data_karyawan['perusahaan']."*  
            Tanggal Lembur: *".$Tanggal."* 
            Waktu mulai: *".$Mulai."* 
            Waktu akhir: *".$selesai."*
            Total Waktu: *".$Total."* 
            Nama Project: *".$project."* 
            Deskripsi pekerjaan: *".$des_pekerjaan."* 
            ";

            $message = "
            Permohonan Lembur Karyawan Dengan Informasi  : ".$variable."";

            send_wa($whatsappLeader,$message,'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_lembur.php?ID='.$ID3.'');
            send_wa('6281291305529',$message,'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_lembur.php?ID='.$ID3.'');
             //END
        }
    }

    if($insert_lembur){

        $sqlKaryawanLembur = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$_GET[edit]' ");
        $sqlKaryawanLembur = mysql_fetch_array($sqlKaryawanLembur);
        $keterangan_aktif = "Anda Baru saja mengajukan permohonan lembur".$sqlKaryawanLembur[0];
        $notifikasiAktif = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_SESSION[ID_karyawan]','$keterangan_aktif',0,'insert')");
        echo '<script type="text/javascript">
        iziToast.success({
            title: "YES",
            message: "berhasil masukan data anda!",
            });
            </script>';
            echo "<script>document.location.href='status_lembur.php'</script>";

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
                            <h2 style="font-size: 20px;margin: 13px;">Formulir Permohonan Lembur</h2>
                        </div>
                        <div class="col-md-4">
                            <a href="status_lembur.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
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
                                <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal Lembur</label>
                                <div class="col-md-9">
                                    <input type="text" name="TanggalLembur" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="example-clickable-password2">Jam Mulai</label>
                                <div class="col-md-9 clockpicker" data-placement="left"  data-align="top" data-autoclose="true">
                                    <input type="text" name="WaktuMulaiKerja" class="form-control"  placeholder="09:30" required>
                                </div>
                                <!-- <div class="col-md-9">
                                    <input type="text" name="WaktuMulaiKerja" class="form-control" placeholder="08:00"  required>
                                </div> -->
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="example-clickable-password2">Jam Akhir</label>
                                <div class="col-md-9 clockpicker" data-placement="left"  data-align="top" data-autoclose="true">
                                    <input type="text" name="WaktuSelesaiKerja" class="form-control" autocomplete="off" placeholder="16:00" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="example-clickable-password2">Total Jam Kerja</label>
                                <div class="col-md-9">
                                    <input type="text" name="TotalJamKerja" class="form-control" autocomplete="off" placeholder="8 jam" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama Project</label>
                                <div class="col-md-9">
                                    <input type="text" name="NamaProject" class="form-control" autocomplete="off" value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Deskripsi Pekerjaan</label>
                                <div class="col-md-9">
                                    <textarea name="DeskripsiPengerjaan" class="form-control" required=""></textarea>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Pergantian Lembur</label>
                                <div class="col-md-9">
                                    <select name="Penggantian_Lembur" required class="form-control"   style="width: 250px; ">
                                        <option value=""></option>
                                        <option value="Uang Lembur (Transfer Oleh HR)">Uang Lembur (Transfer Oleh HR)</option>
                                        <option value="Ganti Hari Kerja">Ganti Hari Kerja</option>
                                    </select>
                                    <br>

                                    <br><input type="submit" class="btn btn-success" value="AJUKAN PERMOHONAN LEMBUR" name="ajukan_lembur" id="">
                                    <br>

                                </div>
                            </div>


                        </div>
                        <div class="col-md-5">
                            <b>Informasi Sebelum Mengajukan Lembur</b>
                            <ol>
                                <li>Penggantian lembur hanya diberikan kepada karyawan yang bekerja pada hari libur karyawan dan Perusahaan, dengan waktu kerja lembur minimal 8(delapan) jam kerja.</li>
                                <li>Uang lembur ditentukan berbeda sesuai dengan jabatan dan tanggung jawab karyawan</li>
                                <li>Penggantian uang lembur akan ditransfer bersamaan dengan gaji dibulan berikutnya setelah form lembur diterima dan divalidasi oleh HR</li>
                                <li>Formulir harus diisi dengan jelas dan sesuai kondisi dengan disetujui atasan</li>
                                <li>Penggantian hari kerja paling lambat dala waktu 1(satu) bulan sejak tanggal lembur dengan persetujuan atasan</li>
                                <li>Tidak dibenarkan mengambil hari kerja pengganti tanpa sepengetahuan atasan dan HR</li>
                                <li>Kerja lembur yang dapat diperhitungkan adalah kerja lembur yang terdokumentasikan secara jelas serta dilengkapi persetujuan secara tertulis dari atasan karyawan</li>
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
$('.clockpicker').clockpicker();
</script>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyDashboard.js"></script>


<?php include 'inc/template_end.php';

?>
