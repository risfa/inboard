<?php include 'inc/config.php';
include 'inc/template_start.php';
include 'inc/page_head.php';
include ('Db/connect.php');
$data_info_1 = mysql_fetch_array(mysql_query("SELECT * FROM tb_mading  WHERE ID_mading = '$_GET[details]' "));
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
                <div class="col-md-12">
                    <h1 ><?php echo $data_info_1['judul'] ?></h1>
                    <font > <?php echo $data_info_1['waktu'] ?></font>
                </div>

            <br><br>

            <div class="post-story" style="color: white;">
                <div class="post-story-body clearfix">
                    <p class="txt1" style="font-size: 20px; color: white;">
                        <?php echo htmlspecialchars_decode($data_info_1['isi']) ?><br>
                    </p>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>



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