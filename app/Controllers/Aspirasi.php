<?php

namespace App\Controllers;

use App\Models\Model_app;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Aspirasi extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model_app();
        helper(['form', 'text']);
        // kalau ada library custom kayak googlemaps, harus bikin service/helper di CI4
    }

    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 12;

        $total = $this->model->getJmlAspirasi();

        $data = [
            'title'         => 'Aspirasi Masyarakat Perencanaan Pemasangan Lampu PJU',
            'aktif_aspirasi'=> 'active',
            'dt_aspirasi'   => $this->model->getAllAspirasi($perPage, ($page - 1) * $perPage),
            'pager'         => \Config\Services::pager()->makeLinks($page, $perPage, $total),
        ];

        return view('home/pages/v_header', $data)
             . view('home/aspirasi/v_aspirasi')
             . view('home/pages/v_footer');
    }

    public function input()
    {
        // Catatan: googlemaps library CI3 harus di-porting ke CI4 dulu
        $data = [
            'title'         => 'Aspirasi Masyarakat Perencanaan Pemasangan Lampu PJU',
            'aktif_aspirasi'=> 'active',
            'peta'          => '' // nanti isi dari service googlemaps custom
        ];

        return view('home/pages/v_header', $data)
             . view('home/aspirasi/v_input_aspirasi')
             . view('home/pages/v_footer');
    }

    public function proses_aspirasi()
    {
        $id = $this->model->getKodeAspirasi();

        // multiple upload
        $files = $this->request->getFiles();
        if ($files && isset($files['foto'])) {
            foreach ($files['foto'] as $i => $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = 'ASP' . $id . $i . '.' . $img->getExtension();
                    $img->move(FCPATH . 'upload/foto/aspirasi/', $newName);

                    $this->model->insertData('tbl_aspirasi_foto', [
                        'id_aspirasi' => $id,
                        'nama_foto'   => $newName
                    ]);
                }
            }
        }

        $data = [
            'id_aspirasi' => $id,
            'tgl_aspirasi'=> Time::now(),
            'no_ktp'      => $this->request->getPost('no_ktp'),
            'nama'        => $this->request->getPost('nama'),
            'no_telp'     => $this->request->getPost('no_telp'),
            'alamat'      => $this->request->getPost('alamat'),
            'aspirasi'    => $this->request->getPost('aspirasi'),
            'lat'         => $this->request->getPost('lat'),
            'lng'         => $this->request->getPost('lng'),
        ];

        $this->model->insertData('tbl_aspirasi', $data);

        return redirect()->to('aspirasi')->with('sukses', 'Terima kasih atas informasinya...');
    }
}
