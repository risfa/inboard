<?php include 'inc/config.php';
// $template['header_link'] = 'UI ELEMENTS'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php';
include ('Db/connect.php');



// if(isset($_GET['delete_voucher'])){
//     $sqldelete = mysql_query("DELETE FROM tb_voucher WHERE ID_voucher='$_GET[delete_voucher]'");
//     $ID_mading_foto = $_GET['delete'];
//     if($sqldelete){

//         echo '<script type="text/javascript">
//     iziToast.success({
//       title: "OK",
//       message: "Data has been Succesfully deleted record!",
//     });
//     </script>';
//         echo "<script>document.location.href='data_manage_voucher.php'</script>";
//     }else{
//         echo "<script>alert('Faile Delete')</script>";
//         echo "<script>document.location.href='data_manage_voucher.php'</script>";
//     }

// }
 $tanggal =date('Y');
 // echo $tanggal;

 // if(isset($_GET['generate'])){
 //        $generet = mysql_query("SELECT * FROM tb_karyawan");
 //         while($data = mysql_fetch_array($generet)){

 //                $insert_cuti = mysql_query("INSERT INTO tb_master_cuti(ID_master_cuti, ID_karyawan,jumlah_cuti, tahun, keterangan_cuti) VALUES(NULL,'$data[ID_karyawan]','12','$tanggal','Cuti Tahunan')");

 //                echo "<script>alert('yes')</script>";
               
 //         }
 //     }
  
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
                    <h2 style="font-size: 20px;margin: 13px;">Manajemen Kuota Cuti</h2>
                </div>
                <?php
               

                // $sql_menu = mysql_query("SELECT * FROM tb_module_list WHERE parent = '0' ");
                // while($main_menu = mysql_fetch_array($sql_menu)){
                //   if($main_menu['has_submenu']=='1'){
                //     echo $main_menu[1]."<br>";
                //     $sql_submenu = mysql_query("SELECT * FROM tb_module_list WHERE parent = '$main_menu[0]'");
                //     while($submenu = mysql_fetch_array($sql_submenu)){
                //       echo " - ".$submenu[1]."<br>";
                //     }
                //   }else{
                //     echo $main_menu[1]."<br>";
                //   }
                // }
                ?>
                <div class="col-md-9">
                    <a href="manajemen_kuota_cuti.php?generate" style="float:right; margin-right:20px;"><button class="btn btn-success" style="margin:20px 0px;" onclick="hide_table()"><i class="fa fa-plus"></i>&nbsp;GENERATE KUOTA CUTI TAHUNAN</button></a><br>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">

                <thead>
                <tr>
                    <th style="width: 40px;">No </th>
                    <th style="width: 40px;">Nama </th>
                    <th style="width: 40px;">Jabatan Dan Departement</th>
                    <th style="width: 40px;">Kuota Cuti / Digunakan</th>
                    <th style="width: 40px;">Tahun Kuota Cuti</th>
                    <th style="width: 40px;">Keterangan Cuti</th>
                    <th style="width: 40px;">Status</th>

                    <th class="text-center" style="width: 10px;"><i class="fa fa-flash"></i></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $tampil_karyawan = mysql_query("SELECT * FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID"); 

                
                while($data= mysql_fetch_array($tampil_karyawan)){
                    $tampil_kuota_cuti = mysql_fetch_array(mysql_query("SELECT * FROM tb_master_cuti WHERE ID_karyawan = '$data[ID_karyawan]'"));
                    $tampil_cuti_dipake = mysql_fetch_array(mysql_query("SELECT COUNT(ID_karyawan) FROM tb_permohonan_cuti WHERE ID_karyawan = '$data[ID_karyawan]'"));
                    ?>
                    <tr>

                        <td><?php echo "<b>".$no ?></td>
                        <td><?php echo "<b>".$data['nama_lengkap']; ?></td>
                        <td><?php echo "<b>".$data['nama_jabatan']."<br>".$data['nama_department']; ?></td>
                        <td><?php echo "<b >".$tampil_kuota_cuti['jumlah_cuti']."/".$tampil_cuti_dipake[0]; ?></td>
                        <td><?php echo "<b >".$tampil_kuota_cuti['tahun']; ?></td> 
                        <td><?php echo "<b >".$tampil_kuota_cuti['keterangan_cuti']; ?></td>
                        <td><?php
                            if($tampil_kuota_cuti['jumlah_cuti'] < '12' && $tampil_kuota_cuti['jumlah_cuti'] > '0' ){
                                echo "<label class='label label-warning'>DI GUNAKAN SEBAGIAN</label>";
                            }else if($tampil_kuota_cuti['jumlah_cuti'] == '12'){
                                echo "<label class='label label-success'>BELUM DIGUNAKAN</label>";
                            }else if($tampil_kuota_cuti['jumlah_cuti'] == 0){
                                echo "<label class='label label-danger'>CUTI TELAH HABIS</label>";
                            }
                            ?></td>

                        <td>
                            <a href="form_kuota_cuti.php?edit=<?php echo $tampil_kuota_cuti['ID_master_cuti'] ?>" data-toggle="tooltip" title="Edit Kuota Cuti" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                            <a href="detail_cuti.php?details=<?php echo $data['ID_karyawan'] ?>" data-toggle="tooltip" title="Details Cuti Karyawan" class="btn btn-effect-ripple btn-xs btn-info"><i class="fa fa-search"></i></a>
                            <!-- <a onclick="return confirm('Apakah anda yakin?, Aksi ini tidak dapat di ulangi')" href="data_manage_voucher.php?delete_voucher=<?php echo $data['ID_voucher'] ?>" data-toggle="tooltip" title="Delete Voucher" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-trash"></i></a> -->
                        </td>
                    </tr>
                    <?php
                    $no++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END Page Content -->
</body>
</html>
<!-- Page content -->


<?php
// show toast_show

if (isset($_GET['toast_show'])) {
    echo '<script type="text/javascript">
  iziToast.success({
    title: "OK",
    message: "Data has been Succesfully inserted record!",
  });

  history.pushState(
    {alert123: "test"},	// data
    "test",	// title
    "data_karyawan.php"		// url path
  )
  </script>';
}elseif (isset($_GET['toast_show_update'])) {
    echo '<script type="text/javascript">
  iziToast.success({
     title: "OK",
     message: "Data has been Succesfully Updated record!",
   });

  history.pushState(
    {alert123: "test"},	// data
    "test",	// title
    "data_karyawan.php"		// url path
  )
  </script>';
}elseif (isset($_GET['toast_show_non_aktif'])) {
    echo '<script type="text/javascript">
  iziToast.success({
    title: "OK",
    message: "Karyawan ini telah di non aktifkan",
  });
  history.pushState(
    {alert123: "test"},	// data
    "test",	// title
    "data_karyawan.php"		// url path
  )
  </script>';
}elseif (isset($_GET['toast_show_aktif'])) {
    echo '<script type="text/javascript">
  iziToast.success({
    title: "OK",
    message: "Karyawan ini telah di  aktifkan",
  });
  history.pushState(
    {alert123: "test"},	// data
    "test",	// title
    "data_karyawan.php"		// url path
  )
  </script>';
}


?>

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
