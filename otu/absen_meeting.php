<?php 
  include('connection.php');
 ?>
<!DOCTYPE html>
<html>
<head>
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
 <title></title>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
 <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
 <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
</head>
<body>
  <?php
  ?>
  <br><br><br>
  <div class="container">
    <div class="row">
      <div class="col-1"></div>
      <div class="col-10" style="margin-top: auto;"> <h5>INBOARD One Time Use Page</h5></div>
    </div>
    <br>

    
    <div class="row" <?php echo $section1; ?>>
      <div class="col-1"></div>
      <div class="col-11">
       Silakan Login menggunakan akun inboard anda untuk mengikuti meeting
       <br><br>

       <table class="table-responsive">
        <tr>
          <td>Email</td>
          <td>&nbsp;</td>
          <td><input type="text" class="form-control" name="email"></td>
        </tr>
        <tr>
          <td>Password</td>
          <td>&nbsp;</td>
          <td><input type="text" class="form-control" name="password"></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td>
            <input type="submit" class="btn btn-success" value="LOGIN" name="">
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="row" <?php echo $section2; ?>>
    <div class="col-1"></div>
    <div class="col-11">
      Masukan Kode meeting untuk mengikuti meeting
      <br><br>

      <table class="table-responsive">

        <tr>
          <td>Kode Meeting</td>
          <td>&nbsp;</td>
          <td><input type="text" class="form-control" name="password"></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td>
            <input type="submit" class="btn btn-success" value="IKUTI MEETING" name="">
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="row" <?php echo $section3; ?>>
    <div class="col-1"></div>
    <div class="col-11">
     Terimakasih Anda Telah mengikuti meeting dengan informasi sebagai berikut
     <br><br>

     <table class="table-responsive">

      <tr>
        <td>Judul Meeting </td>
        <td>&nbsp;</td>
        <td>Judul Meeting</td>
      </tr>


      <tr>
        <td>Waktu Meeting </td>
        <td>&nbsp;</td>
        <td>Waktu Meeting</td>
      </tr>

      <tr>
        <td>Lokasi Meeting </td>
        <td>&nbsp;</td>
        <td>Lokasi Meeting</td>
      </tr>

      <tr>
        <td>Deskripsi </td>
        <td>&nbsp;</td>
        <td>Deskripsi</td>
      </tr>

      <tr>
        <td></td>
        <td></td>
        <td>
          <input type="submit" class="btn btn-danger" value="LOG OUT" name="">
        </td>
      </tr>

    </table>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/uiTables.js"></script>
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
