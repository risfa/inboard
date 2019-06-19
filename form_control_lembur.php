<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; 
include ('Db/connect.php'); 
include 'wa.php';
$cek_apakah_saya_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE ID = '$_SESSION[departement]' AND leader = '$_SESSION[ID_karyawan]'"));
        if($cek_apakah_saya_leader[0]==""){
            $cek_saya_leader = "FALSE";
        }else{
            $cek_saya_leader = "TRUE";
        }
    $cek_apakah_saya_top_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE top_leader = '$_SESSION[ID_karyawan]'"));
        if($cek_apakah_saya_top_leader[0]==""){
            $cek_saya_top_leader = "FALSE";
        }else{
            $cek_saya_top_leader = "TRUE";
        }
        function fetch_karyawan($id_karyawan){
            $sql = mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '".$id_karyawan."' ");
            return mysql_fetch_array($sql);
        }

        if (isset($_GET['tolak'])){
            $telp = $_GET['ditolak'];
            $get_data_karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_lembur WHERE ID_master_lembur = '$_GET[tolak]'"));
            $delete_permohonan_lembur = mysql_query("UPDATE `tb_permohonan_lembur` SET `StatusLembur` = '2' WHERE `tb_permohonan_lembur`.`ID_master_lembur` = '$_GET[tolak]';");
            
            $message = $status['CHECKED'] = "Ssssttt.. untuk permohonan lembur tanggal *".$get_data_karyawan['TanggalLembur']."*, *".$_SESSION['nama_lengkap']."* Minta Kamu Untuk Ngobrol, Klik Link Dibawah ini";
             $kirim_feedback_ke_karyawan = send_wa($telp,$message,'LEMBUR','inboard.ardgroup.co.id');


            echo "<script>document.location.href='form_control_cuti.php'</script>";

            //KIRIM PEMBERITAHUAN BAHWA DI TOLAK

        }

        if(isset($_GET['terima_leader'])){
           $id = $_GET['terima_leader'];
           $nmr_karyawan = $_GET['telpon'];
           $id_leader = $_GET['id_lead'];
         
            $update_status_lembur = mysql_query("UPDATE `tb_permohonan_lembur` SET ApprovedBy = 'CHECKED' WHERE `tb_permohonan_lembur`.`ID_master_lembur` = '$_GET[terima_leader]'");

          $data_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_leader'"));

          $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_lembur ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan WHERE no_telp = '$nmr_karyawan' AND ID_master_lembur = '$id' "));

            
            //KIRIM MESSAGE KE KARYAWAN
            $message_karyawan = "Pemohonan Lembur Anda Pada Tanggal *".$data_pemohon['TanggalLembur']."* Telah Di Setujui Oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ";
            $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'LEMBUR','inboard.ardgroup.co.id');
            //END
        
            // SEND MESSAGE KE CBDO
            $message_HR = "Permohonan Lembur *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['TanggalLembur']."* telah disetujui oleh *".$data_leader['nama_lengkap']."*, Sekarang Giliran Anda. klik link dibawah ini : 
            ";
            $kirim_feedback_ke_HR = send_wa('6281316124343',$message_HR,'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_lembur_HR.php?ID='.$id.'');
            //END
            echo "<script>document.location.href='form_control_lembur.php'</script>";
        } 
?>
<div id="page-content">
 <div class="block full">
  <div class="block-title">
    <div class="row">
      <div class="col-md-8">
        <h2 style="font-size: 20px;margin: 13px;">HALAMAN PERSETUJUAN LEMBUR</h2>
      </div>
    </div>
  </div>

    <div class="table-responsive">
      <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
        <thead>
          <tr>
            
            <th>Nama</th>
            <th>Jabatan / Department</th>
            
            <th>Deskripsi Pekerjaan</th>
            <th>Nama Project</th>
            <th>Waktu<br><h5>Mulai / Wakti Akhir</h5></th>
            <th>Penggantian Lembur</th>
            <th style="width: 20px;">Tanggal Lembur</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sql_approve_leader = mysql_query("SELECT `tb_permohonan_lembur`.*, tb_jabatan.nama_jabatan, tb_department.nama_department,tb_karyawan.* FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_permohonan_lembur.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE departement IN(SELECT ID FROM tb_department WHERE top_leader =  '$_SESSION[ID_karyawan]' OR leader =  '$_SESSION[ID_karyawan]') AND ApprovedBy = '$_SESSION[ID_karyawan]' AND tb_permohonan_lembur.StatusLembur = '0'");
              while($data = mysql_fetch_array($sql_approve_leader)){
                $Tanggal = $data['TanggalLembur'];
              $datee = new DateTime($Tanggal);
              $date_time = $datee->format('d M Y');
          ?>
          <tr>
            <td><?php echo $data['nama_lengkap'] ?></td>
            <td><?php echo $data['nama_jabatan']." /<br> ". $data['nama_department'] ?></td>
            
            <td><?php echo $data['DeskripsiPengerjaan'] ?></td>
            <td><?php echo $data['NamaProject'] ?></td>
            <td><?php echo $data['WaktuMulaiKerja']." / ". $data['WaktuSelesaiKerja']?></td>
            <td><?php echo $data['Penggantian_Lembur'] ?></td>
            <td><?php echo $date_time ?></td>
            <td>
              <a href="form_control_lembur.php?terima_leader=<?php echo $data[0] ?>&telpon=<?php echo $data['no_telp'] ?>&id_lead=<?php echo $_SESSION['ID_karyawan'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>SETUJUI PERMOHONAN</span></a>
              <a href="form_control_lembur.php?tolak=<?php echo $data[0] ?>&ditolak=<?php echo $data['no_telp'] ?>"><span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i>NGOBROL YUK</span></a>
            </td>
          </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>

  </div>
</div>

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