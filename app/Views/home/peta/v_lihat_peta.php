<section class="page-header page-header-xs">
	<div class="container">
		<h1>DATA INFORMASI LAMPU PJU
</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('');?>">Beranda</a></li>
			<li class="active"><a href="<?php echo site_url('peta')?>">Peta</a></li>
		</ol>
	</div>
</section>

<!-- -->
<section class="nopadding">
	<div class="container">
		<?php
			foreach($dt_pju as $row){
			?>
			<div class="row margin-top-10">
				<div class="col-md-6">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h2 class="panel-title">PETA LOKASI</h2>
						</div>
						<div class="panel-body">
							<?php echo $peta['html'];?>
						</div>
					</div>
					
					<div class="panel panel-info">
						<div class="panel-heading">
							<h2 class="panel-title">FOTO LAMPU PJU</h2>
						</div>
						<div class="panel-body">
							<?php if($row->foto==""){
								echo "Tidak ada lampiran";
							} else { ?>
							<img class="img-responsive" src="<?php echo base_url('upload/bimagepat/thumbnail/'.$row->id_pju);?>" alt="" />
							<?php }?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h2 class="panel-title">DATA LAMPU PJU</h2>
						</div>
						<div class="panel-body">
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
		<?php }?>
		</div>
</section>