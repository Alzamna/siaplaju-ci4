<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		
		<div class="block block-themed">
			 <div class="block-header bg-gd-sea">
				<h3 class="block-title">VERIFIKASI ASPIRASI</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-user"></i>
					</button>
				</div>
			</div>
			<?php foreach($dt_aspirasi as $row){ ?>
			<div class="block-content">
				<form action="<?php echo site_url('adminaspirasi/proses_verifikasi/'.$row->id_aspirasi);?>" method="post" enctype="multipart/form-data">
					<?= csrf_field() ?>
					<div class="row">
                        <div class="col-sm-8">
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="id_aspirasi">ID Aspirasi</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="id_aspirasi" name="id_kecamatan" value="<?php echo $row->id_aspirasi;?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="tgl_aspirasi">Tanggal Aspirasi</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="tgl_aspirasi" name="tgl_aspirasi" value="<?php echo date("d M Y H:i:s",strtotime($row->tgl_aspirasi));?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="no_ktp">No KTP</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="no_ktp" name="no_ktp" value="<?php echo $row->no_ktp;?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="nama">Nama</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row->nama;?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="alamat">Alamat</label>
								<div class="col-lg-8">
									<textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat" readonly><?php echo $row->alamat;?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="no_telp">Nomor Telepon</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $row->no_telp;?>" readonly>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="aspirasi">Aspirasi</label>
								<div class="col-lg-8">
									<textarea class="form-control" id="aspirasi" name="aspirasi" rows="5" placeholder="Aspirasi"><?php echo $row->aspirasi;?></textarea>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="tindakan">Tindakan</label>
								<div class="col-lg-8">
									<textarea class="form-control" id="tindakan" name="tindakan" rows="3" placeholder="tindakan"></textarea>
								</div>
							</div>
						</div>
						
						<div class="col-sm-4 text-center">
							<?php if (!empty($dt_foto)): ?>
								<?php foreach ($dt_foto as $ft): ?>
									<a class="img-link img-link-zoom-in img-thumb img-lightbox"
									href="<?= base_url('upload/foto/perbaikan/'.$ft->nama_foto); ?>">
										<img class="img-fluid" style="height:200px"
											src="<?= base_url('upload/foto/perbaikan/'.$ft->nama_foto); ?>" alt="">
									</a>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="items-push js-gallery">
									<div class="animated fadeIn">
										<a class="img-link img-link-zoom-in img-thumb img-lightbox"
										href="<?= base_url('public/img/image-not-found.png'); ?>">
											<img class="img-fluid" style="height:200px"
												src="<?= base_url('public/img/image-not-found.png'); ?>" alt="">
										</a>
									</div>
									<span class="badge badge-danger">TIDAK ADA LAMPIRAN</span>
								</div>
							<?php endif; ?>
						</div>
					</div>
			</div>
			<?php } ?>
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