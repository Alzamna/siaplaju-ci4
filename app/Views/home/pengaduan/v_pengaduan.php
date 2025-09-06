<?php if (session()->getFlashdata('sukses')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('sukses') ?>
    </div>
<?php endif; ?>

<section class="nopadding">
    <div class="container">
        <header class="text-center margin-bottom-10 margin-top-10">
            <h2 class="nomargin">PENGADUAN LAMPU PENERANGAN JALAN UMUM</h2>
            <p class="font-lato size-20 nomargin">KABUPATEN TEGAL</p>
        </header>

        <div class="divider divider-circle divider-color divider-center">
            <i class="glyphicon glyphicon-earphone"></i>
        </div>

        <div class="row text-center">
            <div class="col-md-4 col-md-offset-4">
                <a href="<?= site_url('pengaduan/input') ?>" class="btn btn-3d btn-blue">
                    <i class="glyphicon glyphicon-earphone"></i> KLIK INPUT PENGADUAN
                </a>
            </div>
        </div>
    </div>
</section>

<div class="container margin-top-20">
    <div class="row">
        <?php if (!empty($dt_pengaduan)): ?>
            <?php foreach ($dt_pengaduan as $row): ?>
                <?php
                    $panel = 'panel-default';
                    if ($row->status == 2) $panel = 'panel-info';
                    if ($row->status == 3) $panel = 'panel-warning';
                    if ($row->status == 4) $panel = 'panel-success';
                ?>
                <div class="col-md-4">
                    <div class="panel <?= $panel ?>">
                        <div class="panel-heading">
                            <ul class="text-left size-12 list-inline nomargin">
                                <li><i class="fa fa-user"></i> <?= esc($row->pelapor) ?></li>
                                <li class="pull-right"><i class="fa fa-calendar"></i> <?= date("d-m-Y H:i:s", strtotime($row->tgl_pengaduan)) ?></li>
                            </ul>
                        </div>

                        <div class="panel-body">
                            <a href="<?= site_url('pengaduan/lihat/'.$row->id_pengaduan) ?>" target="_blank">
                                <?php if (!empty($row->foto) && file_exists(FCPATH.'upload/foto/pengaduan/'.$row->foto)): ?>
                                    <img class="img-responsive img-thumbnail" 
                                         src="<?= base_url('upload/foto/pengaduan/'.$row->foto) ?>" 
                                         alt="Foto Pengaduan">
                                <?php else: ?>
                                    <div class="text-center text-muted">Tidak ada foto</div>
                                <?php endif; ?>
                                <hr/>
                                <p class="lead text-center text-default">Baca Pengaduan</p>
                            </a>

                            <div class="alert alert-mini alert-info margin-bottom-10">
                                <p class="text-left"><?= word_limiter($row->laporan, 30) ?></p>
                            </div>

                            <ul class="text-left size-12 list-inline nomargin">
                                <li><i class="fa fa-file"></i> <?= $row->id_pengaduan ?></li>
                                <li class="pull-right">
                                    <i class="fa fa-hourglass-2"></i>
                                    <?php
                                        if ($row->status == 2) echo "Pengaduan Diverifikasi";
                                        elseif ($row->status == 3) echo "Pengaduan Dalam Proses";
                                        elseif ($row->status == 4) echo "Pengaduan Selesai";
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Belum ada pengaduan.</p>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <?= $pager ?>
    </div>
</div>
