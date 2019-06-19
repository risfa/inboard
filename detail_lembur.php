<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
 include 'wa.php';
 //generate Bulan
$arrBulan = array();
for ($i=0; $i < 17; $i++) { 
  $bulan = date("F Y",strtotime("August 2018" ." +". $i ." month"));
  $arrBulan[] = $bulan;
//end of generate bulan
}
// echo "Jam Mulai : ".$jam_mulai='08:30:09'; echo "
// "; 
// echo "Jam Selesai : ".$jam_selesai='09:45:01'; 
// echo "$times = array($jam_mulai,$jam_selesai)"; 
//$times = array(’08:30:22′,’09:45:53′); $seconds = 0; foreach ( $times as $time ) { list( $g, $i, $s ) = explode( ‘:’, $time ); $seconds += $g * 3600; $seconds += $i * 60; $seconds += $s; } $hours = floor( $seconds / 3600 ); $seconds -= $hours * 3600; $minutes = floor( $seconds / 60 ); $seconds -= $minutes * 60; echo “Hasil penjumlahan : {$hours}:{$minutes}:{$seconds}”; echo ”
if(isset($_GET['delete'])){
    $sql_batalkan_lembur = mysql_query("DELETE FROM tb_permohonan_lembur WHERE ID_master_lembur = '$_GET[delete]'");
    if($sql_batalkan_lembur){
        echo "<script>document.location.href='status_lembur.php'</script>";
    }
}
if(isset($_GET['delete1'])){
  $id= $_GET['delete1'];
$update_batal = mysql_query("UPDATE tb_permohonan_lembur SET pembatalan_lembur = 1 WHERE `tb_permohonan_lembur`.`ID_master_lembur` = '$_GET[delete1]'");
if($update_batal){
$idKaryawan = $_GET['id_karyawan'];
$id_leader = $_GET['leader'];
$karyawan = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$idKaryawan'"));

$karyawan2 = mysql_fetch_array(mysql_query("SELECT * FROM `tb_karyawan` JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '$idKaryawan'"));
$telp_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan='$karyawan2[leader]'"));

$karyawan1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_cuti  WHERE ID_karyawan = '$idKaryawan'"));
$kirim_ke_karyawan = send_wa($karyawan['no_telp'],"Permohonan pembatalan Lembur anda sedang di proses, klik link dibawah ini : ",'LEMBUR','inboard.ardgroup.co.id');

$kirim_ke_HR = send_wa('6281316124343',"Karyawan Dengan Nama *".$karyawan['nama_lengkap']."* Meminta pembatalan Cuti Pada Tanggal ".$karyawan1['TanggalLembur'].", klik link dibawah ini : ",'LEMBUR','https://xeniel.5dapps.com/inboard/otu/otu_pembatalan_lembur.php?ID='.$id.'');
$cc_ke_leader = send_wa($telp_leader['no_telp'],"Karyawan Dengan Nama *".$karyawan['nama_lengkap']."* Meminta pembatalan Lembur Pada Tanggal ".$karyawan1['TanggalLembur'].", klik link dibawah ini : ",'LEMBUR','inboard.ardgroup.co.id');

 echo "<script>document.location.href='status_lembur.php'</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
</head>
<body>
<div id="page-content">
 <div class="block full">
        <div class="block-title">
          <div class="row">
            <div class="col-md-3">
                <h2 style="font-size: 20px;margin: 13px;">Daftar Lembur</h2>
            </div>
            <div class="col-md-9">
              <a href="export.php?bulan=<?php echo $_GET[bulan] ?>" class="btn btn-effect-ripple btn-info" style="float:right; ">EXPORT TO EXCEL</a><br><br>
              <a href="print_lembur.php?bulan=<?php echo $_GET['bulan'] ?>" target="blank" class="btn btn-effect-ripple btn-info" style="float:right; ">PRINT</a>
            </div>
          </div>
        </div>
       
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                  <label>Pilih Bulan </label>
                  <select id="bulan">
                    <option></option>
                    <?php
                    $arrLength = count($arrBulan); 
                    for ($i=0; $i < $arrLength ; $i++) {
                       $checkOpt = str_replace(" ", "_", $arrBulan[$i]); 
                      ?>
                     <option class="form-control" <?php if($_GET['bulan'] == $checkOpt){ ?> selected <?php } ?> value="<?php echo $arrBulan[$i]; ?>"><?php echo $arrBulan[$i]; ?></option>
                      <?php
                    } ?>
                  </select>
                    <tr>
                        <th class="text-center" style="width: 10px; text-align: center;">No</th>
                        <th style="width: 40px;">Nama</th>
                        <th style="width: 40px;">Tanggal Pengajuan <br>Nama Project<br> Deskripsi Pekerjaan</th>
                        <th style="width: 20px;">Jumlah Hari</th>
                        <th style="width: 20px;">Jam Lembur</th>
                        <th style="width: 20px;">Tanggal Lembur</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                   $no = 1;
                   if(isset($_GET['bulan'])){
                    $bulan = str_replace("_", " ", $_GET['bulan']);
                    $date = date('m-Y', strtotime($bulan));
                      $sql = mysql_query("SELECT * FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan where TanggalLembur LIKE '%-$date%' AND ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND ValidateBy='CHECKED' GROUP BY tb_karyawan.ID_karyawan");
                   }else{
                    $sql = mysql_query("SELECT * FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan WHERE ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND ValidateBy='CHECKED' GROUP BY tb_karyawan.ID_karyawan");
                  }
                    while($data = mysql_fetch_array($sql)){
                   ?>
                   <tr>
                  <td style="text-align: center;"><?php echo $no ?></td>
                  <td><?php echo $data['nama_lengkap'] ?></td>
                  <td><ul>
                    <?php 
                    $loop = mysql_query("SELECT * FROM tb_permohonan_lembur WHERE ID_karyawan='$data[ID_karyawan]' AND TanggalLembur LIKE '%-$date%' AND ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND ValidateBy='CHECKED'");
                    while($tampil = mysql_fetch_array($loop)){ 
                      // echo "<li><b>Tanggal : </b>$tampil[TanggalLembur]</li>";

                      echo "<li><b>Nama Project : </b> $tampil[NamaProject]</li>";
                      echo "<li><b>Deskripsi : </b> $tampil[DeskripsiPengerjaan]</li>";
                      echo "<li><b>Pergantian Lembur : </b> $tampil[Penggantian_Lembur]</li><br>";
                      
                    }
                    ?>
                      </ul>
                    </td>
                  <td>
                  <?php 
                  $hari = mysql_fetch_array(mysql_query("SELECT COUNT(TanggalLembur) AS Hari FROM tb_permohonan_lembur WHERE ID_karyawan = '$data[ID_karyawan]' AND TanggalLembur LIKE '%-$date%' AND ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND ValidateBy='CHECKED'"));
                  echo "$hari[Hari]";
                  ?>
                    
                  </td>
                  <td> 
                    <ul>
                      <?php 
                        $waktu = mysql_query("SELECT * FROM tb_permohonan_lembur WHERE ID_karyawan = '$data[ID_karyawan]' AND TanggalLembur LIKE '%-$date%' AND ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND ValidateBy='CHECKED'");
                        while($total = mysql_fetch_array($waktu)){
                          $awal  = date_create($total['WaktuMulaiKerja']);
                          $akhir = date_create($total['WaktuSelesaiKerja']);
                          $diff  = date_diff($awal,$akhir);
                          // echo "$diff->h" . " jam, ";
                          // echo "$diff->i" . " menit ";
                       ?>
                       <li><?php echo $total['WaktuMulaiKerja']." - ".$total['WaktuSelesaiKerja'] ?></li>
                      <li><?php echo "$diff->h" . " jam, "."$diff->i" . " menit ";  ?></li><br>
                      <?php } ?>
                    </ul>

                  </td>
                  <td>
                    <ul>
                      <?php 
                        $tanggal = mysql_query("SELECT * FROM tb_permohonan_lembur WHERE ID_karyawan = '$data[ID_karyawan]' AND TanggalLembur LIKE '%-$date%' AND ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND ValidateBy='CHECKED'");
                        while($tgl = mysql_fetch_array($tanggal)){
                          $Tanggal = $tgl['TanggalLembur'];
                          $datee = new DateTime($Tanggal);
                          $date_time = $datee->format('d M Y');
                       ?>
                      <li><?php echo $date_time ?></li><br>
                      <?php } ?>
                    </ul>
                  </td>
                  </tr>
                 <?php $no++; } ?>
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

  $('#export').change(function(){
    var export = $(this).val();
   
    var export2 = export.replace(" ","_")
    
    location.href = 'detail_lembur.php?export='+ export2;
  });
 function hide_table(){

        document.getElementById("formnya").style.display = "block";
        document.getElementById("datanya").style.display = "none";

    }
</script>
<script type="text/javascript">

  $('#bulan').change(function(){
    var bulan = $(this).val();
   
    var bulan2 = bulan.replace(" ","_")
    
    location.href = 'detail_lembur.php?bulan='+ bulan2;
  });
 function hide_table(){

        document.getElementById("formnya").style.display = "block";
        document.getElementById("datanya").style.display = "none";

    }
</script>
