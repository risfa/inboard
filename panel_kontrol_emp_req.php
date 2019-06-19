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
  $data_lead = $_GET['lead'];
  $data_kar = $_GET['karyawan'];
  $get_data_pengajuan = mysql_fetch_array(mysql_query("SELECT * FROM tb_employee_req WHERE ID_emp_req = '$_GET[tolak]'"));
  $get_data_lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$data_lead'"));
  $get_data_karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$data_kar'"));
  $delete_permohonan_cuti = mysql_query("UPDATE `tb_employee_req` SET `Status_request` = 'TIDAK DAPAT DITINDAKLAJUTI' WHERE `tb_employee_req`.`ID_emp_req` = '$_GET[tolak]'");
  
  $message = "Ssssttt.. untuk permohonan keluhan anda pada tanggal ".$get_data_pengajuan['tanggal_pengajuan'].", *".$get_data_lead['nama_lengkap']."* Minta Kamu Untuk Ngobrol, Klik Link Dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa($telp,$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');

  $message = "Untuk permohonan keluhan *".$get_data_karyawan['nama_lengkap']."* pada tanggal *".$get_data_pengajuan['tanggal_pengajuan']."*, Tidak dapat ditindaklanjuti oleh *".$get_data_lead['nama_lengkap']."* , Klik Link Dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa('62816767176',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');

  $message = "Untuk permohonan keluhan *".$get_data_karyawan['nama_lengkap']."* pada tanggal *".$get_data_pengajuan['tanggal_pengajuan']."*, Tidak dapat ditindaklanjuti oleh *".$get_data_lead['nama_lengkap']."* , Klik Link Dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa('628161988871',$message,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
  echo "<script>document.location.href='panel_kontrol_emp_req.php'</script>";

            //KIRIM PEMBERITAHUAN BAHWA DI TOLAK
}

