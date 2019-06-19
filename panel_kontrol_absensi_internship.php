<?php
include 'inc/config.php';  ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
$tanggal_sekarang = date('d-m-Y');
$jam_sekarang = date('H:i:s');

if(isset($_GET['set_izin'])){
  $sql_izin = mysql_query("INSERT INTO `tb_absensi_karyawan` (`ID_absensi`, `ID_karyawan`, `TanggalAbsen`, `JamMasuk`, `JamKeluar`, `Keterangan`) VALUES (NULL, '$_GET[set_izin]', '$tanggal_sekarang', '00:00:00', '00:00:00', 'ABSEN/IZIN');");
    echo "<script>document.location.href='panel_kontrol_absensi_internship.php'</script>";
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

        <h2>Kontrol Absensi Internship Hari Ini <?php echo date('d-m-Y'); ?></h2>

      </div>

      <div class="container" style="width: 100%;">

        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped">
              <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            <?php 
            $no=1;
              $sql_anak_magang = mysql_query("SELECT tb_karyawan.*,  tb_jabatan.nama_jabatan, tb_department.nama_department FROM tb_karyawan
                  JOIN tb_jabatan ON tb_jabatan.ID = tb_karyawan.jabatan
                  JOIN tb_department ON tb_department.ID = tb_karyawan.departement
                  WHERE tb_jabatan.nama_jabatan LIKE '%Internship%'");
              while($data_anak_magang = mysql_fetch_array($sql_anak_magang)){
                 $cek_status = mysql_fetch_array(mysql_query("SELECT * FROM tb_absensi_karyawan WHERE ID_karyawan = '$data_anak_magang[ID_karyawan]' AND TanggalAbsen = '$tanggal_sekarang'"));

            ?>
              <tr style="">
                <td><?php echo $no; ?></td>
                <td><?php echo $data_anak_magang['nama_lengkap'] ?></td>
                <td><?php echo $data_anak_magang['nama_jabatan']." | ".$data_anak_magang['nama_department'] ?></td>
                <td><?php 

                  if($cek_status['JamMasuk']==''){
                    echo "Belum Absen";
                  }else if($cek_status['JamMasuk']!='' && $cek_status['Keterangan']!='ABSEN/IZIN'){
                    echo "Sedang Bekereja, Belum absen pulang";
                  }else if($cek_status['JamKeluar']!=''&& $cek_status['Keterangan']!='ABSEN/IZIN'){
                    echo "Sudah Absen pulang";
                  }else if($cek_status['Keterangan']=='ABSEN/IZIN' && $cek_status['JamKeluar']=='00:00:00'){
                    echo "ABSEN/IZIN";
                  }
                 ?></td>
                <td>
                  <?php  
                 

                  if($cek_status['Keterangan']!='ABSEN/IZIN' && $cek_status['JamMasuk']==''){
                   ?>
                    <a href="panel_kontrol_absensi_internship.php?set_izin=<?php echo $data_anak_magang[ID_karyawan] ?>"><label class="label label-danger">ABSEN/IZIN</label></a>
                  <?php }  ?>

                </td>

              </tr>
            <?php $no++;  } ?>

            </table>
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
                JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID WHERE  TanggalAbsen BETWEEN '$dari' AND '$sampai' ");
              }else{
              $sql = mysql_query("SELECT tb_absensi_karyawan.* , tb_karyawan.nama_lengkap, tb_jabatan.nama_jabatan, tb_karyawan.departement, tb_department.nama_department FROM tb_absensi_karyawan 
                JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_absensi_karyawan.ID_karyawan
                JOIN tb_department ON tb_department.ID = tb_karyawan.departement
                JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID ");
              }
              while($data= mysql_fetch_array($sql)){
                ?>
                <tr <?php if($data['Keterangan']=='ABSEN/IZIN'){echo "style='background:#de815c; color:white;'";} ?>>
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
<!-- END Page Content -->
</body>
</html>

<style >

</style>
<!-- Page content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/uiTables.js"></script>
<script>$(function(){ UiTables.init(); });</script>


  <!-- function myFunction() {
var x = document.getElementById("textarea-ckeditor-tidak").required;
} -->
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
