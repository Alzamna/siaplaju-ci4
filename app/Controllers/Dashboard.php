<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $session = session();
        if ($session->get('login') != 1) {
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        $this->isLoggedIn();

        $data = [
            'title'            => 'Dashboard SIAPLAJU',
            'open_dashboard'   => 'open',
            'aktif_dashboard'  => 'active',
        ];

        return view('pages/v_header', $data)
             . view('pages/v_dashboard')
             . view('pages/v_footer');
    }
}
