<?php session_start(); include 'inc/config.php'; ?>
<?php include 'inc/template_start.php';
include ('Db/connect.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body class="body_login">
<?php
    if(isset($_POST['Login'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        if(is_numeric($username)){
          $sql = mysql_query("SELECT * FROM tb_login JOIN tb_karyawan ON tb_login.ID_karyawan = tb_karyawan.ID_karyawan WHERE no_telp = '$_POST[username]' AND password = '$password'");
        }else{
          $sql = mysql_query("SELECT * FROM tb_login JOIN tb_karyawan ON tb_login.ID_karyawan = tb_karyawan.ID_karyawan WHERE email = '$_POST[username]' AND password = '$password'");
        }

        $data = mysql_fetch_array($sql);

        if(mysql_num_rows($sql)>0){
            $_SESSION['username'] = $data['email'];
            $_SESSION['ID_karyawan'] = $data['ID_karyawan'];
            $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
            $_SESSION['jenis_kelamin'] = $data['jenis_kelamin'];
            $_SESSION['no_ktp'] = $data['no_ktp'];
            $_SESSION['tgl_lahir'] = $data['tgl_lahir'];
            $_SESSION['agama'] = $data['agama'];
            $_SESSION['pendidikan'] = $data['pendidikan'];
            $_SESSION['perusahaan'] = $data['perusahaan'];
            $_SESSION['jabatan'] = $data['jabatan'];
            $_SESSION['akses_level'] = $data['akses_level'];
            $_SESSION['departement'] = $data['departement'];
            $_SESSION['mulai_bekerja'] = $data['mulai_bekerja'];
            $_SESSION['NIP'] = $data['NIP'];
            $_SESSION['no_npwp'] = $data['no_npwp'];
            $_SESSION['no_telp'] = $data['no_telp'];
            $_SESSION['alamat'] = $data['alamat'];
            // $_SESSION['credential'] = $credential;
            // $_SESSION['ID_hak_akses'] = $ID_hak_akses;
            echo "<script>document.location.href='index.php'</script>";
        }else{
            echo "<script>alert('Ups, Email dan Password mu tidak terdaftar pada sistem kami.')</script>";

            echo "<script>document.location.href='login.php'</script>";
        }
    }

 ?>

<!-- Login Container -->
<div id="login-container" style="margin-top:10vh">
    <!-- Login Header -->

    <!-- END Login Header -->

    <!-- Login Block -->
    <div class="block animation-fadeInQuickInv" style="background:#ffffff8c">
        

        <h1 class="h2 text-light text-center  animation-slideDown" style="margin-bottom:30px;">
          <div style="float:left">
            <img src="http://xeniel.5dapps.com/inboard/img/logo.png" alt="" style="height: 70px;padding-top:  20px;">
          </div>
          <div style="">
            <img src="http://xeniel.5dapps.com/inboard/img/inboard_logo.png" alt="" style="height: 75px;margin-left:  35px;">
          </div>
          <div style="clear:both;">

          </div>
        </h1>
        <!-- END Login Title -->

        <!-- Login Form -->
        <form id="form-login" method="post" class="form-horizontal">
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="text"  name="username" class="form-control" placeholder="Masukan Email di Sini">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="password" id="login-password" name="password" class="form-control" placeholder="Masukan kata sandi di sini">
                </div>
            </div>
            <div class="form-group form-actions">

                <div class="col-xs-12 text-right">
                    <button style="width:100%;" type="submit" class="btn btn-effect-ripple btn-sm btn-warning" name="Login"><i class="fa fa-check"></i> Let's Login</button>
                </div>
            </div>
        </form>
        <!-- END Login Form -->
        <footer class="text-muted text-center animation-pullUp" style="color: #000;">
            <small></span> &copy; 2018 ArdGroup</small><br><br>
        </footer>
    </div>
    <!-- END Login Block -->

    <!-- Footer -->

    <!-- END Footer -->
</div>
<!-- END Login Container -->

</body>
</html>

<style >
  html{
    background: url('img/background_image.png') no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  }
</style>


<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyLogin.js"></script>
<script>$(function(){ ReadyLogin.init(); });</script>

<?php include 'inc/template_end.php'; ?>
