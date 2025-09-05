<?php

namespace App\Controllers;

use App\Models\Model_app;
use App\Models\ModelApp;
use CodeIgniter\Controller;

class Login extends BaseController
{
    protected $model;
    protected $validation;

    public function __construct()
    {
        $this->model = new Model_app();
        $this->validation = \Config\Services::validation();
        helper(['form', 'date']);
    }

    public function index()
    {
        // Aturan validasi
        $rules = [
            'login-username' => 'required',
            'login-password' => 'required'
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Login Admin SIAPLAJU',
            ];
            return view('pages/v_login', $data);
        } else {
            $hasil = $this->cek_akun();
            switch ($hasil) {
                case 'login_sukses':
                    return redirect()->to('dashboard');

                case 'password_salah':
                    return view('pages/v_login', [
                        'title' => 'Login Admin SIAPLAJU',
                        'error' => 'Login gagal, pastikan password yang anda masukan benar',
                    ]);

                case 'akun_belum_aktif':
                    return view('pages/v_login', [
                        'title' => 'Login Admin SIAPLAJU',
                        'error' => 'Login gagal, akun tidak aktif. Silahkan hubungi admin',
                    ]);

                case 'akun_tidak_ditemukan':
                    return view('pages/v_login', [
                        'title' => 'Login Admin SIAPLAJU',
                        'error' => 'Login gagal, pastikan username dan password yang anda masukan benar',
                    ]);
            }
        }
    }

    private function cek_akun()
    {
        $username = $this->request->getPost('login-username');
        $password = $this->request->getPost('login-password');

        $db = \Config\Database::connect();
        $sql = "SELECT * FROM tbl_user a 
                INNER JOIN tbl_akses b ON a.id_akses = b.id_akses 
                WHERE username = ? 
                LIMIT 1";
        $result = $db->query($sql, [$username]);
        $row = $result->getRow();

        if ($result->getNumRows() === 1) {
            if ($row->aktif == 1) {
                if (password_verify($password, $row->password)) {
                    $id = ['id_user' => $row->id_user];
                    $tgl_login = date('Y-m-d H:i:s');
                    $login = ['last_login' => $tgl_login];

                    // update last login
                    $this->model->updateData('tbl_user', $login, $id);

                    // set session
                    $session_data = [
                        'id_user'   => $row->id_user,
                        'id_akses'  => $row->id_akses,
                        'username'  => $row->username,
                        'nama'      => $row->nama,
                        'status'    => $row->akses,
                        'login'     => 1
                    ];
                    $this->set_session($session_data);

                    return 'login_sukses';
                } else {
                    return 'password_salah';
                }
            } else {
                return 'akun_belum_aktif';
            }
        } else {
            return 'akun_tidak_ditemukan';
        }
    }

    private function set_session($session_data)
    {
        session()->set($session_data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
