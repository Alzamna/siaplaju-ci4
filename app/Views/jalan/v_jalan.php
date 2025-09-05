<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block">
			
			<div class="block-content">
				<div class="row">
					<div class="col-lg-8">
						<div class="block-header block-header-default">
							<h3 class="block-title">DATA JALAN KABUPATEN TEGAL</h3>
						</div>
					</div>
					<div class="col-lg-4 text-right">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#jalan-tambah">
							<i class="fa fa-plus mr-10"></i>Tambah Jalan
						</button>
					</div>
				</div>
				<div class="block-content block-content-full">
					<!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/be_tables_datatables.js -->
					<table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
						<thead>
							<tr>
								<th class="text-center"></th>
								<th>Nama Jalan</th>
								<th class="d-none d-sm-table-cell">Kecamatan</th>
								<th class="d-none d-sm-table-cell">Status Jalan</th>
								<th class="d-none d-sm-table-cell">Panjang Jalan</th>
								<th class="d-none d-sm-table-cell">Jumlah PJU</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$no = 1;
								if(isset($dt_jalan)){
									foreach($dt_jalan as $row){
								?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td class="font-w600"><?php echo $row->nama_jalan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->nama_kecamatan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->status_jalan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->panjang_jalan;?></td>
								<td class="d-none d-sm-table-cell"></td>
								<td class="text-center">
									<a href="<?php echo site_url('adminjalan/lihat/'.$row->id_jalan);?>">
										<button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="Lihat Jalan">
											<i class="fa fa-search"></i>
										</button>
									</a>
									<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#jalan-edit-<?php echo $row->id_jalan;?>" title="Edit jalan">
										<i class="fa fa-pencil"></i>
									</button>
									<a href="<?php echo site_url('adminmaster/hapus_jalan/'.$row->id_jalan);?>">
										<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus jalan">
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


<div class="modal fade" id="jalan-tambah" tabindex="-1" role="dialog" aria-labelledby="jalan-tambah" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminmaster/proses_tambah_jalan');?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Tambah Jalan</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="nama_jalan">Nama Jalan</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="nama_jalan" autofocus>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="kecamatan">Kecamatan</label>
						<div class="col-lg-8">
							<select class="js-select2 form-control" name="kecamatan" style="width: 100%;" data-placeholder="Pilih kecamatan">
								<option></option>
								<?php foreach($dt_kecamatan as $row){ ?>
								<option value="<?php echo $row->id_kecamatan;?>"><?php echo $row->nama_kecamatan;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="status_jalan">Status Jalan</label>
						<div class="col-lg-8">
							<select class="js-select2 form-control" name="status_jalan" style="width: 100%;" data-placeholder="Pilih status jalan">
								<option></option>
								<option value="KAB">KABUPATEN</option>
								<option value="PROV">PROVINSI</option>
								<option value="NAS">NASIONAL</option>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="panjang_jalan">Panjang Jalan</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="panjang_jalan">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-alt-success">
					<i class="fa fa-check"></i> Simpan
				</button>
			</div>
		</form>
		</div>
	</div>
</div>

<?php 
	foreach($dt_jalan as $row){
?>
<div class="modal fade" id="jalan-edit-<?php echo $row->id_jalan;?>" tabindex="-1" role="dialog" aria-labelledby="jalan-edit" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminmaster/proses_edit_jalan/'.$row->id_jalan);?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Edit Jalan</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="nama_jalan">Nama Jalan</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="nama_jalan" name="nama_jalan" value="<?php echo $row->nama_jalan;?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="kecamatan">Kecamatan</label>
						<div class="col-lg-8">
							<select class="js-select2 form-control" id="kecamatan" name="kecamatan" style="width: 100%;" data-placeholder="Pilih kecamatan">
								<option value="<?php echo $row->id_kecamatan;?>" selected><?php echo $row->nama_kecamatan;?></option>
								<option>-</option>
								<?php foreach($dt_kecamatan as $kec){ ?>
								<option value="<?php echo $kec->id_kecamatan;?>"><?php echo $kec->nama_kecamatan;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="status_jalan">Status Jalan</label>
						<div class="col-lg-8">
							<select class="js-select2 form-control" name="status_jalan" style="width: 100%;" data-placeholder="Pilih status jalan">
								<option value="<?php echo $row->status_jalan;?>"><?php echo $row->status_jalan;?></option>
								<option></option>
								<option value="KAB">KABUPATEN</option>
								<option value="PROV">PROVINSI</option>
								<option value="NAS">NASIONAL</option>
							</select>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="panjang_jalan">Panjang Jalan</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="panjang_jalan" value="<?php echo $row->panjang_jalan;?>">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-alt-success">
					<i class="fa fa-check"></i> Simpan
				</button>
			</div>
		</form>
		</div>
	</div>
</div>
<?php } ?>