<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block">
			
			<div class="block-content">
				<div class="row">
					<div class="col-lg-8">
						<div class="block-header block-header-default">
							<h3 class="block-title">DATA KECAMATAN KABUPATEN TEGAL</h3>
						</div>
					</div>
					<div class="col-lg-4 text-right">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kecamatan-tambah">
							<i class="fa fa-plus mr-10"></i>Tambah Kecamatan
						</button>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
						<thead>
							<tr>
								<th class="text-center"></th>
								<th>Nama Kecamatan</th>
								<th>Rayon</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							if(isset($dt_kecamatan)){
								foreach($dt_kecamatan as $row){
							?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td><?php echo $row->nama_kecamatan;?></td>
								<td><?php echo $row->nama_rayon;?></td>
								<td class="text-center">
									<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#kecamatan-edit-<?php echo $row->id_kecamatan;?>" title="Edit kecamatan">
										<i class="fa fa-pencil"></i>
									</button>
									<a href="<?php echo site_url('adminmaster/hapus_kecamatan/'.$row->id_kecamatan);?>">
										<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus kecamatan">
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


<div class="modal fade" id="kecamatan-tambah" tabindex="-1" role="dialog" aria-labelledby="kecamatan-tambah" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminmaster/proses_tambah_kecamatan');?>" method="post">
			<?= csrf_field() ?>
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Tambah Kecamatan</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="nama_kecamatan">Nama Kecamatan</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="nama_kecamatan" autofocus>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="rayon">Rayon</label>
						<div class="col-lg-8">
							<select class="js-select2 form-control" name="rayon" style="width: 100%;" data-placeholder="Pilih rayon">
								<option></option>
								<?php foreach($dt_rayon as $row){ ?>
								<option value="<?php echo $row->id_rayon;?>"><?php echo $row->nama_rayon;?></option>
								<?php } ?>
							</select>
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
	foreach($dt_kecamatan as $row){
?>
<div class="modal fade" id="kecamatan-edit-<?php echo $row->id_kecamatan;?>" tabindex="-1" role="dialog" aria-labelledby="kecamatan-edit" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminmaster/proses_edit_kecamatan/'.$row->id_kecamatan);?>" method="post">
			<?= csrf_field() ?>
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Edit Kecamatan</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="nama_kecamatan">Nama Kecamatan</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="nama_kecamatan" name="nama_kecamatan" value="<?php echo $row->nama_kecamatan;?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="rayon">Rayon</label>
						<div class="col-lg-8">
							<select class="js-select2 form-control" id="rayon" name="rayon" style="width: 100%;" data-placeholder="Pilih rayon">
								<option value="<?php echo $row->id_rayon;?>" selected><?php echo $row->nama_rayon;?></option>
								<option>-</option>
								<?php foreach($dt_rayon as $row){ ?>
								<option value="<?php echo $row->id_rayon;?>"><?php echo $row->nama_rayon;?></option>
								<?php } ?>
							</select>
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