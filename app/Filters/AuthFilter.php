<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Method ini dijalankan sebelum controller dipanggil.
     * Bisa digunakan untuk cek login atau izin akses.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Jika belum login, redirect ke halaman login
        if ($session->get('login') != 1) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    /**
     * Method ini dijalankan setelah controller dipanggil.
     * Biasanya digunakan untuk modifikasi response.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi kalau belum ada kebutuhan
    }
}
