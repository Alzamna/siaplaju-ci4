<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		
		<div class="block block-themed">
			 <div class="block-header bg-gd-sea">
				<h3 class="block-title">TAMBAH PERBAIKAN LAMPU PJU</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-user"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<form action="<?php echo site_url('adminpengaduan/proses_tambah');?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="row">
                        <div class="col-sm-6">														
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="tgl_pengaduan">Tanggal Pengaduan</label>
								<div class="col-lg-8">
									<div class="input-group">
										<input type="text" class="js-datepicker form-control" id="tgl_pengaduan" name="tgl_pengaduan" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy-mm-dd" value="<?php echo date("Y-m-d H:i:s");?>">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="kecamatan">Kecamatan</label>
								<div class="col-lg-8">
									<select class="js-select2 form-control" id="select-kecamatan" name="kecamatan" style="width: 100%;" data-placeholder="Pilih kecamatan">
										<option></option>
										<?php foreach($dt_kecamatan as $row){ ?>
										<option value="<?php echo $row->id_kecamatan;?>"><?php echo $row->nama_kecamatan;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="jalan">Jalan</label>
								<div class="col-lg-8">
									<select class="js-select2 form-control" id="select-jalan" name="jalan" style="width: 100%;" data-placeholder="Pilih nama jalan">
										<option></option>
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="media">Media Pengaduan</label>
								<div class="col-lg-8">
									<select class="js-select2 form-control" name="media" style="width: 100%;" data-placeholder="Pilih media pengaduan">
										<option></option>
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
						
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="nama">Pelapor</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $this->session->userdata('nama');?>">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="telp">Nomor Telepon</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="telp" name="telp">
								</div>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="laporan">Laporan</label>
								<div class="col-lg-8">
									<textarea class="form-control" id="laporan" name="laporan" rows="5" placeholder="Laporan"></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="tindakan">Tindakan</label>
								<div class="col-lg-8">
									<textarea class="form-control" id="tindakan" name="tindakan" rows="3" placeholder="tindakan"></textarea>
								</div>
							</div>
							
							<div id="wrap_foto">
								<div class="form-group row">
									<label class="col-lg-4 col-form-label" for="foto">Lampiran Foto</label>
									<div class="col-lg-7">
										<input type="file" id="foto" name="foto">
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		
					
		<div class="row">
			<div class="col-lg-8">
				<?php echo $peta['html'];?>
			</div>
			
			<div class="col-lg-4">
				<div class="block block-themed">
				   <div class="block-header bg-gd-sea">
						<h3 class="block-title">Cari Lokasi</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option">
								<i class="si si-map"></i>
							</button>
						</div>
					</div>
					<div class="block-content">
						<div class="form-group row">
							<div class="col-lg-12">
								<div class="input-group">
									<input type="search" class="form-control" id="cari_lokasi" name="cari_lokasi" placeholder="Cari lokasi pengguna">
								</div>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-lg-6">
								<input type="text" class="form-control" id="lat" name="lat" placeholder="Latitude">
							</div>
							<div class="col-lg-6">
								<input type="text" class="form-control" id="lng" name="lng" placeholder="Longitude">
							</div>
						</div>
						
						<div class="row justify-content-center text-center">
							<div class="col-md-6">
								<button type="submit" class="btn btn-hero btn-primary mb-20 mt-20">
									<i class="fa fa-check mr-10"></i>KIRIM
								</button>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</main>