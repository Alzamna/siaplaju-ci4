<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block block-themed">
		   <div class="block-header bg-gd-sea">
				<h3 class="block-title">DATA PENGADUAN</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-map"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row">
					<div class="col-lg-8">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-vcenter">
								<?php foreach($dt_pengaduan as $row){ 
								$id_pengaduan = $row->id_pengaduan;
								?>
								<tbody>
									<tr>
										<td>ID PENGADUAN</td>
										<td class="font-w600"><?php echo $row->id_pengaduan;?></td>
									</tr>
									<tr>
										<td>TANGGAL PENGADUAN</td>
										<td class="font-w600"><?php echo date("d M Y H:i:s",strtotime($row->tgl_pengaduan));?></td>
									</tr>
									<tr>
										<td>MEDIA PENGADUAN</td>
										<td class="font-w600"><?php echo $row->media;?></td>
									</tr>
									<tr>
										<td>PELAPOR</td>
										<td class="font-w600"><?php echo $row->pelapor;?></td>
									</tr>
									<tr>
										<td>NO TELP</td>
										<td class="font-w600"><?php echo $row->no_telp;?></td>
									</tr>
									<tr>
										<td>LAPORAN</td>
										<td class="font-w600"><?php echo $row->laporan;?></td>
									</tr>
									<tr>
										<td>RUAS JALAN</td>
										<td class="font-w600"><?php echo $row->nama_jalan;?></td>
									</tr>
									<tr>
										<td>KECAMATAN</td>
										<td class="font-w600"><?php echo $row->nama_kecamatan;?></td>
									</tr>
								</tbody>
								<?php } ?>
							</table>
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
								<a class="img-link img-link-zoom-in img-thumb img-lightbox" href="<?php echo base_url('public/img/image-not-found.png');?>">
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
			<div class="col-lg-6">
				<div class="block block-themed">
					<div class="block-header bg-gd-info">
						<h3 class="block-title">TINDAKAN PENGADUAN</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option">
								<i class="si si-map"></i>
							</button>
						</div>
					</div>
					<div class="block-content">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-vcenter">
								<thead>
									<tr>
										<th class="text-center">Tindakan</th>
										<th class="text-center">Tanggal</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($dt_tindakan as $row){
									?>
									<tr>
										<td class="font-w600"><?php echo $row->tindakan;?></td>
										<td class="font-w600"><?php echo date("d M Y H:i:s",strtotime($row->tgl_tindakan));?></td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-lg-6">
				<div class="block block-themed">
					<div class="block-header bg-gd-info">
						<h3 class="block-title">STATUS PENGADUAN</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option">
								<i class="si si-map"></i>
							</button>
						</div>
					</div>
					<div class="block-content">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-vcenter">
								<thead>
									<tr>
										<th class="text-center">Keterangan</th>
										<th class="text-center">Tanggal</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($dt_status as $row){
										if($row->status=='1'){
											$tr = 'table-active';
											$status = 'MASUK';
										} else if($row->status=='2'){
											$tr = 'table-info';
											$status = 'DITERIMA';
										}
										else if($row->status=='3'){
											$tr = 'table-warning';
											$status = 'DALAM PROSES';
										} else if($row->status=='4'){
											$tr = 'table-success';
											$status = 'SELESAI';
										} else if($row->status=='0'){
											$tr = 'table-danger';
											$status = 'DITOLAK';
										}
									?>
									<tr class="<?php echo $tr;?>">
										<td class="font-w600"><?php echo $row->keterangan;?></td>
										<td class="font-w600"><?php echo date("d M Y H:i:s",strtotime($row->tgl_status));?></td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="block block-themed">
				   <div class="block-header bg-gd-info">
						<h3 class="block-title">PETA/LOKASI PERBAIKAN</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option">
								<i class="si si-map"></i>
							</button>
						</div>
					</div>
					<div class="block-content">
						<?php echo $peta['html'];?>
					</div>
				</div>
			</div>
			
			<div class="col-lg-6">
				<div class="block block-themed">
				   <div class="block-header bg-gd-info">
						<h3 class="block-title">FOTO-FOTO PERBAIKAN</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option">
								<i class="si si-map"></i>
							</button>
						</div>
					</div>
					<div class="block-content text center">
						<?php if(!empty($dt_foto)) { ?>
						<div class="row items-push js-gallery">
							<?php foreach($dt_foto as $ft){ ?>
							<div class=" col-sm-6 animated fadeIn">
								<a class="img-link img-link-zoom-in img-thumb img-lightbox" href="<?php echo base_url('upload/foto/perbaikan/'.$ft->nama_foto);?>">
									<img class="img-fluid" style="height:200px" src="<?php echo base_url('upload/foto/perbaikan/'.$ft->nama_foto);?>" alt="">
								</a>
							</div>
							<?php } ?>
						</div>

						<?php } else { ?>
						<div class="items-push js-gallery">
							<div class="animated fadeIn">
								<a class="img-link img-link-zoom-in img-thumb img-lightbox" href="<?php echo base_url('img/image-not-found.png');?>">
									<img class="img-fluid" style="height:200px" src="<?php echo base_url('img/image-not-found.png');?>" alt="">
								</a>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>