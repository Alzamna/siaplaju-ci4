<main id="main-container">
	<!-- Page Content -->
	<div class="content">		
		<?php 
			foreach($dt_setting as $row){
		?>
		
		<div class="block block-themed" id="block-asap">
			<div class="block-header bg-primary">
				<h3 class="block-title">SETTING SIM PKB DINAS PERHUBUNGAN KABUPATEN BREBES</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
				</div>
			</div>
			<div class="block-content">
				<form action="<?php echo site_url('setting/edit/'.$row->id_setting);?>" method="post">
					<?= csrf_field() ?>
					<div class="row">
                        <div class="col-sm-6">
							<div class="form-group row">
								<label class="col-lg-3 col-form-label" for="nama_kasi">Kepala Seksi</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="nama_kasi" name="nama_kasi" value="<?php echo $row->kasi;?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-3 col-form-label" for="nip_kasi">NIP</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="nip_kasi" name="nip_kasi" value="<?php echo $row->nip_kasi;?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-3 col-form-label" for="gol_kasi">Pangkat</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="gol_kasi" name="gol_kasi" value="<?php echo $row->gol_kasi;?>">
								</div>
							</div>
						</div>
						<div class="col-sm-6">	
							<div class="form-group row">
								<label class="col-lg-3 col-form-label" for="nama_kadis">Kepala Dinas</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="nama_kadis" name="nama_kadis" value="<?php echo $row->kadis;?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-3 col-form-label" for="nip_kadis">NIP</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="nip_kadis" name="nip_kadis" value="<?php echo $row->nip_kadis;?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-3 col-form-label" for="gol_kadis">Pangkat</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="gol_kadis" name="gol_kadis" value="<?php echo $row->gol_kadis;?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row justify-content-center text-center">
						<div class="col-md-4">
							<button type="submit" class="btn btn-hero btn-primary mb-20 mt-20">
								<i class="fa fa-check mr-10"></i>SIMPAN
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
</main>