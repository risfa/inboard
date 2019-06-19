<?php
include 'inc/config.php';  ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
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
  <?php
    $keterangan =  "";
  if(isset($_POST['simpan'])){
     $persetujuan = $_POST['persetujuan'];
    if(isset($persetujuan) && $persetujuan=="Setuju"){
      $keterangan = $_POST['keteranganyes'];
      $notifikasiKeterangan = 'Anda setuju pada form bpjs';

    }else if (isset($persetujuan) && $persetujuan=="Tidak Setuju"){
      $keterangan = $_POST['keteranganno'];

      $notifikasiKeterangan = 'Anda tidak Setuju pada form bpjs';
    }

    $ID_karyawan = $_SESSION['ID_karyawan'];
    if($persetujuan=="Tidak Setuju" && $keterangan == ""){
       echo '<script type="text/javascript">
      iziToast.error({
        title: "Gagal Insert!",
        message: "Masukan Alasannya!",
      });
      </script>';

    }else{
      $sqlsimpan = mysql_query("INSERT INTO bpjs(ID_bpjs,persetujuan,keterangan,ID_karyawan)VALUES(NULL,'$persetujuan','$keterangan',$ID_karyawan)");
    }

    if($sqlsimpan){
      $notifikasiPersetujuanBPJS = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$_SESSION[ID_karyawan]','$notifikasiKeterangan',0,'insert')");
      
      echo '<script type="text/javascript">
      iziToast.success({
        title: "OK",
        message: "Data has been Succesfully inserted",
      });
      </script>';
      echo "document.location.href='persetujuan_bpjs.php'";

    }else{
      // echo "<script>alert('no')</script>";
      echo "document.location.href='persetujuan_bpjs.php'";

    }

  }
  if(isset($_GET['edit'])){
    $data_edit = mysql_fetch_array(mysql_query("SELECT * FROM bpjs WHERE ID_bpjs = '$_GET[edit]'"));
  }
  ?>
  <div id="page-content">
    <div class="block ">
      <div class="block-title">

        <h2>Persetujuan BPJS</h2>

      </div>

      <div class="container" style="width: 100%;">
        <div class="col-md-8">
          <img src="img/brosurbpjs.jpg" style="width: 100%;"><br>
          <br><p style="color:red; font-style: italic">*Untuk mengubah pernyataan, silakan menghubungi HRD.</p>
        </div>
        <div class="col-md-4" style="margin-bottom:30px;">

          <p style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt; text-align: center;"><span style="font-family: verdana, geneva;"><strong><span style="font-size: 16pt; color: #000000; background-color: transparent; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">FORM PERSETUJUAN</span></strong></span></p><br>
          <p style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;"><span style="font-size: 12pt; font-family: verdana, geneva; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Yang bertanda tangan dibawah ini saya selaku karyawan ARDGroup, dengan ini menyatakan bersedia mengikuti program Jaminan Hari Tua (JHT) sebagai bagian dari program BPJS Ketenagakerjaan. Dengan demikian saya menyatakan &nbsp;sanggup dan tidak berkeberatan untuk dipotong 2 % dari upah setiap bulannya.</span></p>
          <p style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt; text-align: justify;"><span style="font-size: 12pt; font-family: verdana, geneva; color: #000000; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Dengan adanya program Jaminan Hari Tua ini, maka untuk selanjutnya program DPLK melalui tabungan BNI Simponi akan ditutup dan tidak lagi dilanjutkan. Jika saya berniat melanjutkan tabungan ini maka biaya dan pengurusannya akan menjadi tanggungan saya pribadi.</span></p>
          <p style="line-height: 1.2; margin-top: 0pt; margin-bottom: 12pt; text-align: justify; background-color: #ffffff;"><span style="font-family: verdana, geneva;"><span style="font-size: 12pt; color: #222222; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><br /></span><span style="font-size: 12pt; color: #222222; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Demikian Surat Persetujuan ini saya buat dengan sadar dan penuh tanggung jawab.</span></span></p>
          <p style="line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt; text-align: justify; background-color: #ffffff;"><span style="font-size: 12pt; font-family: verdana, geneva; color: #222222; background-color: transparent; font-weight: 400; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Hormat saya, <?php  echo $_SESSION['nama_lengkap']  ?></span></p>


          <br><br>
          <?php
          $cek_udah_jawab = mysql_fetch_array(mysql_query("SELECT * FROM bpjs WHERE ID_karyawan = '$_SESSION[ID_karyawan]'"));
          if($cek_udah_jawab[0]==""){ ?>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <div style="background: #afdd5d;padding: 10px;color: white;border-radius: 10px; margin-bottom:10px;">
              <label for="example-checkbox1" >

                <input type="radio" id="example-checkbox1" name="persetujuan" value="Setuju" required=""> &nbsp;SAYA SETUJU
              </label>
              <textarea class="form-control" id="textarea-ckeditor" placeholder="Tidak Wajib Diisi" name="keteranganyes" class="ckeditor" ></textarea>
            </div>

            <div  style="background: #f03f4b;padding: 10px;color: white;border-radius: 10px;">
              <label for="example-checkbox1-tidak">

                <input type="radio" id="example-checkbox1-tidak" name="persetujuan" value="Tidak Setuju" required=""> SAYA TIDAK SETUJU
              </label>
              <textarea class="form-control" id="textarea-ckeditor-tidak" placeholder="Wajib Diisi Alasan kenapa anda tidak ingin mengikuti program ini"  name="keteranganno" class="ckeditor" ></textarea>
            </div>
            <input type="submit" style="margin-top: 20px; margin-bottom: 10px;"  name="simpan" class="btn btn-primary" value="BUAT PERNYATAAN">

          </form>
        <?php }else{ ?>
          <h3 style="margin-top:-10px; line-height:1.5">Anda Sudah Selesai Menjawab Pertanyaan, dengan jawaban :
          <?php
            if($cek_udah_jawab['persetujuan']=="Setuju"){
                echo "<b style='background:#72ff66; padding:5px;'>".$cek_udah_jawab[2]." ".$cek_udah_jawab[3]."</b></h3>";
            }else{
                echo "<b style='background:#72ff66; padding:5px; color: red;'>".$cek_udah_jawab[2].", dengan alasan : ".$cek_udah_jawab[3]."</b></h3>";
            }
          ?>
        <?php } ?>

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
