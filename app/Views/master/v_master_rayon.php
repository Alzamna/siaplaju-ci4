<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block">
			
			<div class="block-content">
				<div class="row">
					<div class="col-lg-8">
						<div class="block-header block-header-default">
							<h3 class="block-title">DATA RAYON</h3>
						</div>
					</div>
					<div class="col-lg-4 text-right">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rayon-tambah">
							<i class="fa fa-plus mr-10"></i>Tambah Rayon
						</button>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter">
						<thead>
							<tr>
								<th class="text-center"></th>
								<th>Nama Rayon</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							if(isset($dt_rayon)){
								foreach($dt_rayon as $row){
							?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td><?php echo $row->nama_rayon;?></td>
								<td class="text-center">
									<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#rayon-edit-<?php echo $row->id_rayon;?>" title="Edit rayon">
										<i class="fa fa-pencil"></i>
									</button>
									<a href="<?php echo site_url('adminmaster/hapus_rayon/'.$row->id_rayon);?>">
										<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus rayon">
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


<div class="modal fade" id="rayon-tambah" tabindex="-1" role="dialog" aria-labelledby="rayon-tambah" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminmaster/proses_tambah_rayon');?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Tambah Rayon</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="nama_rayon">Nama Rayon</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="nama_rayon" autofocus>
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
	foreach($dt_rayon as $row){
?>
<div class="modal fade" id="rayon-edit-<?php echo $row->id_rayon;?>" tabindex="-1" role="dialog" aria-labelledby="rayon-edit" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminmaster/proses_edit_rayon/'.$row->id_rayon);?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Edit Rayon</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="nama_rayon">Nama Rayon</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="nama_rayon" name="nama_rayon" value="<?php echo $row->nama_rayon;?>">
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