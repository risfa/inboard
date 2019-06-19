<?php include 'inc/config.php';
include 'inc/template_start.php';
include 'inc/page_head.php';
include ('Db/connect.php');

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

  if (isset($_GET['nonaktif'])) {
    if ($_GET['nonaktif'] == 1) {

      $sqlUpdateDisaktif = mysql_query("UPDATE `tb_karyawan` SET `status` = '0' WHERE `tb_karyawan`.`ID_karyawan` = '$_GET[edit]' ");
      if ($sqlUpdateDisaktif) {
        $sqlKaryawanDisaktif = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$_GET[edit]' ");
        $dataKaryawanDisaktif = mysql_fetch_array($sqlKaryawanDisaktif);
        $keterangan_disaktif = "Anda Baru saja non aktifkan karyawan  ".$dataKaryawanDisaktif[0];
        $notifikasiDisaktif = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_GET[edit]','$keterangan_disaktif',0,'nonaktif')");
      }
      echo '<script type="text/javascript">
      iziToast.success({
        title: "OK",
        message: "Karyawan ini telah di non aktifkan",
      });
      </script>';
      echo "<script>document.location.href='data_karyawan.php'</script>";

    }elseif ($_GET['nonaktif'] == 0) {
      $sqlUpdateAktif = mysql_query("UPDATE `tb_karyawan` SET `status` = '1' WHERE `tb_karyawan`.`ID_karyawan` = '$_GET[edit]' ");
      if ($sqlUpdateAktif) {
        $sqlKaryawanAktif = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$_GET[edit]' ");
        $dataKaryawanAktif = mysql_fetch_array($sqlKaryawanAktif);
        $keterangan_aktif = "Anda Baru saja aktifkan karyawan  ".$dataKaryawanAktif[0];
        $notifikasiAktif = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_GET[edit]','$keterangan_aktif',0,'aktif')");
      }
      echo '<script type="text/javascript">
      iziToast.success({
        title: "OK",
        message: "Karyawan ini telah di non aktifkan",
      });
      </script>';
      echo "<script>document.location.href='data_karyawan.php'</script>";
    }
  }
  if(isset($_POST['update'])){
    $sql_udpate = mysql_query("UPDATE tb_karyawan SET nama_lengkap = '$_POST[nama_lengkap]', jenis_kelamin = '$_POST[jenis_kelamin]', no_ktp = '$_POST[no_ktp]', tgl_lahir = '$_POST[tgl_lahir]', agama = '$_POST[agama]', pendidikan = '$_POST[pendidikan]', perusahaan = '$_POST[perusahaan]', jabatan = '$_POST[jabatan]', akses_level = '$_POST[akses_level]', departement = '$_POST[departement]', mulai_bekerja = '$_POST[mulai_bekerja]', NIP = '$_POST[NIP]', no_npwp = '$_POST[no_npwp]', no_telp = '$_POST[no_telp]', alamat = '$_POST[alamat]'  WHERE ID_karyawan = '$_GET[edit]'");

    $ID_karyawan = $_GET['edit'];
    $sql_bank = mysql_query("UPDATE tb_bank SET bank ='$_POST[bank]', nama_pemilik_bank = '$_POST[nama_pemilik_bank]',no_rek='$_POST[no_rek]' WHERE ID_karyawan = '$_GET[edit]'");

    $ID_karyawan = $_GET['edit'];
    $sql_bank = mysql_query("UPDATE tb_login SET email ='$_POST[email]' WHERE ID_karyawan = '$_GET[edit]'");

    if($sql_udpate){

      move_uploaded_file($_FILES["fileToUpload_ktp"]["tmp_name"],"img/KTP/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_pasfoto"]["tmp_name"],"img/PasFoto/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_akta"]["tmp_name"],"img/akta/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_cv"]["tmp_name"],"img/CV/".$ID_karyawan.".jpg");

      echo '<script type="text/javascript">
      iziToast.success({
        title: "OK",
        message: "Data has been Succesfully Updated record!",
      });
      </script>';
      echo "<script>document.location.href='data_karyawan.php'</script>";

    }else{
      echo "<script>alert('Failed Update!')</script>";
      echo "<script>document.location.href='data_karyawan.php'</script>";
    }
  }
  if(isset($_POST['simpan'])){
    $sql_simpan = mysql_query("INSERT INTO `tb_karyawan` (`ID_karyawan`, `nama_lengkap`, `jenis_kelamin`, `no_ktp`, `tgl_lahir`, `agama`, `pendidikan`, `no_telp`, `alamat`, `perusahaan`, `jabatan`, `akses_level`, `departement`, `mulai_bekerja`, `NIP`, `no_npwp`) VALUES (null, '$_POST[nama_lengkap]','$_POST[jenis_kelamin]','$_POST[no_ktp]','$_POST[tgl_lahir]','$_POST[agama]','$_POST[pendidikan]','$_POST[no_telp]','$_POST[alamat]','$_POST[perusahaan]','$_POST[jabatan]','$_POST[akses_level]','$_POST[departement]','$_POST[mulai_bekerja]','$_POST[NIP]','$_POST[no_npwp]');");
    $ID_karyawan = mysql_insert_id();
    $bank_simpan = mysql_query("INSERT INTO tb_bank(ID_bank,bank,nama_pemilik_bank,no_rek,ID_karyawan)VALUES(NULL,'$_POST[bank]','$_POST[nama_pemilik_bank]','$_POST[no_rek]','$ID_karyawan')");
    $ID_karyawan = mysql_insert_id();
    $login_simpan = mysql_query("INSERT INTO tb_login(ID,email,ID_karyawan)VALUES(NULL,'$_POST[email]','$ID_karyawan')");

    if($sql_simpan == true){

      move_uploaded_file($_FILES["fileToUpload_ktp"]["tmp_name"],"img/KTP/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_pasfoto"]["tmp_name"],"img/PasFoto/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_akta"]["tmp_name"],"img/akta/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_cv"]["tmp_name"],"img/CV/".$ID_karyawan.".jpg");

      echo '<script type="text/javascript">
      iziToast.success({
        title: "OK",
        message: "Data has been Succesfully inserted record!",
      });
      </script>';
      
    }else{
      echo "<script>alert('Failed save!')</script>";
      echo "<script>document.location.href='regis_karyawan.php'</script>";
    }
  }
  if(isset($_GET['edit'])){
    $data_edit = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_department ON tb_karyawan.departement= tb_department.ID JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID WHERE ID_karyawan = '$_GET[edit]'"));
    $data_editt = mysql_fetch_array(mysql_query("SELECT * FROM tb_bank WHERE ID_karyawan = '$_GET[edit]'"));
    $login_edit = mysql_fetch_array(mysql_query("SELECT * FROM tb_login WHERE ID_karyawan = '$_GET[edit]'"));
  }
  ?>

  <!-- Page content -->


  <div id="page-content">
    <div class="block full">
      <div class="block-title">
        <div class="row">
          <div class="col-md-6">
            <h2 style="font-size: 20px;margin: 13px;">Informasi Detail Karyawan</h2>
          </div>
          <div class="col-md-6">

          </div>
        </div>
      </div>
      <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
        <div class="row" style="padding:20px;">
          <div class="col-md-6">
            <div class="block">
              <div class="block-title">
                <h2>Data Pribadi</h2>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Nama Lengkap</label>
                <div class="col-md-9">
                  <input type="text" readonly name="nama_lengkap" class="form-control" value="<?php echo $data_edit['nama_lengkap'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Jenis Kelamin</label>
                <div class="col-md-9">
                  <select disabled id="example-chosen" name="jenis_kelamin" required value="<?php echo $data_edit['jenis_kelamin'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['jenis_kelamin'] ?>"><?php echo $data_edit['jenis_kelamin'] ?></option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal Lahir</label>
                <div class="col-md-9">
                  <input type="text" readonly name="tgl_lahir" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $data_edit['tgl_lahir'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Agama</label>
                <div class="col-md-9">
                  <select disabled id="example-chosen" name="agama" required value="<?php echo $data_edit['agama'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['agama'] ?>"><?php echo $data_edit['agama'] ?></option>
                    <option value="ISLAM">ISLAM</option>
                    <option value="KATOLIK">KATOLIK</option>
                    <option value="PROTESTAN">PROTESTAN</option>
                    <option value="HINDU">HINDU</option>
                    <option value="BUDHA">BUDHA</option>
                    <option value="KONGHUCHU">KONGHUCHU</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Pendidikan Akhir</label>
                <div class="col-md-9">
                  <select disabled id="example-chosen" name="pendidikan" required value="<?php echo $data_edit['pendidikan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['pendidikan'] ?>"><?php echo $data_edit['pendidikan'] ?></option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="D1">D1</option>
                    <option value="D2">D2</option>
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-noKTP">No KTP</label>
                <div class="col-md-9">
                  <input type="text" readonly name="no_ktp" class="form-control" value="<?php echo $data_edit['no_ktp'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-city">NPWP</label>
                <div class="col-md-9">
                  <input type="text" readonly id="no_npwp" name="no_npwp" class="form-control" value="<?php echo $data_edit['no_npwp'] ?>" required>
                </div>
              </div>


            </div>
            <div class="block">
              <div class="block-title">
                <h2>Data Kepegawaian</h2>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Perusahaan</label>
                <div class="col-md-9">
                  <select disabled id="example-chosen" name="perusahaan" required value="<?php echo $data_edit['perusahaan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['perusahaan'] ?>"><?php echo $data_edit['perusahaan'] ?> </option>
                    <option value="Limadigit">Limadigit</option>
                    <option value="Ardecny">Ardency</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Departemen</label>
                <div class="col-md-9">
                  <select disabled id="example-chosen" name="departement" required value="<?php echo $data_edit['department'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['departement'] ?>"><?php echo $data_edit['nama_department'] ?></option>
                    <?php
                    $data = mysql_query("SELECT * FROM tb_department");
                    while($sql = mysql_fetch_array($data)){
                      ?>
                      <option value="<?php echo $sql[1] ?>" style="text-transform:uppercase;"><?php echo $sql[1] ?></option>
                    <?php } ?>

                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Jabatan</label>
                <div class="col-md-9">
                  <select disabled id="example-chosen" name="jabatan" required value="<?php echo $data_edit['jabatan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['jabatan'] ?>"><?php echo $data_edit['nama_jabatan'] ?></option>
                    <?php
                    $sql = mysql_query("SELECT * FROM tb_jabatan");
                    while($dataa = mysql_fetch_array($sql)){
                      ?>
                      <option value="<?php echo $dataa[1] ?>" style="text-transform:uppercase;"><?php echo $dataa[1]?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-password2">Mulai Bekerja</label>
                <div class="col-md-9">
                  <input type="text" readonly id="example-datepicker-kerja" name="mulai_bekerja" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $data_edit['mulai_bekerja'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-city">NIP</label>
                <div class="col-md-9">
                  <input type="text" readonly id="NIP" name="NIP" class="form-control" value="<?php echo $data_edit['NIP'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Akses Level</label>
                <div class="col-md-9">
                  <select disabled id="example-chosen" name="akses_level" required value="<?php echo $data_edit['akses_level'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <?php $get_akese_level = mysql_fetch_array(mysql_query("SELECT * FROM tb_hak_akses WHERE ID_akses = '$data_edit[akses_level]'")); ?>
                    <option value="<?php echo $get_akese_level['akses_level']?>"><?php echo $get_akese_level['nama_hak_akses']?></option>
                  </select>
                </div>
              </div>


            </div>
          </div>
          <div class="col-md-6">
            <div class="block">
              <div class="block-title">
                <h2>Data Korespondensi</h2>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Alamat</label>
                <div class="col-md-9">
                  <input type="text" readonly  name="alamat" class="form-control" value="<?php echo $data_edit['alamat'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >No HP</label>
                <div class="col-md-9">
                  <input type="text" readonly  name="no_telp" class="form-control" value="<?php echo $data_edit['no_telp'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Email</label>
                <div class="col-md-9">
                  <input type="text" readonly  name="email" class="form-control" value="<?php echo $login_edit['email'] ?>" required>
                </div>
              </div>
            </div>

            <div class="block">
              <div class="block-title">
                <h2>Berkas</h2>
              </div>
              <div class="row">
                  <div class="col-md-3">
                      <font><b>KTP</b></font><br>
                      <?php
                      if (file_get_contents("img/KTP/$_GET[edit].jpg") != '' ) {
                          ?>
                          <img src="img/KTP/<?php echo $_GET['edit']; ?>.jpg"  width="100px" height="100px">
                          <?php
                      }else{
                          echo "Anda Belum Upload File";
                      }
                      ?>
                  </div>

                  <div class="col-md-3">
                      <font><b>PAS FOTO</b></font><br>
                      <?php
                      if (file_get_contents("img/PasFoto/$_GET[edit].jpg") != '' ) {
                          ?>
                          <img src="img/PasFoto/<?php echo $_GET['edit']; ?>.jpg"  width="100px" height="100px">
                          <?php
                      }else{
                          echo "Anda Belum Upload File";
                      }
                      ?>
                  </div>

                  <div class="col-md-3">
                      <font><b>AKTA KERJA </b></font><br>
                      <?php
                      if (file_get_contents("img/akta/$_GET[edit].jpg") != '' ) {
                          ?>
                          <img src="img/akta/<?php echo $_GET['edit']; ?>.jpg"  width="100px" height="100px">
                          <?php
                      }else{
                          echo "Anda Belum Upload File";
                      }
                      ?>
                  </div>

                  <div class="col-md-3">
                      <font><b>CV</b></font><br>
                      <?php
                      if (file_get_contents("img/CV/$_GET[edit].jpg") != '' ) {
                          ?>
                          <img src="img/CV/<?php echo $_GET['edit']; ?>.jpg"  width="100px" height="100px">
                          <?php
                      }else{
                          echo "Anda Belum Upload File";
                      }
                      ?>
                  </div>

                  <div class="col-md-3">
                      <font><b>KK</b></font><br>
                      <?php
                      if (file_get_contents("img/KK/$_GET[edit].jpg") != '' ) {
                          ?>
                          <img src="img/KK/<?php echo $_GET['edit']; ?>.jpg"  width="100px" height="100px">
                          <?php
                      }else{
                          echo "Anda Belum Upload File";
                      }
                      ?>
                  </div>

              </div>
                <br>
            </div>

            <div class="block">
              <div class="block-title">
                <h2>Data Bank</h2>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">Bank</label>
                <div class="col-md-9">
                  <select disabled id="example-select" name="bank" class="select-chosen" size="1" value="<?php echo $data_edit['bank'] ?>" required>
                    <option value="<?php echo $data_editt['bank'] ?>"><?php echo $data_editt['bank'] ?></option>
                    <option value="BCA">BCA</option>
                    <option value="BRI">BRI</option>
                    <option value="BNI">BNI</option>
                    <option value="Mandiri">Mandiri</option>
                    
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">Nama Pemilik Bank</label>
                <div class="col-md-9">
                  <input type="text" readonly  name="nama_pemilik_bank" class="form-control" value="<?php echo $data_editt['nama_pemilik_bank'] ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">No. Rekening</label>
                <div class="col-md-9">
                  <input type="text" readonly name="no_rek" class="form-control" value="<?php echo $data_editt['no_rek'] ?>" required>
                </div>
              </div>

            </div>

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
