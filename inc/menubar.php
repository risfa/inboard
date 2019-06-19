<?php
include('Db/connect.php') ;
error_reporting(1);


$akses_level = $_SESSION['akses_level'];

  $main_number = 0;
  $sql_menu = mysql_query("SELECT * FROM tb_module_list JOIN tb_hak_detail ON tb_hak_detail.ID_module = tb_module_list.ID_module WHERE parent = '0' AND ID_akses = '$akses_level' ORDER BY ID_akses_detail ASC");
  while($main_menu = mysql_fetch_array($sql_menu)){
    if($main_menu['has_submenu']=='1'){

        $primary_nav[$main_number]['name'] = $main_menu['judul_module'];
        $primary_nav[$main_number]['icon'] = $main_menu['icon'];

      $sql_submenu = mysql_query("SELECT * FROM tb_module_list JOIN tb_hak_detail ON tb_hak_detail.ID_module = tb_module_list.ID_module WHERE parent = '$main_menu[0]' AND ID_akses = '$akses_level' ORDER BY ID_akses_detail ASC");
      $main_number_2 = 0;
      while($submenu = mysql_fetch_array($sql_submenu)){

          $primary_nav[$main_number]['sub'][$main_number_2]['name'] = $submenu['judul_module'];
          $primary_nav[$main_number]['sub'][$main_number_2]['url'] = $submenu['link_module'];
        $main_number_2++;
      }
    }else{
      $primary_nav[$main_number]['name'] = $main_menu['judul_module'];
      $primary_nav[$main_number]['icon'] = $main_menu['icon'];
      $primary_nav[$main_number]['url'] = $main_menu['link_module'];
    }
    $main_number++;
  }

?>
