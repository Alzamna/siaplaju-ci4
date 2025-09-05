<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block block-themed">
		   <div class="block-header bg-gd-dusk">
				<h3 class="block-title">DATA PENGADUAN LPJU KABUPATEN TEGAL</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-bulb"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row">
					<div class="col-lg-5">
						<form action="<?php echo site_url('adminpengaduan/cari');?>" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="form-group row">
								<div class="col-lg-12">
									<div class="input-group">
										<input type="search" class="form-control" id="cari" name="cari" placeholder="Masukan kode pengaduan atau nama pelapor" required="">
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
					<div class="col-lg-7 text-right">
						<a href="<?php echo site_url('adminpengaduan/tambah');?>">
							<button type="button" class="btn btn-primary">
								<i class="fa fa-plus mr-10"></i>Tambah Pengaduan
							</button>
						</a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">ID Pengaduan</th>
								<th class="text-center">Pelapor</th>
								<th class="d-none d-sm-table-cell">Tgl Pengaduan</th>
								<th class="d-none d-sm-table-cell">Ruas Jalan</th>
								<th class="d-none d-sm-table-cell">Status</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = $start+1;
							if(isset($dt_pengaduan)){
								foreach($dt_pengaduan as $row){
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
								<td class="text-center"><?php echo $no++;?></td>
								<td class="font-w600"><?php echo $row->id_pengaduan;?></td>
								<td class="font-w600"><?php echo $row->pelapor;?></td>
								<td class="d-none d-sm-table-cell"><?php echo date("d M Y H:i:s",strtotime($row->tgl_pengaduan));?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->nama_jalan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $status;?></td>
								<td class="text-center">
									<a href="<?php echo site_url('adminpengaduan/lihat/'.$row->id_pengaduan);?>">
										<button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Lihat Pengaduan">
											<i class="fa fa-search"></i>
										</button>
									</a>
									
									<a href="<?php echo site_url('adminpengaduan/edit/'.$row->id_pengaduan);?>">
										<button type="button" class="btn btn-sm btn-default" data-toggle="tooltip" title="Edit Pengaduan">
											<i class="fa fa-pencil"></i>
										</button>
									</a>
									
									<?php if($row->status=='1'){ ?>
									<a href="<?php echo site_url('adminpengaduan/verifikasi/'.$row->id_pengaduan);?>">
										<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" title="Verifikasi Pengaduan">
											<i class="fa fa-check"></i>
										</button>
									</a>
									<?php } else if($row->status=='2'){ ?>
									<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#proses-<?php echo $row->id_pengaduan;?>" title="Proses Pengaduan">
										<i class="fa fa-check"></i>
									</button>
									<?php } else if($row->status=='3'){ ?>
									<a href="<?php echo site_url('adminpengaduan/inputperbaikan/'.$row->id_pengaduan);?>">
										<button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" title="Input perbaikan">
											<i class="fa fa-check"></i>
										</button>
									</a>
									<?php } ?>
									<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus-<?php echo $row->id_pengaduan;?>" title="Tolak Pengaduan">
										<i class="fa fa-ban"></i>
									</button>
									
									<a href="<?php echo site_url('adminpengaduan/hapus/'.$row->id_pengaduan);?>">
										<button type="button" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin menghapus pengaduan?')" title="Hapus Pengaduan">
											<i class="fa fa-trash"></i>
										</button>
									</a>
								</td>
							</tr>
							<?php }} ?>
						</tbody>
					</table>
					
					<nav aria-label="Page navigation">
						<?php echo $this->pagination->create_links();?>
					</nav>
				</div>
			</div>
		</div>
	</div>
</main>

<?php 
	foreach($dt_pengaduan as $row){
?>
<div class="modal fade" id="proses-<?php echo $row->id_pengaduan;?>" tabindex="-1" role="dialog" aria-labelledby="user-edit" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminpengaduan/proses_pengaduan/'.$row->id_pengaduan);?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Proses Pengaduan</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">										
					<div class="form-group row">
						<label class="col-lg-2 col-form-label" for="laporan">Laporan</label>
						<div class="col-lg-10">
							<textarea class="form-control" id="laporan" name="laporan" rows="5" readonly><?php echo $row->laporan;?></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-2 col-form-label" for="tindak">Tindakan</label>
						<div class="col-lg-10">
							<textarea class="form-control" id="tindakan" name="tindakan" rows="5"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-alt-success">
					<i class="fa fa-check"></i> Kirim
				</button>
			</div>
		</form>
		</div>
	</div>
</div>

<div class="modal fade" id="hapus-<?php echo $row->id_pengaduan;?>" tabindex="-1" role="dialog" aria-labelledby="hapus-pengaduan" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminpengaduan/tolak/'.$row->id_pengaduan);?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Tolak Pengaduan</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">										
					<div class="form-group row">
						<label class="col-lg-3 col-form-label" for="laporan">Laporan</label>
						<div class="col-lg-9">
							<textarea class="form-control" id="laporan" name="laporan" rows="5" readonly><?php echo $row->laporan;?></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-3 col-form-label" for="tindak">Alasan Penolakan</label>
						<div class="col-lg-9">
							<textarea class="form-control" id="tindakan" name="tindakan" rows="5"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-alt-success">
					<i class="fa fa-check"></i> Kirim
				</button>
			</div>
		</form>
		</div>
	</div>
</div>
<?php } ?>