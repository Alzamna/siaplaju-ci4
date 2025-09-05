<section class="page-header page-header-xs">
	<div class="container">
		<h1>PENGADUAN LAMPU PJU</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('');?>">Beranda</a></li>
			<li><a href="<?php echo site_url('pengaduan');?>">Pengaduan</a></li>
		</ol>
	</div>
</section>
<!-- /PAGE HEADER -->

<!-- -->
<section class="nopadding">
	<div class="container">		
		<?php
			if(isset($dt_pengaduan)){
			foreach($dt_pengaduan as $row){
			?>
			<div class="row margin-top-10">
				<div class="col-md-6">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h2 class="panel-title">DATA PENGADUAN</h2>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-condensed table-vertical-middle nomargin">
									<tbody>
										<tr>
											<td>No pengaduan</td>
											<td>:</td>
											<td><strong><?php echo $row->id_pengaduan;?></strong></td>
										</tr>
										<tr>
											<td>Tanggal</td>
											<td>:</td>
											<td><?php echo date("d M Y H:i:s",strtotime($row->tgl_pengaduan)); ?></td>
										</tr>
										<tr>
											<td>Nama</td>
											<td>:</td>
											<td><?php echo $row->pelapor; ?> </td>
										</tr>
										<tr>
											<td>Telepon/Email</td>
											<td>:</td>
											<td><?php if(is_numeric($row->no_telp)){ 
												$num = $row->no_telp;
												$disnum = substr($num, 0, 6) . str_repeat("*", strlen($num)-6);
												echo $disnum; } 
												else { echo $row->no_telp; }?> </td>
										</tr>
										<tr>
											<td>Isi Laporan</td>
											<td>:</td>
											<td><?php echo $row->laporan;?></td>
										</tr>
										<tr>
											<td>Ruas Jalan </td>
											<td>:</td>
											<td><?php echo $row->nama_jalan;?></td>
										</tr>
										<tr>
											<td>Koordinat</td>
											<td>:</td>
											<td><?php echo $row->lat;?> , <?php echo $row->lng;?></td>
										</tr>
										<tr>
											<td>Lampiran</td>
											<td>:</td>
											<td><?php echo $row->foto;?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="panel panel-info">
						<div class="panel-body">
							<?php 
								if(!empty($peta)){ 
									echo $peta['html'];
								} else {
									echo "Peta tidak disertakan";
								}?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h2 class="panel-title">FOTO/LAMPIRAN LAPORAN</h2>
						</div>
						<div class="panel-body">
							<?php if($row->foto==""){
								echo "Tidak ada lampiran";
							} else { ?>
							<img class="img-responsive" src="<?php echo base_url('upload/foto/pengaduan/'.$row->foto);?>" alt="" />
							<?php }?>
						</div>
					</div>
					
					<div class="panel panel-info">
						<div class="panel-heading">
							<h2 class="panel-title">TINDAKAN PENGADUAN</h2>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table nomargin">
									<thead>
										<tr>
											<th>Tindakan Admin</th>
											<th><i class="fa fa-calendar"></i> Tanggal</th>
										</tr>
									</thead>
									<tbody>
									<?php
									foreach($dt_tindakan as $row){
									?>
										<tr>
											<td><?php echo $row->tindakan;?></td>
											<td><?php echo date("d M Y H:i:s",strtotime($row->tgl_tindakan)); ?> </td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="panel panel-info">
						<div class="panel-heading">
							<h2 class="panel-title">STATUS PENGADUAN</h2>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table nomargin">
									<thead>
										<tr>
											<th>Keterangan</th>
											<th><i class="fa fa-calendar"></i> Tanggal</th>
										</tr>
									</thead>
									<tbody>
									<?php
									foreach($dt_status as $row){
										$status=$row->status;
									?>
										<tr class="<?php 
												if($status==1){
													echo "";
												} else if($status==2) {
													echo "success";
												} else if($status==3) { 
													echo "warning";
												} else if($status==4) { 
													echo "info";
												} else if($status==0) {
													echo "danger";
												} ?>">
											<td><?php echo $row->keterangan;?></td>
											<td><?php echo date("d M Y H:i:s",strtotime($row->tgl_status)); ?> </td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">	
						<div class="panel-heading">
							<h2 class="panel-title">FOTO PERBAIKAN LAMPU PJU</h2>
						</div>
						
						<div class="panel-body">
							<div class="masonry-gallery columns-4 clearfix lightbox" data-img-big="3" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
							<?php foreach($dt_foto as $row){?>
								<a class="image-hover" href="<?php echo base_url('upload/foto/perbaikan/'.$row->nama_foto);?>">
									<img  src="<?php echo base_url('upload/foto/perbaikan/'.$row->nama_foto);?>" alt="...">
								</a>
							<?php }?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php }}?>
		</div>
</section>