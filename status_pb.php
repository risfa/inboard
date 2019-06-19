<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
include 'wa.php';

if(isset($_GET['delete'])){
  $ID = $_GET['delete'];
  $IDlead = $_GET['id_lead'];
  $IDkar = $_GET['id_karyawan'];
  $data_lead = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan ='$IDlead'"));
  $data_kar = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan JOIN tb_permohonan_biaya_master ON tb_karyawan.ID_karyawan = tb_permohonan_biaya_master.id_pemohon WHERE ID_karyawan ='$IDkar'"));
  $Tanggal = $data_kar['tanggal_pengajuan'];
  $date = new DateTime($Tanggal);
  $date_time = $date->format('d-M-Y');
  $sql_batalkan_pb = mysql_query("DELETE FROM tb_permohonan_biaya_master WHERE ID_master_pb = '$_GET[delete]'");
  $sql_batalkan_pb_detail = mysql_query("DELETE FROM tb_permohonan_biaya_detail WHERE ID_master_pb = '$ID'");
  if($sql_batalkan_pb){
    move_uploaded_file($_FILES["fileToUpload_pce"]["tmp_name"],"img/PCE/".$ambil_id.".jpg");
    $kirim_feedback_ke_leader = send_wa($data_lead['no_telp'],"Permohonan Biaya *".$data_kar['nama_lengkap']."* Pada Tanggal *".$date_time."* Telah Dibatalkan Oleh *".$data_kar['nama_lengkap']."* , klik link dibawah ini :",'PERMOHONAN BIAYA');

    echo "<script>document.location.href='status_pb.php'</script>";
  }
}

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

  <div id="page-content">
   <div class="block full">
    <div class="block-title">
      <div class="row">
        <div class="col-md-3">
          <h2 style="font-size: 20px;margin: 13px;">Form Permohonan Biaya</h2>
        </div>
        <div class="col-md-9">
          <a href="form_pengajuan_pb.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;AJUKAN PERMOHONAN BIAYA</button></a><br>
        </div>
      </div>
    </div>
    
    <div class="table-responsive">
      <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
        <thead>
          <tr>
            <th style="width: 40px;">No</th>
            <th style="width: 40px;">Tanggal Pengajuan</th>
            <th style="width: 40px;">Nama Proyek</th>
            <th style="width: 20px;">Kualifikasi</th>
            <th style="width: 20px;">Kategori</th>
            <th style="width: 20px;">Ditujukan</th>
            <th style="width: 20px;">Transfer To</th>
            <th style="width: 20px;">Status</th>
            <th style="width: 20px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $No = 1;
          $sql = mysql_query("SELECT * FROM tb_permohonan_biaya_master JOIN tb_karyawan ON tb_permohonan_biaya_master.approved_by = tb_karyawan.ID_karyawan WHERE id_pemohon = '$_SESSION[ID_karyawan]' ORDER BY ID_master_pb DESC");
          while($data = mysql_fetch_array($sql)){
            $Tanggal = $data['tanggal_pengajuan'];
            $date = new DateTime($Tanggal);
            $date_time = $date->format('d M Y');
            ?>
            <tr>
              <td><?php echo $No++; ?></td>
              <td><?php echo $date_time ?></td>
              <td><?php echo $data['nama_proyek'] ?></td>
              <td><?php echo $data['kualifikasi'] ?></td>
              <td><?php echo $data['kategori'] ?></td>
              <td><?php echo $data['nama_lengkap'] ?></td>
              <td><?php echo $data['transferTo'] ?></td>
              <td>
                <?php if($data['status_pb']== 'DI AJUKAN'){ ?>
                    <span class="btn btn-warning btn-growl" data-growl="success"><i class="fa fa-clock-o"></i>DI AJUKAN</span>
                  <?php }else if($data['status_pb']=='DITERIMA LEADER' && $data['status_pb_finance']=='MENUNGGU FINANCE'){?>
                    <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>DI TERIMA LEADER / MENUNGGU FINANCE</span>
                    <span><a href="detail_pb.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-primary btn-growl" data-growl="success"><i class="fa fa-search">DETAIL PB</i></a></span>
                  <?php }else if($data['status_pb_finance']=='PB DITERIMA'){ ?>
                    <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>DI CHECK FINANCE</span>
                  <?php }else if($data['status_pb_finance']=='PB DIPROSES'){ ?>
                    <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-clock-o"></i>SEDANG DI PROSES FINANCE</span>
                  <?php }else if($data['status_pb_finance']=='FINALIZE'){ ?>
                    <span class="btn btn-success btn-growl" data-growl="success"><i class="fa fa-check-circle"></i>DI TERIMA</span>
                  <?php }else{ ?>
                    <span class="btn btn-danger btn-growl" data-growl="success"><i class="fa fa-times-circle-o"></i>REVISI</span>
                  <?php } ?>
              </td>
              <td>
                <?php if($data['status_pb']== 'DI AJUKAN'){ ?>
                    <a href="form_pengajuan_pb.php?ID=<?php echo $data[0] ?>&edit=1"><span class="btn btn-info" style="padding:5px;">EDIT PERMOHONAN BIAYA</span></a>
                    <span><a target="blank" href="detail_pb2.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-primary btn-growl" data-growl="success"><i class="fa fa-search">DETAILS PB</i></a></span>
                    <a href="status_pb.php?delete=<?php echo $data[0] ?>&id_lead=<?php echo $data['approved_by'] ?>&id_karyawan=<?php echo $data['id_pemohon'] ?>"><span class="btn btn-danger" style="padding:5px;">BATALKAN PERMOHONAN BIAYA</span></a>
                  <?php }else if($data['status_pb']=='DITERIMA LEADER' && $data['status_pb_finance']=='MENUNGGU FINANCE'){?>
                    <span><a target="blank" href="detail_pb2.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-primary btn-growl" data-growl="success"><i class="fa fa-search">DETAIL PB</i></a></span>
                  <?php }else if($data['status_pb_finance']=='PB DITERIMA'){ ?>
                    <span><a target="blank" href="detail_pb2.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-primary btn-growl" data-growl="success"><i class="fa fa-search">DETAILS PB</i></a></span>
                  <?php }else if($data['status_pb_finance']=='PB DIPROSES'){ ?>
                    <span><a target="blank" href="detail_pb2.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-primary btn-growl" data-growl="success"><i class="fa fa-search">DETAILS PB</i></a></span>
                  <?php }else if($data['status_pb_finance']=='FINALIZE'){ ?>
                    <span><a target="blank" href="detail_pb2.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-primary btn-growl" data-growl="success"><i class="fa fa-search">DETAILS PB</i></a></span>
                    <a target="blank" href="img/TRF/<?php echo $data['ID_master_pb'] ?>.jpg"><span class="label label-info">LIHAT BUKTI TRANSFER</span></a>
                  <?php } else if($data['status_pb']== 'REVISI'){ ?>
                    <a href="form_pengajuan_pb.php?ID=<?php echo $data[0] ?>&edit=1"><span class="btn btn-info" style="padding:5px;">EDIT PERMOHONAN BIAYA</span></a>
                    <span><a target="blank" href="detail_pb2.php?edit=<?php echo $data['ID_master_pb'] ?>" data-toggle="tooltip" title="Details PB" class="btn btn-primary btn-growl" data-growl="success"><i class="fa fa-search">DETAILS PB</i></a></span>
                  <?php } ?>
                </td>
          </tr>
        <?php }?>
      </tbody>

    </table>
  </div>
</div>
</div>
<!-- END Page Content -->
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
