<?php
include 'inc/config.php';  ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
$tanggal_sekarang = date('d-m-Y');
$jam_sekarang = date('H:i:s');

if(isset($_POST['checkin'])){
  $sql_checkin = mysql_query("INSERT INTO `tb_absensi_karyawan` (`ID_absensi`, `ID_karyawan`, `TanggalAbsen`, `JamMasuk`, `JamKeluar`, `Keterangan`) VALUES (NULL, '$_SESSION[ID_karyawan]', '$tanggal_sekarang', '$jam_sekarang', '', '');");
  if($sql_checkin){
    echo "<script>document.location.href='absen_internship.php'</script>";
  }else{
    echo "<script>alert('Koneksi ke server terputus silakan ulangi')</script>";
    echo "<script>document.location.href='absen_internship.php'</script>";
  }
}

if(isset($_POST['checkout'])){
  $kegiatan = $_POST['kegiatan'];
  $sql_checkout = mysql_query("UPDATE `tb_absensi_karyawan` SET `JamKeluar` = '$jam_sekarang',  `Keterangan` = '$kegiatan' WHERE `ID_karyawan` = '$_SESSION[ID_karyawan]' AND TanggalAbsen = '$tanggal_sekarang';");
  if($sql_checkout){

    echo "<script>document.location.href='absen_internship.php'</script>";
  }else{
    echo "<script>alert('Koneksi ke server terputus silakan ulangi')</script>";
    echo "<script>document.location.href='absen_internship.php'</script>";
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

  <div id="page-content">
    <div class="block ">
      <div class="block-title">

        <h2>Absensi Internship</h2>

      </div>

      <div class="container" style="width: 100%;">

        <div class="row">
          <div class="col-md-8">
           <script type="text/javascript">
            window.onload = setInterval(clock,1000);

            function clock()
            {
              var d = new Date();

              var date = d.getDate();

              var month = d.getMonth();
              var montharr =["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
              month=montharr[month];

              var year = d.getFullYear();

              var day = d.getDay();
              var dayarr =["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
              day=dayarr[day];

              var hour =d.getHours();
              var min = d.getMinutes();
              if(min<10){
                min = '0'+min;
              }
              var sec = d.getSeconds();
              
              if(sec<10){
                sec = '0'+sec;
              }
              document.getElementById("date").innerHTML=day+", "+date+" "+month+" "+year;
              document.getElementById("time").innerHTML=hour+":"+min+":"+sec;
            }
          </script>

          <div>
            <center style="font-size: 2.5vw">
              <strong id="date"></strong><br>
              <strong id="time"></strong>
            </center>
          </div>



        </div>
        <div class="col-md-4">



          <form method="post">
            <?php  
            $cek_hadir = mysql_fetch_array(mysql_query("SELECT * FROM `tb_absensi_karyawan` WHERE `TanggalAbsen` = '$tanggal_sekarang'  AND ID_karyawan = '$_SESSION[ID_karyawan]'"));
            if($cek_hadir['JamMasuk']==''){
              echo '<center><p>Silakan untuk menekan tombol check-in untuk masuk</p>
              <br><input type="submit" class="btn btn-success" name="checkin" value="ABSEN MASUK"></center>';
            }else if($cek_hadir['JamMasuk']!='' && $cek_hadir['JamKeluar']=='' ){
              echo '
              <center><p>Jangan lupa untuk mengisikan form kegiatan di bawah ini : </p>
              <input type="text" name="kegiatan" value="Kegiatan Kantor" class="form-control" ><br>
              <input type="submit" class="btn btn-danger" name="checkout" value="ABSEN KELUAR"></center>';
            }else{
              echo "<b>Terima Kasih Telah taat administrasi!<br>Tidak ada kewajiban absen untuk saat ini, sampai jumpa di hari berikutnya</b>";
            }
            ?>

          </form>
          <br><br>
        </div>
      </div>

    </div>
  </div>

  <div class="block">
    <div class="block-title"><h2>LAPORAN ABSENSI ANDA</h2></div>
    <div class="block-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            Pilih Periode
            <form method="post">
              <div class="input-group input-daterange" data-date-format="dd-mm-yyyy">
                <input type="text" id="example-daterange1" name="daterange1" class="form-control" placeholder="From" required="" value="<?php echo $_POST['daterange1'] ?>">
                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                <input type="text" id="example-daterange2" name="daterange2" class="form-control" placeholder="To" required="" value="<?php echo $_POST['daterange2'] ?>">
              </div>
              <input type="submit" value="TAMPILKAN FILTER" class="btn btn-primary" name="periode" style="float: left; margin: 5px 5px 5px 5px;">
            </form>
              <a href="absen_internship.php" style="float: left; margin: 5px 5px 5px 0px;"><button class="btn btn-success">TAMPILKAN SEMUA</button></a>


            <br>
            <br>
          </div>
        </div>
        <div class="row">
          <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <thead>
              <tr>
                  <th>No</th>
                  <th>Informasi Karyawan</th>
                  <th>Tanggal Absen</th>
                  <th>Jam Masuk</th>
                  <th>Jam Keluar</th>
                  <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              if(isset($_POST['periode'])){

                $dari = $_POST['daterange1'];
                $sampai = $_POST['daterange2'];

                $sql = mysql_query("SELECT tb_absensi_karyawan.* , tb_karyawan.nama_lengkap, tb_jabatan.nama_jabatan, tb_karyawan.departement, tb_department.nama_department FROM tb_absensi_karyawan 
                JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_absensi_karyawan.ID_karyawan
                JOIN tb_department ON tb_department.ID = tb_karyawan.departement
                JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID WHERE  tb_absensi_karyawan.ID_karyawan = '$_SESSION[ID_karyawan]' AND (TanggalAbsen BETWEEN '$dari' AND '$sampai') ");
              }else{
              $sql = mysql_query("SELECT tb_absensi_karyawan.* , tb_karyawan.nama_lengkap, tb_jabatan.nama_jabatan, tb_karyawan.departement, tb_department.nama_department FROM tb_absensi_karyawan 
                JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_absensi_karyawan.ID_karyawan
                JOIN tb_department ON tb_department.ID = tb_karyawan.departement
                JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID WHERE tb_absensi_karyawan.ID_karyawan = '$_SESSION[ID_karyawan]'");
              }
              while($data= mysql_fetch_array($sql)){
                ?>
                <tr <?php if($data['Keterangan']=='ABSEN/IZIN'){echo "style='background:#de815c; color:white;'";} ?>>
                	<td><?php echo $no ?></td>
                  <td>
                    <?php 
                      echo "<b>".$data['nama_lengkap']."</b> / ".$data['nama_jabatan']."<br>".$data['nama_department'];
                     ?>
                  </td>
                  <td><?php echo $data['TanggalAbsen']; ?></td>
                  <td><?php echo $data['JamMasuk']; ?></td>
                  <td><?php echo $data['JamKeluar']; ?></td>
                  <td><?php echo $data['Keterangan']; ?></td>
                </tr>
                <?php
                $no++;
              }
              ?>
            </tbody>
          </table>
          <br>
          <br>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

</body>
</html>

<style >

</style>


<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>


<script src="js/pages/uiTables.js"></script>
<script>$(function(){ UiTables.init(); });</script>


  
<script type="text/javascript">
  $('#textarea-ckeditor').css('display','none');
  $('#textarea-ckeditor-tidak').css('display','none');

  $('#example-checkbox1').change(function(){
    if (this.checked) {
      $('#textarea-ckeditor').css('display','block');
      $('#textarea-ckeditor-tidak').css('display','none')
    }
  })


  $('#example-checkbox1-tidak').change(function(){
    if (this.checked) {
      $('#textarea-ckeditor-tidak').css('display','block');
      $('#textarea-ckeditor').css('display','none');
    }
  })

</script>

<?php include 'inc/template_end.php'; ?>
