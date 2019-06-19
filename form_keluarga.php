<?php
    include 'inc/config.php'; ;
    include 'inc/template_start.php';
    include 'inc/page_head.php';
    include ('Db/connect.php');
    include 'wa.php';
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
    $ID_karyawan = $_SESSION['ID_karyawan'];

    $cek_apakah_saya_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE ID = '$_SESSION[departement]' AND leader = '$_SESSION[ID_karyawan]'"));
    if($cek_apakah_saya_leader[0]==""){
        $cek_saya_leader = "FALSE";
    }else{
        $cek_saya_leader = "TRUE";
    }

    $cek_kepemilikan_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE ID = '$_SESSION[departement]'"));
    if($cek_kepemilikan_leader['leader']==$cek_kepemilikan_leader['top_leader']){
        $status_leader = "LEADER_UNAVAILABLE";
    }else{
        $status_leader = "LEADER_AVAILABLE";
    }

function fetch_karyawan($id_karyawan){
  $sql = mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '".$id_karyawan."' ");
  return mysql_fetch_array($sql);
}
// $edit_familiy = mysql_fetch_array(mysql_query("SELECT * FROM `tb_keluarga` WHERE ID_karyawan = '$_SESSION[ID_karyawan]'"));
$dataPribadi = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_department ON tb_karyawan.departement= tb_department.ID JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID where ID_karyawan = '$_SESSION[ID_karyawan]'  "));

  if(isset($_POST['insert_kel'])){
          $ID_karyawan = $_SESSION['ID_karyawan'];
          $query_kel = mysql_query("INSERT INTO `tb_keluarga`(`ID_keluarga`, `nik`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `hubungan`, `ID_karyawan`, `faskes_tk1`, `faskes_dr_gigi`, `alamat_keluarga`, `telp_keluarga`) VALUES (NULL,'$_POST[nik]','$_POST[nama]','$_POST[jenis_kelamin]','$_POST[tanggal_lahir]','$_POST[hubungan]','$ID_karyawan','$_POST[faskes_tk1]','$_POST[faskes_dr_gigi]','$_POST[alamat_keluarga]','$_POST[telp_keluarga]')");
          if($query_kel){
            $kirim_ke_HR = send_wa('6281316124343'," ".$dataPribadi['nama_lengkap']." Telah melakukan Pengisian data keluarga, mohon cek kembali data yang telah dimasukan, klik link dibawah ini : ",'DATA KELUARGA','inboard.ardgroup.co.id');
            echo"<script>alert('berhasil')</script>";
          }else{
            echo"<script>alert('tidak berhasil')</script>";
          }
        }
?>
<!-- Page content -->
<div id="page-content">
    <div class="block full">
        <div class="block-title">
            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-size: 20px;margin: 13px;">Formulir Data Keluarga</h2>
                </div>
                <div class="col-md-4">
                    <a href="index.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
                </div>
            </div>
        </div>
        <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                <input type="hidden" name="ID_keluarga" class="form-control" value="<?php echo $edit_familiy['ID_keluarga'] ?>" required>

              <div class="form-group">
                <label class="col-md-3 control-label" >NIK</label>
                <div class="col-md-7">
                  <input type="text" name="nik" class="form-control" value="<?php echo $edit_familiy['nik'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Nama</label>
                <div class="col-md-7">
                  <input type="text" name="nama" class="form-control" value="<?php echo $edit_familiy['nama'] ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" >Alamat</label>
                <div class="col-md-7">
                  <input type="text" name="alamat_keluarga" class="form-control" value="<?php echo $edit_familiy['alamat_keluarga'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Hubungan Dengan Karyawan</label>
                <div class="col-md-7">
                  <select id="example-chosen" name="hubungan" required  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $edit_familiy['hubungan'] ?>"style="text-transform:uppercase;"><?php echo $edit_familiy['hubungan'] ?></option>
                    <option value="anak"style="text-transform:uppercase;">Anak</option>
                    <option value="istri" style="text-transform:uppercase;">Istri</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Tempat, Tanggal Lahir</label>
                <div class="col-md-7">
                  <input type="text" name="tanggal_lahir" class="form-control" value="<?php echo $edit_familiy['tanggal_lahir'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Jenis Kelamin</label>
                <div class="col-md-7">
                  <select id="example-chosen1" name="jenis_kelamin" required  class="select-chosen"  style="width: 250px; display: none;">
                    <option value="<?php echo $edit_familiy['jenis_kelamin'] ?>" style="text-transform:uppercase;"><?php echo $edit_familiy['jenis_kelamin'] ?></option>
                    <option value="Laki-Laki" style="text-transform:uppercase;">Laki-Laki</option>
                    <option value="Perempuan" style="text-transform:uppercase;">Perempuan</option>
                  </select>
                  <!-- <input type="text"  name="jenis_kelamin" class="form-control" value="" required> -->
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Telpon</label>
                <div class="col-md-7">
                  <input type="text" name="telp_keluarga" class="form-control" value="<?php echo $edit_familiy['telp_keluarga'] ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" >Faskes Tk.1</label>
                <div class="col-md-7">
                  <input type="text" name="faskes_tk1" class="form-control" value="<?php echo $edit_familiy['faskes_tk1'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" >Faskes Dokter Gigi</label>
                <div class="col-md-7">
                  <input type="text" name="faskes_dr_gigi" class="form-control" value="<?php echo $edit_familiy['faskes_dr_gigi'] ?>" required>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-7">
                  <input class="btn btn-success" type="submit" name="insert_kel" value="INSERT DATA KELUARGA">
                </div>
              </div>
            </form>

              <table class="table table-bordered">
                <tr>
                  <td>No</td>
                  <td>Informasi</td>
                  <td>Action</td>
                </tr>
              <?php 
              if(isset($_GET['delete'])){
                $delete_kel = mysql_query("DELETE FROM `tb_keluarga` WHERE ID_keluarga = '$_GET[delete]'");
                if($delete_kel){
                  echo "<script>documen.location.href='form_keluarga.php'</script>";
                }else{
                  echo"<script>alert('data tidak berhasil didelete!')</script>";
                  echo"<script><script>documen.location.href='form_keluarga.php'</script>";
                }
              }
              $No = 1;
                $keluarga = mysql_query("SELECT * FROM tb_keluarga ORDER BY ID_keluarga DESC");
                while($data_kel = mysql_fetch_array($keluarga)){
                ?>
                <tr>
                  <td><?php echo $No++; ?></td>
                  <td>
                    <b><?php echo $data_kel['nama'] ?></b><br>
                    <i><?php echo $data_kel['nik'] ?><i><br>
                    <?php echo $data_kel['tanggal_lahir'] ?><br>
                    <?php echo $data_kel['jenis_kelamin'] ?><br>
                    <?php echo $data_kel['hubungan'] ?><br>
                  </td>
                  <td>
                    
                    <a href="form_keluarga.php?delete=<?php echo $data_kel['ID_keluarga'] ?>"><i class="fa fa-trash"></i></a>
                    
                  </td>
                </tr>
                <?php } ?>
              </table>  
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
