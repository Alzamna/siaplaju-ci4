<section class="page-header page-header-xs">
	<div class="container">
		<h1>FORMULIR PENGADUAN LAMPU PJU</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('');?>">Beranda</a></li>
			<li><a href="<?php echo site_url('pengaduan');?>">Pengaduan</a></li>
		</ol>
	</div>
</section>

<section class="nopadding">
	<div class="container">
		<?php
			if (isset($error)){
				echo '<div class="alert alert-mini alert-danger margin-bottom-30">'. $error .'</div>';
			}
		?>
		<article class="row margin-top-10">
			<div class="col-md-7">
				<form action="<?php echo site_url('pengaduan/proses_input_pengaduan');?>" method="post" enctype="multipart/form-data">
					<?= csrf_field() ?>
					<fieldset>
						<div class="row">
							<div class="form-group">
								<div class="col-md-6 col-sm-6">
									<label>Nama Lengkap *</label>
									<input type="text" name="nama" placeholder="Contoh : Agus Sutrisno"  class="form-control" required="">
								</div>
								<div class="col-md-6 col-sm-6">
									<label>Nomor Whatsapp/ Telepon *</label>
									<input type="text" name="telp" placeholder="Nomor Whatsapp aktif / telepon"  class="form-control" required="">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<div class="col-md-12 col-sm-12">
									<label>Laporan anda *</label>
									<textarea name="isi" rows="5" class="form-control required" required="" placeholder="Contoh : Lampu PJU mati di ruas jalan raya talang depan minimarket kita sampai pasar pesayangan desa talang kecamatan talang" required=""></textarea>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="form-group">
								<div class="col-md-12">
									<label>
										Lampiran file/foto
									</label>
									<input class="custom-file-upload" name="foto" type="file" id="file" data-btn-text="Pilih Lampiran" />
									<small class="text-muted block">Jika terdapat file/foto dapat dilampirkan sebagai file pendukung</small>
								</div>
							</div>
						</div>
					</fieldset>

					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-3d btn-primary btn-xlg btn-block margin-top-10">
								KIRIM LAPORAN
							</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-5">
				<div class="panel panel-info">
					<div class="panel-heading">
						PETUNJUK PENGADUAN
					</div>
				
					<div class="panel-body">
						<ol>
							<li>Anda diwajibkan untuk mengisikan kolom nama lengkap, nomor telepon, dan laporan pada formulir pengaduan.</li>
							<li>Pelapor diharapkan untuk mengisikan laporan lokasi lampu PJU yang mati secara lengkap dan jelas guna mempercepat proses perbaikan.</li>
							<li>Pelapor dimohon untuk mengisi formulir pengaduan dengan lengkap dan benar, data nama lengkap dan nomor telepon pelapor yang ditampilkan akan disamarkan.</li>
							<li>Jika terdapat foto/file dapat dilampirkan sebagai file pendukung.</li>
							<li>Perbaikan lampu PJU akan dilaksanakan secepat mungkin setelah laporan kami terima.</li>
						</ol>
					</div>
				</div>
		</article>
	</div>
</section>
