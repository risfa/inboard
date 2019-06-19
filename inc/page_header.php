<!-- Header -->
<!-- In the PHP version you can set the following options from inc/config file -->
<!--
    Available header.navbar classes:

    'navbar-default'            for the default light header
    'navbar-inverse'            for an alternative dark header

    'navbar-fixed-top'          for a top fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
        'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

    'navbar-fixed-bottom'       for a bottom fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
        'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
-->



<header style="background-image: linear-gradient(to right, #ef3e33, #f5428d, #ca6fd5, #7996f6, #00aeef);" class="navbar<?php if ($template['header_navbar']) { echo ' ' . $template['header_navbar']; } ?><?php if ($template['header']) { echo ' '. $template['header']; } ?>">
    <!-- Left Header Navigation -->

    <ul class="nav navbar-nav-custom">


        <!-- Main Sidebar Toggle Button -->
        <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
            </a>
        </li>
        <!-- END Main Sidebar Toggle Button -->

        <?php if ($template['header_link']) { ?>
        <!-- Header Link -->
        <li class="hidden-xs animation-fadeInQuick">
            <a href=""><strong><?php echo $template['header_link']; ?></strong></a>
        </li>
        <!-- END Header Link -->
        <?php } ?>
    </ul>
    <!-- END Left Header Navigation -->

    <!-- Right Header Navigation -->

    <ul class="nav navbar-nav-custom pull-right">


        <!-- Search Form -->
        <!-- <li>
            <form action="page_ready_search_results.php" method="post" class="navbar-form-custom">
                <input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search..">
            </form>
        </li> -->
        <!-- END Search Form -->

        <!-- Alternative Sidebar Toggle Button -->
        <!-- <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');this.blur();">
                <i class="gi gi-settings"></i>
            </a>
        </li> -->
        <!-- END Alternative Sidebar Toggle Button -->


        <!-- User Dropdown -->

        <style>
            .hovering_notification:hover, .open{
                background: #0e91cd;
            }
        </style>

        <!-- <li class="dropdown hover_notification" style="width: 70px; height: 54px; ">
          <button id = "button_notifikasi" class="dropdown-toggle" data-toggle="dropdown" style="background: none;  padding: 15px 9px; border: none;color: white;">
                <i class="fa fa-bell"> <label style="padding: 4px; background-color: red; border-radius: 20px; " id="total_notifikasi"></label></i>
          </button> -->
            <!-- <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> -->
                <!-- <img src="img/placeholders/avatars/avatar9.jpg" alt="avatar"> -->
                <!-- <i class="fa fa-bell"></i> -->
            <!-- </a> -->

            <ul class="dropdown-menu dropdown-menu-right" style="width: auto; ">
                <li style="background:#15abf0;">
                  <a id="notifikasi_header"  style=" color:white;">Notifikasi header
                  </a>
                </li>
</textarea>

                <li >
                    <?php
                        $tampil = mysql_query("SELECT * FROM tb_notifikasi_log WHERE id_karyawan = '$_SESSION[ID_karyawan]' AND flag_read = 0 LIMIT 5");
                        while($tampilkan = mysql_fetch_array($tampil)){
                     ?>
                  <a  onclick="MyFunction(<?php echo $tampilkan['id_notifikasi']; ?>)" href="javascript:void(0)" class="hovering_notification" style="padding-left: 4vh; padding-right: 6vh;">
                    <div class="row">
                    <div class="col-2" id="notifikasi_isi"><i class="fa fa-check"></i>&nbsp;<td><?php echo $tampilkan['msg'] ?></td></div>
                    <div style="color: grey; font-size: 9px;" class="col-4" id="notifikasi_tanggal"><?php echo $tampilkan['waktu'] ?></div>
                    </div>
                    <div style="clear:both"></div>
                  </a>
                 <?php   }?>
                </li>

                <li style="background:#f215158c;">

                  <a href="notif_full.php" id="notifikasi_header"  style=" color:white;">Tampikan lebih banyak
                  </a>
                </li>




            </ul>

        </li>

        <li class="dropdown">

            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="img/placeholders/avatars/avatar9.jpg" alt="avatar">
            </a>

            <ul class="dropdown-menu dropdown-menu-right">

                <li style="background:#15abf0;">
                  <a href="#" style=" color:white;">
                    Halo, <b><?php echo $_SESSION['nama_lengkap']; ?></b>
                  </a>
                </li>
                <li>
                    <a href="profile.php">
                        <i class="fa fa-user fa-fw pull-right"></i>
                        Pengaturan Akun
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fa fa-power-off fa-fw pull-right"></i>
                        Keluar
                    </a>
                </li>
            </ul>
        </li>
        <!-- END User Dropdown -->
    </ul>
    <!-- END Right Header Navigation -->
</header>
<!-- END Header -->

<style media="screen">
  .hovering_notification:hover{
    background: #c9cbce !important;
  }



</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">
$.post("api/notifikasi.php",{param : 'total_notifikasi',ID_notifikasi : <?php echo $_SESSION['ID_karyawan'] ?>} ,function(data, status){
    var data = JSON.parse(data)
    if (data.status) {
      $('#total_notifikasi').html(data.data);
    }else{
      $('#total_notifikasi').html('error inet');
    }

});

  function MyFunction(id_notifikasi) {
    $.post("notifikasi/flag_read.php",{id_notifikasi : id_notifikasi} ,function(data, status){
      location.href = 'notif_full.php';
    });
  }

</script>
