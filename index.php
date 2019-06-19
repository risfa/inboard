<?php include 'inc/config.php';?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include('Db/connect.php');
include('wa.php');


?>

<script src="//cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.1/firebase.js"></script>


<script>
// Initialize Firebase
var config = {
    apiKey: "AIzaSyCgDf9JuKr0xQ2MZQ5sNuG4uqPFq5szwu0",
    authDomain: "inboard-eb2af.firebaseapp.com",
    databaseURL: "https://inboard-eb2af.firebaseio.com",
    projectId: "inboard-eb2af",
    storageBucket: "inboard-eb2af.appspot.com",
    messagingSenderId: "529742209862"
};
firebase.initializeApp(config);
// Retrieve Firebase Messaging object.
const messaging = firebase.messaging();
// Add the public key generated from the console here.
// messaging.usePublicVapidKey("BKagOny0KF_2pCJQ3m....moL0ewzQ8rZu");
messaging.requestPermission().then(function() {
  console.log('Notification permission granted.');
  // TODO(developer): Retrieve an Instance ID token for use with FCM.
  // ...
  if (isTokenSentToServer()) {
    console.log('Token already send');
  }else{
    getRegToken();
  }
  // getRegToken();

}).catch(function(err) {
  console.log('Unable to get permission to notify.', err);
});

function getRegToken(argument){
  // console.log(argument)
  // Get Instance ID token. Initially this makes a network call, once retrieved
  // subsequent calls to getToken will return from cache.
  messaging.getToken().then(function(currentToken) {
  // alert(currentToken)

    if (currentToken) {
      // sendTokenToServer(currentToken);
      // updateUIForPushEnabled(currentToken);
      console.log("Curren Token :  " + currentToken);
      saveToken(currentToken);
      setTokenSentToServer(true);
    } else {
      // Show permission request.
      console.log('No Instance ID token available. Request permission to generate one.');
      // Show permission UI.
      setTokenSentToServer(false);
    }
  }).catch(function(err) {
    console.log('An error occurred while retrieving token. ', err);
    showToken('Error retrieving Instance ID token. ', err);
    setTokenSentToServer(false);
  });
}

function setTokenSentToServer(sent) {
  window.localStorage.setItem('sentToServer', sent ? '1' : '0');
}
function showToken(currentToken) {
  // Show token in console and UI.
  var tokenElement = document.querySelector('#token');
  tokenElement.textContent = currentToken;
}
function isTokenSentToServer() {
  return window.localStorage.getItem('sentToServer') === '1';
}

messaging.onMessage(function(payload){
  // alert(payload.notification.icon)

  notificationTitle = payload.notification.title;
  notificationOptions = {
    body : payload.notification.body,
    icon : payload.notification.icon
  };
  var notification = new Notification(notificationTitle,notificationOptions);

  
  // notificationTitle = payload.data.title;
  // notificationOptions = {
  //   body : payload.data.body,
  //   icon : payload.data.icon
  // };
  // var notification = new Notification(notificationTitle,notificationOptions);
  // notification.onclick = function(event) {
  //   event.preventDefault(); // prevent the browser from focusing the Notification's tab
  //   window.open(payload.data.link, '_blank');
  // }

  // setTimeout(notification.close.bind(notification), 10000);
});

function saveToken(token){

  $.get("save_token.php?token="+token+"&ID_karyawan="+'<?php echo $_SESSION['ID_karyawan']; ?>', function(data, status){
    console.log('save token'+data);
    $.get("notifikasi/send_notifikasi.php?ID_karyawan="+'<?php echo $_SESSION['ID_karyawan']; ?>', function(data, status){
      console.log('send notifikasi'+data);
    });
  });

}
</script>


<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
<script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
<link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">

