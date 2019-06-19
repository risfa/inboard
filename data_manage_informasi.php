<?php include 'inc/config.php'; $template['header_link'] = 'UI ELEMENTS'; ?>
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
if(isset($_GET['delete'])){
    $sqldelete = mysql_query("DELETE FROM tb_manage_pages WHERE ID='$_GET[delete]'");
    
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
<div id="page-content">
 <div class="block full">
        <div class="block-title">
        <a href="index_detail.php"><button class="btn btn-success" onclick="hide_table()">Tambah Informasi</button></a><br>
            <h2>Manajement Informasi</h2>
        </div>
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10px;">No</th>
                        <th style="width: 40px;">Judul</th>
                        
                        <th class="text-center" style="width: 10px;"><i class="fa fa-flash"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                $no = 1;
                    $sql = mysql_query("SELECT * FROM tb_manage_pages");
                    while($data= mysql_fetch_array($sql)){
                 ?>
                    
                    <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data['judul']; ?></td>
                    <td>
                            <a href="index_detail.php?edit=<?php echo $data['ID'] ?>" data-toggle="tooltip" title="Edit informasi" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>

                            <a target="_blank" href="informasi_detail.php?details=<?php echo $data['ID']?>" title="detail informasi Karyawan" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search"></i>&nbsp;</a>

                            <a href="data_manage_informasi.php?delete=<?php echo $data['ID'] ?>" data-toggle="tooltip" title="Delete informasi" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times"></i></a>
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
 