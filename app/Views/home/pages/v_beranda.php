<div class="slider fullwidthbanner-container roundedcorners">
	<div class="fullwidthbanner" data-height="300" data-shadow="0" data-navigationStyle="preview2">
		<ul class="hide">

			<!-- SLIDE  -->
			<li data-transition="random" data-slotamount="1" data-masterspeed="1000" data-delay="5000" data-saveperformance="off" data-title="Slide 1">
				<img src="<?php echo base_url('public/home/images/1x1.png')?>" data-lazyload="<?php echo base_url('public/home/images/slider/slider1.jpg')?>" alt="" data-bgfit="cover" data-bgrepeat="no-repeat" />
			</li>
			
			<li data-transition="random" data-slotamount="1" data-masterspeed="1000" data-delay="5000" data-saveperformance="off" data-title="Slide 2">
				<img src="<?php echo base_url('public/home/images/1x1.png')?>" data-lazyload="<?php echo base_url('public/home/images/slider/slider2.jpg')?>" alt="" data-bgfit="cover" data-bgrepeat="no-repeat" />
			</li>
			
			<li data-transition="random" data-slotamount="1" data-masterspeed="1000" data-delay="5000" data-saveperformance="off" data-title="Slide 2">
				<img src="<?php echo base_url('public/home/images/1x1.png')?>" data-lazyload="<?php echo base_url('public/home/images/slider/slider3.jpg')?>" alt="" data-bgfit="cover" data-bgrepeat="no-repeat" />
			</li>
		</ul>

		<div class="tp-bannertimer"><!-- progress bar --></div>
	</div>
</div>

<section class="nopadding">
	<img class="img-responsive" src="<?php echo base_url('public/home/images/jargon.png');?>" alt="">
</section>

<section class="nopadding">
	<div class="row margin-left-60 margin-right-60 margin-top-20 margin-bottom-20">
		<div class="col-md-12">
			<div class="row text-center">
				<div class="col-lg-4 col-md-6 col-sm-12">
					<a href="http://webgis.siaplaju.com">
						<img class="img-responsive" style="height:150px;width:auto" src="<?php echo base_url('public/home/images/icon/map-icon.jpg');?>" alt="" />
						<div class="caption text-center margin-top-10">
							<h4 class="nomargin">PETA PERLENGKAPAN JALAN</h4>
							<small class="block">PETA DATABASE PERLENGKAPAN JALAN KABUPATEN TEGAL</small>
						</div>
					</a>
				</div>
				
				<div class="col-lg-4 col-md-6 col-sm-12">
					<a href="<?php echo site_url('pengaduan');?>">
						<img class="img-responsive" style="height:150px;width:auto" src="<?php echo base_url('public/home/images/icon/pengaduan-icon.jpg');?>" alt="" />
						<div class="caption text-center margin-top-10">
							<h4 class="nomargin">PENGADUAN</h4>
							<small class="block">PENGADUAN LAMPU PJU BERMASALAH/MATI</small>
						</div>
					</a>
				</div>
				
				<div class="col-lg-4 col-md-6 col-sm-12">
					<a href="<?php echo site_url('aspirasi');?>">
						<img class="img-responsive" style="height:150px;width:auto" src="<?php echo base_url('public/home/images/icon/aspirasi-icon.jpg');?>" alt="" />
						<div class="caption text-center margin-top-10">
							<h4 class="nomargin">ASPIRASI</h4>
							<small class="block">ASPIRASI MASYARAKAT LAMPU PJU</small>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- RECENT NEWS -->
