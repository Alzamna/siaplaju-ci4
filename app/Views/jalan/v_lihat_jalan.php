<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block block-themed">
		   <div class="block-header bg-gd-sea">
				<h3 class="block-title">DATA INFORMASI JALAN</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-map"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row">
					<?php foreach($dt_jalan as $row){ 
						$panjang_jalan = $row->panjang_jalan;
						$kebutuhan = round($panjang_jalan/0.05,0);
						$terpasang = $row->pju_terpasang;
						$belum_terpasang = $kebutuhan-$terpasang;
					?>
					<div class="col-lg-6">
						<?php echo $peta['html'];?>
						<br/>
					</div>
					<div class="col-lg-6">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-vcenter">
								<tbody>
									<tr>
										<td>NAMA JALAN</td>
										<td class="font-w600"><?php echo $row->nama_jalan;?></td>
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
										<td>PANJANG JALAN</td>
										<td class="font-w600"><?php echo $panjang_jalan;?> km</td>
									</tr>
									<tr>
										<td>KEBUTUHAN PJU</td>
										<td class="font-w600"><?php echo $kebutuhan;?></td>
									</tr>
									<tr>
										<td>TERPASANG</td>
										<td class="font-w600"><?php echo $terpasang;?></td>
									</tr>
									<tr>
										<td>BELUM TERPASANG</td>
										<td class="font-w600"><?php echo $belum_terpasang;?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="block block-themed">
		   <div class="block-header bg-gd-lake">
				<h3 class="block-title">DATA PERBAIKAN</h3>
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
								<th class="text-center">No</th>
								<th class="text-center">ID Pengaduan</th>
								<th class="d-none d-sm-table-cell">Tgl Pengaduan</th>
								<th class="d-none d-sm-table-cell">Pelapor</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							if(isset($dt_perbaikan)){
								foreach($dt_perbaikan as $row){
							?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td class="font-w600"><?php echo $row->id_pengaduan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo date("d M Y H:i:s",strtotime($row->tgl_pengaduan));?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->pelapor;?></td>
								<td class="text-center">
									<a href="<?php echo site_url('adminpengaduan/lihat/'.$row->id_pengaduan);?>">
										<button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Lihat Perbaikan PJU">
											<i class="fa fa-search"></i>
										</button>
									</a>
								</td>
							</tr>
							<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<div class="block block-themed">
		   <div class="block-header bg-gd-dusk">
				<h3 class="block-title">DATA LAMPU PJU</h3>
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
								<th class="text-center">No</th>
								<th class="text-center">ID PJU</th>
								<th class="d-none d-sm-table-cell">ID Pelanggan</th>
								<th class="d-none d-sm-table-cell">No PAL</th>
								<th class="d-none d-sm-table-cell">Jenis Lampu</th>
								<th class="d-none d-sm-table-cell">Daya</th>
								<th class="d-none d-sm-table-cell">Kondisi</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							if(isset($dt_pju)){
								foreach($dt_pju as $row){
							?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td class="font-w600"><?php echo $row->id_pju;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->id_pel;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->no_pal;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->jenis;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->daya;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->kondisi;?></td>
								<td class="text-center">
									<a href="<?php echo site_url('adminpju/lihat/'.$row->id_pju);?>">
										<button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Lihat PJU">
											<i class="fa fa-search"></i>
										</button>
									</a>
									<a href="<?php echo site_url('adminpju/edit/'.$row->id_pju);?>">
										<button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit PJU">
											<i class="fa fa-pencil"></i>
										</button>
									</a>
									<a href="<?php echo site_url('adminpju/hapus/'.$row->id_pju);?>">
										<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" onclick="return confirm('Anda yakin ingin menghapus data PJU?')" title="Hapus PJU">
											<i class="fa fa-trash"></i>
										</button>
									</a>
								</td>
							</tr>
							<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>