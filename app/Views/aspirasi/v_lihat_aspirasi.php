<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block block-themed">
		   <div class="block-header bg-gd-sea">
				<h3 class="block-title">DATA ASPIRASI</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-map"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row">
					<div class="col-lg-6">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-vcenter">
								<?php foreach($dt_aspirasi as $row){ 
								$id_aspirasi = $row->id_aspirasi;
								?>
								<tbody>
									<tr>
										<td>ID aspirasi</td>
										<td class="font-w600"><?php echo $row->id_aspirasi;?></td>
									</tr>
									<tr>
										<td>TANGGAL ASPIRASI</td>
										<td class="font-w600"><?php echo date("d M Y H:i:s",strtotime($row->tgl_aspirasi));?></td>
									</tr>
									<tr>
										<td>NO KTP</td>
										<td class="font-w600"><?php echo $row->no_ktp;?></td>
									</tr>
									<tr>
										<td>NAMA</td>
										<td class="font-w600"><?php echo $row->nama;?></td>
									</tr>
									<tr>
										<td>ALAMAT</td>
										<td class="font-w600"><?php echo $row->alamat;?></td>
									</tr>
									<tr>
										<td>NO TELP</td>
										<td class="font-w600"><?php echo $row->no_telp;?></td>
									</tr>
									<tr>
										<td>ASPIRASI</td>
										<td class="font-w600"><?php echo $row->aspirasi;?></td>
									</tr>
									<tr>
										<td>KOORDINAT</td>
										<td class="font-w600"><?php echo $row->lat;?>,<?php echo $row->lng;?></td>
									</tr>
								</tbody>
								<?php } ?>
							</table>
						</div>
					</div>
					<div class="col-sm-6 text-center">
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
								<a class="img-link img-link-zoom-in img-thumb img-lightbox" href="<?php echo base_url('assets/img/image-not-found.png');?>">
									<img class="img-fluid" style="height:200px" src="<?php echo base_url('assets/img/image-not-found.png');?>" alt="">
								</a>
							</div>
						</div>
						<span class="badge badge-danger">TIDAK ADA LAMPIRAN</span>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				<div class="block block-themed">
				   <div class="block-header bg-gd-info">
						<h3 class="block-title">PETA/LOKASI YANG DITUJUKAN</h3>
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
		</div>
	</div>
</main>