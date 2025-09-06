<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<title><?php echo $title;?></title>
		<meta name="keywords" content="siaplaju, sistem informasi penerangan jalan umum, dinas perhubungan kabupaten tegal, pju kabupaten tegal, lampu pju, pju dishub" />
		<meta name="description" content="Sistem Informasi Alat Penerangan Lampu Jalan Umum Kabupaten Tegal" />
		<meta name="Author" content="Dinas Perhubungan Kabupaten Tegal" />
		
		<link href="<?php echo base_url('home/images/favicon.png');?>" rel="icon" type="image/png">
		<link href="<?php echo base_url('home/images/favicon.ico');?>" rel="shortcut icon">
	
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

		<!-- WEB FONTS : use %7C instead of | (pipe) -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700" rel="stylesheet" type="text/css" />

		<!-- CORE CSS -->
		<link href="<?php echo base_url('home/plugins/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />

		<!-- REVOLUTION SLIDER -->
		<link href="<?php echo base_url('home/plugins/slider.revolution/css/extralayers.css')?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('home/plugins/slider.revolution/css/settings.css')?>" rel="stylesheet" type="text/css" />

		<!-- THEME CSS -->
		<link href="<?php echo base_url('home/css/essentials.css')?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('home/css/layout.css')?>" rel="stylesheet" type="text/css" />

		<!-- PAGE LEVEL SCRIPTS -->
		<link href="<?php echo base_url('home/css/header-4.css')?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('home/css/color_scheme/darkblue.css')?>" rel="stylesheet" type="text/css" id="color_scheme" />
	
		<?php if(isset($peta)){
			echo $peta['js']; } ?>
		
	</head>
	
	<body class="smoothscroll enable-animation boxed pattern11">
		<!-- wrapper -->
		<div id="wrapper">
			<!--
			<div id="topBar">
				<div class="container">
					<ul class="top-links list-inline">
						<?php $session = \Config\Services::session();
						$status_login = $session->get('login'); if($status_login){ ?>
						<li class="text-welcome hidden-xs">Selamat datang, <strong><?php echo $this->session->userdata('nama');?></strong></li>
						<li>
							<a class="dropdown-toggle no-text-underline" data-toggle="dropdown" href="#"><i class="fa fa-user hidden-xs"></i> MY ACCOUNT</a>
							<ul class="dropdown-menu pull-right">
								<li><a tabindex="-1" href="<?php echo site_url('akun');?>"><i class="fa fa-home"></i> PROFIL AKUN</a></li>
								<li><a tabindex="-1" href="<?php echo site_url('akun/setting');?>"><i class="fa fa-cog"></i> SETTING</a></li>
								<li class="divider"></li>
								<li><a tabindex="-1" href="<?php echo site_url('login/logout')?>"><i class="glyphicon glyphicon-off"></i> LOGOUT</a></li>
							</ul>
						</li>
						<?php } else { ?>
						<li><a href="<?php echo site_url('login')?>">LOGIN</a></li>
						<li><a href="<?php echo site_url('daftar')?>">DAFTAR</a></li>
						<?php } ?>
					</ul>
					
					<div class="social-icons pull-right hidden-xs">
						<a href="#" class="social-icon social-icon-sm social-icon-transparent social-facebook" data-toggle="tooltip" data-placement="bottom" title="Facebook">
							<i class="icon-facebook"></i>
							<i class="icon-facebook"></i>
						</a>
						<a href="#" class="social-icon social-icon-sm social-icon-transparent social-twitter" data-toggle="tooltip" data-placement="bottom" title="Twitter">
							<i class="icon-twitter"></i>
							<i class="icon-twitter"></i>
						</a>
						<a href="#" class="social-icon social-icon-sm social-icon-transparent social-instagram" data-toggle="tooltip" data-placement="bottom" title="Instagram">
							<i class="icon-instagram"></i>
							<i class="icon-instagram"></i>
						</a>
					</div>
				</div>
			</div>
			-->

			<div id="header" class="header-md sticky clearfix">

				<!-- TOP NAV -->
				<header id="topNav">
					<div class="container">

						<button class="btn btn-mobile" data-toggle="collapse" data-target=".nav-main-collapse">
							<i class="fa fa-bars"></i>
						</button>

						<a class="logo pull-left" href="<?php echo site_url('');?>">
							<img src="<?php echo base_url('home/images/siaplaju-logo.png')?>" alt="" />
						</a>
						<div class="navbar-collapse pull-right nav-main-collapse collapse submenu-color">
							<nav class="nav-main">
								<ul id="topMain" class="nav nav-pills nav-main">
									<li class="<?php if(isset($aktif_beranda)){echo $aktif_beranda ;}?>">
										<a href="<?php echo site_url('')?>">
											<span class="theme-color">BERANDA</span>
										</a>
									</li>
									
									<li class="<?php if(isset($aktif_peta)){echo $aktif_peta ;}?>">
										<a href="https://webgis.siaplaju.com" target="_blank" rel="noopener noreferrer">
											<span class="theme-color">PETA PERLENGKAPAN JALAN</span>
										</a>
									</li>
									
									<li class=" dropdown <?php if(isset($pengaduan)){echo $pengaduan ;}?>">
										<a class="dropdown-toggle">
											<span class="theme-color">PENGADUAN</span>
										</a>
										<ul class="dropdown-menu">
											<li class="<?php if(isset($aktif_pengaduan)){echo $aktif_pengaduan;}?>"><a href="<?php echo site_url('pengaduan')?>">PENGADUAN LAMPU PENERANGAN / PERLENGKAPAN JALAN</a></li>
											<li><a href="https://webgis.siaplaju.com/pengaduan" target="_blank" rel="noopener noreferrer">PENGADUAN PELAYANAN PERHUBUNGAN</a></li>
										</ul>
									</li>
									
									<li class="<?php if(isset($aktif_aspirasi)){echo $aktif_aspirasi ;}?>">
										<a href="<?php echo site_url('aspirasi');?>">
											<span class="theme-color">ASPIRASI</span>
										</a>
									</li>
									
									<li class="<?php if(isset($aktif_kontak)){echo $aktif_kontak ;}?>">
										<a href="<?php echo site_url('kontak');?>">
											<span class="theme-color">KONTAK</span>
										</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</header>
			</div>	