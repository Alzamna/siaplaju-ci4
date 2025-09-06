<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Beranda');  // default controller
$routes->setDefaultMethod('index');        // default method
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// -------------------
// Default & Auth
// -------------------
$routes->get('/', 'Beranda::index');
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('kontak', 'Kontak::index');

$routes->get('pengaduan', 'Pengaduan::index');
$routes->post('pengaduan/input', 'Pengaduan::input');
$routes->get('pengaduan/(:num)', 'Pengaduan::detail/$1');
$routes->get('pengaduan/(:num)/survey/(:num)', 'Pengaduan::survey/$1/$2');

// Halaman aspirasi
$routes->get('aspirasi', 'Aspirasi::index');         
$routes->get('aspirasi/input', 'Aspirasi::input');   
$routes->post('aspirasi/proses', 'Aspirasi::proses_aspirasi'); 

$routes->get('peta', 'Peta::index');



// -------------------
// Dashboard
// -------------------
$routes->get('dashboard', 'Dashboard::index');

// Admin Master
$routes->group('adminmaster', function($routes) {
    // Admin User
    $routes->get('admin', 'Adminmaster::admin');
    $routes->post('proses_tambah_admin', 'Adminmaster::proses_tambah_admin');
    $routes->post('proses_edit_admin/(:num)', 'Adminmaster::proses_edit_admin/$1');
    $routes->get('hapus_user/(:num)', 'Adminmaster::hapus_user/$1');

    // Rayon
    $routes->get('rayon', 'Adminmaster::rayon');
    $routes->post('proses_tambah_rayon', 'Adminmaster::proses_tambah_rayon');
    $routes->post('proses_edit_rayon/(:num)', 'Adminmaster::proses_edit_rayon/$1');
    $routes->get('hapus_rayon/(:num)', 'Adminmaster::hapus_rayon/$1');

    // Kecamatan
    $routes->get('kecamatan', 'Adminmaster::kecamatan');
    $routes->post('proses_tambah_kecamatan', 'Adminmaster::proses_tambah_kecamatan');
    $routes->post('proses_edit_kecamatan/(:num)', 'Adminmaster::proses_edit_kecamatan/$1');
    $routes->get('hapus_kecamatan/(:num)', 'Adminmaster::hapus_kecamatan/$1');

    // Jalan
    $routes->get('jalan', 'Adminmaster::jalan');
    $routes->post('proses_tambah_jalan', 'Adminmaster::proses_tambah_jalan');
    $routes->post('proses_edit_jalan/(:num)', 'Adminmaster::proses_edit_jalan/$1');
    $routes->get('hapus_jalan/(:num)', 'Adminmaster::hapus_jalan/$1');
});


// Admin Aspirasi
$routes->group('adminaspirasi', function($routes) {
    $routes->get('/', 'Adminaspirasi::index');
    $routes->get('verifikasi/(:num)', 'Adminaspirasi::verifikasi/$1');
    $routes->get('lihat/(:num)', 'Adminaspirasi::lihat/$1');
    $routes->post('cari', 'Adminaspirasi::cari');
    $routes->get('hapus/(:num)', 'Adminaspirasi::hapus/$1');
});

// Admin Jalan
$routes->group('adminjalan', function($routes) {
    $routes->get('/', 'Adminjalan::index');
    $routes->post('tambah', 'Adminjalan::proses_tambah_jalan');
    $routes->post('edit/(:num)', 'Adminjalan::proses_edit_jalan/$1');
    $routes->get('hapus/(:num)', 'Adminjalan::hapus_jalan/$1');
    $routes->get('lihat/(:num)', 'Adminjalan::lihat/$1');
    $routes->get('get_jalan', 'Adminjalan::get_jalan');
});

// Admin PJU
$routes->group('adminpju', function($routes) {
    $routes->get('/', 'Adminpju::index');
    $routes->post('tambah', 'Adminpju::proses_tambah');
    $routes->post('edit/(:num)', 'Adminpju::proses_edit/$1');
    $routes->get('hapus/(:num)', 'Adminpju::hapus/$1');
});

// Admin Rekap
$routes->group('adminrekap', function($routes) {
    $routes->get('/', 'Adminrekap::index');
    $routes->get('export', 'Adminrekap::export'); // asumsi ada fitur export excel
});

// Admin Pengaduan
$routes->group('adminpengaduan', function($routes) {
    $routes->get('/', 'Adminpengaduan::index');
    $routes->post('tambah', 'Adminpengaduan::proses_tambah');
    $routes->post('edit/(:num)', 'Adminpengaduan::proses_edit/$1');
    $routes->get('hapus/(:num)', 'Adminpengaduan::hapus/$1');
    $routes->get('tolak/(:num)', 'Adminpengaduan::tolak/$1');
});