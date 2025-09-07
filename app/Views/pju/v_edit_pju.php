<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		
		<div class="block block-themed">
			 <div class="block-header bg-gd-sea">
				<h3 class="block-title">EDIT LAMPU PJU</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-user"></i>
					</button>
				</div>
			</div>
			<?php foreach($dt_pju as $row){ ?>
			<div class="block-content">
				<form action="<?php echo site_url('adminpju/proses_edit/'.$row->id_pju);?>" method="post" enctype="multipart/form-data">
					<?= csrf_field() ?>
					<div class="row">
                        <div class="col-sm-6">														
							<div class="form-group row">
							<label class="col-lg-4 col-form-label" for="kecamatan">Kecamatan</label>
								<div class="col-lg-8">
									<select class="js-select2 form-control" id="select-kecamatan" name="kecamatan" style="width: 100%;" data-placeholder="Pilih kecamatan">
										<option value="<?php echo $row->id_kecamatan;?>" selected><?php echo $row->nama_kecamatan;?></option>
										<option></option>
										<?php foreach($dt_kecamatan as $kec){ ?>
										<option value="<?php echo $kec->id_kecamatan;?>"><?php echo $kec->nama_kecamatan;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="jalan">Jalan</label>
								<div class="col-lg-8">
									<select class="js-select2 form-control" id="select-jalan" name="jalan" style="width: 100%;" data-placeholder="Pilih nama jalan">
										<option value="<?php echo $row->id_jalan;?>" selected><?php echo $row->nama_jalan;?></option>
									</select>
								</div>
							</div>
						
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="id_pel">ID Pelanggan</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="id_pel" name="id_pel" value="<?php echo $row->id_pel;?>" placeholder="ID Pelanggan">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="no_gardu">Nomor Gardu</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="no_gardu" name="no_gardu" value="<?php echo $row->no_gardu;?>" placeholder="Nomor Gardu">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="no_pal">Nomor PAL</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="no_pal" name="no_pal" value="<?php echo $row->no_pal;?>" placeholder="Nomor PAL">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="jenis">Jenis Lampu</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="jenis" name="jenis" value="<?php echo $row->jenis;?>" placeholder="Jenis Lampu">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="kwh">KWH</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="kwh" name="kwh" value="<?php echo $row->kwh;?>" placeholder="KWH">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="daya">Daya Lampu</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="daya" name="daya" value="<?php echo $row->daya;?>" placeholder="Daya Lampu">
								</div>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="posisi">Posisi Tiang</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="posisi" name="posisi" value="<?php echo $row->posisi;?>" placeholder="Posisi Tiang">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="kondisi">Kondisi Lampu</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="kondisi" name="kondisi" value="<?php echo $row->kondisi;?>" placeholder="Kondisi Lampu">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-4 col-form-label" for="keterangan">Keterangan</label>
								<div class="col-lg-8">
									<textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan"><?php echo $row->keterangan;?></textarea>
								</div>
							</div>
							
							<div id="wrap_foto">
								<div class="form-group row">
									<label class="col-lg-4 col-form-label" for="foto">Upload Foto PJU</label>
									<div class="col-lg-7">
										<input type="file" id="foto" name="foto[]">
									</div>
									<a href="javascript:void(0);" class="add_foto" title="Tambah foto">
										<label class="col-form-label"><i class="si si-plus fa-1x"></i></label>
									</a>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		
					
		<div class="row">
			<div class="col-lg-8">
				<?php echo $peta['html'];?>
			</div>
			
			<div class="col-lg-4">
				<div class="block block-themed">
				   <div class="block-header bg-gd-sea">
						<h3 class="block-title">Cari Lokasi</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option">
								<i class="si si-map"></i>
							</button>
						</div>
					</div>
					<div class="block-content">
						<div class="form-group row">
							<div class="col-lg-12">
								<div class="input-group">
									<input type="search" class="form-control" id="cari_lokasi" name="cari_lokasi" placeholder="Cari lokasi pengguna">
								</div>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-lg-6">
								<input type="text" class="form-control" id="lat" name="lat" value="<?php echo $row->lat;?>" placeholder="Latitude">
							</div>
							<div class="col-lg-6">
								<input type="text" class="form-control" id="lng" name="lng" value="<?php echo $row->lng;?>" placeholder="Longitude">
							</div>
						</div>
						
						<div class="row justify-content-center text-center">
							<div class="col-md-6">
								<button type="submit" class="btn btn-hero btn-primary mb-20 mt-20">
									<i class="fa fa-check mr-10"></i>KIRIM
								</button>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
			<?php } ?>
		</div>
	</div>
</main>

<script src="<?php echo base_url('js/core/jquery.min.js');?>"></script>
<script>
	$(document).ready(function(){
		var maxField = 3; //Input fields increment limitation
		var addButton = $('.add_foto'); //Add button selector
		var wrapper = $('#wrap_foto'); //Input field wrapper
		var fieldHTML = '<div class="form-group row"><label class="col-lg-4 col-form-label" for="foto">Upload Foto PJU</label><div class="col-lg-7"><input type="file" id="foto" name="foto[]"></div><a href="javascript:void(0);" class="hapus_foto" title="Hapus foto"><label class="col-form-label"><i class="si si-close fa-1x"></i></label></a></div>'; //New input field html 
		var x = 1; //Initial field counter is 1
		$(addButton).click(function(){ //Once add button is clicked
			if(x < maxField){ //Check maximum number of input fields
				x++; //Increment field counter
				$(wrapper).append(fieldHTML); // Add field html
			}
		});
		$(wrapper).on('click', '.hapus_foto', function(e){ //Once remove button is clicked
			e.preventDefault();
			$(this).parent('div').remove(); //Remove field html
			x--; //Decrement field counter
		});
	});
</script>