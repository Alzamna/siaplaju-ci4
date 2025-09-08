<?php

namespace App\Controllers;

use App\Models\Model_app;
use CodeIgniter\Controller;

class Login extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = model(Model_app::class);
        helper(['form']);
    }

    public function index()
    {
        return view('pages/v_login', ['title' => 'Login Admin SIAPLAJU']);
    }

    public function proses()
    {
        $rules = [
            'login-username' => 'required',
            'login-password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('login')->with('error', 'Username dan password wajib diisi!');
        }

        $username = $this->request->getPost('login-username');
        $password = $this->request->getPost('login-password');

        $db = \Config\Database::connect();
        $row = $db->table('tbl_user a')
                  ->join('tbl_akses b', 'a.id_akses = b.id_akses')
                  ->where('username', $username)
                  ->get()
                  ->getRow();

        if ($row) {
            if ($row->aktif == 1) {
                if (password_verify($password, $row->password)) {
                    $this->model->updateData('tbl_user', [
                        'last_login' => date('Y-m-d H:i:s')
                    ], ['id_user' => $row->id_user]);

                    session()->set([
                        'id_user'  => $row->id_user,
                        'id_akses' => $row->id_akses,
                        'username' => $row->username,
                        'nama'     => $row->nama,
                        'status'   => $row->akses,
                        'login'    => 1, 
                    ]);

                    return redirect()->to('dashboard');
                }
                return redirect()->to('login')->with('error', 'Password salah!');
            }
            return redirect()->to('login')->with('error', 'Akun belum aktif!');
        }
        return redirect()->to('login')->with('error', 'Username tidak ditemukan!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
