<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block">
			
			<div class="block-content">
				<div class="row">
					<div class="col-lg-4">
						<div class="block-header block-header-default">
							<h3 class="block-title">ADMIN SIPELAJU</h3>
						</div>
					</div>
					<div class="col-lg-8 text-right">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#user-tambah">
							<i class="fa fa-plus mr-10"></i>Tambah Admin
						</button>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter">
						<thead>
							<tr>
								<th class="text-center"></th>
								<th>Nama</th>
								<th>Akses</th>
								<th>Username</th>
								<th>Telepon</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							if(isset($dt_user)){
								foreach($dt_user as $row){
							?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td><?php echo $row->nama;?></td>
								<td><?php echo $row->akses;?></td>
								<td><?php echo $row->username;?></td>
								<td><?php echo $row->telp;?></td>
								<td class="text-center">
									<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#user-edit-<?php echo $row->id_user;?>" title="Edit user">
										<i class="fa fa-pencil"></i>
									</button>
									<a href="<?php echo site_url('adminmaster/hapus_user/'.$row->id_user);?>">
										<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus user">
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


<div class="modal fade" id="user-tambah" tabindex="-1" role="dialog" aria-labelledby="user-tambah" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminmaster/proses_tambah_admin');?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Tambah Admin</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="nama">Nama</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="nama" autofocus>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="alamat">Alamat</label>
						<div class="col-lg-8">
							<textarea class="form-control" name="alamat" rows="2"></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="telp">Telepon</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="telp">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="username">Username</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="username">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="password">Password</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" name="password">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="akses">Akses</label>
						<div class="col-lg-8">
							<select class="js-select2 form-control" name="akses" style="width: 100%;" data-placeholder="Pilih Hak Akses">
								<option></option>
								<?php foreach($dt_akses as $row){ ?>
								<option value="<?php echo $row->id_akses;?>"><?php echo $row->akses;?></option>
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
	foreach($dt_user as $row){
?>
<div class="modal fade" id="user-edit-<?php echo $row->id_user;?>" tabindex="-1" role="dialog" aria-labelledby="user-edit" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminmaster/proses_edit_admin/'.$row->id_user);?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Edit Admin</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content">					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="nama">Nama</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row->nama;?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="alamat">Alamat</label>
						<div class="col-lg-8">
							<textarea class="form-control" id="alamat" name="alamat" rows="2"><?php echo $row->alamat;?></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="telp">Telepon</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $row->telp;?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="username">Username</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="username" name="username" value="<?php echo $row->username;?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="password">Password</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" id="password" name="password">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="akses">Akses</label>
						<div class="col-lg-8">
							<select class="js-select2 form-control" id="akses" name="akses" style="width: 100%;" data-placeholder="Pilih Hak Akses">
								<option value="<?php echo $row->id_akses;?>" selected><?php echo $row->akses;?></option>
								<option>-</option>
								<?php foreach($dt_akses as $row){ ?>
								<option value="<?php echo $row->id_akses;?>"><?php echo $row->akses;?></option>
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