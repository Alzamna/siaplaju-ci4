<main id="main-container">
	<!-- Page Content -->
	<div class="content">
		<div class="block block-themed">
		   <div class="block-header bg-gd-sea">
				<h3 class="block-title">DATA PENGADUAN</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-map"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<div class="row">
					<div class="col-lg-5">
						<?php echo $peta['html'];?>
						<br/>
					</div>
					<div class="col-lg-7">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-vcenter">
								<?php foreach($dt_pengaduan as $row){ 
								$id_pengaduan = $row->id_pengaduan;
								?>
								<tbody>
									<tr>
										<td>ID PENGADUAN</td>
										<td class="font-w600"><?php echo $row->id_pengaduan;?></td>
									</tr>
									<tr>
										<td>TANGGAL PENGADUAN</td>
										<td class="font-w600"><?php echo date("d M Y H:i:s",strtotime($row->tgl_pengaduan));?></td>
									</tr>
									<tr>
										<td>MEDIA PENGADUAN</td>
										<td class="font-w600"><?php echo $row->media;?></td>
									</tr>
									<tr>
										<td>PELAPOR</td>
										<td class="font-w600"><?php echo $row->pelapor;?></td>
									</tr>
									<tr>
										<td>NO TELP</td>
										<td class="font-w600"><?php echo $row->no_telp;?></td>
									</tr>
									<tr>
										<td>LAPORAN</td>
										<td class="font-w600"><?php echo $row->laporan;?></td>
									</tr>
									<tr>
										<td>RUAS JALAN</td>
										<td class="font-w600"><?php echo $row->nama_jalan;?></td>
									</tr>
								</tbody>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="block block-themed">
		   <div class="block-header bg-gd-lake">
				<h3 class="block-title">INPUT HASIL PERBAIKAN</h3>
				<div class="block-options">
					<button type="button" class="btn-block-option">
						<i class="si si-wrench"></i>
					</button>
				</div>
			</div>
			<div class="block-content">
				<form action="<?php echo site_url('adminpengaduan/proses_perbaikan/'.$row->id_pengaduan);?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly>
					<div class="row">
                        <div class="col-sm-6">
							<div class="form-group row">
								<label class="col-lg-3 col-form-label" for="tgl_perbaikan">Tgl Perbaikan</label>
								<div class="col-lg-9">
									<div class="input-group">
										<input type="text" class="js-datepicker form-control" id="tgl_perbaikan" name="tgl_perbaikan" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy-mm-dd" value="<?php echo date("Y-m-d H:i:s");?>">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-3 col-form-label" for="tindakan">Tindakan</label>
								<div class="col-lg-9">
									<textarea class="form-control" id="tindakan" name="tindakan" rows="5" placeholder="tindakan"></textarea>
								</div>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div id="wrap_foto">
								<div class="form-group row">
									<label class="col-lg-3 col-form-label" for="foto">Upload Foto</label>
									<div class="col-lg-6">
										<input type="file" id="foto" name="foto[]">
									</div>
									<a href="javascript:void(0);" class="add_foto" title="Tambah foto">
										<label class="col-form-label"><i class="si si-plus fa-1x"></i></label>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row justify-content-center text-center">
						<div class="col-md-6">
							<button type="submit" class="btn btn-hero btn-primary mb-20 mt-20">
								<i class="fa fa-check mr-10"></i>KIRIM
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>

<script src="<?php echo base_url('assets/js/core/jquery.min.js');?>"></script>
<script>
	$(document).ready(function(){
		var maxField = 5; //Input fields increment limitation
		var addButton = $('.add_foto'); //Add button selector
		var wrapper = $('#wrap_foto'); //Input field wrapper
		var fieldHTML = '<div class="form-group row"><label class="col-lg-3 col-form-label" for="foto">Upload Foto</label><div class="col-lg-6"><input type="file" id="foto" name="foto[]"></div><a href="javascript:void(0);" class="hapus_foto" title="Hapus foto"><label class="col-form-label"><i class="si si-close fa-1x"></i></label></a></div>'; //New input field html 
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