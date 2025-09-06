<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		
		<div class="block block-themed">
			 <div class="block-header bg-gd-sea">
				<h3 class="block-title">EDIT PENGADUAN PENGADUAN</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-user"></i>
					</button>
				</div>
			</div>
			<?php foreach($dt_pengaduan as $row){ ?>
			<div class="block-content">
				<form action="<?php echo site_url('adminpengaduan/proses_edit/'.$row->id_pengaduan);?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly>
					<div class="row">
                        <div class="col-sm-8">
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="id_pengaduan">ID Pengaduan</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="id_pengaduan" name="id_kecamatan" value="<?php echo $row->id_pengaduan;?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="tgl_pengaduan">Tanggal Pengaduan</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="tgl_pengaduan" name="tgl_pengaduan" value="<?php echo date("d M Y H:i:s",strtotime($row->tgl_pengaduan));?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="media">Media Pengaduan</label>
								<div class="col-lg-8">
									<select class="js-select2 form-control" name="media" style="width: 100%;" data-placeholder="Pilih media pelaporan">
										<option value="<?php echo $row->media;?>" selected><?php echo $row->media;?></option>
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
								<label class="col-lg-4 col-form-label" for="pelapor">Pelapor</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="pelapor" name="pelapor" value="<?php echo $row->pelapor;?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="no_telp">Nomor Telepon</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $row->no_telp;?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="laporan">Laporan</label>
								<div class="col-lg-8">
									<textarea class="form-control" id="laporan" name="laporan" rows="5" placeholder="Laporan"><?php echo $row->laporan;?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="kecamatan">Kecamatan</label>
								<div class="col-lg-8">
									<select class="js-select2 form-control" id="select-kecamatan" name="kecamatan" style="width: 100%;" data-placeholder="Pilih kecamatan">
										<option value="<?php echo $row->id_kecamatan;?>" selected><?php echo $row->nama_kecamatan;?></option>
										<option></option>
										<?php foreach($dt_kecamatan as $kec){ ?>
										<option value="<?php echo $kec->id_kecamatan;?>"><?php echo $kec->nama_kecamatan;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="jalan">Jalan</label>
								<div class="col-lg-8">
									<select class="js-select2 form-control" id="select-jalan" name="jalan" style="width: 100%;" data-placeholder="Pilih nama jalan" required="">
										<option value="<?php echo $row->id_jalan;?>" selected><?php echo $row->nama_jalan;?></option>
										<option></option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="col-sm-4 text-center">
							<?php if($row->foto!='') { ?>	
							<div class="items-push js-gallery">
								<div class="animated fadeIn">
									<a class="img-link img-link-zoom-in img-thumb img-lightbox" href="<?php echo base_url('upload/foto/pengaduan/'.$row->foto);?>">
										<img class="img-fluid" style="height:200px" src="<?php echo base_url('upload/foto/pengaduan/'.$row->foto);?>" alt="">
									</a>
								</div>
							</div>
							<?php } else { ?>
							<div class="items-push js-gallery">
								<div class="animated fadeIn">
									<a class="img-link img-link-zoom-in img-thumb img-lightbox" href="<?php echo base_url('img/image-not-found.png');?>">
										<img class="img-fluid" style="height:200px" src="<?php echo base_url('img/image-not-found.png');?>" alt="">
									</a>
								</div>
								<span class="badge badge-danger">TIDAK ADA LAMPIRAN</span>
							</div>
							<?php } ?>
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
								<input type="text" class="form-control" id="lat" name="lat" value="<?php echo $row->lat;?>" placeholder="Latitude">
							</div>
							<div class="col-lg-6">
								<input type="text" class="form-control" id="lng" name="lng" value="<?php echo $row->lng;?>" placeholder="Longitude">
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
			<?php } ?>
			</div>
		</div>
	</div>
</main>