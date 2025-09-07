<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block">
			
			<div class="block-content">
				<div class="row">
					<div class="col-lg-4">
						<div class="block-header block-header-default">
							<h3 class="block-title">TEKNISI PT CAHAYA KILAU KENCANA</h3>
						</div>
					</div>
					<div class="col-lg-8 text-right">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#teknisi-tambah">
							<i class="fa fa-plus mr-10"></i>Tambah Teknisi
						</button>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter">
						<thead>
							<tr>
								<th class="text-center"></th>
								<th>Nama</th>
								<th>Keahlian</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							if(isset($dt_teknisi)){
								foreach($dt_teknisi as $row){
							?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td><?php echo $row->nama_teknisi;?></td>
								<td><?php echo $row->keahlian;?></td>
								<td class="text-center">
									<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#teknisi-edit-<?php echo $row->id_teknisi;?>" title="Edit teknisi">
										<i class="fa fa-pencil"></i>
									</button>
									<a href="<?php echo site_url('master/hapus_teknisi/'.$row->id_teknisi);?>">
										<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus teknisi">
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


<div class="modal fade" id="teknisi-tambah" tabindex="-1" role="dialog" aria-labelledby="teknisi-tambah" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('master/proses_tambah_teknisi');?>" method="post">
			<?= csrf_field() ?>
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Tambah Teknisi</h3>
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
							<input type="text" class="form-control" name="nama_teknisi" autofocus>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="keahlian">Keahlian</label>
						<div class="col-lg-8">
							<textarea class="form-control" name="keahlian" rows="2"></textarea>
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
	foreach($dt_teknisi as $row){
?>
<div class="modal fade" id="teknisi-edit-<?php echo $row->id_teknisi;?>" tabindex="-1" role="dialog" aria-labelledby="teknisi-edit" aria-hidden="true">
	<div class="modal-dialog modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('master/proses_edit_teknisi/'.$row->id_teknisi);?>" method="post">
			<?= csrf_field() ?>
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Edit Teknisi</h3>
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
							<input type="text" class="form-control" id="nama_teknisi" name="nama_teknisi" value="<?php echo $row->nama_teknisi;?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-4 col-form-label" for="keahlian">Keahlian</label>
						<div class="col-lg-8">
							<textarea class="form-control" id="keahlian" name="keahlian" rows="2"><?php echo $row->keahlian;?></textarea>
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