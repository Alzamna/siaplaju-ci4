<main id="main-container">
	<!-- Page Content -->
	<div class="content">		
		<div class="row">
			<div class="col-lg-12">
				<div class="block block-themed">
				   <div class="block-header bg-gd-emerald">
						<h3 class="block-title">PETA PERBAIKAN PJU KABUPATEN TEGAL</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option">
								<i class="si si-map"></i>
							</button>
						</div>
					</div>
					<div class="block-content">
						<?php echo $peta['html'];?>
						<br/>
					</div>
				</div>
			</div>
			
			<!--
			<div class="col-lg-4">
				<div class="block block-themed">
				   <div class="block-header bg-gd-dusk">
						<h3 class="block-title">Filter Pencarian</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option">
								<i class="si si-map"></i>
							</button>
						</div>
					</div>
					<div class="block-content">		
					<form role="form" action="<?php echo site_url('adminpengaduan/fpeta');?>" method="post">
						<?= csrf_field() ?>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="kecamatan">Kecamatan</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="select-kecamatan" name="kecamatan" style="width: 100%;" data-placeholder="Pilih kecamatan">
									<option></option>
									<?php foreach($dt_kecamatan as $row){ ?>
									<option value="<?php echo $row->id_kecamatan;?>"><?php echo $row->nama_kecamatan;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="jalan">Jalan</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="select-jalan" name="jalan" style="width: 100%;" data-placeholder="Pilih nama jalan">
									<option></option>
								</select>
							</div>
						</div>
						
						<div class="row justify-content-center text-center">
							<div class="col-md-6">
								<button type="submit" class="btn btn-hero btn-primary mb-20 mt-20">
									<i class="fa fa-check mr-10"></i>KIRIM
								</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
			-->
		</div>
	</div>
</main>