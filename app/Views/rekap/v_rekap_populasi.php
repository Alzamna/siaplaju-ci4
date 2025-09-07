<main id="main-container">
	<!-- Page Content -->
	<div class="content">		
		<div class="block block-themed">
			<div class="block-header bg-gd-dusk">
				<h3 class="block-title">REKAP POPULASI PERSEBARAN PRODUK</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-map"></i>
					</button>
				</div>
			</div>
			<div class="block-content">		
			<form role="form" action="<?php echo site_url('rekap/fpopulasi');?>" method="post">
				<?= csrf_field() ?>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="pulau">Pulau</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="select-pulau" name="pulau" style="width: 100%;" data-placeholder="Pilih Pulau">
									<option></option>
									<?php foreach($dt_pulau as $row){ ?>
									<option value="<?php echo $row->id_pulau;?>"><?php echo $row->nama_pulau;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="provinsi">Provinsi</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="select-provinsi" name="provinsi" style="width: 100%;" data-placeholder="Pilih provinsi">
									<option></option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="kabupaten">Kabupaten</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="select-kabupaten" name="kabupaten" style="width: 100%;" data-placeholder="Pilih Kabupaten">
									<option></option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="instansi">Instansi</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="select-instansi" name="instansi" style="width: 100%;" data-placeholder="Pilih Instansi">
									<option></option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="jenis">Jenis</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" name="jenis" style="width: 100%;" data-placeholder="Pilih jenis produk">
									<option></option>
									<option value="ALKES">ALKES</option>
									<option value="IPAL">IPAL</option>										
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="produk">Produk</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" name="produk" style="width: 100%;" data-placeholder="Pilih produk">
									<option></option>
									<?php foreach($dt_produk as $row){ ?>
									<option value="<?php echo $row->id_produk;?>"><?php echo $row->nama_produk;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="distributor">Distributor</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" name="distributor" style="width: 100%;" data-placeholder="Pilih distributor">
									<option></option>
									<?php foreach($dt_distributor as $row){ ?>
									<option value="<?php echo $row->id_distributor;?>"><?php echo $row->distributor;?></option>
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
				<h3 class="block-title">REKAP POPULASI PRODUK</h3>
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
						<a href="<?php echo site_url('rekap/export_populasi'.$export);?>">
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
								<th class="text-center">Instansi/Pengguna</th>
								<th class="d-none d-sm-table-cell">Kota/Kabupaten</th>
								<th class="d-none d-sm-table-cell">Produk</th>
								<th class="d-none d-sm-table-cell">Tipe</th>
								<th class="d-none d-sm-table-cell">Kode Produksi</th>
								<th class="d-none d-sm-table-cell">Distributor</th>
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
								<td class="font-w600"><?php echo $row->pengguna;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->nama_kabupaten;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->nama_produk;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->tipe;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->kode_produksi;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->distributor;?></td>
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