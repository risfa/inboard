<?php include 'inc/config.php'; $template['header_link'] = 'UI ELEMENTS'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; 
include ('Db/connect.php');  
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
 <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
</head>
<body>
<?php  
if(isset($_GET['delete'])){
    $sqldelete = mysql_query("DELETE FROM tb_keluarga WHERE ID_keluarga='$_GET[delete]'");
    
    if($sqldelete){

              echo '<script type="text/javascript">
                 iziToast.success({
                  title: "OK",
                 message: "Data has been Succesfully deleted record!",
                   });
                   </script>';
      
  }else{
      echo "<script>alert('Faile Delete')</script>";
      echo "<script>document.location.href='data_keluarga.php'</script>";
  }
}
?>
<script type="text/javascript">
    $(document).ready(function() {
    $('#result-datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'print'
        ]
    } );
} );
</script>
<div id="page-content">
 <div class="block full">
        <div class="block-title">
        <a href="keluarga.php"><button class="btn btn-success" onclick="hide_table()">ADD DATA</button></a><br>
            <h2>Data Keluarga</h2>
        </div>
        <div class="table-responsive">
            <table id="result-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10px;">No</th>
                        <th style="width: 40px;">Nama</th>
                        <th style="width: 20px;">Jenis Kelamin</th>
                        <th style="width: 20px;">Tanggal Lahir</th>
                        <th style="width: 20px;">Hubungan</th>
                        <th style="width: 20px;">No Handphone</th>
                        <th style="width: 20px;">Status</th>
                        <th style="width: 20px;">Keterangan</th>
                        
                        <th class="text-center" style="width: 10px;"><i class="fa fa-flash"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                $no = 1;
                    $sql = mysql_query("SELECT * FROM tb_keluarga");
                    while($data= mysql_fetch_array($sql)){
                 ?>
                    
                    <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['jenis_kelamin']; ?></td>
                   
                    <td><?php echo $data['tgl_lahir']; ?></td>
                    <td><?php echo $data['hubungan']; ?></td>
                    
                    <td><?php echo $data['telp']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td><?php echo $data['keterangan']; ?></td>
                    <td>
                            <a href="keluarga.php?edit=<?php echo $data['ID_keluarga'] ?>" data-toggle="tooltip" title="Edit Karyawan" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                            <a href="data_keluarga.php?delete=<?php echo $data['ID_keluarga'] ?>" data-toggle="tooltip" title="Delete Karyawan" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times"></i></a>
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
 