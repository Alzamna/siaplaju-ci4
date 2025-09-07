<?php

namespace App\Controllers;

use App\Models\Model_backend;
use CodeIgniter\Controller;
use Config\Services;

class Adminaspirasi extends BaseController
{
    protected $model;
    protected $session;
    protected $pager;
    protected $googlemaps;

    public function __construct()
    {
        $this->model   = new Model_backend();
        $this->session = Services::session();
        $this->pager   = Services::pager();
        $this->googlemaps = service('googlemaps'); 
        helper(['url', 'text']);

        // Cek login
        if ($this->session->get('login') != 1) {
            return redirect()->to('login');
        }
    }

    public function index()
    {
        $perPage = 20;

        $uri   = service('uri');
        $dari  = ($uri->getTotalSegments() >= 3) ? (int) $uri->getSegment(3) : 0;

        $num = $this->model->getJmlAspirasi();

        $aspirasi = $this->model->getAllAspirasi($perPage, $dari);

        $pager = \Config\Services::pager();
        $pager_links = $pager->makeLinks($dari, $perPage, $num);

        $data = [
            'title'          => 'Aspirasi LPJU Kabupaten Tegal',
            'open_aspirasi'  => 'open',
            'aktif_aspirasi' => 'active',
            'dt_aspirasi'    => $aspirasi,
            'pager'          => $pager_links,
            'start'          => $dari,
        ];

        return view('pages/v_header', $data)
            . view('aspirasi/v_aspirasi', $data)
            . view('pages/v_footer');
    }

    public function verifikasi($id = null)
    {
        // Konfigurasi peta
        $confmap = [
            'center'                       => '-6.99926531, 109.13596825',
            'zoom'                         => 11,
            'map_height'                   => 500,
            'map_type'                     => 'HYBRID',
            'places'                       => true,
            'placesAutocompleteInputID'    => 'cari_lokasi',
            'placesAutocompleteBoundsMap'  => true,
            'placesAutocompleteOnChange'   => 'PlacesLokasi();',
            'onclick'                      => 'updateKoordinat(event.latLng.lat(), event.latLng.lng());setMapOnAll(map);clearMarker(); createMarker_map({ map: map, position:event.latLng });',
        ];

        // Panggil library googlemaps
        $googlemaps = service('googlemaps');
        $googlemaps->initialize($confmap);

        // Ambil data aspirasi dari model
        $dtAspirasi = $this->model->getDataAspirasi($id);

        // Siapkan data untuk dikirim ke view
        $data = [
            'title'          => 'Verifikasi Aspirasi LPJU',
            'open_aspirasi'  => 'open',
            'aktif_aspirasi' => 'active',
            'dt_aspirasi'    => $dtAspirasi,
            'peta'           => $googlemaps->create_map(),
        ];

        // Return view dengan template CI4
        return view('pages/v_header', $data)
            . view('aspirasi/v_verifikasi')
            . view('pages/v_footer');
    }


    public function lihat($id = null)
    {
        $idx = ['id_aspirasi' => $id];
        $asp = $this->model->getDataAspirasi($id);

        $googlemaps = service('googlemaps');

        foreach ($asp as $row) {
            $confmap = [
                'map_height' => 400,
                'map_type'   => 'HYBRID',
                'center'     => $row->lat . ',' . $row->lng,
                'zoom'       => 17,
            ];
            $googlemaps->initialize($confmap);

            $marker = [
                'position'  => $row->lat . ',' . $row->lng,
                'animation' => 'DROP',
            ];
            $googlemaps->add_marker($marker);
        }

        $data = [
            'title'          => 'Lihat Aspirasi',
            'open_aspirasi'  => 'open',
            'aktif_aspirasi' => 'active',
            'peta'           => $googlemaps->create_map(),
            'dt_aspirasi'    => $asp,
            'dt_foto'        => $this->model->getSelectedData('tbl_aspirasi_foto', $idx),
        ];

        return view('pages/v_header', $data)
             . view('aspirasi/v_lihat_aspirasi')
             . view('pages/v_footer');
    }

    public function cari()
    {
        $id = $this->request->getPost('cari');

        $data = [
            'title'          => 'Aspirasi LPJU Kabupaten Tegal',
            'open_aspirasi'  => 'open',
            'aktif_aspirasi' => 'active',
            'dt_aspirasi'    => $this->model->getCariAspirasi($id),
            'start'          => 0,
        ];

        return view('pages/v_header', $data)
             . view('aspirasi/v_aspirasi')
             . view('pages/v_footer');
    }

    public function hapus($id = null)
    {
        $idx = ['id_aspirasi' => $id];
        $data = ['aktif' => 0];

        $this->model->updateData('tbl_aspirasi', $data, $idx);

        return redirect()->to('adminaspirasi');
    }
}
