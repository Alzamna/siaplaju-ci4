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
		<link rel="stylesheet" href="<?php echo base_url('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('js/plugins/select2/select2.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('js/plugins/select2/select2-bootstrap.min.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('js/plugins/jquery-auto-complete/jquery.auto-complete.min.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('js/plugins/datatables/dataTables.bootstrap4.min.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('js/plugins/magnific-popup/magnific-popup.min.css');?>">
		
        <link rel="stylesheet" id="css-main" href="<?php echo base_url('css/codebase.min.css');?>">
		
		<?php 
		if(isset($peta)){
			echo $peta['js'];
			}
		?>
        <!-- END Stylesheets -->
    </head>
    <body>
        <!-- Page Container -->
        <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Codebase() -> uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-inverse'                           Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Classic Header style if no class is added
            'page-header-modern'                        Modern Header style
            'page-header-inverse'                       Dark themed Header (works only with classic Header style)
            'page-header-glass'                         Light themed Header with transparency by default
                                                        (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
            'page-header-glass page-header-inverse'     Dark themed Header with transparency by default
                                                        (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->
		
		<?php 
            $akses    = session()->get('id_akses');
            $admin    = ($akses == '1');
            $operator = ($akses == '2');
            $pengguna = ($akses == '3');
        ?>
		
        <div id="page-container" class="sidebar-o side-scroll main-content-boxed" >
            <!-- Sidebar -->
            <nav id="sidebar">
                <!-- Sidebar Scroll Container -->
                <div id="sidebar-scroll">
                    <!-- Sidebar Content -->
                    <div class="sidebar-content">
                        <!-- Side Header -->
                        <div class="content-header content-header-fullrow px-15">
                            <!-- Mini Mode -->
                            <div class="content-header-section sidebar-mini-visible-b">
                                <!-- Logo -->
                                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                    <span class="text-dual-primary-dark">SIAP</span><span class="text-primary">LAJU</span>
                                </span>
                                <!-- END Logo -->
                            </div>
                            <!-- END Mini Mode -->

                            <!-- Normal Mode -->
                            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                                <!-- Close Sidebar, Visible only on mobile screens -->
                                <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                                <!-- END Close Sidebar -->

                                <!-- Logo -->
                                <div class="content-header-item">
                                    <a class="link-effect font-w700" href="<?php echo site_url('dashboard');?>">
                                        <i class="si si-bulb text-primary"></i>
                                        <span class="font-size-xl text-dual-primary-dark">SIAP</span><span class="font-size-xl text-primary">LAJU</span>
                                    </a>
                                </div>
                                <!-- END Logo -->
                            </div>
                            <!-- END Normal Mode -->
                        </div>
                        <!-- END Side Header -->

                        <!-- Side User -->
                        <div class="content-side content-side-full content-side-user px-10 align-parent">
                            <!-- Visible only in mini mode -->
                            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                                <img class="img-avatar img-avatar32" src="<?php echo base_url('img/avatars/avatar15.jpg');?>" alt="">
                            </div>
                            <!-- END Visible only in mini mode -->

                            <!-- Visible only in normal mode -->
                            <div class="sidebar-mini-hidden-b text-center">
                                <a class="img-link" href="#">
                                    <img class="img-avatar" src="<?php echo base_url('img/avatars/avatar15.jpg');?>" alt="">
                                </a>
                                <ul class="list-inline mt-10">
                                    <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="#">
                                        <?php echo session()->get('status'); ?>
                                    </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                                        <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                                            <i class="si si-drop"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="link-effect text-dual-primary-dark" href="<?php echo site_url('login/logout');?>">
                                            <i class="si si-logout"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- END Visible only in normal mode -->
                        </div>
                        <!-- END Side User -->

                        <!-- Side Navigation -->
                        <div class="content-side content-side-full">
                            <ul class="nav-main">
                                <li class="<?php if(isset($open_dashboard)){echo $open_dashboard ;}?>">
                                    <a class="<?php if(isset($aktif_dashboard)){echo $aktif_dashboard;}?>" href="<?php echo site_url('dashboard');?>"><i class="si si-home"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                                </li>
								
								<li class="<?php if(isset($open_pju)){echo $open_pju ;}?>">
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-bulb"></i><span class="sidebar-mini-hide">LAMPU PJU</span></a>
                                    <ul>
										<li>
                                            <a class="<?php if(isset($pju_data)){echo $pju_data ;}?>" href="<?php echo site_url('adminpju');?>">DATA LAMPU PJU</a>
                                        </li>
                                        <li>
                                            <a class="<?php if(isset($pju_peta)){echo $pju_peta ;}?>" href="<?php echo site_url('adminpju/peta');?>">PETA LAMPU PJU</a>
                                        </li>
                                    </ul>
                                </li>
								
								<li class="<?php if(isset($open_jalan)){echo $open_jalan ;}?>">
                                    <a class="<?php if(isset($aktif_jalan)){echo $aktif_jalan;}?>" href="<?php echo site_url('adminjalan');?>"><i class="si si-cursor"></i><span class="sidebar-mini-hide">Jalan</span></a>
                                </li>
								
								<li class="<?php if(isset($open_aspirasi)){echo $open_aspirasi ;}?>">
                                    <a class="<?php if(isset($aktif_aspirasi)){echo $aktif_aspirasi;}?>" href="<?php echo site_url('adminaspirasi');?>"><i class="si si-bubble"></i><span class="sidebar-mini-hide">Aspirasi</span></a>
                                </li>
								
								<li class="<?php if(isset($open_pengaduan)){echo $open_pengaduan ;}?>">
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-call-in"></i><span class="sidebar-mini-hide">Pengaduan</span></a>
                                    <ul>
										<li>
                                            <a class="<?php if(isset($pengaduan_data)){echo $pengaduan_data ;}?>" href="<?php echo site_url('adminpengaduan');?>">PENGADUAN</a>
                                        </li>
										<li>
                                            <a class="<?php if(isset($pengaduan_peta)){echo $pengaduan_peta ;}?>" href="<?php echo site_url('adminpengaduan/peta');?>">PETA PENGADUAN</a>
                                        </li>
                                    </ul>
                                </li>
								
								<li class="<?php if(isset($open_rekap)){echo $open_rekap ;}?>">
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-doc"></i><span class="sidebar-mini-hide">Rekap</span></a>
                                    <ul>
										<li>
                                            <a class="<?php if(isset($rekap_pju)){echo $rekap_pju ;}?>" href="<?php echo site_url('adminrekap/pju');?>">REKAP PJU</a>
                                        </li>
										<li>
                                            <a class="<?php if(isset($rekap_pengaduan)){echo $rekap_pengaduan ;}?>" href="<?php echo site_url('adminrekap/pengaduan');?>">REKAP PENGADUAN</a>
                                        </li>
										<li>
                                            <a class="<?php if(isset($rekap_aspirasi)){echo $rekap_aspirasi ;}?>" href="<?php echo site_url('adminrekap/aspirasi');?>">REKAP ASPIRASI</a>
                                        </li>
                                    </ul>
                                </li>
								
								<li class="<?php if(isset($open_master)){echo $open_master ;}?>">
                                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-briefcase"></i><span class="sidebar-mini-hide">Master</span></a>
                                    <ul>
										<li>
                                            <a class="<?php if(isset($master_jalan)){echo $master_jalan ;}?>" href="<?php echo site_url('adminmaster/jalan');?>">JALAN</a>
                                        </li>
                                        <li>
                                            <a class="<?php if(isset($master_kecamatan)){echo $master_kecamatan ;}?>" href="<?php echo site_url('adminmaster/kecamatan');?>">KECAMATAN</a>
                                        </li>
										<li>
                                            <a class="<?php if(isset($master_rayon)){echo $master_rayon ;}?>" href="<?php echo site_url('adminmaster/rayon');?>">RAYON</a>
                                        </li>
										<li>
                                            <a class="<?php if(isset($master_admin)){echo $master_admin ;}?>" href="<?php echo site_url('adminmaster/admin');?>">ADMIN</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- END Side Navigation -->
                    </div>
                    <!-- Sidebar Content -->
                </div>
                <!-- END Sidebar Scroll Container -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- END Toggle Sidebar -->

                        <!-- Open Search Section -->
                        <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="header_search_on">
                            <i class="fa fa-search"></i>
                        </button>
                        <!-- END Open Search Section -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="content-header-section">
                        <!-- User Dropdown -->
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <?php echo session()->get('nama'); ?><i class="fa fa-angle-down ml-5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right min-width-150" aria-labelledby="page-header-user-dropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="si si-user mr-5"></i> Profile
                                </a>
                                <div class="dropdown-divider"></div>

                                <!-- Toggle Side Overlay -->
                                <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                                <a class="dropdown-item" href="<?php echo site_url('setting');?>" data-toggle="layout" data-action="side_overlay_toggle">
                                    <i class="si si-wrench mr-5"></i> Settings
                                </a>
                                <!-- END Side Overlay -->

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo site_url('login/logout');?>">
                                    <i class="si si-logout mr-5"></i> Logout
                                </a>
                            </div>
                        </div>
                        <!-- END User Dropdown -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Loader -->
                <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
                <div id="page-header-loader" class="overlay-header bg-primary">
                    <div class="content-header content-header-fullrow text-center">
                        <div class="content-header-item">
                            <i class="fa fa-sun-o fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->