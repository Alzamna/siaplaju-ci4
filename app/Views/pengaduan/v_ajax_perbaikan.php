<?php 
	foreach($dt_pengaduan as $row){
?>
<div class="modal fade" id="perbaikan-<?php echo $row->id_pengaduan;?>" tabindex="-1" role="dialog" aria-labelledby="user-edit" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-popout" role="document">
		<div class="modal-content">
		<form action="<?php echo site_url('adminpengaduan/proses_perbaikan/'.$row->id_pengaduan);?>" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header">
					<h3 class="block-title">Input Hasil Perbaikan</h3>
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
							<textarea class="form-control" id="laporan" name="laporan" rows="4" readonly><?php echo $row->laporan;?></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-lg-2 col-form-label" for="tindak">Tindakan</label>
						<div class="col-lg-10">
							<textarea class="form-control" id="tindakan" name="tindakan" rows="4"></textarea>
						</div>
					</div>
					
					<div id="wrap_foto">
						<div class="form-group row">
							<label class="col-lg-2 col-form-label" for="foto">Upload Foto</label>
							<div class="col-lg-4">
								<input type="file" id="foto" name="foto[]">
							</div>
							<a href="javascript:void(0);" class="add_foto" title="Tambah foto">
								<label class="col-form-label"><i class="si si-plus fa-1x"></i></label>
							</a>
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

<script src="<?php echo base_url('assets/js/core/jquery.min.js');?>"></script>
<script>
	$(document).ready(function(){
		var maxField = 5; //Input fields increment limitation
		var addButton = $('.add_foto'); //Add button selector
		var wrapper = $('#wrap_foto'); //Input field wrapper
		var fieldHTML = '<div class="form-group row"><label class="col-lg-2 col-form-label" for="foto">Upload Foto</label><div class="col-lg-4"><input type="file" id="foto" name="foto[]"></div><a href="javascript:void(0);" class="hapus_foto" title="Hapus foto"><label class="col-form-label"><i class="si si-close fa-1x"></i></label></a></div>'; //New input field html 
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