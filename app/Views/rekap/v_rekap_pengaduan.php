<main id="main-container">
	<!-- Page Content -->
	<div class="content">		
		<div class="block block-themed">
			<div class="block-header bg-gd-dusk">
				<h3 class="block-title">REKAP PENGADUAN PJU KABUPATEN TEGAL</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-map"></i>
					</button>
				</div>
			</div>
			<div class="block-content">		
			<form role="form" action="<?php echo site_url('adminrekap/fpengaduan');?>" method="post">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
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
							<label class="col-lg-3 col-form-label" for="media">Media</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="media" name="media" style="width: 100%;" data-placeholder="Pilih media pengaduan">
									<option></option>
									<option value="%%">Semua Media</option>
									<option value="Langsung">Langsung</option>
									<option value="SMS">SMS</option>
									<option value="Telepon">Telepon</option>
									<option value="Website">Website</option>
									<option value="Twitter">Twitter</option>
									<option value="Facebook">Facebook</option>
									<option value="Instagram">Instagram</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label" for="status">Status</label>
							<div class="col-lg-9">
								<select class="js-select2 form-control" id="status" name="status" style="width: 100%;" data-placeholder="Pilih status pengaduan">
									<option></option>
									<option value="%%">Semua Status</option>
									<option value="1">Diterima</option>
									<option value="2">Diverifikasi</option>
									<option value="3">Dalam Proses</option>
									<option value="4">Selesai</option>
									<option value="0">Ditolak</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="col-lg-2 col-form-label" for="tanggal">Tanggal</label>
							<div class="col-lg-10">
								<div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1" data-autoclose="true" data-today-highlight="true">
									<input type="text" class="form-control" id="tgl_awal" name="tgl_awal" placeholder="Tanggal Awal" data-week-start="1" data-autoclose="true" data-today-highlight="true">
									<span class="input-group-addon font-w600">to</span>
									<input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir" placeholder="Tanggal Akhir" data-week-start="1" data-autoclose="true" data-today-highlight="true">
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-sm-2 text-center">
						<button type="submit" class="btn btn-hero btn-primary mb-20">
							<i class="fa fa-check mr-10"></i>CARI
						</button>
					</div>
				</div>
			</form>
			</div>
		</div>
		
		<?php if(!empty($dt_rekap)){ ?>
		<div class="block block-themed">
		   <div class="block-header bg-gd-sea">
				<h3 class="block-title">REKAP PENGADUAN PJU KABUPATEN TEGAL</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-diamond"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row mb-10">
					<div class="col-lg-8">
					</div>
					<div class="col-lg-4 text-right">
						<a href="<?php echo site_url('adminrekap/export_pengaduan'.$export);?>">
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
								<th class="text-center">ID Pengaduan</th>
								<th class="d-none d-sm-table-cell">Tgl Pengaduan</th>
								<th class="d-none d-sm-table-cell">Media</th>
								<th class="d-none d-sm-table-cell">Pelapor</th>
								<th class="d-none d-sm-table-cell">Laporan</th>
								<th class="d-none d-sm-table-cell">Ruas Jalan</th>
								<th class="d-none d-sm-table-cell">Status</th>
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
								<td class="font-w600"><?php echo $row->id_pengaduan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo date("d M Y",strtotime($row->tgl_pengaduan));?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->media;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->pelapor;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->laporan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->nama_jalan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->status;?></td>
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