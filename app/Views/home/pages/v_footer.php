			<!-- FOOTER -->
			<footer id="footer">
				<div class="copyright">
					<div class="container">
						Copyright &copy; <?php echo date("Y");?>. SIAPLAJU Dinas Perhubungan Kabupaten Tegal. All Rights Reserved.
					</div>
				</div>
			</footer>
			<!-- /FOOTER -->

		</div>
		<!-- /wrapper -->


		<!-- SCROLL TO TOP -->
		<a href="#" id="toTop"></a>
		
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = '<?php echo base_url('home/plugins')?>/';</script>
		<script type="text/javascript" src="<?php echo base_url('home/plugins/jquery/jquery-2.1.4.min.js')?>"></script>

		<script type="text/javascript" src="<?php echo base_url('home/js/scripts.js')?>"></script>

		<!-- REVOLUTION SLIDER -->
		<script type="text/javascript" src="<?php echo base_url('home/plugins/slider.revolution/js/jquery.themepunch.tools.min.js')?>"></script>
		<script type="text/javascript" src="<?php echo base_url('home/plugins/slider.revolution/js/jquery.themepunch.revolution.min.js')?>"></script>
		<script type="text/javascript" src="<?php echo base_url('home/js/view/demo.revolution_slider.js')?>"></script>
		<script>
            jQuery(function () {
				$("#select-kecamatan").on("select2:select",function(e){
					var kec = $("#select-kecamatan").val();
					$.ajax({
						url: "<?php echo base_url('peta/get_jalan'); ?>",
						type: 'GET',
						data: {
							'id':kec,
						},
						success: function(data){
							// alert();
							console.log(data);
							$("#select-jalan").html("");
							$("#select-jalan").append(
								"<option value='%%'>Semua jalan</option>"
							);
							$.each(JSON.parse(data),function(key,i){
								console.log(this.id);
								 $("#select-jalan").append(
									 "<option value="+this.id_jalan+">"+this.nama_jalan+"</option>"
									 );
							});
						},
						failed: function(data){
							alert('Gagal mendapatkan jalan!');
						}
					});
				});
			});
			
			$(document).ready(function(){
				var maxField = 5; //Input fields increment limitation
				var addButton = $('.add_foto'); //Add button selector
				var wrapper = $('#wrap_foto'); //Input field wrapper
				var fieldHTML = '<div class="row"><div class="form-group"><div class="col-md-10"><input class="custom-file-upload" name="foto[]" type="file" id="file" data-btn-text="Pilih Lampiran" /></div><a href="javascript:void(0);" class="hapus_foto" title="Tambah foto"><button type="button" class="btn btn-link"><i class="glyphicon glyphicon-minus-sign"></i></button></a></div></div>'; //New input field html 
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
			
			function updateKoordinat(newLat, newLng){
				$('#lat').val(newLat);
				$('#lng').val(newLng);
			}
        </script>
	</body>
</html>