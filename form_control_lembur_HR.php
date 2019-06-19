<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; 
include ('Db/connect.php'); 
 include 'wa.php';

if(isset($_GET['terima_HR'])){
           $id = $_GET['terima_HR'];
           $nmr_karyawan = $_GET['telpon'];
           $id_CA = $_GET['id_CA'];

            $update_status_lembur = mysql_query("UPDATE `tb_permohonan_lembur` SET ReceivedBy = 'CHECKED' WHERE `tb_permohonan_lembur`.`ID_master_lembur` = '$_GET[terima_HR]'");
          $data_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_CA'"));

          $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_lembur ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan WHERE no_telp = '$nmr_karyawan' AND ID_master_lembur = '$id' "));

            
            //KIRIM MESSAGE KE KARYAWAN
            $message_karyawan = "Pemohonan Lembur Anda Pada Tanggal *".$data_pemohon['TanggalLembur']."* Telah Di Check Oleh *".$data_leader['nama_lengkap']."* klik link dibawah ini : ";
            $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'LEMBUR','inboard.ardgroup.co.id');
            //END
        
            // SEND MESSAGE KE CBDO
            $message_CBDO = "Permohonan Lembur *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['TanggalLembur']."* telah diterima oleh *".$data_leader['nama_lengkap']."*, Sekarang Giliran Anda. klik link dibawah ini : 
        ";
            $kirim_feedback_ke_CBDO = send_wa('62816767176',$message_CBDO,'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_lembur_CBDO.php?ID='.$id.'');
            //END
            echo "<script>alert('yes')</script>";
            echo "<script>document.location.href='form_control_lembur_HR.php'</script>";

        } 
?>
<div id="page-content">
 <div class="block full">
  <div class="block-title">
    <div class="row">
      <div class="col-md-8">
        <h2 style="font-size: 20px;margin: 13px;">HALAMAN PERSETUJUAN LEMBUR</h2>
      </div>
      <div class="col-md-4">
              
             <br>
              <?php 
              $sql_cek = mysql_num_rows(mysql_query("SELECT * FROM tb_permohonan_lembur WHERE pembatalan_lembur = 1"));
              $cek = $sql_cek['pembatalan_lembur'];
              if($_SESSION['ID_karyawan'] == 16){
              if($sql_cek == 1 ){
               ?>
               <a href="#modal-fade" class="btn btn-effect-ripple btn-danger" data-toggle="modal" style="float:right; ">PERMOHONAN PEMBATALAN LEMBUR</a>
              <?php  }}else { ?>
                
                
              <?php } ?>
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
            <th>Waktu<br><h5>Mulai / Waktu Akhir</h5></th>
            <th>Penggantian Lembur</th>
            <th style="width: 20px;">Tanggal Lembur</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if($_SESSION['ID_karyawan']==16){
            $sql_approve_hr = mysql_query("SELECT `tb_permohonan_lembur`.*, tb_jabatan.nama_jabatan, tb_department.nama_department,tb_karyawan.* FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_permohonan_lembur.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE tb_permohonan_lembur.StatusLembur = '0' AND ApprovedBy = 'CHECKED' AND ReceivedBy = '16'");
            while($data = mysql_fetch_array($sql_approve_hr)){
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
              <a href="form_control_lembur_HR.php?terima_HR=<?php echo $data[0] ?>&telpon=<?php echo $data['no_telp'] ?>&id_CA=<?php echo $_SESSION['ID_karyawan'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>TERIMA PERMOHONAN</span></a>
             
            </td>
          </tr>
          <?php } } ?>
        </tbody>
      </table>
    </div>

  </div>
