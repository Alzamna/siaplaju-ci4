<?php

namespace App\Controllers;

use App\Models\Model_app;

class Peta extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model_app();
        helper(['url', 'form']); 
    }

    public function index()
    {
        $confmap = [
            'center'     => '-6.99926531, 109.13596825',
            'zoom'       => 10,
            'map_height' => 500,
            'map_type'   => 'HYBRID',
        ];

        $data = [
            'title'        => 'Peta Lampu PJU Kabupaten Tegal',
            'aktif_peta'   => 'active',
            'dt_kecamatan' => $this->model->getAllKecamatan(),
            'dt_jenis'     => $this->model->getAllJenisLampu(),
            'dt_kondisi'   => $this->model->getAllKondisiLampu(),
            'peta'         => '' 
        ];

        return view('home/pages/v_header', $data)
            . view('home/peta/v_peta')
            . view('home/pages/v_footer');
    }

    public function fpeta()
    {
        $kec = $this->request->getPost('kecamatan') ?: "%%";
        $jln = $this->request->getPost('jalan') ?: "%%";

        $pju = $this->model->getFilterPetaPublik($kec, $jln);

        $confmap = [
            'center'     => '-6.99926531, 109.13596825',
            'zoom'       => 'auto',
            'map_height' => 500,
            'map_type'   => 'HYBRID',
        ];


        foreach ($pju as $row) {
            $icon = ($row->kondisi == 'H') ? base_url('assets/img/lampu-on.png') : base_url('assets/img/lampu-off.png');

            $marker = [
                'position'           => $row->lat . ',' . $row->lng,
                'infowindow_content' =>
                    '<center><h6>' . $row->nama_jalan . '</h6></center>
                    <table>
                        <tr><td><b>ID PJU</b></td><td>: ' . $row->id_pju . '</td></tr>
                        <tr><td><b>NAMA JALAN</b></td><td>: ' . $row->nama_jalan . '</td></tr>
                        <tr><td><b>KECAMATAN</b></td><td>: ' . $row->nama_kecamatan . '</td></tr>
                        <tr><td><b>JENIS LAMPU</b></td><td>: ' . $row->jenis . '</td></tr>
                        <tr><td><b>DAYA LAMPU</b></td><td>: ' . $row->daya . '</td></tr>
                        <tr><td><b>KONDISI LAMPU</b></td><td>: ' . $row->kondisi . '</td></tr>
                    </table>
                    <center><a href="' . site_url('peta/lihat/' . $row->id_pju) . '" target="_blank">Lihat Selengkapnya</a></center>',
                'icon'               => $icon,
            ];

        }

        $data = [
            'title'        => 'Peta Lampu PJU Kabupaten Tegal',
            'aktif_peta'   => 'active',
            'dt_pju'       => $this->model->getGroupFilterPeta($kec, $jln),
            'dt_jln'       => $jln,
            'dt_kecamatan' => $this->model->getAllKecamatan(),
            'dt_jenis'     => $this->model->getAllJenisLampu(),
            'dt_kondisi'   => $this->model->getAllKondisiLampu(),
            'peta'         => '' 
        ];

        return view('home/pages/v_header', $data)
            . view('home/peta/v_peta')
            . view('home/pages/v_footer');
    }

    public function lihat($id = null)
    {
        if (!$id) {
            $id = $this->request->getUri()->getSegment(3);
        }

        $pju = $this->model->getLihatPju($id);

        foreach ($pju as $row) {
            $confmap = [
                'map_height' => 300,
                'map_type'   => 'HYBRID',
                'center'     => $row->lat . ',' . $row->lng,
                'zoom'       => 19,
            ];

            $icon = ($row->kondisi == 'H') ? base_url('assets/img/lampu-on.png') : base_url('assets/img/lampu-off.png');

            $marker = [
                'position'  => $row->lat . ',' . $row->lng,
                'animation' => 'DROP',
                'icon'      => $icon,
            ];
        }

        $data = [
            'title'      => 'Lihat Lampu PJU',
            'aktif_peta' => 'active',
            'peta'       => '', 
            'dt_pju'     => $pju,
        ];

        return view('home/pages/v_header', $data)
            . view('home/peta/v_lihat_peta')
            . view('home/pages/v_footer');
    }

    public function get_jalan()
	{
		$id = $this->request->getGet('id'); 
		$jalan = $this->model->getSelectedData('tbl_jalan', ['id_kecamatan' => $id]);
		return $this->response->setJSON($jalan);
	}

}
