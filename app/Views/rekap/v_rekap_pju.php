<main id="main-container">
	<!-- Page Content -->
	<div class="content">		
		<div class="block block-themed">
			<div class="block-header bg-gd-dusk">
				<h3 class="block-title">REKAP PJU KABUPATEN TEGAL</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-map"></i>
					</button>
				</div>
			</div>
			<div class="block-content">		
			<form role="form" action="<?php echo site_url('adminrekap/fpju');?>" method="post">
				<?= csrf_field() ?>
				<div class="row">
					<div class="col-sm-4">
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
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="jalan">Jalan</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="select-jalan" name="jalan" style="width: 100%;" data-placeholder="Pilih nama jalan">
									<option></option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-4 col-form-label" for="jenis">Jenis Lampu</label>
							<div class="col-lg-8">
								<select class="js-select2 form-control" id="jenis" name="jenis" style="width: 100%;" data-placeholder="Pilih jenis lampu">
									<option></option>
									<option value="%%">Semua Lampu</option>
									<?php foreach($dt_jenis as $row){ ?>
									<option value="<?php echo $row->jenis;?>"><?php echo $row->jenis;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="kondisi">Kondisi Lampu</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="kondisi" name="kondisi" style="width: 100%;" data-placeholder="Pilih kondisi lampu">
									<option></option>
									<option value="%%">Semua Kondisi</option>
									<?php foreach($dt_kondisi as $row){ ?>
									<option value="<?php echo $row->kondisi;?>"><?php echo $row->kondisi;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					
					<div class="col-sm-4 text-center">
						<button type="submit" class="btn btn-hero btn-primary mb-20">
							<i class="fa fa-check mr-10"></i>CARI REKAP
						</button>
					</div>
				</div>
			</form>
			</div>
		</div>
		
		<?php if(!empty($dt_rekap)){ ?>
		<div class="block block-themed">
		   <div class="block-header bg-gd-sea">
				<h3 class="block-title">REKAP PJU KABUPATEN TEGAL</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-diamond"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				
				<!--
				<p class="text-info">REKAP POPULASI PRODUK BERDASAR : PULAU <mark class="text-danger"><?php echo $vpul;?></mark>, PROVINSI <mark class="text-danger"><?php echo $vpro;?></mark>, KABUPATEN <mark class="text-danger"><?php echo $vkab;?></mark>, JENIS PRODUK <mark class="text-danger"><?php echo $vjns;?></mark>, PRODUK <mark class="text-danger"><?php echo $vpdk;?></mark>, DISTRIBUTOR <mark class="text-danger"><?php echo $vdst;?></mark>.
				-->
				
				<div class="row mb-10">
					<div class="col-lg-8">
					</div>
					<div class="col-lg-4 text-right">
						<a href="<?php echo site_url('adminrekap/export_pju'.$export);?>">
							<button type="button" class="btn btn-success">
								<i class="fa fa-file-excel-o mr-10"></i>EXPORT REKAP
							</button>
						</a>
					</div>
				</div>
				
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">ID PJU</th>
								<th class="d-none d-sm-table-cell">Nama Jalan</th>
								<th class="d-none d-sm-table-cell">Kecamatan</th>
								<th class="d-none d-sm-table-cell">Jenis Lampu</th>
								<th class="d-none d-sm-table-cell">Daya</th>
								<th class="d-none d-sm-table-cell">Kondisi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							if(isset($dt_rekap)){
								foreach($dt_rekap as $row){
							?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td class="font-w600"><?php echo $row->id_pju;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->nama_jalan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->nama_kecamatan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->jenis;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->daya;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->kondisi;?></td>
							</tr>
							<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</main>