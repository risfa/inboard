<?php include 'inc/config.php'; ?>
<?php include 'inc/template_start.php'; ?>

<!-- Full Background -->
<!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
<img src="img/placeholders/layout/login2_full_bg.jpg" alt="Full Background" class="full-bg animation-pulseSlow">
<!-- END Full Background -->

<!-- Login Container -->
<div id="login-container">
    <!-- Login Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-pullDown">
        <i class="fa fa-cube text-light-op"></i> <strong>AppUI</strong>
    </h1>
    <!-- END Login Header -->

    <!-- Login Block -->
    <div class="block animation-fadeInQuick">
        <!-- Login Title -->
        <div class="block-title">
            <h2>Please Login</h2>
        </div>
        <!-- END Login Title -->

        <!-- Login Form -->
        <form id="form-login" action="index.php" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="login-email" class="col-xs-12">Email</label>
                <div class="col-xs-12">
                    <input type="text" id="login-email" name="login-email" class="form-control" placeholder="Your email..">
                </div>
            </div>
            <div class="form-group">
                <label for="login-password" class="col-xs-12">Password</label>
                <div class="col-xs-12">
                    <input type="password" id="login-password" name="login-password" class="form-control" placeholder="Your password..">
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-8">
                    <label class="csscheckbox csscheckbox-primary">
                        <input type="checkbox" id="login-remember-me" name="login-remember-me"><span></span> Remember Me?
                    </label>
                </div>
                <div class="col-xs-4 text-right">
                    <button type="submit" class="btn btn-effect-ripple btn-sm btn-success">Log In</button>
                </div>
            </div>
        </form>
        <!-- END Login Form -->

        <!-- Social Login -->
        <hr>
        <div class="push text-center">or Login with</div>
        <div class="row push">
            <div class="col-xs-6">
                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-sm btn-info btn-block"><i class="fa fa-facebook"></i> Facebook</a>
            </div>
            <div class="col-xs-6">
                <a href="javascript:void(0)" class="btn btn-effect-ripple btn-sm btn-primary btn-block"><i class="fa fa-twitter"></i> Twitter</a>
            </div>
        </div>
        <!-- END Social Login -->
    </div>
    <!-- END Login Block -->

    <!-- Footer -->
    <footer class="text-muted text-center animation-pullUp">
        <small><span id="year-copy"></span> &copy; <a href="http://goo.gl/RcsdAh" target="_blank"><?php echo $template['name'] . ' ' . $template['version']; ?></a></small>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Login Container -->

<?php include 'inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="js/pages/readyLogin.js"></script>
<script>$(function(){ ReadyLogin.init(); });</script>

<?php include 'inc/template_end.php'; ?>