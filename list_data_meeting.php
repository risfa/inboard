<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');
 include 'wa.php';

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
                <h2 style="font-size: 20px;margin: 13px;">List Meeting</h2>
            </div>
            <div class="col-md-9">
                  <a href="form_absensi_meeting.php" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;AJUKAN PERMOHONAN MEETING</button></a><br>
            </div>
          </div>
        </div>
       
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10px; text-align: center;">No</th>
                        
                        <th style="width: 40px;">Judul Meeting</th>
                        <th style="width: 20px;">Tanggal</th>
                        <th style="width: 20px;">Waktu Meeting <br> <h5>Mulai / Akhir</h5></th>
                        <th style="width: 20px;">Total Jam Meeting</h5></th>
                        <th style="width: 20px;">Lokasi Meeting</h5></th>
                        <th style="width: 20px;">Deksripsi Meeting</th>
                        <th style="width: 20px;">Unique Code</th>
                        <th style="width: 20px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  if(isset($_GET['delete'])){
                    $meeting_delete = mysql_query("DELETE FROM `tb_meeting` WHERE ID_meeting='$_GET[delete]'");
                    if($meeting_delete){
                        echo"<script>document.location.href='list_data_meeting.php'</script>";
                    }
                  }
                   $no = 1;
                    $sql = mysql_query("SELECT * FROM tb_meeting");
                    while($data = mysql_fetch_array($sql)){
                   $Tanggal = $data['tanggal_meeting'];
                   $datee = new DateTime($Tanggal);
                   $date_time = $datee->format('d M Y');

                   $awal  = date_create($data['waktu_mulai']);
                   $akhir = date_create($data['waktu_akhir']);
                   $diff  = date_diff($awal,$akhir);
                   ?>
                   <tr>
                  <td style="text-align: center;"><?php echo $no ?></td>
                  
                  <td><?php echo $data['judul_meeting'] ?></td>
                  <td><?php echo $date_time ?></td>
                  <td><?php echo $data['waktu_mulai'] ?> / <?php echo $data['waktu_akhir']?></td>
                  <td><?php echo "$diff->h" . " jam, "."$diff->i" . " menit ";  ?></td>
                  <td><?php echo $data['Lokasi'] ?></td>
                  <td><?php echo $data['desk_meeting'] ?></td>
                  <td><?php echo $data['kode_meeting'] ?></td>
                  
                  <td>
                     <a href="form_absensi_meeting.php?edit=<?php echo $data['ID_meeting'] ?>"><i class="fa fa-pencil" title="Edit"></i></a>&nbsp;&nbsp; / &nbsp;&nbsp;
                     <a href="list_data_meeting.php?delete=<?php echo $data['ID_meeting'] ?>"><i class="fa fa-trash" title="Delete"></i></a>&nbsp;&nbsp; / &nbsp;&nbsp;
                     <a href="print_data_meeting.php?id=<?php echo $data['ID_meeting'] ?>" target="_blank"><i class="fa fa-print" title="View Report"></i></a>
                  </td>
                  </tr>
                 <?php $no++; } ?>
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
