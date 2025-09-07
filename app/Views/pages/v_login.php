<!doctype html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

        <title><?php echo $title;?></title>

        <meta name="description" content="Sistem Informasi Alamt Penerangan Lampu Jalan Umum Dinas Perhubungan Kabupaten Tegal">
        <meta name="author" content="duamedia">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="Sistem Informasi Alat Penerangan Lampu Jalan Umum Dinas Perhubungan Kabupaten Tegal">
        <meta property="og:site_name" content="Siaplaju">
        <meta property="og:description" content="Sistem Informasi Alat Penerangan Lampu Jalan Umum Dinas Perhubungan Kabupaten Tegal">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Icons -->
        <link rel="shortcut icon" href="<?php echo base_url('img/favicons/favicon.png');?>">
        <link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url('img/favicons/favicon-192x192.png');?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('img/favicons/apple-touch-icon-180x180.png');?>">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <link rel="stylesheet" id="css-main" href="<?php echo base_url('css/codebase.min.css');?>">
		
        <!-- END Stylesheets -->
    </head>
    <body>
        <div id="page-container" class="main-content-boxed">
            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="bg-body-dark bg-pattern" style="background-image: url('<?php echo base_url('img/various/bg-pattern-inverse.png')?>');">
                    <div class="row mx-0 justify-content-center">
                         <div class="hero-static col-lg-5 col-xl-5">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <div class="py-30 text-center">
                                    <a class="link-effect font-w700" href="<?php echo site_url('beranda');?>">
                                        <i class="si si-globe-alt"></i>
                                        <span class="font-size-xl text-primary-dark">SIAP</span><span class="font-size-xl">LAJU</span>
                                    </a>
                                    <h1 class="h4 font-w700 mt-10 mb-10">SISTEM INFORMASI ALAT PENERANGAN LAMPU JALAN UMUM</h1>
                                    <h2 class="h5 font-w400 text-muted mb-0">DINAS PERHUBUNGAN KABUPATEN TEGAL</h2>
                                </div>
                                <!-- END Header -->

                                <!-- Sign In Form -->
                                <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.js) -->
                                <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <form class="js-validation-signin" action="<?php echo site_url('login')?>" method="post">
                                <?= csrf_field() ?>
                                <div class="block block-themed block-rounded block-shadow">
                                        <div class="block-header bg-gd-sea">
                                            <h3 class="block-title">Login Administrator</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option">
                                                    <i class="si si-wrench"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content">
											<?php
												if (isset($error)){
													echo '<div class="alert alert-danger">' . $error . '</div>';
												}
											?>
													
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-username">Username</label>
                                                    <input type="text" class="form-control" id="login-username" name="login-username">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-password">Password</label>
                                                    <input type="password" class="form-control" id="login-password" name="login-password">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <div class="col-sm-6 d-sm-flex align-items-center push">
												
                                                </div>
                                                <div class="col-sm-6 text-sm-right push">
                                                    <button type="submit" class="btn btn-alt-primary">
                                                        <i class="si si-login mr-10"></i> Login
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Sign In Form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <!-- Codebase Core JS -->
        <script src="<?php echo base_url('js/core/jquery.min.js')?>"></script>
        <script src="<?php echo base_url('js/core/popper.min.js')?>"></script>
        <script src="<?php echo base_url('js/core/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('js/core/jquery.slimscroll.min.js')?>"></script>
        <script src="<?php echo base_url('js/core/jquery.scrollLock.min.js')?>"></script>
        <script src="<?php echo base_url('js/core/jquery.appear.min.js')?>"></script>
        <script src="<?php echo base_url('js/core/jquery.countTo.min.js')?>"></script>
        <script src="<?php echo base_url('js/core/js.cookie.min.js')?>"></script>
        <script src="<?php echo base_url('js/codebase.js')?>"></script>

        <!-- Page JS Plugins -->
        <script src="<?php echo base_url('js/plugins/jquery-validation/jquery.validate.min.js')?>"></script>

        <!-- Page JS Code -->
        <script src="<?php echo base_url('js/pages/op_auth_signin.js')?>"></script>
    </body>
</html>