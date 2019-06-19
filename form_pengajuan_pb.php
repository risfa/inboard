    <?php
    include 'inc/config.php'; ;
    include 'inc/template_start.php';
    include 'inc/page_head.php';
    include ('Db/connect.php');
    include 'wa.php';

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
        $nomor_Top_leader = fetch_karyawan($cek_kepemilikan_leader['top_leader']);
        $nomor_leader = fetch_karyawan($cek_kepemilikan_leader['leader']);
        echo "nomor".$nomor_Top_leader[0];
        // echo "nomor".$nomor_leader[0];

    if(isset($_POST['ajukan_PB'])){
        $insert_pb = mysql_query("INSERT INTO `tb_permohonan_biaya_master`(`ID_master_pb`, `nama_proyek`, `kualifikasi`, `approved_by`,`kategori`, `note`, `id_pemohon`, `transferTo`) VALUES (NULL,'$_POST[nama_proyek]','$_POST[kualifikasi]','$_POST[approved_by]','$_POST[kategori]','$_POST[note]','$_SESSION[ID_karyawan]','$_POST[transferTo]')");
        $ID_PB = mysql_insert_id();
        if($insert_pb){
            move_uploaded_file($_FILES["fileToUpload_pce"]["tmp_name"],"img/PCE/".$ID_PB.".jpg");
        // echo"<script>alert('yes')</script>"; 
            echo"<script>document.location.href='form_pengajuan_pb.php?ID=$ID_PB'</script>";    
        }
    }
    if(isset($_POST['save_all'])){
        $nomor_Top_leader = fetch_karyawan($cek_kepemilikan_leader['top_leader']);
        $nomor_leader = fetch_karyawan($cek_kepemilikan_leader['leader']);
        $whatsappLeader = $nomor_leader['no_telp'];
        $whatsappTopLeader = $nomor_Top_leader['no_telp'];
        
        $tanggal = $_POST['tanggal_pengajuan'];
        $proyek = $_POST['nama_proyek'];
        $klifikasi = $_POST['kualifikasi'];
        $Ktgori = $_POST['kategori'];
        $data_karyawan = fetch_karyawan($_SESSION[ID_karyawan]);
        $insert= mysql_query("UPDATE `tb_permohonan_biaya_master` SET `status_pb`= 'DI AJUKAN',`status_pb_finance`= ''  WHERE tb_permohonan_biaya_master.ID_master_pb = '$_GET[ID]'");
        if($insert){
        $tampil = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_biaya_master JOIN tb_karyawan ON tb_permohonan_biaya_master.approved_by = tb_karyawan.ID_karyawan WHERE ID_master_pb='$_GET[ID]'"));
        $Tanggal = $tampil['tanggal_pengajuan'];
        $date = new DateTime($Tanggal);
        $date_time = $date->format('d M Y');
                    $variable = " 
Nama Karyawan: *".$data_karyawan['nama_lengkap']."*
Jabatan: *".$data_karyawan['nama_jabatan']."*
Departement: *".$data_karyawan['nama_department']."*
Perusahaan: *".$data_karyawan['perusahaan']."*  
Tanggal Pengajuan: *".$date_time."* 
Proyek Terkait: *".$proyek."* 
Kualifikasi: *".$tampil['kualifikasi']."* 
Kategori: *".$tampil[kategori]."* 
Klik Link Dibawah ini :
";

             $message = "
Permohonan Biaya Karyawan Dengan Informasi  : ".$variable."";

             send_wa($tampil['no_telp'],$message,'PERMOHONAN BIAYA','https://xeniel.5dapps.com/inboard/otu/otu_permohonan_biaya.php?ID='.$_GET['ID'].'');
            echo"<script>document.location.href='status_pb.php'</script>"; 
        }
    }
    $ID_PB = mysql_insert_id();
    // echo"dfg".$ID_PB;
    if(isset($_POST['ajukan_PB2'])){
        $ID_master_pb = $_GET['ID'];

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
    if(isset($_GET['ID'])){ 
        $data_tampil = mysql_fetch_array(mysql_query("SELECT * FROM tb_permohonan_biaya_master JOIN tb_karyawan ON tb_permohonan_biaya_master.approved_by = tb_karyawan.ID_karyawan WHERE ID_master_pb ORDER BY tanggal_pengajuan DESC"));
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
                        <a href="status_pb.php" style="float:right; margin-right:20px;"><button class="btn btn-danger" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-times"></i>&nbsp;BATALKAN PENGISIAN</button></a><br>
                    </div>
                </div>
            </div>
            <form id="form" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <div class="row" style="padding:20px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="example-clickable-password2">Tanggal Pengajuan</label>
                            <div class="col-md-9">
                                <input <?php if($_GET['ID']!='' && $_GET['edit']==''){ echo " readonly "; }?> type="text" name="tanggal_pengajuan" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Proyek Terkait</label>
                            <div class="col-md-9">
                                <input <?php if($_GET['ID']!='' && $_GET['edit']==''){ echo " readonly "; }?> type="text" name="nama_proyek" class="form-control" value="<?php echo $data_tampil['nama_proyek'] ?>"  required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Kualifikasi</label>
                            <div class="col-md-9">
                                <?php 
                                if($data_tampil['kualifikasi']!=""){
                                    echo $data_tampil['kualifikasi'];
                                }else{
                                   ?>
                                   <select <?php if($_GET['ID']!='' && $_GET['edit']==''){ echo " disabled "; } ?> id="example-chosen" name="kualifikasi" required value="<?php echo $data_tampil['kualifikasi'] ?>" class="select-chosen">  
                                    <option value=""><?php echo $data_tampil['kualifikasi'] ?></option>
                                    <option value="Sangat Penting">Sangat Penting</option>
                                    <option class="penting" value="Penting">Penting</option>
                                    <option value="Biasa">Biasa</option>
                                </select> 
                            <?php } ?>                           
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-3 control-label">Kategori</label>
                            <div class="col-md-9">
                                <?php 
                                if($data_tampil['kategori']!=""){
                                    echo $data_tampil['kategori'];
                                }else{
                                   ?>
                                   <select <?php if($_GET['ID']!='' && $_GET['edit']==''){ echo " disabled "; } ?> id="example-chosen" name="kategori" required value="<?php echo $data_tampil['kategori'] ?>" class="select-chosen">  
                                    <option value=""><?php echo $data_tampil['kategori'] ?></option>
                                    <option value="Limadigit">Limadigit</option>
                                    <option value="Ardency">Ardency</option>
                                </select> 
                            <?php } ?>                           
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="col-md-3 control-label">Ditujukan</label>
                            <div class="col-md-9">
                                <?php 
                                if($data_tampil['nama_lengkap']!=""){
                                    echo $data_tampil['nama_lengkap'];
                                }else{
                                   ?>
                                   <select <?php if($_GET['ID']!='' && $_GET['edit']==''){ echo " disabled "; } ?> id="example-chosen" name="approved_by" required value="<?php echo $data_tampil['approved_by'] ?>" class="select-chosen">  
                                    <option value=""><?php echo $data_tampil['approved_by'] ?></option>
                                    <?php $lead = mysql_query("SELECT * FROM tb_karyawan WHERE departement = 5 LIMIT 2,2");
                                    while($data = mysql_fetch_array($lead)){
                                     ?>
                                    <option value="<?php echo $data[0] ?>"><?php echo $data['nama_lengkap'] ?></option>
                                    <?php } ?>
                                </select> 
                            <?php } ?>                           
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Catatan</label>
                        <div class="col-md-9">
                            <textarea <?php if($_GET['ID']!='' && $_GET['edit']==''){ echo " readonly "; } ?> name="note" class="form-control" value="<?php echo $data_tampil['note'] ?>"required=""><?php echo $data_tampil['note'] ?></textarea>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Transfer to</label>
                        <div class="col-md-9">
                            <input <?php if($_GET['ID']!='' && $_GET['edit']==''){ echo " readonly "; } ?> type="text" name="transferTo" class="form-control" value="<?php echo $data_tampil['transferTo'] ?>" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">File PCE</label>
                        <div class="col-md-9">
                            <input <?php if($_GET['ID']!='' && $_GET['edit']==''){ echo " disabled "; } ?> type="file" id="fileToUpload_pce" name="fileToUpload_pce">
                            <br>
                            <?php if($_GET['ID']!='' && $_GET['edit']==''){ ?>
                            	 <img style="max-width: 100px" src="img/PCE/<?php echo $data_tampil[0] ?>.jpg">
                            <?php } ?>
                            <br>
                            
                            <br><button <?php if($_GET['ID'] || $_GET['edit']=='0'){ echo " disabled "; } ?> type="submit" class="btn btn-success" value="+" name="ajukan_PB" id="show">LANJUTKAN</button>
                            <br>
                        </div>
                        
                    </div>

                </form>
                <form method="post">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Uraian Kebutuhan</label>
                        <div class="col-md-9">
                            <textarea type="text" name="uraian" class="form-control" required=""></textarea>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Harga</label>
                        <div class="col-md-9">
                            <input type="number" name="jumlah" class="form-control " style="width:60%; float:left; margin-right: 20px;" required="">
                            <input <?php if($_GET['ID']=='' ){ echo " disabled "; } ?> type="submit" class="btn btn-success" value="TAMBAH KE CART > " name="ajukan_PB2" id="" style="float:left">
                        </div>

                    </div>
                </form>
            </div>
            <?php 
            $ambil_id = $_GET['ID'];
            $tampil = mysql_fetch_array(mysql_query("SELECT SUM(jumlah) as jumlah FROM `tb_permohonan_biaya_detail` WHERE ID_master_pb = '$_GET[ID]'"));
        	?>
        <input type="hidden" id="jumlah_uang" name="jumlah_uang" value="<?php echo $tampil['jumlah'] ?>">
        <div class="form-group">
            <!-- <input value="<?php echo $_GET['ID'] ?>" type="" name="Id"> -->
            <div class="col-md-6">
                <input style="height:80px; font-size:50px; width:100%;" <?php if($_GET['ID']){ echo " readonly "; } ?> type="tel" name="jumlah_uang" class="form-control" placeholder="10000" id="terbilangg" value="Rp <?php echo number_format($tampil['jumlah']) ?>" required>

                <input style="width:100%; font-style: italic; background: none;" <?php if($_GET['ID']){ echo " readonly "; } ?> type="text" id="tampilkan" name="terbilangg" class="form-control" required readonly="">
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
                        $tampil_PB1= mysql_query("SELECT * FROM tb_permohonan_biaya_detail WHERE ID_master_pb = '$_GET[ID]' ORDER BY ID_permohonan_detail DESC");
                        while($data=mysql_fetch_array($tampil_PB1)){
                            ?>
                            <tr>
                                <td><?php echo $data['uraian'] ?></td>
                                <td><?php echo "Rp. ".number_format($data['jumlah']); ?></td>
                                <td>
                                    <a onclick="return confirm('Apakah anda yakin?, Aksi ini tidak dapat di ulangi')" href="form_pengajuan_pb.php?Ajukan_pb2=<?php echo $data['ID_permohonan_detail']?>&id=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Delete" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


            </div>
        </div>
        <br><input <?php if($_GET['ID']=='' ){ echo " disabled "; } ?> type="submit" class="btn btn-success" value="AJUKAN PERMOHONAN BIAYA" name="save_all" id="">
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
