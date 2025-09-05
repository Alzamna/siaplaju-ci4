<?php echo $this->session->flashdata('sukses');?>
<section class="nopadding">
	<div class="container">
		<header class="text-center margin-bottom-10 margin-top-10">
			<h2 class="nomargin">ASPIRASI MASYARAKAT LAMPU PENERANGAN JALAN UMUM</h2>
			<p class="font-lato size-20 nomargin">KABUPATEN TEGAL</p>
		</header>
		
		<div class="divider divider-circle divider-color divider-center"><!-- divider -->
			<i class="fa fa-bullhorn"></i>
		</div>
		
		<div class="row text-center">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
					<a href="<?php echo site_url('aspirasi/input')?>" class="btn btn-3d btn-blue">
						<i class="fa fa-bullhorn"></i>KLIK INPUT ASPIRASI
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!--
<section class="alternate nopadding-top">
	<div class="container">	
-->	
		
		<!--
		<form method="post" action="<?php echo site_url('pengaduan/cari') ?>" class="clearfix well well-sm search-big nomargin">
			<div class="input-group">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<input name="cari" class="form-control input-lg" type="text" placeholder="Masukan nomor pengaduan atau nama anda untuk mencari data pengaduan anda">
				<div class="input-group-btn">
					<button type="submit" class="btn btn-default input-lg noborder-left">
						<i class="fa fa-search fa-lg nopadding"></i>
					</button>
				</div>
			</div>
		</form>
		-->
		
		<div class="box-light margin-top-20">
			<div class="row">
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
				<div class="col-md-4">
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
		
		<br/>
		
		<div class="text-center">
			<?php echo $this->pagination->create_links();?>
		</div>
		<hr/>
<!--
	</div>
</section>
-->