<?php include 'inc/config.php'; $template['header_link'] = 'WELCOME';
include 'inc/template_start.php';
include 'inc/page_head.php';
include ('Db/connect.php');
// include 'notifikasi/notifikasi_lib.php';
// include ('session.php');
// $connect = mysqli_connect("localhost", "dapps", "l1m4d1g1t", "dapps_joker_pertamina_lesehan2018");

?>
<!DOCTYPE html>
<html>
<head>
  <title>Data Karyawan</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
  <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
  <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">

  <script src="https://www.gstatic.com/firebasejs/5.3.1/firebase.js"></script>
  <script src="js/config_message.js"></script>

  <script type="text/javascript">

    function saveToken(token){

      $.get("save_token.php?token="+token+"&ID_karyawan="+'<?php echo $_SESSION['ID_karyawan']; ?>', function(data, status){
        console.log('save token'+data);
        $.get("notifikasi/send_notifikasi.php?ID_karyawan="+'<?php echo $_SESSION['ID_karyawan']; ?>', function(data, status){
          console.log('send notifikasi'+data);
        });
      });



    }
  </script>

</head>
<body>
  <?php
    $gather_pw_lama = mysql_fetch_array(mysql_query("SELECT * FROM tb_login WHERE ID_karyawan = '$_SESSION[ID_karyawan]'"));
    if (isset($_POST['ubah_pw'])) {
      $pw_lamanya = $_POST['password_db'];
      $pw_baru = $_POST['pw_baru'];
      $pw_baru_repeat = $_POST['pw_baru_repeat'];
      $masukin_pw_lama = md5($_POST['pw_lama']);

      if($pw_lamanya != $masukin_pw_lama){
        echo "<script>alert('Kata Sandi Lama Anda Salah!, Silakan ulangi')</script>";
      }else{
        if($pw_baru != $pw_baru_repeat){
          echo "<script>alert('Kata sandi terbaru anda tidak cocok satu sama lainnya')</script>";
        }else{
          $pass_baru = md5($pw_baru_repeat);
          mysql_query("UPDATE tb_login SET password = '$pass_baru' WHERE ID_karyawan = '$_SESSION[ID_karyawan]'");
          // $keterangan_disaktif = "Anda Baru saja non aktifkan karyawan  ".$dataKaryawanDisaktif[0];
          $notifikasiChangePwd = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_SESSION[ID_karyawan]','Mengganti Password',0,'update')");
          echo'<script>
          $.get("notifikasi/send_notifikasi_cpwd.php?ID_karyawan='.$_SESSION['ID_karyawan'].'", function(data, status){
            console.log("send notifikasi"+data);
          });
          </script>';
          echo "<script>alert('Password Anda Berhasil di Ubah, silakan login kembali')</script>";
          session_destroy();
          echo "<script>document.location.href='login.php'</script>";
        }
      }
    }

    $dataPribadi = mysql_fetch_array(mysql_query("SELECT * from tb_karyawan where ID_karyawan = '$_SESSION[ID_karyawan]'  "));
    $dataLogin = mysql_fetch_array(mysql_query("SELECT * FROM tb_login where ID_karyawan = '$_SESSION[ID_karyawan]'  "));
    $dataBank = mysql_fetch_array(mysql_query("SELECT * FROM tb_bank where ID_karyawan = '$_SESSION[ID_karyawan]'  "));

  ?>

  <!-- Page content -->


  <div id="page-content">
    <div class="block full">
      <div class="block-title">
        <div class="row">
          <div class="col-md-3">
            <h2 style="font-size: 20px;margin: 13px;">Pengaturan Akun</h2>
          </div>

        </div>
      </div>
      <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
        <div class="row" style="padding:20px;">

          <div class="col-md-6">
            <div class="block">
              <form method="post">
                <div class="block-title">
                  <h2>Perubahan Kata Sandi</h2>
                </div>

                <input type="hidden" name="password_db" value="<?php echo $gather_pw_lama['password']; ?>">

                <div class="form-group">
                  <label class="col-md-3 control-label">Username </label>
                  <div class="col-md-9">
                    <input type="text" readonly value="<?php echo $gather_pw_lama['email']; ?>" required  class="form-control"  required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label">Kata Sandi Lama</label>
                  <div class="col-md-9">
                    <input type="password" required  name="pw_lama" class="form-control"  required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label">Kata Sandi Baru</label>
                  <div class="col-md-9">
                    <input type="password" required  name="pw_baru" class="form-control"  required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label">Ulangi Kata Sandi Baru</label>
                  <div class="col-md-9">
                    <input type="password" required  name="pw_baru_repeat" class="form-control"  required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label"></label>
                  <div class="col-md-9">
                    <input type="submit" class="btn btn-success" name="ubah_pw" value="UBAH KATA SANDI">
                  </div>
                </div>
              </form>

            </div>
          </div>
            <div class="col-md-6">

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
