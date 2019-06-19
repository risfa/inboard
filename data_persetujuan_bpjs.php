<?php include 'inc/config.php'; ;
include 'inc/template_start.php';
include 'inc/page_head.php';
include ('Db/connect.php');

if(isset($_GET['delete'])){
  $sqldelete = mysql_query("DELETE FROM bpjs WHERE ID_bpjs = '$_GET[delete]'");
  echo "<script>document.location.href='data_persetujuan_bpjs.php'</script>";

}

?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
  <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
  <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>

  <!-- Page content -->
  <div id="page-content">
    <div class="block full">
      <div class="block-title">
        <div class="row">
          <div class="col-md-8">
            <h2 style="font-size: 20px;margin: 13px;">PANEL KONTROL PERSETUJUAN BPJS</h2>
          </div>
          <div class="col-md-4">
          </div>
        </div>

      </div>
      <div class="row">
        <div class=" col-lg-3">
          <a href="javascript:void(0)" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix" style="min-height: 101px; background:#f9f9f9; border: 1px solid #ebeef2;">
              <div class="widget-icon pull-left themed-background-info">
                <i class="fa fa-users text-light-op"></i>
              </div>
              <h2 class="widget-heading h3 text-info">
                <?php
                    $jumlah_karyawan = mysql_num_rows(mysql_query("SELECT * FROM tb_karyawan WHERE status = '1'"));
                 ?>
                <strong><span data-toggle="counter" data-to="2835"><?php echo $jumlah_karyawan; ?></span></strong>
              </h2>
              <span class="text-muted">Total Karyawan Terdaftar</span>
            </div>
          </a>
        </div>

        <div class=" col-lg-3" >
          <a href="javascript:void(0)" class="widget" style="background:#f9f9f9; border: 1px solid #ebeef2;">
            <div class="widget-content widget-content-mini text-right clearfix" style="min-height: 101px">
              <div class="widget-icon pull-left themed-background-success">
                <i class="fa fa-users text-light-op"></i>
              </div>
              <h2 class="widget-heading h3 text-success">
                <?php
                    $udah_isi = mysql_num_rows(mysql_query("SELECT * FROM bpjs"));
                 ?>
                <strong><span data-toggle="counter" data-to="75"><?php echo $udah_isi; ?></span></strong>
              </h2>
              <span class="text-muted">Total Karyawan Sudah Mengisi Pernyataan</span>
            </div>
          </a>
        </div>

        <div class=" col-lg-3">
          <a href="javascript:void(0)" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix" style="min-height: 101px; background:#f9f9f9; border: 1px solid #ebeef2;">
              <div class="widget-icon pull-left themed-background-danger">
                <i class="fa fa-users text-light-op"></i>
              </div>
              <h2 class="widget-heading h3 text-danger">
                <strong><span data-toggle="counter" data-to="2835"><?php echo $jumlah_karyawan - $udah_isi; ?></span></strong>
              </h2>
              <span class="text-muted">Karyawan Belum Mengisi Pernyataan</span>
            </div>
          </a>
        </div>

        <div class=" col-lg-3">
          <a href="javascript:void(0)" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix" style="min-height: 101px; background:#f9f9f9; border: 1px solid #ebeef2;">
              <div class="widget-icon pull-left themed-background-warning">
                <i class="fa fa-users text-light-op"></i>
              </div>
              <h2 class="widget-heading h3 text-warning">
                <?php
                    $setuju = mysql_num_rows(mysql_query("SELECT * FROM bpjs WHERE persetujuan = 'Setuju'"));
                    $tsetuju = mysql_num_rows(mysql_query("SELECT * FROM bpjs WHERE persetujuan = 'Tidak Setuju'"));
                 ?>
                <strong><span data-toggle="counter" data-to="2835"><?php echo $setuju." / ".$tsetuju; ?></span></strong>
              </h2>
              <span class="text-muted">Total Jawaban Setuju / Tidak Setuju</span>
            </div>
          </a>
        </div>




      </div>
      <form id="form" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
        <div class="row" style="padding:20px;">
          <div class="col-md-12">
            <div class="table-responsive">
                <table id="example-datatable" class="table table-striped table-bordered table-vcenter dataTable no-footer" role="grid" aria-describedby="example-datatable_info">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Kontak</th>
                  <th>Hasil Persetujuan</th>
                  <th>Tanggal Persetujuan</th>
                  <th>Batalkan Persetujuan</th>
                </tr>
              </thead>

                <?php
                $No = 1;
  				   $tampil_bpjs = mysql_query("SELECT * FROM bpjs JOIN tb_karyawan ON bpjs.ID_karyawan = tb_karyawan.ID_karyawan JOIN tb_login ON tb_karyawan.ID_karyawan = tb_login.ID_karyawan");
  				   while($data = mysql_fetch_array($tampil_bpjs)) {

   				?>
                <tr>
                    <td><?php echo $No ?></td>
                    <td><?php echo  "<b style='font-size:15px'>" .$data['nama_lengkap']."</b>" ?></td>
                    <td><?php echo  "<b style='font-size:15px'>" .$data['no_telp']."</b><br>".$data['email'] ?></td>
                    <td><?php echo "<b style='font-size:15px'>".$data['persetujuan']."</b><br>".$data['keterangan']?></td>
                    <td><?php echo "<b style='font-size:15px'>".$data['waktu']."</b>" ?></td>
                    <td>
                      <a href="data_persetujuan_bpjs.php&delete=<?php echo $data[0] ?>" onclick="return confirm('Anda yakin akan menghapus persetujuan ini?')"><button class="btn btn-danger">BATALKAN PERSETUJUAN</button></a>
                    </td>
                  </tr>
                  <?php $No++; } ?>
              </table>
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

<?php include 'inc/template_end.php';

?>