if(isset($_GET['dalam_pengajuan'])){
  $nmr_karyawan = $_GET['telpon'];
  $id_kat = $_GET['Kategori'];
  $id_aju = $_GET['dalam_pengajuan'];

  $data_kat = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_kat'"));

  $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_employee_req ON tb_karyawan.ID_karyawan = tb_employee_req.ID_karyawan WHERE ID_emp_req = '$id_aju'"));

  $update_status_request = mysql_query("UPDATE `tb_employee_req` SET `Status_request` = 'DALAM PEMBAHASAN' WHERE `tb_employee_req`.`ID_emp_req` = '$_GET[dalam_pengajuan]'");

            //KIRIM MESSAGE KE KARYAWAN
  $message_karyawan = "Request Anda Pada Tanggal *".$data_pemohon['tanggal_pengajuan']."* Telah Di Setujui Oleh *".$data_kat['nama_lengkap']."* Dengan Status *".$data_pemohon['Status_request']."* klik link dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
            //END

            //KIRIM MESSAGE KE TOP LEADER
  $kirim_ke_atasan = send_wa('628161988871',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal_pengajuan']."* Dengan Status *".$data_pemohon['Status_request']."* telah disetujui oleh *".$data_kat['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
  $kirim_ke_atasan1 = send_wa('62816767176',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal_pengajuan']."* Dengan Status *".$data_pemohon['Status_request']."* telah disetujui oleh *".$data_kat['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
            //END 62816767176
  echo "<script>document.location.href='panel_kontrol_emp_req.php'</script>";
}

if(isset($_GET['dalam_pembahasan'])){
  $nmr_karyawan = $_GET['telpon'];
  $id_kat = $_GET['Kategori'];
  $id_aju = $_GET['dalam_pembahasan'];

  $data_kat = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_kat'"));

  $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_employee_req ON tb_karyawan.ID_karyawan = tb_employee_req.ID_karyawan WHERE ID_emp_req = '$id_aju'"));

  $update_status_request1 = mysql_query("UPDATE `tb_employee_req` SET `Status_request` = 'PROSES APPROVAL' WHERE `tb_employee_req`.`ID_emp_req` = '$_GET[dalam_pembahasan]'");
             //KIRIM MESSAGE KE KARYAWAN
  $message_karyawan = "Request Anda Pada Tanggal *".$data_pemohon['tanggal_pengajuan']."* Telah Di Setujui Oleh *".$data_kat['nama_lengkap']."* Dengan Status *".$data_pemohon['Status_request']."* klik link dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
            //END

            //KIRIM MESSAGE KE TOP LEADER
  $kirim_ke_atasan = send_wa('628161988871',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal_pengajuan']."* Dengan Status *".$data_pemohon['Status_request']."* telah disetujui oleh *".$data_kat['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
  $kirim_ke_atasan1 = send_wa('62816767176',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal_pengajuan']."* Dengan Status *".$data_pemohon['Status_request']."* telah disetujui oleh *".$data_kat['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
            //END

  if($update_status_request1){
  echo "<script>document.location.href='panel_kontrol_emp_req.php'</script>";
}else{
echo "<script>alert('no')</script>";
  echo "<script>document.location.href='panel_kontrol_emp_req.php'</script>";
}

}

if(isset($_GET['proses_approval'])){
  $nmr_karyawan = $_GET['telpon'];
  $id_kat = $_GET['Kategori'];
  $id_pro = $_GET['proses_approval'];

  $data_kat = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_kat'"));

  $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_employee_req ON tb_karyawan.ID_karyawan = tb_employee_req.ID_karyawan WHERE ID_emp_req = '$id_pro'"));

  $update_status_request1 = mysql_query("UPDATE `tb_employee_req` SET `Status_request` = 'PENGAJUAN BIAYA' WHERE `tb_employee_req`.`ID_emp_req` = '$_GET[proses_approval]'");
            //KIRIM MESSAGE KE KARYAWAN
  $message_karyawan = "Request Anda Pada Tanggal *".$data_pemohon['tanggal_pengajuan']."* Telah Selesai Di Bahas Oleh *".$data_kat['nama_lengkap']."* Dengan Status Saat ini Sedang *".$data_pemohon['Status_request']."* klik link dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
            //END

            //KIRIM MESSAGE KE TOP LEADER
  $kirim_ke_atasan = send_wa('628161988871',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal_pengajuan']."* Dengan Status *".$data_pemohon['Status_request']."* telah disetujui oleh *".$data_kat['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
  $kirim_ke_atasan1 = send_wa('62816767176',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal_pengajuan']."* Dengan Status *".$data_pemohon['Status_request']."* telah disetujui oleh *".$data_kat['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
            //END
  if($update_status_request1){
  // echo "<script>alert('yes')</script>";
  echo "<script>document.location.href='panel_kontrol_emp_req.php'</script>";
}else{
echo "<script>alert('no')</script>";
  echo "<script>document.location.href='panel_kontrol_emp_req.php'</script>";
 }

}

if(isset($_GET['pengajuan_biaya'])){
  $nmr_karyawan = $_GET['telpon'];
  $id_kat = $_GET['Kategori'];
  $id_aju = $_GET['pengajuan_biaya'];

  $data_kat = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$id_kat'"));

  $data_pemohon = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_employee_req ON tb_karyawan.ID_karyawan = tb_employee_req.ID_karyawan WHERE ID_emp_req = '$id_aju'"));

  $update_status_request1 = mysql_query("UPDATE `tb_employee_req` SET `Status_request` = 'MENUNGGU ACTION KARYAWAN' WHERE `tb_employee_req`.`ID_emp_req` = '$_GET[pengajuan_biaya]'");
            //KIRIM MESSAGE KE KARYAWAN
  $message_karyawan = "Request Anda Pada Tanggal *".$data_pemohon['tanggal_pengajuan']."* Telah Di Proses Oleh *".$data_kat['nama_lengkap']."* Dengan Status Sedang *".$data_pemohon['Status_request']."* klik link dibawah ini : ";
  $kirim_feedback_ke_karyawan = send_wa($nmr_karyawan,$message_karyawan,'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
            //END

            //KIRIM MESSAGE KE TOP LEADER
  $kirim_ke_atasan = send_wa('628161988871',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal_pengajuan']."* Dengan Status *".$data_pemohon['Status_request']."* telah disetujui oleh *".$data_kat['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
  $kirim_ke_atasan1 = send_wa('62816767176',"Request *".$data_pemohon['nama_lengkap']."* pada tanggal *".$data_pemohon['tanggal_pengajuan']."* Dengan Status *".$data_pemohon['Status_request']."* telah disetujui oleh *".$data_kat['nama_lengkap']."* klik link dibawah ini : ",'PENGAJUAN KELUHAN','inboard.ardgroup.co.id');
            //END
  if($update_status_request1){
  // echo "<script>alert('yes')</script>";
  echo "<script>document.location.href='panel_kontrol_emp_req.php'</script>";
}else{
echo "<script>alert('no')</script>";
  echo "<script>document.location.href='panel_kontrol_emp_req.php'</script>";
}

}
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
  <?php
  ?>

  <div id="page-content">
   <div class="block full">
    <div class="block-title">
      <div class="row">
        <div class="col-md-8">
          <h2 style="font-size: 20px;margin: 13px;">HALAMAN PERSETUJUAN PENGAJUAN KELUHAN</h2>
        </div>
        <div class="col-md-4">

         <br>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
        <thead>
          <tr>
            <th class="text-center" style="width: 10px; text-align: center;">No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Perusahaan</th>
            <th>Tanggal Pengajuan</th>
            <th>Kategori</th>
            <th>Keterangan</th>
            <th>Kualifikasi</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
          <?php
          
          $tampil = mysql_query("SELECT * FROM tb_employee_req");
          $data_tampil = mysql_fetch_array($tampil);
            if($data_tampil['kategori_request'] == 'Teknis' && $_SESSION['ID_karyawan']== 6){
              $no = 1;
          $sql = mysql_query("SELECT tb_karyawan.*, tb_department.nama_department, tb_jabatan.nama_jabatan, tb_employee_req.* FROM tb_employee_req JOIN tb_karyawan ON tb_employee_req.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE kategori_request= 'Teknis'  ORDER BY ID_emp_req DESC");
         while($data = mysql_fetch_array($sql)){
           ?>
           <tr>
            <td style="text-align: center;"><?php echo $no ?></td>
            <td><?php echo $data['nama_lengkap'] ?></td>
            <td><?php echo $data['nama_jabatan']."<br>". $data['nama_department'] ?></td>
            <td> <?php echo $data['perusahaan'] ?></td>
            <td> <?php echo $data['tanggal_pengajuan'] ?></td>
            <td> <?php echo $data['kategori_request'] ?></td>
            <td> <?php echo $data['keterangan'] ?></td>
            <td>  <?php echo $data['kualifikasi'] ?></td>
            <td>  
              <?php if($data['Status_request']=="DALAM PENGAJUAN"){ ?>
               <a href="panel_kontrol_emp_req.php?dalam_pengajuan=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&Kategori=<?php echo $data['Approve_By'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>CHECK PERMOHONAN</span></a>
               <a href="panel_kontrol_emp_req.php?tolak=<?php echo $data['ID_emp_req'] ?>&ditolak=<?php echo $data['no_telp'] ?>&lead=<?php echo $data['Approve_By'] ?>&karyawan=<?php echo $data['ID_karyawan'] ?>"><span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i>TIDAK DAPAT DILANJUTI</span></a>
                
             <?php }else if($data['Status_request']=='DALAM PEMBAHASAN'){ ?>
               <a href="panel_kontrol_emp_req.php?dalam_pembahasan=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&Kategori=<?php echo $data['Approve_By'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>NEXT PROSES</span></a>
               <a href="panel_kontrol_emp_req.php?tolak=<?php echo $data['ID_emp_req'] ?>&ditolak=<?php echo $data['no_telp'] ?>&lead=<?php echo $data['Approve_By'] ?>&karyawan=<?php echo $data['ID_karyawan'] ?>"><span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i>TIDAK DAPAT DILANJUTI</span></a>
                
             <?php }else if($data['Status_request']=='PROSES APPROVAL'){ ?>
               <a href="panel_kontrol_emp_req.php?proses_approval=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&Kategori=<?php echo $data['Approve_By'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PROSES APPROVAL</span></a>
                <a href="panel_kontrol_emp_req.php?tolak=<?php echo $data['ID_emp_req'] ?>&ditolak=<?php echo $data['no_telp'] ?>&lead=<?php echo $data['Approve_By'] ?>&karyawan=<?php echo $data['ID_karyawan'] ?>"><span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i>TIDAK DAPAT DILANJUTI</span></a>
             <?php }else if($data['Status_request']=='PENGAJUAN BIAYA'){ ?>
               <a href="panel_kontrol_emp_req.php?pengajuan_biaya=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&Kategori=<?php echo $data['Approve_By'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PROSES PENGAJUAN BIAYA</span></a>
                
             <?php }else{ ?>
            	<span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>SELESAI</span>
           </td>
         <?php } ?>
         </tr>
         <?php $no++; } 
              }else if($data_tampil['kategori_request']=='Administrasi' && $_SESSION['ID_karyawan'] == 16){
                $no = 1;
          $sql = mysql_query("SELECT tb_karyawan.*, tb_department.nama_department, tb_jabatan.nama_jabatan, tb_employee_req.* FROM tb_employee_req JOIN tb_karyawan ON tb_employee_req.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE kategori_request='Administrasi' ORDER BY ID_emp_req DESC");
         while($data = mysql_fetch_array($sql)){
           ?>
           <tr>
            <td style="text-align: center;"><?php echo $no ?></td>
            <td><?php echo $data['nama_lengkap'] ?></td>
            <td><?php echo $data['nama_jabatan']."<br>". $data['nama_department'] ?></td>
            <td> <?php echo $data['perusahaan'] ?></td>
            <td> <?php echo $data['tanggal_pengajuan'] ?></td>
            <td> <?php echo $data['kategori_request'] ?></td>
            <td> <?php echo $data['keterangan'] ?></td>
            <td>  <?php echo $data['kualifikasi'] ?></td>
            <td>  
              <?php if($data['Status_request']=="DALAM PENGAJUAN"){ ?>
               <a href="panel_kontrol_emp_req.php?dalam_pengajuan=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&Kategori=<?php echo $data['Approve_By'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>CHECK PERMOHONAN</span></a>
                
             <?php }else if($data['Status_request']=='DALAM PEMBAHASAN'){ ?>
               <a href="panel_kontrol_emp_req.php?dalam_pembahasan=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&Kategori=<?php echo $data['Approve_By'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>DALAM PEMBAHASAN</span></a>
                
             <?php }else if($data['Status_request']=='PROSES APPROVAL'){ ?>
               <a href="panel_kontrol_emp_req.php?proses_approval=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&Kategori=<?php echo $data['Approve_By'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PROSES APPROVAL</span></a>
                <a href="panel_kontrol_emp_req.php?tolak=<?php echo $data['ID_emp_req'] ?>&ditolak=<?php echo $data['no_telp'] ?>&lead=<?php echo $data['Approve_By'] ?>&karyawan=<?php echo $data['ID_karyawan'] ?>"><span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i>TIDAK DAPAT DILANJUTI</span></a>
             <?php }else if($data['Status_request']=='PENGAJUAN BIAYA'){ ?>
               <a href="panel_kontrol_emp_req.php?pengajuan_biaya=<?php echo $data['ID_emp_req'] ?>&telpon=<?php echo $data['no_telp'] ?>&Kategori=<?php echo $data['Approve_By'] ?>"><span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>PENGAJUAN BIAYA</span></a>
                
             <?php }else{ ?>
            	<span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>SELESAI</span>
           </td>
         <?php } ?>
         </tr>
         <?php $no++; } 
              }
            
           
         if($_SESSION['ID_karyawan'] == 5 OR $_SESSION['ID_karyawan']== 4){
          $no = 1;
          $sql = mysql_query("SELECT tb_karyawan.*, tb_department.nama_department, tb_jabatan.nama_jabatan, tb_employee_req.* FROM tb_employee_req JOIN tb_karyawan ON tb_employee_req.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID  ORDER BY ID_emp_req DESC");
         while($data = mysql_fetch_array($sql)){
           ?>
           <tr>
            <td style="text-align: center;"><?php echo $no ?></td>
            <td><?php echo $data['nama_lengkap'] ?></td>
            <td><?php echo $data['nama_jabatan']."<br>". $data['nama_department'] ?></td>
            <td><?php echo $data['perusahaan'] ?></td>
            <td><?php echo $data['tanggal_pengajuan'] ?></td>
            <td><?php echo $data['kategori_request'] ?></td>
            <td><?php echo $data['keterangan'] ?></td>
            <td><?php echo $data['kualifikasi'] ?></td>
            <td>
              <?php echo $data['Status_request'] ?>
            </td>
         </tr>
         <?php $no++; } } ?>
       </tbody>

     </table>
   </div>
 </div>
</div>
<!-- END Page Content -->
</body>
</html>
<!-- Page content -->


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
