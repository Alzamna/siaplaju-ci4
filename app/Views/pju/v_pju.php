<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block block-themed">
		   <div class="block-header bg-gd-dusk">
				<h3 class="block-title">DATA PJU KABUPATEN TEGAL</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-bulb"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row">
					<div class="col-lg-4">
						<form action="<?php echo site_url('adminpju/cari');?>" method="post">
							<?= csrf_field() ?>
							<div class="form-group row">
								<div class="col-lg-12">
									<div class="input-group">
										<input type="search" class="form-control" id="cari" name="cari" placeholder="Masukan nama jalan" required="">
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
					<div class="col-lg-8 text-right">
						<a href="<?php echo site_url('adminpju/tambah');?>">
							<button type="button" class="btn btn-primary">
								<i class="fa fa-plus mr-10"></i>Tambah PJU
							</button>
						</a>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">ID PJU</th>
								<th class="text-center">Nama Jalan</th>
								<th class="d-none d-sm-table-cell">Jenis Lampu</th>
								<th class="d-none d-sm-table-cell">Daya</th>
								<th class="d-none d-sm-table-cell">Kondisi</th>
								<th class="text-center">Kecamatan</th>
								<th class="text-center">Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = $start+1;
							if(isset($dt_pju)){
								foreach($dt_pju as $row){
							?>
							<tr>
								<td class="text-center"><?php echo $no++;?></td>
								<td class="font-w600"><?php echo $row->id_pju;?></td>
								<td class="font-w600"><?php echo $row->nama_jalan;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->jenis;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->daya;?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row->kondisi;?></td>
								<td class="font-w600"><?php echo $row->nama_kecamatan;?></td>
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