<section class="page-header page-header-xs">
	<div class="container">
		<h1>PETA LAMPU PENERANGAN JALAN UMUM KABUPATEN TEGAL</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('');?>">Beranda</a></li>
			<li class="active"><a href="<?php echo site_url('peta')?>">Peta</a></li>
		</ol>
	</div>
</section>

<?php 
if(isset($dt_pju)){
	foreach($dt_pju as $row){ 
	$kec = $row->id_kecamatan;
}}
?>

<section class="nopadding margin-bottom-10">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-body">
					<form role="form" action="<?php echo site_url('peta/fpeta');?>" method="post" class="nomargin">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="row">
							<div class="col-md-2">
								<div class="heading-title">
									<h3>
										FILTER
										<span class="word-rotator" data-delay="2000">
											<span class="items">
												<span>PETA</span>
											</span>
										</span>
									</h3>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="fancy-form fancy-form-select">
									<select class="form-control select2" id="select-kecamatan" name="kecamatan" style="width: 100%;" data-placeholder="Pilih kecamatan">
										<option value=""></option>
										<?php foreach($dt_kecamatan as $row){ 
											if($kec==$row->id_kecamatan){ ?>
											<option value="<?php echo $row->id_kecamatan;?>" selected><?php echo $row->nama_kecamatan;?></option>
										<?php } else { ?>
											<option value="<?php echo $row->id_kecamatan;?>"><?php echo $row->nama_kecamatan;?></option>
										<?php }} ?>
									</select>
									<i class="fancy-arrow-"></i>
								</div>
							</div>
							<div class="col-md-4">
								<div class="fancy-form fancy-form-select">
									<select class="form-control select2" style="width: 100%;" id="select-jalan" name="jalan" data-placeholder="Pilih nama jalan">
									<?php 
									if($dt_jln=="%%"){ ?>
										<option value="%%">Semua Jalan</option>
									<?php } else if(isset($dt_pju)){
										foreach($dt_pju as $row){ ?>
										<option value="<?php echo $row->id_jalan;?>"><?php echo $row->nama_jalan;?></option>
									<?php }} ?>
									</select>
									<i class="fancy-arrow-"></i>
								</div>
							</div>
							
							<div class="col-md-2">
								<button type="submit" class="btn btn-info"><i class="et-search"></i>Cari</a>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12">
							<?php echo $peta['html'];?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>