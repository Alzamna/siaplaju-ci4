<?php

namespace App\Controllers;

use App\Models\Model_app;
use App\Models\ModelApp;
use App\Libraries\Googlemaps;

class Kontak extends BaseController
{
    protected $model;
    protected $googlemaps;

    public function __construct()
    {
        $this->model = new Model_app();
        helper(['date']);

        $this->googlemaps = new Googlemaps();
    }

    public function index()
    {
        $confmap = [
            'center'     => '-7.006282, 109.139990',
            'zoom'       => 17,
            'map_height' => 400,
            'map_type'   => 'HYBRID',
        ];
        $this->googlemaps->initialize($confmap);

        $marker = [
            'position'  => '-7.006282, 109.139990',
            'animation' => 'DROP',
            'title'     => 'TIM PJU DINAS PERHUBUNGAN KABUPATEN TEGAL',
        ];
        $this->googlemaps->add_marker($marker);

        $data = [
            'title'        => 'Kontak TIM PJU Dinas Perhubungan Kabupaten Tegal',
            'aktif_kontak' => 'active',
            'peta'         => $this->googlemaps->create_map(),
        ];

        return view('home/pages/v_header', $data)
             . view('home/pages/v_kontak')
             . view('home/pages/v_footer');
    }
}
