<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block block-themed">
		   <div class="block-header bg-gd-dusk">
				<h3 class="block-title">DATA ASPIRASI LPJU KABUPATEN TEGAL</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-bulb"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row">
					<div class="col-lg-5">
						<form action="<?php echo site_url('adminaspirasi/cari');?>" method="post">
							<?= csrf_field() ?>
							<div class="form-group row">
								<div class="col-lg-12">
									<div class="input-group">
										<input type="search" class="form-control" id="cari" name="cari" placeholder="Masukan aspirasi atau nama masyarakat" required="">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-secondary">
												<i class="fa fa-search"></i>Cari
											</button>
										</span>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">ID aspirasi</th>
								<th class="text-center">Tgl Aspirasi</th>
								<th class="d-none d-sm-table-cell">Nama</th>
								<th class="d-none d-sm-table-cell">Aspirasi</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = $start+1;
							if(isset($dt_aspirasi)){
								foreach($dt_aspirasi as $row){
									if($row->status=='1'){
										$tr = 'table-active';
										$status = 'MASUK';
									} else if($row->status=='2'){
										$tr = 'table-info';
										$status = 'DIVERIFIKASI';
									}
									else if($row->status=='3'){
										$tr = 'table-warning';
										$status = 'PROSES PENGAJUAN';
									} else if($row->status=='4'){
										$tr = 'table-success';
										$status = 'SELESAI';
									} else if($row->status=='0'){
										$tr = 'table-danger';
										$status = 'DITOLAK';
									}
							?>
							<tr class="<?php echo $tr;?>">
								<td class="text-center"><?php echo $no++;?></td>
								<td class="font-w600"><?php echo $row->id_aspirasi;?></td>
								<td class="font-w600"><?php echo date("d M Y H:i:s",strtotime($row->tgl_aspirasi));?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->nama;?></td>
								<td class="d-none d-sm-table-cell"><?php $isi = word_limiter($row->aspirasi, 10); echo $isi; ?></td>
								<td class="text-center">
									<a href="<?php echo site_url('adminaspirasi/lihat/'.$row->id_aspirasi);?>">
										<button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Lihat aspirasi">
											<i class="fa fa-search"></i>
										</button>
									</a>
									<?php if($row->status=='1'){ ?>
									<a href="<?php echo site_url('adminaspirasi/verifikasi/'.$row->id_aspirasi);?>">
										<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" title="Verifikasi aspirasi">
											<i class="fa fa-check"></i>
										</button>
									</a>
									<?php } ?>
									<a href="<?php echo site_url('adminaspirasi/hapus/'.$row->id_aspirasi);?>">
										<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" onclick="return confirm('Anda yakin ingin menghapus data aspirasi?')" title="Hapus Aspirasi">
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