</div>
<!-- END PAGE CONTENT -->
<form method="post">
    <div id="modal-fade" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 809px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><strong> Permohonan Pembatalan Cuti Karyawan </strong></h3>
                </div>
                <div class="modal-body" style="height:auto;">
                    <table class="table table-striped">
                        <thead style="font-weight: bolder;">
                            <td style="width: 20px;">Nama</td>
            <td style="width: 20px;">Jabatan / Department</td>
            <td style="width: 20px;">Tanggal Pengajuan</td>
            <td style="width: 20px;">Deskripsi Pekerjaan</td>
            <td style="width: 20px;">Nama Project</td>
            <td style="width: 20px;">Waktu<br><h5>Mulai / Wakti Akhir</h5></td>
            <td style="width: 20px;">Penggantian Lembur</td>
            <td style="width: 20px;">Tanggal Lembur</td>
            <td style="width: 20px;">Aksi</td>
                        </thead>
                        <?php
                        //TERIMA PEMBATALAN LEMBUR
                          if(isset($_GET['delete_pembatalan'])){
                            $telp_karyawan = $_GET['telp'];
                            $delete_batal = mysql_query("DELETE FROM tb_permohonan_lembur WHERE ID_master_lembur = '$_GET[delete_pembatalan]'");
                            if($delete_batal){
                              
                              $kirim_feedback_ke_karyawan = send_wa($telp_karyawan,'PEMBATALAN LEMBUR ANDA TELAH DI SETUJUI, klik link dibawah ini : ','LEMBUR','inboard.ardgroup.co.id');
                              echo "<script>document.location.href='form_control_lembur_HR.php'</script>";
                            }
                          }
                            //TOLAK PEMBATALAN CUTI
                          if(isset($_GET['tolak_pembatalan'])){
                            $telp_karyawan1 = $_GET['telpon'];
                            $tolak = mysql_query("UPDATE tb_permohonan_lembur SET pembatalan_lembur = 0 WHERE ID_master_lembur = '$_GET[tolak_pembatalan]'");
                            if($tolak){
                              $kirim_feedback_ke_karyawan = send_wa($telp_karyawan1,'PEMBATALAN LEMBUR ANDA DI TOLAK, klik link dibawah ini : ','LEMBUR','inboard.ardgroup.co.id');
                             
                              echo "<script>document.location.href='form_control_lembur_HR.php'</script>";
                            }
                          }
                          $No= 1; 
                          $tampil_data = mysql_query("SELECT tb_permohonan_lembur.*,tb_karyawan.*,tb_jabatan.*, tb_department.* FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_permohonan_lembur.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_department.ID = tb_karyawan.departement WHERE pembatalan_lembur = 1");
                           while($tampil = mysql_fetch_array($tampil_data)){
                         ?>
                        <tr>
                            <td><?php echo $tampil['nama_lengkap'] ?></td>
            <td><?php echo $tampil['nama_jabatan']." /<br> ". $tampil['nama_department'] ?></td>
            <td><?php echo $tampil['Tanggal_pengajuan'] ?></td>
            <td><?php echo $tampil['DeskripsiPengerjaan'] ?></td>
            <td><?php echo $tampil['NamaProject'] ?></td>
            <td><?php echo $tampil['WaktuMulaiKerja']." / ". $tampil['WaktuSelesaiKerja']?></td>
            <td><?php echo $tampil['Penggantian_Lembur'] ?></td>
            <td><?php echo $tampil['TanggalLembur'] ?></td>
                            <td>
                              <a onclick="return confirm('Apakah anda yakin? Aksi ini tidak dapat di ulangi')" href="form_control_lembur_HR.php?delete_pembatalan=<?php echo $tampil['ID_master_lembur'] ?>&telp=<?php echo $tampil['no_telp'] ?>" data-toggle="tooltip" title="Terima" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-check"></i></a>
                              <a onclick="return confirm('Apakah anda yakin? Aksi ini tidak dapat di ulangi')" href="form_control_lembur_HR.php?tolak_pembatalan=<?php echo $tampil['ID_master_lembur'] ?>&telpon=<?php echo $tampil['no_telp'] ?>" data-toggle="tooltip" title="Delete" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-close"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
</form>

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