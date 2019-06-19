<?php include 'inc/config.php'; ;
include 'inc/template_start.php';
include 'inc/page_head.php';
include ('Db/connect.php');
// include ('session.php');
// $connect = mysqli_connect("localhost", "dapps", "l1m4d1g1t", "dapps_joker_pertamina_lesehan2018");

?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
  <script src="js/iziToast-rails-master/vendor/assets/javascripts/iziToast.js" type="text/javascript"></script>
  <link rel="stylesheet" href="js/iziToast-rails-master/vendor/assets/stylesheets/iziToast.css">
</head>
<body>
  <?php
    if (isset($_GET['id'])) {
      $data_hak_akses = mysql_fetch_array(mysql_query("SELECT * FROM tb_hak_akses WHERE ID_akses = '$_GET[id]'"));
    }


    if (isset($_GET['remove'])) {
      $delete = mysql_query("DELETE FROM tb_hak_detail WHERE ID_akses_detail = '$_GET[remove]'");
      echo "<script>document.location.href='setting_hak_akses.php?id=$_GET[id]'</script>";
    }

    if(isset($_GET['add'])){
      $add = mysql_query("INSERT INTO `tb_hak_detail` (`ID_akses_detail`, `ID_akses`, `ID_module`) VALUES (NULL, '$_GET[id]', '$_GET[add]');");
      echo "<script>document.location.href='setting_hak_akses.php?id=$_GET[id]'</script>";
    }


    if (isset($_POST['ubah_kategori'])) {
      $sql_update = mysql_query("UPDATE tb_hak_akses SET nama_hak_akses = '$_POST[nama_hak_akses]' WHERE ID_akses = '$_GET[id]'");
      echo "<script>document.location.href='setting_hak_akses.php'</script>";
    }

    if(isset($_POST['tambah_kategori'])){
    	$sql_insert = mysql_query("INSERT INTO tb_hak_akses(ID_akses,nama_hak_akses) VALUES(NULL,'$_POST[nama_hak_akses]')");
    	if ($sql_insert) {
    		// echo "<script>alert('yes')</script>";
    		echo "<script>document.location.href='setting_hak_akses.php'</script>";
    	}
    }

    
  ?>

  <!-- Page content -->


  <div id="page-content">
    <div class="block full">
      <div class="block-title">
        <div class="row">
          <div class="col-md-3">
            <h2 style="font-size: 20px;margin: 13px;">Konfigurasi Hak Akses</h2>
          </div>

        </div>
      </div>
      <div class="row form-horizontal form-bordered" style="padding:20px;">

        <div class="col-md-4">
          <div class="block">
            <form method="post">
              <div class="block-title">
                <h2>Kategori Hak Akses</h2>
              </div>




              <div class="form-group">
                <label class="col-md-4 control-label">Kategori Hak Akses</label>
                <div class="col-md-8">
                  <input type="text" required  name="nama_hak_akses" class="form-control"  value="<?php echo $data_hak_akses[1]; ?>">
                </div>
              </div>
 
              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <?php if($_GET['id']){ ?>
                    <input type="submit" class="btn btn-primary" name="ubah_kategori" value="PERBAHARUI ">
                    <a href="setting_hak_akses.php"><button type="button" name="button" class="btn btn-danger">BATALKAN</button></a>

                  <?php  }else{ ?>
                    <input type="submit" class="btn btn-success" name="tambah_kategori" value="TAMBAH KATEGORI">
                  <?php  } ?>
                </div>
              </div>

              <div class="form-group">
                <?php
                $sql_hak_akses = mysql_query("SELECT * FROM tb_hak_akses");
                while($data_akses = mysql_fetch_array($sql_hak_akses)){
                  ?>
                  <p class="well well-sm"><strong><?php echo $data_akses[1]; ?></strong> <a href="setting_hak_akses.php?id=<?php echo $data_akses[0]; ?>" class="pull-right"><i class="fa fa-pencil"></i></a> </p>
                <?php } ?>
              </div>
            </form>

          </div>
        </div>
        <div class="col-md-8">
          <?php  if($_GET['id']){ ?>
          <div class="block">
              <div class="block-title">
                <h2>Kategori Hak Akses : [UNTUK USER APA]</h2>
              </div>
              <div class="col-md-6">
                <table class="table table-striped table-bordered table-vcenter">
                  HAK AKSES YANG DIMILIKI  <br><br>
                  <tr style="font-weight:bolder; font:+2">
                    <td>Module</td>
                    <td>Link</td>
                    <td style="width:80px;">Action</td>
                  </tr>
                  <?php
                    $module_list = mysql_query("SELECT * FROM `tb_hak_detail` JOIN tb_hak_akses ON tb_hak_detail.ID_akses = tb_hak_akses.ID_akses JOIN tb_module_list ON tb_hak_detail.ID_module = tb_module_list.ID_module WHERE tb_hak_akses.ID_akses = '$_GET[id]'");
                    while($module = mysql_fetch_array($module_list)){
                  ?>
                  <tr>
                    <td><?php echo $module['judul_module']; ?></td>
                    <td><?php echo $module['link_module']; ?></td>
                    <td><a href="setting_hak_akses.php?id=<?php echo $_GET['id'] ?>&remove=<?php echo $module['ID_akses_detail']; ?>"><button class="btn btn-danger"><i class="fa fa-arrow-right"></i></button></a></td>
                  </tr>
                <?php } ?>
                </table>
              </div>


              <div class="col-md-6">
                <table class="table table-striped table-bordered table-vcenter">
                  HAK AKSES YANG TERSEDIA <br><br>
                  <tr style="font-weight:bolder; font:+2">
                    <td style="width:80px;">Action</td>
                    <td>Module</td>
                    <td>Link</td>
                  </tr>
                  <?php
                    $module_list = mysql_query("SELECT * FROM `tb_module_list` WHERE ID_module NOT IN(SELECT ID_module FROM tb_hak_detail WHERE ID_akses = '$_GET[id]')");
                    while($module = mysql_fetch_array($module_list)){
                  ?>
                  <tr>
                    <td><a href="setting_hak_akses.php?id=<?php echo $_GET['id'] ?>&add=<?php echo $module[0]; ?>"><button class="btn btn-success"><i class="fa fa-arrow-left"></i></button></a></td>
                    <td><?php echo $module['judul_module']; ?></td>
                    <td><?php echo $module['link_module']; ?></td>
                  </tr>
                <?php } ?>
                </table>
              </div>
              <div style="clear:both"></div>
          </div>
        <?php  } ?>

        </div>

      </div>
    </div>