<section class="nopadding">
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<header class="text-center margin-bottom-10 margin-top-10">
						<h1 class="panel-title weight-200 size-20">PENGADUAN</h1>
						<h2 class="panel-title weight-200 letter-spacing-1 size-13">PENGADUAN LAMPU PJU TERBARU</h2>
					</header>
				</div>
				
				<div class="panel-body">
					<div class="owl-carousel owl-padding-5 buttons-autohide controlls-over" data-plugin-options='{"singleItem": false, "items":"2", "autoPlay": true, "navigation": true, "pagination": false}'>
						<?php
						if(isset($dt_pengaduan)){
							foreach($dt_pengaduan as $row){
							if($row->status=='2'){
								$panel = 'panel-info';
							} else if($row->status=='3'){
								$panel = 'panel-warning';
							} else if($row->status=='4'){
								$panel = 'panel-success';
							}
						?>	
						<div class="col-md-12">
							<div class="panel <?php echo $panel;?>">
								<div class="panel-heading">
									<ul class="text-left size-12 list-inline nomargin">
										<li>
											<i class="fa fa-user"></i> 
											<?php echo $row->pelapor;?>
										</li>
										<li class="pull-right" date>
											<i class="fa fa-calendar"></i> 
											<?php echo date("d-m-Y H:i:s",strtotime($row->tgl_pengaduan));?>
										</li>
									</ul>
								</div>
								
								<div class="panel-body">
									<a href="<?php echo site_url('pengaduan/lihat/'.$row->id_pengaduan);?>" target="_blank" data-rel="tooltip" title="Klik untuk membaca pengaduan">
									<?php if($row->foto==""){ ?>
										Tidak ada foto
									<?php } else { ?>
										<img class="img-responsive" src="<?php echo base_url('upload/pengaduan/thumbnail/'.$row->foto);?>" alt="image" />
									<?php }?>
										<hr/>
										
										<p class="lead text-center text-default">
											Baca 
											<span class="word-rotator text-info" data-delay="3000">
												<span class="items">
													<span>Pengaduan</span>
												</span>
											</span>
										</p>
									</a>
									
									<div class="alert alert-mini alert-info margin-bottom-10">
										<p class="text-left"><?php $isi = word_limiter($row->laporan, 30);
											echo $isi; ?></p>
									</div>
									
									<ul class="text-left size-12 list-inline nomargin">
										<li>
											<i class="fa fa-file"></i> 
											<?php echo $row->id_pengaduan;?>
										</li>
										<li class="pull-right" date>
											<i class="fa fa-hourglass-2"></i> 
											<?php $status = $row->status;
												if($status==2){
													echo "Pengaduan Diverifikasi";
												}
												else if($status==3){
													echo "Pengaduan Dalam Proses";
												}
												else if($status==4){
													echo "Pengaduan Selesai";
												} ?>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<?php }} ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					<header class="text-center margin-bottom-10 margin-top-10">
						<h1 class="panel-title weight-200 size-20">ASPIRASI</h1>
						<h2 class="panel-title weight-200 letter-spacing-1 size-13">ASPIRASI LAMPU PJU TERBARU</h2>
					</header>
				</div>
				
				<div class="panel-body">
					<div class="owl-carousel owl-padding-5 buttons-autohide controlls-over" data-plugin-options='{"singleItem": false, "items":"2", "autoPlay": true, "navigation": true, "pagination": false}'>
						<?php
						if(isset($dt_aspirasi)){
							foreach($dt_aspirasi as $row){
							if($row->status=='2'){
								$panel = 'panel-info';
							} else if($row->status=='3'){
								$panel = 'panel-warning';
							} else if($row->status=='4'){
								$panel = 'panel-success';
							}
						?>	
						<div class="col-md-12">
							<div class="panel <?php echo $panel;?>">
								<div class="panel-heading">
									<ul class="text-left size-12 list-inline nomargin">
										<li>
											<i class="fa fa-user"></i> 
											<?php echo $row->nama;?>
										</li>
										<li class="pull-right" date>
											<i class="fa fa-calendar"></i> 
											<?php echo date("d-m-Y H:i:s",strtotime($row->tgl_aspirasi));?>
										</li>
									</ul>
								</div>
								
								<div class="panel-body">
									<a href="<?php echo site_url('aspirasi/lihat/'.$row->id_aspirasi);?>" target="_blank" data-rel="tooltip" title="Klik untuk membaca aspirasi">
									<?php if($row->foto==""){ ?>
										Tidak ada foto
									<?php } else { ?>
										<img class="img-responsive" src="<?php echo base_url('upload/foto/aspirasi/'.$row->id_aspirasi);?>" alt="image" />
									<?php }?>
										<hr/>
										
										<p class="lead text-center text-default">
											Baca 
											<span class="word-rotator text-info" data-delay="3000">
												<span class="items">
													<span>Aspirasi</span>
												</span>
											</span>
										</p>
									</a>
									
									<div class="alert alert-mini alert-info margin-bottom-10">
										<p class="text-left"><?php $isi = word_limiter($row->aspirasi, 30);
											echo $isi; ?></p>
									</div>
									
									<ul class="text-left size-12 list-inline nomargin">
										<li>
											<i class="fa fa-file"></i> 
											<?php echo $row->id_aspirasi;?>
										</li>
										<li class="pull-right" date>
											<i class="fa fa-hourglass-2"></i> 
											<?php $status = $row->status;
												if($status==2){
													echo "Aspirasi Diverifikasi";
												}
												else if($status==3){
													echo "Aspirasi Dalam Pengajuan";
												}
												else if($status==4){
													echo "Aspirasi Selesai";
												} ?>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<?php }} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /RECENT NEWS -->