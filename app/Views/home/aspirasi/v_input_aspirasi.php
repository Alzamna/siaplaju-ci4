<?php if (session()->getFlashdata('sukses')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('sukses') ?>
    </div>
<?php endif; ?>
<section class="page-header page-header-xs">
	<div class="container">
		<h1>ASPIRASI MASYARAKAT</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('');?>">Beranda</a></li>
			<li><a href="<?php echo site_url('aspirasi');?>">Aspirasi</a></li>
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
		
		<div class="alert alert-mini alert-info margin-bottom-20 margin-top-20"><!-- INFO -->
			<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span>
				<span class="sr-only">Close</span>
			</button>
			<strong>Perhatian!</strong> Harap mengisikan formulir aspirasi dengan benar karena aspirasi yang anda masukan akan menjadi dasar perencanaan kegiatan kami.
		</div>

		<article class="row margin-top-10">
			<div class="col-md-7">
				<form action="<?php echo site_url('aspirasi/proses_aspirasi');?>" method="post" enctype="multipart/form-data">
					<?= csrf_field() ?>
					<fieldset>
						<div class="row">
							<div class="form-group">
								<div class="col-md-5 col-sm-5">
									<label>Nomor KTP *</label>
									<input type="text" name="no_ktp" placeholder="3328xxxx"  data-format="9999999999999999" data-placeholder="*" class="form-control masked" required="">
								</div>
								<div class="col-md-7 col-sm-7">
									<label>Nama Lengkap *</label>
									<input type="text" name="nama" placeholder="Contoh : Agus Sutrisno"  class="form-control" required="">
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="form-group">
								<div class="col-md-5 col-sm-5">
									<label>Nomor Telepon *</label>
									<input type="text" name="no_telp" placeholder="Nomor Telepon"  class="form-control" required="">
								</div>
								<div class="col-md-7 col-sm-7">
									<label>Alamat *</label>
									<textarea name="alamat" rows="3" class="form-control required" required="" placeholder="Alamat " required=""></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<div class="col-md-12 col-sm-12">
									<label>Aspirasi Anda *</label>
									<textarea name="aspirasi" rows="5" class="form-control required" required="" placeholder="Contoh : Jalan kapten ismail di kecamatan slawi belum terdapat lampu PJU, mohon untuk dipasangkan lampu PJU mobilitas masyarakat dijalan tersebut ramai" required=""></textarea>
								</div>
							</div>
						</div>
						
						<div id="wrap_foto">
							<div class="row">
								<div class="form-group">
									<div class="col-md-10">
										<label>
											Lampiran file/foto
										</label>
										<input class="custom-file-upload" name="foto[]" type="file" id="file" data-btn-text="Pilih Lampiran" />
										<small class="text-muted block">Anda dapat melampirkan foto maksimal 5 foto</small>
									</div>

									<label><br/></label>
									<a href="javascript:void(0);" class="add_foto" title="Tambah foto">
										<button type="button" class="btn btn-link"><i class="glyphicon glyphicon-plus-sign"></i></button>
									</a>
								</div>
							</div>
						</div>
						
						<br/>
						
						<input type="hidden" name="lat" id="lat" class="form-control">
						<input type="hidden" name="lng" id="lng" class="form-control">
						
						<div class="row">
							<div class="form-group">
								<div class="col-md-12">
									<label>
										Nama jalan atau lokasi
									</label>
									<input type="text" id="cari" placeholder="Contoh : jalan kapten ismail slawi"  class="form-control">
								</div>
							</div>
						</div>
						
						<div class="row">
							<?php echo $peta['html'];?>
						</div>
					</fieldset>

					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-3d btn-primary btn-xlg btn-block margin-top-10">
								KIRIM ASPIRASI
							</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-5">
				<div class="panel panel-info">
					<div class="panel-heading">
						PETUNJUK ASPIRASI
					</div>
				
					<div class="panel-body">
						<ol>
							<li>Anda diwajibkan untuk mengisikan kolom nomor KTP, nama lengkap, alamat, nomor telepon, dan aspirasi pada formulir aspirasi.</li>
							<li>Masyarakat dimohon untuk mengisi formulir aspirasi dengan lengkap dan benar, identitas masyarakat tidak akan ditampilkan dipublik tetapi hanya untuk data kami dalam perencanaan kegiatan.</li>
							<li>Jika terdapat foto/file dapat dilampirkan sebagai file pendukung.</li>
							<li>Jika anda mengetahui lokasi jalan yang diajukan. Anda dapat mengetikan nama jalan pada form jalan dan mengklik jalan yang diajukan pada peta</li>
							<li>Jika anda bingung dalam mengisi formulir aspirasi anda mendownload petunjuk penggunaan pada menu dibawah ini</li>
						</ol>
					</div>
				</div>
		</article>
	</div>
</section>
