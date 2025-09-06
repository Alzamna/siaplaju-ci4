<?php

namespace App\Controllers;

use App\Libraries\Googlemaps;
use App\Models\Model_app;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Aspirasi extends BaseController
{
    protected $model;
    protected $googlemaps;

    public function __construct()
    {
        $this->model = new Model_app();
        helper(['form', 'text']);
        $this->googlemaps = new Googlemaps(); 
    }

    public function index()
    {
        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 12;

        $total = $this->model->getJmlAspirasi();

        $aspirasi = $this->model->getAllAspirasi($perPage, ($page - 1) * $perPage);

        $pager = \Config\Services::pager();
        $pagerLinks = $pager->makeLinks($page, $perPage, $total, 'default_full');

        $data = [
            'title'         => 'Aspirasi Masyarakat Perencanaan Pemasangan Lampu PJU',
            'aktif_aspirasi'=> 'active',
            'dt_aspirasi'   => $aspirasi,
            'pager'         => $pagerLinks,
        ];

        return view('home/pages/v_header', $data)
            . view('home/aspirasi/v_aspirasi', $data)
            . view('home/pages/v_footer');
    }


    public function input()
    {
        $confmap = [
            'center' => '-6.99926531, 109.13596825',
            'zoom' => 10,
            'map_height' => 400,
            'map_type' => 'HYBRID',
            'onload' => 'ControlLokasi();',
            'onclick' => 'updateKoordinat(event.latLng.lat(), event.latLng.lng());setMapOnAll(map);clearMarker(); createMarker_map({ map: map, position:event.latLng });',
            'places' => TRUE,
            'placesAutocompleteInputID' => 'cari',
            'placesAutocompleteBoundsMap' => TRUE,
            'placesAutocompleteOnChange' => 'PlacesLokasi();',
        ];

        // inisialisasi googlemaps (pastikan sudah di-porting ke CI4 sebagai service/library)
        $this->googlemaps->initialize($confmap);

        // hasil create_map
        $peta = $this->googlemaps->create_map();

        $data = [
            'title'          => 'Aspirasi Masyarakat Perencanaan Pemasangan Lampu PJU',
            'aktif_aspirasi' => 'active',
            'peta'           => $peta, 
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
