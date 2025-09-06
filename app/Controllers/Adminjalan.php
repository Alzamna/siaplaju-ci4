<?php

namespace App\Controllers;

use App\Models\Model_backend;
use CodeIgniter\Controller;

class Adminjalan extends BaseController
{
    protected $model;
    protected $session;
    protected $googlemaps; 

    public function __construct()
    {
        $this->model = new Model_backend();
        $this->session = \Config\Services::session();
        $this->googlemaps = new \App\Libraries\Googlemaps(); 

        helper(['text', 'form']);
    }

    public function index()
    {
        if ($this->session->get('login') != 1) {
            return redirect()->to('/login');
        }

        $data = [
            'title'        => 'Data Jalan Kabupaten Tegal',
            'open_jalan'   => 'open',
            'aktif_jalan'  => 'active',
            'dt_jalan'     => $this->model->getDataJalan(),
            'dt_kecamatan' => $this->model->getAllKecamatan(),
        ];

        return view('pages/v_header', $data)
             . view('jalan/v_jalan')
             . view('pages/v_footer');
    }

    public function proses_tambah_jalan()
    {
        $data = [
            'nama_jalan'   => $this->request->getPost('nama_jalan'),
            'id_kecamatan' => $this->request->getPost('kecamatan'),
            'status_jalan' => $this->request->getPost('status_jalan'),
            'panjang_jalan'=> $this->request->getPost('panjang_jalan'),
        ];

        $this->model->insertData('tbl_jalan', $data);
        return redirect()->to('/adminjalan');
    }

    public function proses_edit_jalan($id)
    {
        $data = [
            'nama_jalan'   => $this->request->getPost('nama_jalan'),
            'id_kecamatan' => $this->request->getPost('kecamatan'),
            'status_jalan' => $this->request->getPost('status_jalan'),
            'panjang_jalan'=> $this->request->getPost('panjang_jalan'),
        ];

        $this->model->updateData('tbl_jalan', $data, ['id_jalan' => $id]);
        return redirect()->to('/adminjalan');
    }

    public function hapus_jalan($id)
    {
        $this->model->deleteData('tbl_jalan', ['id_jalan' => $id]);
        return redirect()->to('/adminjalan');
    }

    public function lihat($id)
    {
        $pju = $this->model->getLihatJalan($id);

        foreach ($pju as $row) {
            $confmap = [
                'map_height' => 400,
                'map_type'   => 'HYBRID',
                'center'     => $row->lat . ',' . $row->lng,
                'zoom'       => 'auto',
            ];
            $this->googlemaps->initialize($confmap);

            $icon = ($row->kondisi == 'H') 
                ? base_url('assets/img/lampu-on.png') 
                : base_url('assets/img/lampu-off.png');

            $marker = [
                'position'  => $row->lat . ',' . $row->lng,
                'animation' => 'DROP',
                'icon'      => $icon,
            ];
            $this->googlemaps->add_marker($marker);
        }

        $data = [
            'title'        => 'Data Jalan',
            'open_jalan'   => 'open',
            'aktif_jalan'  => 'active',
            'peta'         => $this->googlemaps->create_map(),
            'dt_jalan'     => $this->model->getJalan($id),
            'dt_perbaikan' => $this->model->getPengaduanJalan($id),
            'dt_pju'       => $pju,
        ];

        return view('pages/v_header', $data)
             . view('jalan/v_lihat_jalan')
             . view('pages/v_footer');
    }

    public function get_jalan()
    {
        $id = ['id_kecamatan' => $this->request->getGet('id')];
        $jalan = $this->model->getSelectedData('tbl_jalan', $id)->getResultArray();
        return $this->response->setJSON($jalan);
    }
}