<?php 
if (isset($_GET['edit'])) {
      $sql_module = mysql_fetch_array(mysql_query("SELECT * FROM tb_module_list WHERE ID_module = '$_GET[edit]'"));
    }

    if(isset($_GET['delete'])){
    	$delete_module = mysql_query("DELETE FROM tb_module_list WHERE ID_module = '$_GET[delete]'");
    }
	if(isset($_POST['simpan_module'])){
    	$module_insert = mysql_query("INSERT INTO tb_module_list(ID_module,judul_module,link_module,parent,has_submenu,icon) VALUES(NULL,'$_POST[judul_module]','$_POST[link_module]','$_POST[parent]','$_POST[has_submenu]','$_POST[icon]')");
    	if ($module_insert) {
    	// echo "<script>alert('yes')</script>";
    	echo "<script>document.location.href='setting_hak_akses.php'</script>";
    	}
    }
    if(isset($_POST['update_module'])){
    	$module_update = mysql_query("UPDATE tb_module_list SET judul_module = '$_POST[judul_module]',link_module = '$_POST[link_module]',parent = '$_POST[parent]',has_submenu ='$_POST[has_submenu]', icon = '$_POST[icon]' WHERE ID_module = '$_GET[edit]'");
    	if ($module_update) {
    	// echo "<script>alert('yes')</script>";
    	echo "<script>document.location.href='setting_hak_akses.php'</script>";
    	}
    }
 ?>
    <div class="block">
      <div class="block-title">
        <h2>Daftar MODULE</h2>
      </div>

      <div class="col-md-4">
        <form class="form-horizontal form-bordered" method="post">

          <div class="form-group">
            <label class="col-md-3">Judul Module</label>
            <div class="col-md-9">
              <input type="text"  class="form-control" name="judul_module" value="<?php echo $sql_module['judul_module']; ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3">Icon</label>
            <div class="col-md-9">
              <input type="text" class="form-control" name="icon" value="<?php echo $sql_module['icon']; ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3">Link Module</label>
            <div class="col-md-9">
              <input type="text" class="form-control" name="link_module" value="<?php echo $sql_module['link_module']; ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3">Parent Module</label>
            <div class="col-md-9">
              <select id="example-chosen" name="parent" required   class="select-chosen"  style="width: 250px; display: none;">
                <option value="<?php echo $sql_module['parent']; ?>"><?php echo $sql_module['parent']; ?></option>
                <option value="0">NO PARENT</option>
                <?php
                  $parent = mysql_query("SELECT * FROM tb_module_list WHERE parent = '0' AND link_module = '#'");
                  while($datanya = mysql_fetch_array($parent)){
                ?>
                  <option value="<?php echo $datanya[0] ?>"><?php echo $datanya['judul_module'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3">Has Sub Menu</label>
            <div class="col-md-9">
              <select id="example-chosen" name="has_submenu" required   class="select-chosen"  style="width: 250px; display: none;">
              <?php if($datanya['has_submenu']=="1"){ ?>
                <option value="1">YES</option>
              <?php }else{ ?>
                <option value="0">NO</option>
              <?php } ?>
                <option value="">--------</option>
                <option value="0">NO</option>
                <option value="1">YES</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <?php if(isset($_GET['edit'])){ ?>
              <input type="submit" class="btn btn-primary col-md-6" name="update_module" value="PERBAHARUI">
              <a href="setting_hak_akses.php"><span class="btn btn-danger col-md-6" >BATAL</span></a>
            <?php }else{ ?>
              <input type="submit" class="btn btn-success col-md-12" name="simpan_module" value="SIMPAN">
            <?php } ?>
          </div>

        </form>
      </div>

      <div class="col-md-8">
        <table class="table table-striped table-bordered table-vcenter">
          <tr>
            <td>No</td>
            <td>Judul</td>
            <td>Link</td>
            <td>Parent</td>
            <td>Sub Menu</td>
            <td>Icon</td>
            <td>Action</td>
          </tr>
          <?php
          $no=1;
              $sql_module = mysql_query("SELECT * FROM tb_module_list");
              while($data = mysql_fetch_array($sql_module)){
           ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data['judul_module'] ?></td>
            <td><?php echo $data['link_module'] ?></td>
            <td><?php echo $data['parent'] ?></td>
            <td><?php echo $data['has_submenu'] ?></td>
            <td><i class="<?php echo $data['icon'] ?>"></i></td>
            <td>
              <a href="setting_hak_akses.php?edit=<?php echo $data[0] ?>"><span class="btn btn-primary"><i class="fa fa-pencil"></i></span></a>
              <a href="setting_hak_akses.php?delete=<?php echo $data[0] ?>"><span class="btn btn-danger"><i class="fa fa-trash"></i></span></a>
            </td>
          </tr>
        <?php $no++; } ?>
        </table>
      </div>

      <div style="clear:both;"></div>



    </div>

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
<!-- <script>$(function(){ ReadyDashboard.init(); });</script> -->

<?php include 'inc/template_end.php';

?>
