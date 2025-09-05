<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block block-themed">
		   <div class="block-header bg-gd-sea">
				<h3 class="block-title">DATA INFORMASI PJU</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-map"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row">
					<?php foreach($dt_pju as $row){ ?>
					<div class="col-lg-6">
						<?php echo $peta['html'];?>
						<br/>
						<?php if($row->foto!=""){ ?>
							<div class="items-push">
								<div class="animated fadeIn">
									<div class="options-container">
										<img class="img-fluid options-item" style="height:250px" src="<?php echo base_url('upload/foto/'.$row->foto);?>.png" alt="">
									</div>
								</div>
							</div>
						<?php } else { ?>
							<div class="items-push">
								<div class="animated fadeIn">
									<div class="options-container">
										<img class="img-fluid options-item" style="height:250px" src="<?php echo base_url('public/img/image-not-found.png');?>" alt="">
									</div>
								</div>
							</div>
						<?php }} ?>
					</div>
					<div class="col-lg-6">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-vcenter">
								<tbody>
									<tr>
										<td>ID PJU</td>
										<td class="font-w600"><?php echo $row->id_pju;?></td>
									</tr>
									<tr>
										<td>NAMA JALAN</td>
										<td class="font-w600"><?php echo $row->nama_jalan;?></td>
									</tr>
									<tr>
										<td>PANJANG JALAN</td>
										<td class="font-w600"><?php echo $row->panjang_jalan;?> km</td>
									</tr>
									<tr>
										<td>KECAMATAN</td>
										<td class="font-w600"><?php echo $row->nama_kecamatan;?></td>
									</tr>
									<tr>
										<td>RAYON</td>
										<td class="font-w600"><?php echo $row->nama_rayon;?></td>
									</tr>
									<tr>
										<td>ID PELANGGAN</td>
										<td class="font-w600"><?php echo $row->id_pel;?></td>
									</tr>
									<tr>
										<td>NOMOR GARDU</td>
										<td class="font-w600"><?php echo $row->no_gardu;?></td>
									</tr>
									<tr>
										<td>NOMOR PAL</td>
										<td class="font-w600"><?php echo $row->no_pal;?></td>
									</tr>
									<tr>
										<td>JENIS LAMPU</td>
										<td class="font-w600"><?php echo $row->jenis;?></td>
									</tr>
									<tr>
										<td>KWH</td>
										<td class="font-w600"><?php echo $row->kwh;?></td>
									</tr>
									<tr>
										<td>DAYA LAMPU</td>
										<td class="font-w600"><?php echo $row->daya;?></td>
									</tr>
									<tr>
										<td>POSISI LAMPU</td>
										<td class="font-w600"><?php echo $row->posisi;?></td>
									</tr>
									<tr>
										<td>KONDISI LAMPU</td>
										<td class="font-w600"><?php echo $row->kondisi;?></td>
									</tr>
									<tr>
										<td>KOORDINAT</td>
										<td class="font-w600"><?php echo $row->lat;?> , <?php echo $row->lng;?></td>
									</tr>
									<tr>
										<td>KETERANGAN</td>
										<td class="font-w600"><?php echo $row->keterangan;?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>