<!-- Page content -->
<div id="page-content">

  <div class="row">
    <div class="col-md-4">
      <div class="block">
        <div class="block-title">
          <h2>Mading Perusahaan</h2>
        </div>
        <div class="block-content-full">
          <div id="info-carousel" class="carousel slide remove-margin" data-ride="carousel" data-interval="2500">

            <ol class="carousel-indicators">
              <li data-target="#info-carousel" data-slide-to="0" class="active"></li>

                <?php
                $get_slider_count = mysql_fetch_array(mysql_query("SELECT COUNT(ID_mading) FROM tb_mading"));
                    for ($i=1;$i<=$get_slider_count[0]-1;$i++){
                        echo '<li data-target="#info-carousel" data-slide-to="'.$i.'" class=""></li>';
                    }
                ?>
            </ol>

            <div class="carousel-inner">

                <?php
                    $datapertama = mysql_fetch_array(mysql_query("SELECT * FROM tb_mading ORDER BY ID_mading DESC LIMIT 0,1 "));
                ?>

                  <div class="item active">
                      <center style="background:black">
                    <a href="<?php echo $datapertama['link'] ?>">
                    <img src="img/mading/<?php echo $datapertama[0] ?>.jpg" alt="image" style="height:350px; width:auto;"></a>
                      </center>
                    <div class="carousel-caption">
                      <!-- <h3><strong><?php echo $datapertama['judul'] ?></strong></h3> -->
                    </div>
                  </div>
                <?php
                    $sql_mading = mysql_query("SELECT * FROM tb_mading ORDER BY ID_mading DESC LIMIT 1,999999");
                    while($data_mading = mysql_fetch_array($sql_mading)){
                ?>
                    <div class="item ">
                        <center style="background:black">
                          <a href="<?php echo $data_mading['link'] ?>">
                        <img src="img/mading/<?php echo $data_mading[0] ?>.jpg" alt="image"  style="height:350px; width:auto;"></a>
                        </center>
                        <div class="carousel-caption">
                            <!-- <h3><strong><?php echo $data_mading['judul'] ?></strong></h3> -->
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a class="left carousel-control" href="#info-carousel" data-slide="prev">
              <span><i class="fa fa-chevron-left"></i></span>
            </a>
            <a class="right carousel-control" href="#info-carousel" data-slide="next">
              <span><i class="fa fa-chevron-right"></i></span>
            </a>
          </div>
        </div>
      </div>
    </div>
      <div class="col-md-4">
          <div class="block">
              <div class="block-title"><h2>ULANG TAHUN BULAN INI</h2></div>
              <div class="block-content-full">
                <?php 
                  $tanggal_sekarang = date('m');
                  $tahun_sekarang = date('Y');
                  // echo $tanggal_sekarang;
                  $data_ultah_sekarang = mysql_query("SELECT * FROM `tb_karyawan` WHERE `tgl_lahir` LIKE '%-".$tanggal_sekarang."-%' ORDER BY tgl_lahir ASC");
                  while($data = mysql_fetch_array($data_ultah_sekarang)){
                    // echo substr($data['tgl_lahir'], -4);
                      $umur_sekarang = $tahun_sekarang - substr($data['tgl_lahir'], -4) ;
                      echo '<div class="label-info" style="color:white; padding: 10px;">'.$data['nama_lengkap'].' | Ke-'.$umur_sekarang.' | '.$data['tgl_lahir'].'</div>';
                  }
                 ?>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="block">
              <div class="block-title"><h2>NOTIFIKASI</h2></div>
              <div class="block-content-full">
              <?php 
                  $tanggal_sekarang = date('d-m-Y');
                  $tahun_sekarang = date('Y');
                  $data_cuti_sekarang = mysql_query("SELECT * FROM `tb_permohonan_cuti` JOIN tb_karyawan ON tb_permohonan_cuti.ID_karyawan = tb_karyawan.ID_karyawan WHERE `tgl_cuti` LIKE '%".$tanggal_sekarang."%' AND tb_permohonan_cuti.status = 'DI TERIMA' ORDER BY tgl_cuti");
                  while($data = mysql_fetch_array($data_cuti_sekarang)){
                      // $cuti = substr($data['tgl_cuti'],-10) = $tanggal_sekarangg ;
                      // echo $cuti;
                      echo '<div class="label-danger" style="color:white; padding: 10px;">'.$data['nama_lengkap'].' | SEDANG CUTI | '.$data['tgl_cuti'].'</div>';
                  }
                 ?>
             </div>
          </div>
      </div>
      <!-- <div class="col-md-8">
    </div> -->
  </div>
<?php
$dataPribadi = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_department ON tb_karyawan.departement= tb_department.ID JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID where ID_karyawan = '$_SESSION[ID_karyawan]'  "));
$dataLogin = mysql_fetch_array(mysql_query("SELECT * FROM tb_login where ID_karyawan = '$_SESSION[ID_karyawan]'  "));
$dataBank = mysql_fetch_array(mysql_query("SELECT * FROM tb_bank where ID_karyawan = '$_SESSION[ID_karyawan]'  "));

  if(isset($_POST['update_data'])){
    $sql_udpate = mysql_query("UPDATE tb_karyawan SET nama_lengkap = '$_POST[nama_lengkap]', jenis_kelamin = '$_POST[jenis_kelamin]', no_ktp = '$_POST[no_ktp]', tgl_lahir = '$_POST[tgl_lahir]', agama = '$_POST[agama]', pendidikan = '$_POST[pendidikan]', perusahaan = '$_POST[perusahaan]', jabatan = '$_POST[jabatan]', akses_level = '$_POST[akses_level]', departement = '$_POST[departement]', mulai_bekerja = '$_POST[mulai_bekerja]', NIP = '$_POST[NIP]', no_npwp = '$_POST[no_npwp]', no_telp = '$_POST[no_telp]', alamat = '$_POST[alamat]', alamat_ktp = '$_POST[alamat_ktp]'  WHERE ID_karyawan = '$_GET[edit]'");

    $ID_karyawan = $_GET['edit'];
    $sql_bank = mysql_query("UPDATE tb_bank SET bank ='$_POST[bank]', nama_pemilik_bank = '$_POST[nama_pemilik_bank]',no_rek='$_POST[no_rek]' WHERE ID_karyawan = '$_GET[edit]'");

    $ID_karyawan = $_GET['edit'];
    $sql_bank = mysql_query("UPDATE tb_login SET email ='$_POST[email]' WHERE ID_karyawan = '$_GET[edit]'");;

    if($sql_udpate == true){
    $kirim_ke_HR = send_wa('6281316124343'," ".$dataPribadi['nama_lengkap']." Telah melakukan perubahan data, mohon cek kembali data yang telah dirubah, klik link dibawah ini : ",'PERUBAHAN DATA','inboard.ardgroup.co.id');
      echo '<script type="text/javascript">
      iziToast.success({
        title: "OK",
        message: "Data has been Succesfully inserted record!",
      });
      </script>';
      echo "<script>document.location.href='index.php'</script>";
    }else{
      echo "<script>alert('Failed save!')</script>";
      echo "<script>document.location.href='index.php'</script>";
    }
  }
  ?>
  <div class="block full">
    <div class="block-title">
      <div class="row">
        <div class="col-md-2">
          <h2 style="font-size: 20px;margin: 13px;">DATA DIRIMU</h2>
        </div>
          <div class="col-md-10">
            <a href="index.php?edit=<?php echo $dataPribadi['ID_karyawan'] ?>" class="btn btn-effect-ripple btn-info" style="float:right; margin:20px;">EDIT DATA DIRI</a>
            <a href="form_keluarga.php" class="btn btn-effect-ripple btn-success" style="float:right; margin:20px;">INSERT DATA KELUARGA</a>

             <?php
              $sql_cek = mysql_num_rows(mysql_query("SELECT * FROM tb_ubah_data WHERE ID_karyawan = '$_SESSION[ID_karyawan]'"));
              if($sql_cek != 0){
              ?>
              TERIMAKASIH! <br>
              ANDA SUDAH MELAKUKAN PERMOHONAN PERUBAHAN DATA!
             <!-- <a href="#" class="btn btn-effect-ripple btn-general " data-toggle="modal" style="float:right;">PENGAJUAN PERUBAHAN</a> -->
              <?php }else{ ?>
                 <a href="#modal-fade" class="btn btn-effect-ripple btn-danger" data-toggle="modal" style="float:right; margin:20px;">AJUKAN PERUBAHAN DATA</a>                
                <?php  } ?>
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

               <input type="hidden" name="ID_karyawan" class="form-control" value="<?php echo $dataPribadi['ID_karyawan'] ?>" required>

            <div class="form-group">
              <label class="col-md-3 control-label">Nama Lengkap</label>
              <div class="col-md-9">
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?> name="nama_lengkap" class="form-control" value="<?php echo $dataPribadi['nama_lengkap'] ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="example-select">Jenis Kelamin</label>
              <div class="col-md-9">
                <select <?php if($_GET['edit']==''){ echo "disabled";} ?> id="example-chosen" name="jenis_kelamin" required value="<?php echo $dataPribadi['jenis_kelamin'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                  <option value="<?php echo $dataPribadi['jenis_kelamin'] ?>"><?php echo $dataPribadi['jenis_kelamin'] ?></option>
                  <option value="Laki-Laki">Laki-Laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal Lahir</label>
              <div class="col-md-9">
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?> name="tgl_lahir" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $dataPribadi['tgl_lahir'] ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="example-select">Agama</label>
              <div class="col-md-9">
                <select <?php if($_GET['edit']==''){ echo "disabled";} ?> id="example-chosen" name="agama" required value="<?php echo $dataPribadi['agama'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                  <option value="<?php echo $dataPribadi['agama'] ?>"><?php echo $dataPribadi['agama'] ?></option>
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
                <select <?php if($_GET['edit']==''){ echo "disabled";} ?> id="example-chosen" name="pendidikan" required value="<?php echo $dataPribadi['pendidikan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                  <option value="<?php echo $dataPribadi['pendidikan'] ?>"><?php echo $dataPribadi['pendidikan'] ?></option>
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
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?> name="no_ktp" class="form-control" value="<?php echo $dataPribadi['no_ktp'] ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="example-clickable-city">NPWP</label>
              <div class="col-md-9">
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?> id="no_npwp" name="no_npwp" class="form-control" value="<?php echo $dataPribadi['no_npwp'] ?>" required>
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
                <select <?php if($_GET['edit']==''){ echo "disabled";} ?> id="example-chosen" name="perusahaan" required value="<?php echo $dataPribadi['perusahaan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                  <option value="<?php echo ['perusahaan'] ?>"><?php echo $dataPribadi['perusahaan'] ?> </option>
                  <option value="Limadigit">Limadigit</option>
                  <option value="Ardecny">Ardency</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="example-select">Departemen</label>
              <div class="col-md-9">
                <select <?php if($_GET['edit']==''){ echo "disabled";} ?> id="example-chosen" name="departement" required value="<?php echo $dataPribadi['departement'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                  <option value="<?php echo $dataPribadi['departement'] ?>"><?php echo $dataPribadi['nama_department'] ?></option>
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
                <select <?php if($_GET['edit']==''){ echo "disabled";} ?> id="example-chosen" name="jabatan" required value="<?php echo $dataPribadi['jabatan'] ?>"  class="select-chosen"  style="width: 250px; display: none;">
                  <option value="<?php echo $dataPribadi['jabatan'] ?>"><?php echo $dataPribadi['nama_jabatan'] ?></option>
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
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?> id="example-datepicker-kerja" name="mulai_bekerja" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $dataPribadi['mulai_bekerja'] ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="example-clickable-city">NIP</label>
              <div class="col-md-9">
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?> id="NIP" name="NIP" class="form-control" value="<?php echo $dataPribadi['NIP'] ?>" required>
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
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?>  name="alamat" class="form-control" value="<?php echo $dataPribadi['alamat'] ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" >No HP</label>
              <div class="col-md-9">
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?>  name="no_telp" class="form-control" value="<?php echo $dataPribadi['no_telp'] ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" >Email</label>
              <div class="col-md-9">
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?>  name="email" class="form-control" value="<?php echo $dataLogin['email'] ?>" required>
              </div>
            </div>

          </div>

            <div class="block">
                <div class="block-title">
                    <h2>Berkas</h2>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <font><b> KTP</b></font><br>
                        <?php
                        if (file_get_contents("img/KTP/$_SESSION[ID_karyawan].jpg") != '' ) {
                            ?>
                            <img src="img/KTP/<?php echo $_SESSION['ID_karyawan']; ?>.jpg"  width="100%" height="100px">
                            <?php
                        }else{
                            echo "Menunggu HRD";
                        }
                        ?>
                    </div>

                    <div class="col-md-3">
                        <font><b>PAS FOTO</b></font><br>
                        <?php
                        if (file_get_contents("img/PasFoto/$_SESSION[ID_karyawan].jpg") != '' ) {
                            ?>
                            <img src="img/KTP/<?php echo $_SESSION['ID_karyawan']; ?>.jpg"  width="100%" height="100px">
                            <?php
                        }else{
                            echo "Menunggu HRD";
                        }
                        ?>
                    </div>

                    <div class="col-md-3">
                        <font><b>AKTA KERJA </b></font><br>
                        <?php
                        if (file_get_contents("img/akta/$_SESSION[ID_karyawan].jpg") != '' ) {
                            ?>
                            <img src="img/akta/<?php echo $_SESSION['ID_karyawan']; ?>.jpg"  width="100%" height="100px">
                            <?php
                        }else{
                            echo "Menunggu HRD";
                        }
                        ?>
                    </div>

                    <div class="col-md-3">
                        <font><b>CV</b></font><br>
                        <?php
                        if (file_get_contents("img/CV/$_SESSION[ID_karyawan].jpg") != '' ) {
                            ?>
                            <img src="img/akta/<?php echo $_SESSION['ID_karyawan']; ?>.jpg"  width="100%" height="100px">
                            <?php
                        }else{
                            echo "Menunggu HRD";
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
                <select <?php if($_GET['edit']==''){ echo "disabled";} ?> id="example-select" name="bank" class="select-chosen" size="1" value="<?php echo $dataBank['bank'] ?>" required>
                  <option value="<?php echo $dataBank['bank'] ?>"><?php echo $dataBank['bank'] ?></option>
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
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?>  name="nama_pemilik_bank" class="form-control" value="<?php echo $dataBank['nama_pemilik_bank'] ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label" for="example-file-input">No. Rekening</label>
              <div class="col-md-9">
                <input type="text" <?php if($_GET['edit']==''){ echo "readonly";} ?> name="no_rek" class="form-control" value="<?php echo $dataBank['no_rek'] ?>" required>
              </div>
            </div>
          </div>
          	<?php if($_GET['edit']){ ?>
            <input type="submit" class="btn btn-info" value="UPDATE DATA DIRI" name="update_data" id="">
            <a href="index.php" class="btn btn-danger">CANCEL</a>
            <?php } ?>
      </form>
      <?php 
      	$edit_familiy = mysql_fetch_array(mysql_query("SELECT * FROM `tb_keluarga` WHERE ID_karyawan = '$_SESSION[ID_karyawan]'"));

      	if(isset($_POST['insert_kel'])){
          $id_karyawan = $_GET['insert_keluarga'];
          echo("INSERT INTO `tb_keluarga`(`ID_keluarga`, `nik`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `hubungan`, `ID_karyawan`, `faskes_tk1`, `faskes_dr_gigi`, `alamat_keluarga`, `telp_keluarga`) VALUES (NULL,'$_POST[nik]','$_POST[nama]','$_POST[jenis_kelamin]','$_POST[tanggal_lahir]','$_POST[hubungan]','$id_karyawan','$_POST[faskes_tk1]','$_POST[faskes_dr_gigi]','$_POST[alamat_keluarga]','$_POST[telp_keluarga]')");
          if($query_kel){
            echo"<script>alert('berhasil')</script>";
          }else{
            echo"<script>alert('tidak berhasil')</script>";
          }
        }
       ?>
       <form method="post" enctype="multipart/form-data">
            <div class="block" >
              <div class="block-title">
                <h2>Data Keluarga</h2>

              <table class="table table-bordered">
                <tr>
                  <td>No</td>
                  <td>Informasi

                  </td>
                  <td>Action</td>
                </tr>
              <?php 
              
              $No = 1;
                $keluarga = mysql_query("SELECT * FROM tb_keluarga WHERE ID_karyawan = '$_SESSION[ID_karyawan]' ORDER BY ID_keluarga DESC");
                while($data_kel = mysql_fetch_array($keluarga)){
                ?>
                <tr>
                  <td><?php echo $No++; ?></td>
                  <td>
                    <b>Nama       :</b> <?php echo $data_kel['nama'] ?><br>
                    <i><b>Nik        :</b><?php echo $data_kel['nik'] ?><i><br>
                    <b>Tanggal Lahir :</b><?php echo $data_kel['tanggal_lahir'] ?><br>
                    <b>Jenis Kelamin :</b><?php echo $data_kel['jenis_kelamin'] ?><br>
                    <b>Hubungan      :</b><?php echo $data_kel['hubungan'] ?><br>
                  </td>
                  <td>
                    <?php if($_GET['insert_keluarga']){ ?>
                    <a href="index.php?insert_keluarga=<?php echo $data_kel['ID_keluarga'] ?>"><i class="fa fa-trash"></i></a>
                    <?php } ?>
                  </td>
                </tr>
                <?php } ?>
              </table>  
            </div>

            </div>
        </div>
      </div>

  </div>
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<?php 
if(isset($_POST['simpan_laporan'])){
  $insert_ubah_data = mysql_query("INSERT INTO tb_ubah_data(ID_ubah_data,ID_karyawan,keterangan) VALUES (NULL, '$_SESSION[ID_karyawan]','$_POST[keterangan]')");
  
  echo"<script>document.location.href = 'index.php'<script/>";
  $id_karyawan_baru = $_SESSION['ID_karyawan'];
  if($insert_ubah_data){
    

    $notifikasiSimpan = mysql_query("INSERT INTO tb_notifikasi_log (id_karyawan,child_id_karyawan,msg,flag_read,keterangan) values ('$_SESSION[ID_karyawan]','$id_karyawan_baru','Anda Telah meminta permohonan perubahan data mohon tunggu untuk proses selanjutnya',0,'insert')");


    // echo '<script type="text/javascript">
    //   iziToast.success({
    //     title: "OK",
    //     message: "Berhasil",
    //   });
    //   </script>';
  } 
}
 ?>
<form method="post">
    <div id="modal-fade" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><strong>Laporkan Kekeliruan Data</strong></h3>
                </div>
                <div class="modal-body" style="height:100px;">
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea class="form-control" name="keterangan" placeholder="Deskripsikan kekeliruan data anda disini"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="simpan_laporan" class="btn btn-effect-ripple btn-primary" value="Ajukan Laporan">
                </div>
            </div>
        </div>
    </div>
</form>




<script src="js/pages/readyDashboard.js"></script>
<script>$(function(){ ReadyDashboard.init(); });</script>

<?php include 'inc/template_end.php'; ?>
