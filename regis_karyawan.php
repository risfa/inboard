<?php include 'inc/config.php'; ;
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
    	$telp_kar = $_GET['telp'];
      $sqlUpdateDisaktif = mysql_query("UPDATE `tb_karyawan` SET `status` = '0', `no_telp`= '-$telp_kar'  WHERE `tb_karyawan`.`ID_karyawan` = '$_GET[edit]' ");

      if ($sqlUpdateDisaktif) {
        $sqlKaryawanDisaktif = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$_GET[edit]' ");
        $dataKaryawanDisaktif = mysql_fetch_array($sqlKaryawanDisaktif);
        $keterangan_disaktif = "Anda Baru saja non aktifkan karyawan  ".$dataKaryawanDisaktif[0];
        $notifikasiDisaktif = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_GET[edit]','$keterangan_disaktif',0,'nonaktif')");
      }

      echo "<script>document.location.href='data_karyawan.php?toast_show_aktif=1'</script>";

    }elseif ($_GET['nonaktif'] == 0) {
      $sqlUpdateAktif = mysql_query("UPDATE `tb_karyawan` SET `status` = '1' WHERE `tb_karyawan`.`ID_karyawan` = '$_GET[edit]' ");
      if ($sqlUpdateAktif) {
        $sqlKaryawanAktif = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$_GET[edit]' ");
        $dataKaryawanAktif = mysql_fetch_array($sqlKaryawanAktif);
        $keterangan_aktif = "Anda Baru saja aktifkan karyawan  ".$dataKaryawanAktif[0];
        $notifikasiAktif = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_GET[edit]','$keterangan_aktif',0,'aktif')");

      }

      echo "<script>document.location.href='data_karyawan.php?toast_show_non_aktif=1'</script>";

    }

  }

  if(isset($_POST['update'])){
    $sql_udpate = mysql_query("UPDATE tb_karyawan SET nama_lengkap = '$_POST[nama_lengkap]', jenis_kelamin = '$_POST[jenis_kelamin]', no_ktp = '$_POST[no_ktp]', tgl_lahir = '$_POST[tgl_lahir]', agama = '$_POST[agama]', pendidikan = '$_POST[pendidikan]', perusahaan = '$_POST[perusahaan]', jabatan = '$_POST[jabatan]', akses_level = '$_POST[akses_level]', departement = '$_POST[departement]', mulai_bekerja = '$_POST[mulai_bekerja]', NIP = '$_POST[NIP]', no_npwp = '$_POST[no_npwp]', no_telp = '$_POST[no_telp]', alamat = '$_POST[alamat]', alamat_ktp = '$_POST[alamat_ktp]'  WHERE ID_karyawan = '$_GET[edit]'");

    $ID_karyawan = $_GET['edit'];
    $sql_bank = mysql_query("UPDATE tb_bank SET bank ='$_POST[bank]', nama_pemilik_bank = '$_POST[nama_pemilik_bank]',no_rek='$_POST[no_rek]' WHERE ID_karyawan = '$_GET[edit]'");

    $ID_karyawan = $_GET['edit'];
    $sql_bank = mysql_query("UPDATE tb_login SET email ='$_POST[email]' WHERE ID_karyawan = '$_GET[edit]'");

    if($sql_udpate){
      $selectKaryawan = mysql_query("SELECT nama_lengkap from tb_karyawan where ID_karyawan = '$_GET[edit]' ");
      $showKaryawan = mysql_fetch_array($selectKaryawan);

        $keterangan_update = "Anda Baru saja mengganti detail karyawan atas nama ".$showKaryawan[0];

          $notifikasiUpdate = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_GET[edit]','$keterangan_update',0,'update')");


      move_uploaded_file($_FILES["fileToUpload_ktp"]["tmp_name"],"img/KTP/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_pasfoto"]["tmp_name"],"img/PasFoto/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_akta"]["tmp_name"],"img/akta/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_cv"]["tmp_name"],"img/CV/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_kk"]["tmp_name"],"img/KK/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_kontrak"]["tmp_name"],"img/kontrak/".$ID_karyawan.".jpg");


      echo "<script>document.location.href='data_karyawan.php?toast_show_update=1'</script>";

    }else{
      echo "<script>alert('Failed Update!')</script>";
      echo "<script>document.location.href='regis_karyawan.php'</script>";
    }
  }
  if(isset($_POST['simpan'])){
    $sql_simpan = mysql_query("INSERT INTO `tb_karyawan` (`ID_karyawan`, `nama_lengkap`, `jenis_kelamin`, `no_ktp`, `tgl_lahir`, `agama`, `pendidikan`, `no_telp`, `alamat`, `alamat_ktp`, `perusahaan`, `jabatan`, `akses_level`, `departement`, `mulai_bekerja`, `NIP`, `no_npwp`) VALUES (null, '$_POST[nama_lengkap]','$_POST[jenis_kelamin]','$_POST[no_ktp]','$_POST[tgl_lahir]','$_POST[agama]','$_POST[pendidikan]','$_POST[no_telp]','$_POST[alamat]','$_POST[alamat_ktp]','$_POST[perusahaan]','$_POST[jabatan]','$_POST[akses_level]','$_POST[departement]','$_POST[mulai_bekerja]','$_POST[NIP]','$_POST[no_npwp]');");
    $id_karyawan_baru = mysql_insert_id();
    $ID_karyawan = mysql_insert_id();
    $bank_simpan = mysql_query("INSERT INTO tb_bank(ID_bank,bank,nama_pemilik_bank,no_rek,ID_karyawan)VALUES(NULL,'$_POST[bank]','$_POST[nama_pemilik_bank]','$_POST[no_rek]','$ID_karyawan')");
    $ID_karyawan = mysql_insert_id();
    $login_simpan = mysql_query("INSERT INTO tb_login(ID,email,password,ID_karyawan)VALUES(NULL,'$_POST[email]','21232f297a57a5a743894a0e4a801fc3','$ID_karyawan')");

    if($sql_simpan == true){


      $notifikasiSimpan = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$id_karyawan_baru','Anda Telah memasukan karyawan baru',0,'insert')");

      move_uploaded_file($_FILES["fileToUpload_ktp"]["tmp_name"],"img/KTP/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_pasfoto"]["tmp_name"],"img/PasFoto/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_akta"]["tmp_name"],"img/akta/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_cv"]["tmp_name"],"img/CV/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_kk"]["tmp_name"],"img/KK/".$ID_karyawan.".jpg");

      move_uploaded_file($_FILES["fileToUpload_kontrak"]["tmp_name"],"img/kontrak/".$ID_karyawan.".jpg");

      
      echo "<script>document.location.href='data_karyawan.php?toast_show=1'</script>";
      
    }else{
      echo "<script>alert('Failed save!')</script>";
      echo "<script>document.location.href='regis_karyawan.php'</script>";
    }
  }

    // $ID_karyawan = $_GET['edit'];
  if(isset($_POST['insert_family'])){
    $ID_karyawan = $_GET['edit'];
    $family_insert = mysql_query("INSERT INTO `tb_keluarga`(`ID_keluarga`, `nik`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `hubungan`, `ID_karyawan`, `faskes_tk1`, `faskes_dr_gigi`, `alamat_keluarga`, `telp_keluarga`) VALUES (NULL,'$_POST[nik]','$_POST[nama]','$_POST[jenis_kelamin]','$_POST[tanggal_lahir]','$_POST[hubungan]','$ID_karyawan','$_POST[faskes_tk1]','$_POST[faskes_dr_gigi]','$_POST[alamat_keluarga]','$_POST[telp_keluarga]')");
    if(family_insert){
      echo"<script>alert('berhasil')</script>";
    }else{
      echo"<script>alert('berhasil')</script>";
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
          <div class="col-md-8">
            <h2 style="font-size: 20px;margin: 13px;">Formulir Data Karyawan</h2>
          </div>
          <div class="col-md-4">
            <a href="data_karyawan.php" style="float:right; margin-right:20px;"><button class="btn btn-info" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-arrow-left"></i>&nbsp;KEMBALI KE DATA AWAL</button></a><br>
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
                  <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $data_edit['nama_lengkap'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Jenis Kelamin</label>
                <div class="col-md-9">
                  <select id="example-chosen" name="jenis_kelamin" required value="<?php echo $data_edit['jenis_kelamin'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['jenis_kelamin'] ?>"><?php echo $data_edit['jenis_kelamin'] ?></option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal Lahir</label>
                <div class="col-md-9">
                  <input type="text" name="tgl_lahir" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $data_edit['tgl_lahir'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Agama</label>
                <div class="col-md-9">
                  <select id="example-chosen" name="agama" required value="<?php echo $data_edit['agama'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
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
                  <select id="example-chosen" name="pendidikan" required value="<?php echo $data_edit['pendidikan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
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
                  <input type="text" name="no_ktp" class="form-control" value="<?php echo $data_edit['no_ktp'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-city">NPWP</label>
                <div class="col-md-9">
                  <input type="text" id="no_npwp" name="no_npwp" class="form-control" value="<?php echo $data_edit['no_npwp'] ?>" required>
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
                  <select id="example-chosen" name="perusahaan" required value="<?php echo $data_edit['perusahaan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['perusahaan'] ?>"><?php echo $data_edit['perusahaan'] ?> </option>
                    <option value="Limadigit">Limadigit</option>
                    <option value="Ardecny">Ardency</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Departemen</label>
                <div class="col-md-9">
                  <select id="example-chosen" name="departement" required  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['departement'] ?>"><?php echo $data_edit['nama_department'] ?></option>
                    <?php
                    $data = mysql_query("SELECT * FROM tb_department");
                    while($sql = mysql_fetch_array($data)){
                      ?>
                      <option value="<?php echo $sql[0] ?>" style="text-transform:uppercase;"><?php echo $sql[1] ?></option>
                    <?php } ?>

                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Jabatan</label>
                <div class="col-md-9">
                  <select id="example-chosen" name="jabatan" required value="<?php echo $data_edit['jabatan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $data_edit['jabatan'] ?>"><?php echo $data_edit['nama_jabatan'] ?></option>
                    <?php
                    $sql = mysql_query("SELECT * FROM tb_jabatan");
                    while($dataa = mysql_fetch_array($sql)){
                      ?>
                      <option value="<?php echo $dataa[0] ?>" style="text-transform:uppercase;"><?php echo $dataa[1]?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-password2">Mulai Bekerja</label>
                <div class="col-md-9">
                  <input type="text" id="example-datepicker-kerja" name="mulai_bekerja" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $data_edit['mulai_bekerja'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-clickable-city">NIP</label>
                <div class="col-md-9">
                  <input type="text" id="NIP" name="NIP" class="form-control" value="<?php echo $data_edit['NIP'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-select">Akses Level</label>
                <div class="col-md-9">
                  <select id="example-chosen" name="akses_level" required value="<?php echo $data_edit['akses_level'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                    <?php $get_akese_level = mysql_fetch_array(mysql_query("SELECT * FROM tb_hak_akses WHERE ID_akses = '$data_edit[akses_level]'")); ?>
                    <option value="<?php echo $get_akese_level['ID_akses'] ?>"><?php echo $get_akese_level['nama_hak_akses'] ?></option>
                    <?php
                    $sql = mysql_query("SELECT * FROM tb_hak_akses");
                    while($dataa = mysql_fetch_array($sql)){
                      ?>
                      <option value="<?php echo $dataa[0] ?>" style="text-transform:uppercase;"><?php echo $dataa[1]?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <!-- //DATA KELUARGA -->
            <?php if($_GET['edit']){ ?>
            <form method="post" enctype="">
            <div class="block" >
              <div class="block-title">
                <h2>Data Keluarga</h2>
              </div>
                <input type="hidden"  name="ID_keluarga" class="form-control" value="" required>

              <div class="form-group">
                <label class="col-md-3 control-label" >NIK</label>
                <div class="col-md-9">
                  <input type="text"  name="nik" class="form-control" value="" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Nama</label>
                <div class="col-md-9">
                  <input type="text"  name="nama" class="form-control" value="" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" >Alamat</label>
                <div class="col-md-9">
                  <input type="text"  name="alamat_keluarga" class="form-control" value="" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Hubungan Dengan Karyawan</label>
                <div class="col-md-9">
                  <select id="example-chosen" name="hubungan"   class="select-chosen"  style="width: 250px; display: none;">
                    <option value="anak"style="text-transform:uppercase;">Anak</option>
                    <option value="istri" style="text-transform:uppercase;">Istri</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Tempat, Tanggal Lahir</label>
                <div class="col-md-9">
                  <input type="text"  name="tanggal_lahir" class="form-control" value="" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Jenis Kelamin</label>
                <div class="col-md-9">
                  <select id="example-chosen" name="jenis_kelamin"   class="select-chosen"  style="width: 250px; display: none;">
                    <option value="Laki-Laki" style="text-transform:uppercase;">Laki-Laki</option>
                    <option value="Perempuan" style="text-transform:uppercase;">Perempuan</option>
                  </select>
                  <!-- <input type="text"  name="jenis_kelamin" class="form-control" value="" required> -->
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Telpon</label>
                <div class="col-md-9">
                  <input type="text"  name="telp_keluarga" class="form-control" value="" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" >Faskes Tk.1</label>
                <div class="col-md-9">
                  <input type="text"  name="faskes_tk1" class="form-control" value="" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Faskes Dokter Gigi</label>
                <div class="col-md-9">
                  <input type="text"  name="faskes_dr_gigi" class="form-control" value="" >
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-9">
                  <input class="btn btn-success" type="submit" name="insert_family">
                </div>
              </div>

              <table class="table table-bordered">
                <tr>
                  <td>No</td>
                  <td>Informasi</td>
                  <td>Action</td>
                </tr>
                <?php 
                if(isset($_GET['delete'])){
                  $delete_kel = mysql_query("DELETE FROM `tb_keluarga` WHERE ID_keluarga = '$_GET[delete]'");
                  if(delete_kel){
                    echo"<script>alert('berhasil delete data')</script>";
                    echo"<script>document.location.href='regis_karyawan.php?edit=".$_GET['edit']."'</script>";
                  }else{
                    echo"<script>alert('tidak berhasil delete data')</script>";
                  }
                }
                $No = 1;
                $keluarga = mysql_query("SELECT * FROM tb_keluarga JOIN tb_karyawan ON tb_keluarga.ID_karyawan = tb_karyawan.ID_karyawan WHERE tb_keluarga.ID_karyawan = '$_GET[edit]'");
                while($data_kel = mysql_fetch_array($keluarga)){
                ?>
                <tr>
                  <td><?php echo $No++; ?></td>
                  <td>
                    <b><?php echo $data_kel['nama'] ?></b><br>
                    <i><?php echo $data_kel['nik'] ?><i><br>
                    <?php echo $data_kel['tanggal_lahir'] ?><br>
                    <?php echo $data_kel['jenis_kelamin'] ?><br>
                  </td>
                  <td>
                    <a href="https://xeniel.5dapps.com/inboard/regis_karyawan.php?edit=<?php echo $_GET['edit'] ?>&delete=<?php echo $data_kel['ID_keluarga'] ?>"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>  
            </div>
              </form>
            <?php } ?>

            </div>

          <!-- //END DATA KELUARGA -->
          <div class="col-md-6">
            <div class="block">
              <div class="block-title">
                <h2>Data Korespondensi</h2>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Alamat Tinggal</label>
                <div class="col-md-9">
                  <input type="text"  name="alamat" class="form-control" value="<?php echo $data_edit['alamat'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Alamat KTP</label>
                <div class="col-md-9">
                  <input type="text"  name="alamat_ktp" class="form-control" value="<?php echo $data_edit['alamat_ktp'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >No HP</label>
                <div class="col-md-9">
                  <input type="text"  name="no_telp" class="form-control" value="<?php echo $data_edit['no_telp'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Email</label>
                <div class="col-md-9">
                  <input type="text"  name="email" class="form-control" value="<?php echo $login_edit['email'] ?>" required>
                </div>
              </div>

            </div>

            <div class="block">
              <div class="block-title">
                <h2>Berkas</h2>
              </div>

              <?php
                  if (file_get_contents("img/KTP/$_GET[edit].jpg") != '' ) {
              ?>

                  <img src="img/KTP/<?php echo $_GET['edit']; ?>.jpg"  width="100px" height="100px">
              <?php
                  }else{
//                    echo "Anda Belum Upload File";
                  }
               ?>


              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">File KTP</label>
                <div class="col-md-9">
                  <input type="file" id="fileToUpload_ktp" name="fileToUpload_ktp">
                </div>
              </div>

              <?php
                  if (file_get_contents("img/PasFoto/$_GET[edit].jpg") != '' ) {
              ?>

                  <img src="img/PasFoto/<?php echo $_GET['edit']; ?>.jpg" width="100px" height="100px">
              <?php
                  }else{
//                    echo "Anda Belum Upload File";
                  }
               ?>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">File PasFoto</label>
                <div class="col-md-9">
                  <input type="file" id="fileToUpload_pasfoto" name="fileToUpload_pasfoto">
                </div>
              </div>

              <?php
                  if (filesize("img/akta/$_GET[edit].jpg") != '' ) {
              ?>

                  <img src="img/akta/<?php echo $_GET['edit']; ?>.jpg" width="100px" height="100px">
              <?php
                  }else{
//                    echo "Anda Belum Upload File";
                  }
               ?>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">File Akta</label>
                <div class="col-md-9">
                  <input type="file" id="fileToUpload_akta" name="fileToUpload_akta">
                </div>
              </div>

              <?php
                  if (filesize("img/CV/$_GET[edit].jpg") != '' ) {
              ?>

                  <img src="img/CV/<?php echo $_GET['edit']; ?>.jpg" width="100px" height="100px">
              <?php
                  }else{
//                    echo "Anda Belum Upload File";
                  }
               ?>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">File CV</label>
                <div class="col-md-9">
                  <input type="file" id="fileToUpload_cv" name="fileToUpload_cv">
                </div>
              </div>
              <?php
                  if (filesize("img/KK/$_GET[edit].jpg") != '' ) {
              ?>

                  <img src="img/KK/<?php echo $_GET['edit']; ?>.jpg" width="100px" height="100px">
              <?php
                  }else{
                  //echo "Anda Belum Upload File";
                  }
               ?>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">File KK</label>
                <div class="col-md-9">
                  <input type="file" id="fileToUpload_kk" name="fileToUpload_kk">
                </div>
              </div>
              <?php
                  if (filesize("img/kontrak/$_GET[edit].jpg") != '' ) {
              ?>

                  <img src="img/kontrak/<?php echo $_GET['edit']; ?>.jpg" width="100px" height="100px">
              <?php
                  }else{
                  //echo "Anda Belum Upload File";
                  }
               ?>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">File Kontrak</label>
                <div class="col-md-9">
                  <input type="file" id="fileToUpload_kontrak" name="fileToUpload_kontrak">
                </div>
              </div>

            </div>

            <div class="block">
              <div class="block-title">
                <h2>Data Bank</h2>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">Bank</label>
                <div class="col-md-9">
                  <select id="example-select" name="bank" class="select-chosen" size="1" value="<?php echo $data_edit['bank'] ?>" required>
                    <option value="<?php echo $data_editt['bank'] ?>"><?php echo $data_editt['bank'] ?></option>
                    <option value="BCA">BCA</option>
                    <option value="BRI">BRI</option>
                    <option value="BNI">BNI</option>
                    <option value="Mandiri">Mandiri</option>
                    <!-- <option value="">Karyawan</option> -->
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">Nama Pemilik Bank</label>
                <div class="col-md-9">
                  <input type="text"  name="nama_pemilik_bank" class="form-control" value="<?php echo $data_editt['nama_pemilik_bank'] ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="example-file-input">No. Rekening</label>
                <div class="col-md-9">
                  <input type="text" name="no_rek" class="form-control" value="<?php echo $data_editt['no_rek'] ?>" required>
                </div>
              </div>

            </div>

            <?php
              if ($data_edit['status'] == 1) {
             ?>
            <a href="regis_karyawan.php?nonaktif=1&edit=<?php echo $_GET['edit']; ?>&telp=<?php echo $data_edit['no_telp'] ?>" class="btn btn-danger">NON AKTIFKAN KARYAWAN</a>
            <?php
              }else {
            ?>
            <a href="regis_karyawan.php?nonaktif=0&edit=<?php echo $_GET['edit']; ?>" class="btn btn-success">AKTIFKAN KARYAWAN</a>
            <?php
              }
             ?>

            <div class="form-group form-actions" style="background: none;">
              <div class="col-md-12 ">
                <p style="color:red">* Dengan ini saya menyatakan telah mengisi seluruh form dengan data yang sebagaimana semestinya</p>
                <?php if(!$_GET['edit']){ ?>
                  <input type="submit" name="simpan" value="SIMPAN DATA KARYAWAN" class="btn btn-success">
                  <a href="data_karyawan.php" class="btn btn-danger">BATALKAN PENGISIAN</a>
                <?php }else{ ?>
                  <input type="submit" name="update" value="PERBAHARUI DATA KARYAWAN" class="btn btn-info">
                  <a href="data_karyawan.php" class="btn btn-danger">BATALKAN PERUBAHAN</a>
                <?php } ?>
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
<!-- <script>$(function(){ ReadyDashboard.init(); });</script> -->

<?php include 'inc/template_end.php';

?>
