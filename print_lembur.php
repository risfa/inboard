<?php
include ('Db/connect.php');
 include 'wa.php';
 //generate Bulan
$arrBulan = array();
for ($i=0; $i < 5; $i++) { 
  $bulan = date("F Y",strtotime("August 2018" ." +". $i ." month"));
  $arrBulan[] = $bulan;
  
}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>
</head>
<body>
<div id="page-content">
 <div class="block full">
        <div class="block-title">
          <div class="row">
            <div class="col-md-3">
                <h2 style="font-size: 20px;margin: 13px; font-family: 'Lato', sans-serif;">Rekap Daftar Lembur</h2>
            </div>
            <div class="col-md-9">
              <!-- <a href="export.php" class="btn btn-effect-ripple btn-info" style="float:right; ">EXPORT</a> -->
            </div>
          </div>
        </div>
       
        <div class="table-responsive">
            <table id="example-datatable" style="" class="table-stripped">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 150px; text-align: center; font-family: 'Lato', sans-serif; border: 1px solid black;">No</th>
                        <th style="width: 330px; font-family: 'Lato', sans-serif; border: 1px solid black;">Nama</th>
                        <th style="width: 350px; font-family: 'Lato', sans-serif; border: 1px solid black;">Nama Project<br> Deskripsi Pekerjaan</th>
                        <th style="width: 150px; font-family: 'Lato', sans-serif; border: 1px solid black;">Jumlah Hari</th>
                        <th style="width: 150px; font-family: 'Lato', sans-serif; border: 1px solid black;">Jam Lembur</th>
                        <th style="width: 150px; font-family: 'Lato', sans-serif; border: 1px solid black;">Tanggal Lembur</th>
                        <!-- <th style="width: 20px; font-family: 'Lato', sans-serif; border: 1px solid black;"></th> -->
                    </tr>
                </thead>
                <tbody>
                  <?php
                   $no = 1;
                   if(isset($_GET['bulan'])){
                    $bulan = str_replace("_", " ", $_GET['bulan']);
                    $date = date('m-Y', strtotime($bulan));
                      $sql = mysql_query("SELECT * FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan where TanggalLembur LIKE '%-$date%' GROUP BY tb_karyawan.ID_karyawan");
                   }else{
                    $sql = mysql_query("SELECT * FROM tb_permohonan_lembur JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_permohonan_lembur.ID_karyawan GROUP BY tb_karyawan.ID_karyawan");
                  }
                    while($data = mysql_fetch_array($sql)){
                   ?>
                   <tr>
                  <td style="text-align: left; font-family: 'Lato', sans-serif; border: 1px solid black;"><?php echo $no ?></td>
                  <td style="text-align: left; font-family: 'Lato', sans-serif; border: 1px solid black;"><?php echo $data['nama_lengkap'] ?></td>
                  <td style="text-align: left; font-family: 'Lato', sans-serif; border: 1px solid black;"><ul>
                    <?php 
                    $loop = mysql_query("SELECT * FROM tb_permohonan_lembur WHERE ID_karyawan='$data[ID_karyawan]' AND TanggalLembur LIKE '%-$date%'");
                    while($tampil = mysql_fetch_array($loop)){
                    ?>
                      <li style="text-align: left; font-family: 'Lato', sans-serif;"><b>Nama Project : </b><?php echo $tampil[NamaProject]?></li>
                      <li style="text-align: left; font-family: 'Lato', sans-serif;"><b>Deskripsi : </b><?php echo $tampil[DeskripsiPengerjaan]?></li>
                      <li style="text-align: left; font-family: 'Lato', sans-serif;"><b>Penggantian Lembur : </b><?php echo $tampil[Penggantian_Lembur]?></li><br>
                      <?php  
                     }
                      ?>
                      </ul>
                    </td>
                    <td style="border: 1px solid black;">
                  <?php 
                  $hari = mysql_fetch_array(mysql_query("SELECT COUNT(TanggalLembur) AS Hari FROM tb_permohonan_lembur WHERE ID_karyawan = '$data[ID_karyawan]' AND TanggalLembur LIKE '%-$date%' AND ApprovedBy ='CHECKED' AND ReceivedBy = 'CHECKED' AND ValidateBy='CHECKED'"));
                  echo "$hari[Hari]";
                  ?>
                    
                  </td>
                    <td style="border: 1px solid black;"> 
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
                  <td style="border: 1px solid black;"> 
                    <ul>
                      <?php 
                        $tanggal = mysql_query("SELECT * FROM tb_permohonan_lembur WHERE ID_karyawan = '$data[ID_karyawan]' AND TanggalLembur LIKE '%-$date%'");
                        while($tgl = mysql_fetch_array($tanggal)){
                          $Tanggal = $tgl['TanggalLembur'];
                          $datee = new DateTime($Tanggal);
                          $date_time = $datee->format('d M Y');
                       ?>
                      <li style="text-align: left; font-family: 'Lato', sans-serif; "><?php echo $date_time ?></li><br>
                      <?php } ?>
                    </ul>

                  </td>
                  <td></td>
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


<!-- Load and execute javascript code used only in this page -->

<script type="text/javascript">

  $('#bulan').change(function(){
    var bulan = $(this).val();
   
    var bulan2 = bulan.replace(" ","_")
    
    location.href = 'excel_lembur.php?bulan='+ bulan2;
  });
 function hide_table(){

        document.getElementById("formnya").style.display = "block";
        document.getElementById("datanya").style.display = "none";

    }
</script>
