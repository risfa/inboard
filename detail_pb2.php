    <?php
    include 'inc/config.php'; ;
    include 'inc/template_start.php';
    include 'inc/page_head.php';
    include ('Db/connect.php');
    include 'wa.php';

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
    if(isset($_POST['ajukan_PB'])){
        $insert_pb = mysql_query("INSERT INTO `tb_permohonan_biaya_master`(`ID_master_pb`, `nama_proyek`, `kualifikasi`, `note`, `approved_by`, `id_pemohon`, `transferTo`) VALUES (NULL,'$_POST[nama_proyek]','$_POST[kualifikasi]','$_POST[note]','$cek_kepemilikan_leader[top_leader]','$_SESSION[ID_karyawan]','$_POST[transferTo]')");
        $ID_PB = mysql_insert_id();
        if($insert_pb){
            move_uploaded_file($_FILES["fileToUpload_pce"]["tmp_name"],"img/PCE/".$ID_PB.".jpg");
        // echo"<script>alert('yes')</script>"; 
            echo"<script>document.location.href='form_pengajuan_pb.php?ID=$ID_PB'</script>";    
        }
    }
    if(isset($_POST['save_all'])){
        $insert= mysql_query("UPDATE `tb_permohonan_biaya_master` SET `status_pb`= 'DI AJUKAN',`status_pb_finance`= ''  WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[ID]'");
        if($insert){
            echo"<script>document.location.href='status_pb.php'</script>"; 
        }
    }
    $ID_PB = mysql_insert_id();
    echo"dfg".$ID_PB;
    if(isset($_POST['ajukan_PB2'])){
        $ID_master_pb = $_GET['ID'];
        move_uploaded_file($_FILES["fileToUpload_pce"]["tmp_name"],"img/PCE/".$ambil_id.".jpg");

        $insert_pb2 = mysql_query("INSERT INTO `tb_permohonan_biaya_detail`(`ID_permohonan_detail`, `ID_master_pb`, `uraian`, `jumlah`) VALUES (NULL,$ID_master_pb,'$_POST[uraian]','$_POST[jumlah]')");
    }
    if(isset($_GET['Ajukan_pb2'])){
        $ID_Pb = $_GET['id'];
        $delete_list = mysql_query("DELETE FROM `tb_permohonan_biaya_detail` WHERE ID_permohonan_detail='$_GET[Ajukan_pb2]'");
        if($delete_list){
            echo"<script>document.location.href='form_pengajuan_pb.php?ID=$ID_Pb'</script>";
        }
    }
    if(isset($_GET['editt'])){
      $data_edit = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_biaya_master WHERE ID_master_pb='$_GET[editt]'"));
      $data_editt = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_biaya_detail WHERE ID_permohonan_detail='$_GET[editt]'"));
  }
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title></title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function(){
            var jumlah_uang = $('#jumlah_uang').val();
            $.ajax({
                type:"post",
                url:"proses.php",
                data:'terbilangg='+jumlah_uang,
                success:function(html){
                    $('#tampilkan').val(html);
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
    <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>
    <?php
    if(isset($_GET['edit'])){
$data_tampil = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_biaya_master WHERE ID_master_pb = '$_GET[edit]' ORDER BY tanggal_pengajuan DESC"));
  $Tanggal = $data_tampil['tanggal_pengajuan'];
  $date = new DateTime($Tanggal);
  $date_time = $date->format('Y-m-d');
$data_tampill = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_biaya_detail WHERE tb_permohonan_biaya_detail.ID_master_pb = '$_GET[edit]'"));
}
    ?>
    <!-- Page content -->
    <div id="page-content">
        <div class="block full">
            <div class="block-title">
                <div class="row">
                    <div class="col-md-8">
                        <h2 style="font-size: 20px;margin: 13px;">Permohonan Biaya</h2>
                    </div>
                    <div class="col-md-4">
                        <!-- <a href="status_pb.php" style="float:right; margin-right:20px;"><button class="btn btn-info" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-chevron-left"></i>&nbsp; KEMBALI</button></a><br> -->
                    </div>
                </div>
            </div>
            <form id="form" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <div class="row" style="padding:20px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal Pengajuan</label>
                            <div class="col-md-9">
                                <input disabled="" type="text" name="tanggal_pengajuan" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $date_time ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Proyek Terkait</label>
                            <div class="col-md-9">
                                <input readonly="" type="text" name="nama_proyek" class="form-control" value="<?php echo $data_tampil['nama_proyek'] ?>"  required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Kualifikasi</label>
                            <div class="col-md-9">
                                
                                   <select disabled="" id="example-chosen" name="kualifikasi" required value="<?php echo $data_tampil['kualifikasi'] ?>" class="select-chosen">  
                                    <option value=""><?php echo $data_tampil['kualifikasi'] ?></option>
                                    <option value="Sangat Penting">Sangat Penting</option>
                                    <option class="penting" value="Penting">Penting</option>
                                    <option value="Biasa">Biasa</option>
                                </select> 
                             
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Catatan</label>
                        <div class="col-md-9">
                            <textarea readonly="" name="note" class="form-control" value="<?php echo $data_tampil['note'] ?>"required=""><?php echo $data_tampil['note'] ?></textarea>
                            

                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Transfer to</label>
                        <div class="col-md-9">
                            <input readonly="" type="text" name="transferTo" class="form-control" value="<?php echo $data_tampil['transferTo'] ?>" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">File PCE</label>
                        <div class="col-md-9">
                            <?php
                  if (file_get_contents("img/PCE/$_GET[edit].jpg") != '' ) {
              ?>
                  
                  <img src="img/PCE/<?php echo $_GET['edit']; ?>.jpg"  width="100px" height="100px">
                  
              <?php
                  }else{
                   echo "Anda Belum Upload File";
                  }
                  ?>
                            
                        </div>
                        
                    </div>

                </form>
                <form method="post">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Uraian Kebutuhan</label>
                        <div class="col-md-9">
                            <textarea readonly="" type="text" name="uraian" class="form-control" required="" value=""></textarea>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Harga</label>
                        <div class="col-md-9">
                            <input readonly="" type="number" name="jumlah" class="form-control " style="width:60%; float:left; margin-right: 20px;" required="">
                        </div>

                    </div>
                </form>
            </div>
            <?php 
            $ambil_id = $_GET['ID'];
            $tampil = mysql_fetch_array(mysql_query("SELECT SUM(jumlah) as jumlah FROM `tb_permohonan_biaya_detail` WHERE ID_master_pb = '$_GET[edit]'"));
            ?>
        <input type="hidden" readonly="" id="jumlah_uang" name="jumlah_uang" value="<?php echo $tampil['jumlah'] ?>">
        <div class="form-group">
            
            <div class="col-md-6">
                <input style="height:80px; font-size:50px; width:100%;" readonly="" type="tel" name="jumlah_uang" class="form-control" placeholder="10000" id="terbilangg" value="Rp <?php echo number_format($tampil['jumlah'])?>" required>

                <input style="width:100%; font-style: italic; background: none;" type="text" id="tampilkan" name="terbilangg" class="form-control" required readonly="">
                <br><br>
                <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                    <thead>
                        <tr>
                            <th>Uraian</th>
                            <th>Harga</th>
                            <th class="text-center" style="width: 10px;"><i class="fa fa-flash"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $tampil_PB1= mysql_query("SELECT * FROM tb_permohonan_biaya_detail WHERE ID_master_pb = '$_GET[edit]' ORDER BY ID_permohonan_detail DESC");
                        while($data=mysql_fetch_array($tampil_PB1)){
                            ?>
                            <tr>
                                <td><?php echo $data['uraian'] ?></td>
                                <td><?php echo "Rp. ".number_format($data['jumlah']); ?></td>
                                
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


            </div>
        </div>
        
    </div>
</div>
</div>
</div>
</div>
</div>
<!-- END OLD PAGE CONTENT -->
</div>

<script>
    $(document).ready(function(){

        $("#show").click(function(){
            $("#form1").toggle();
        });
    });
</script>
</body>
</html>

<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyDashboard.js"></script>


<?php include 'inc/template_end.php';

?>