<?php

namespace App\Controllers;

use App\Models\Model_app;

class Beranda extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Model_app();
        helper(['date', 'text']); 
    }

    public function index()
    {
        $data = [
            'title'        => 'Sistem Informasi Alat Penerangan Lampu Jalan Umum Kabupaten Tegal',
            'aktif_beranda'=> 'active',
            'dt_pengaduan' => $this->model->getPengaduanBeranda(),
        ];

        return view('home/pages/v_header', $data)
             . view('home/pages/v_beranda')
             . view('home/pages/v_footer');
    }
}
