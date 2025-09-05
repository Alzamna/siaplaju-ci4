			<!-- Footer -->
            <footer id="page-footer" class="opacity-0">
                <div class="content py-20 font-size-xs clearfix">
                    <div class="float-right">
                        Crafted with <i class="fa fa-heart text-pulse"></i> by <a class="font-w600" href="https://duamedia.net">CV. CVV</a>
                    </div>
                    <div class="float-left">
                        <a class="font-w600" href="#" target="_blank">SIPELAJU DINAS PERHUBUNGAN KAB. TEGAL</a> &copy; <span class="js-year-copy">2018</span>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <!-- Codebase Core JS -->
        <script src="<?php echo base_url('assets/js/core/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/core/popper.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/core/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/core/jquery.slimscroll.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/core/jquery.scrollLock.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/core/jquery.appear.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/core/jquery.countTo.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/core/js.cookie.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/codebase.js');?>"></script>

        <!-- Page JS Plugins -->
        <script src="<?php echo base_url('assets/js/plugins/chartjs/Chart.bundle.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap4.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/select2/select2.full.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/plugins/masked-inputs/jquery.maskedinput.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js');?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/jquery-validation/jquery.validate.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/magnific-popup/magnific-popup.min.js');?>"></script>
		
        <!-- Page JS Code -->
        <script src="<?php echo base_url('assets/js/pages/be_pages_dashboard.js');?>"></script>
		<script src="<?php echo base_url('assets/js/pages/be_tables_datatables.js');?>"></script>
		<script src="<?php echo base_url('assets/js/pages/be_forms_plugins.js');?>"></script>
		<script src="<?php echo base_url('assets/js/pages/be_forms_wizard.js');?>"></script>
        <script>
            jQuery(function () {
                // Init page helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
                Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs','magnific-popup']);
				
				$("#select_produk").on("select2:select",function(e){
					var id_pop = $("#select_produk").val();
					var post_data = {
					   'id_pop': id_pop,
					   '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
					};

					$.ajax({
						type: "post",
						url : "<?php echo base_url('maintenance/get_produk'); ?>",
						data: post_data,
						success:function(data){
							$('#ajax_produk').html(data)
						}
					});
				});
				
				$("#select-kecamatan").on("select2:select",function(e){
					var kec = $("#select-kecamatan").val();
					$.ajax({
						url: "<?php echo base_url('adminpju/get_jalan'); ?>",
						type: 'GET',
						data: {
							'id':kec,
						},
						success: function(data){
							// alert();
							console.log(data);
							// $('#makul_id').html(data);
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
				
				$("#pilih_pengguna").on("select2:select",function(e){
					var pengguna = $("#pilih_pengguna").val();
					$.ajax({
						url: "<?php echo base_url('master/get_pengguna'); ?>",
						type: 'GET',
						data: {
							'id':pengguna,
						},
						success: function(response){
							var obj = JSON.parse(response);
							if(obj == ""){
								
							} else {
								$("#nama_pj").val(obj[0].nama_pj);
								$("#telepon").val(obj[0].telepon);
								$("#kota").val(obj[0].nama_kabupaten);
							}
						}
					});
				});
			});
			
			function updateKoordinat(newLat, newLng)
			{
				$('#lat').val(newLat);
				$('#lng').val(newLng);
			}
        </script>
    </body>
</html>