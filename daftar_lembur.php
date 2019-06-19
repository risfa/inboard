<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; 
include ('Db/connect.php'); 
 include 'wa.php';


if(isset($_GET['terima_CBDO'])){
           $nmr_karyawan = $_GET['telpon'];
           $id_topleader = $_GET['id_depart'];
          
          
            $update_status_lembur = mysql_query("UPDATE `tb_permohonan_lembur` SET ValidateBy = 'CHECKED', StatusLembur ='1' WHERE `tb_permohonan_lembur`.`ID_master_lembur` = '$_GET[terima_CBDO]'");

          $telp_topleader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$id_topleader'"));

          $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_lembur ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan WHERE no_telp = '$nmr_karyawan'"));

            
            //KIRIM MESSAGE KE KARYAWAN
            $message_karyawan = "Pemohonan Lembur Anda Pada Tanggal *".$data_pemohon['TanggalLembur']."* Telah Di Validasi Oleh *".$_SESSION['nama_lengkap']."* klik link dibawah ini : 
            ";
            $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'LEMBUR','http://inboard.ardgroup.co.id');
            //END
        
            // SEND MESSAGE KE ATASAN
            $message_CBDO = "Permohonan Lembur *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['TanggalLembur']."* telah divalidasi oleh *".$_SESSION['nama_lengkap']."* . klik link dibawah ini : 
            ";
            $kirim_feedback_ke_leader = send_wa($telp_topleader['no_telp'],$message_CBDO,'LEMBUR','http://inboard.ardgroup.co.id');

            $kirim_feedback_ke_HR = send_wa("6281316124343",$message_CBDO,'LEMBUR','http://inboard.ardgroup.co.id');
            //END
            echo "<script>alert('yes')</script>";

            echo "<script>document.location.href='daftar_lembur.php'</script>";

        } 
?>
<div id="page-content">
 <div class="block full">
  <div class="block-title">
    <div class="row">
      <div class="col-md-8">
        <h2 style="font-size: 20px;margin: 13px;">HALAMAN PERSETUJUAN LEMBUR</h2>
      </div>
      <div class="col-md-12">
      
                  <a href="detail_lembur.php" style="float:right; margin-right:20px;"><button class="btn btn-info" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;DETAIL LEMBUR KARYAWAN</button></a><br>
              

            </div>
    </div>
  </div>

    <div class="table-responsive">
      <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
        <thead>
          <tr>
            <th>Nama / Jabatan / Department</th>
            <!-- <th>Jabatan / Department</th> -->
            
            <th>Deskripsi Pekerjaan/<br><h4>Nama Project</h4></th>
            
            <th>Waktu<br><h4>Mulai / Akhir</h4>(Total)</th>
            <th>Penggantian Lembur</th>
            <th style="width: 20px;">Tanggal Lembur</th>
            <th>Leader Approval</th>
            <th>HR Approval</th>
            <th>CBDO Approval</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if($_SESSION['ID_karyawan']==4){
            $sql_approve_cbdo = mysql_query("SELECT `tb_permohonan_lembur`.*, tb_jabatan.nama_jabatan, tb_department.*,tb_karyawan.* FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_permohonan_lembur.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND StatusLembur = '0' ORDER BY ID_master_lembur");
            while($data = mysql_fetch_array($sql_approve_cbdo)){ 
              $Tanggal = $data['TanggalLembur'];
              $datee = new DateTime($Tanggal);
              $date_time = $datee->format('d M Y');
          ?>
          <tr>
            <td><?php echo $data['nama_lengkap'] ?></td>
            <td><?php echo $data['nama_jabatan']." /<br> ". $data['nama_department'] ?></td>
            <td><?php echo $data['DeskripsiPengerjaan']." / ". $data['NamaProject']?></td>
            <td><?php echo $data['NamaProject'] ?></td>
            <td><?php echo $data['WaktuMulaiKerja']." / ". $data['WaktuSelesaiKerja']." / ". $data['TotalJamKerja']?></td>
            <td><?php echo $data['Penggantian_Lembur'] ?></td>
            <td><?php echo $date_time ?></td>
            <td><?php echo $data['ApprovedBy'] ?></td>
            <td><?php echo $data['ReceivedBy'] ?></td>
            <td><?php echo $data['ValidateBy'] ?></td>
            <td>
              <a href="daftar_lembur.php?terima_CBDO=<?php echo $data[0] ?>&id_depart=<?php echo $data['top_leader'] ?>&telpon=<?php echo $data['no_telp'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>CHECK PERMOHONAN</span></a>
            </td>
          </tr>
          <?php } } ?>

          <?php 
          if($_SESSION['ID_karyawan']==16 OR $_SESSION['ID_karyawan']==5){
            $sql_approve = mysql_query("SELECT `tb_permohonan_lembur`.*, tb_jabatan.nama_jabatan, tb_department.*,tb_karyawan.* FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_permohonan_lembur.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan JOIN tb_department ON tb_department.ID = tb_karyawan.departement");
            while($data = mysql_fetch_array($sql_approve)){ 
              $Tanggal = $data['TanggalLembur'];
              $datee = new DateTime($Tanggal);
              $date_time = $datee->format('d M Y');
          ?>
          <tr>
            <td><?php echo $data['nama_lengkap']." /<br><b> ". $data['nama_jabatan']."</b> /<br> ". $data['nama_department']?></td>
            
            <td><?php echo $data['DeskripsiPengerjaan']." / ". $data['NamaProject']?></td>
  
            <td><?php echo $data['WaktuMulaiKerja']." / ". $data['WaktuSelesaiKerja']." / <b>". $data['TotalJamKerja']."</b>"?></td>
            <td><?php echo $data['Penggantian_Lembur'] ?></td>
            <td><?php echo $date_time ?></td>
            <td><?php echo $data['ApprovedBy'] ?></td>
            <td><?php echo $data['ReceivedBy'] ?></td>
            <td><?php echo $data['ValidateBy'] ?></td>
            <td>
              
            </td>
            
            
          </tr>
          <?php } } ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<script src="js/pages/uiTables.js"></script>
<script>$(function(){ UiTables.init(); });</script>

<?php include 'inc/template_end.php'; ?>

<script type="text/javascript">
 function hide_table(){

  document.getElementById("formnya").style.display = "block";
  document.getElementById("datanya").style.display = "none";

}
</script>