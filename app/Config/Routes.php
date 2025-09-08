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
// Default 
// -------------------
$routes->get('/',                     'Beranda::index');

// -------------------
// Pengaduan
// -------------------
$routes->get('pengaduan',             'Pengaduan::index');
$routes->get('pengaduan/input',       'Pengaduan::input');
$routes->post('pengaduan/proses_input_pengaduan', 'Pengaduan::proses_input_pengaduan');
$routes->get('pengaduan/lihat/(:segment)',        'Pengaduan::lihat/$1');

// -------------------
// Aspirasi
// -------------------
$routes->get('aspirasi',              'Aspirasi::index');
$routes->get('aspirasi/input',        'Aspirasi::input');
$routes->post('aspirasi/proses_aspirasi', 'Aspirasi::proses_aspirasi');

// -------------------
// Peta & Kontak
// -------------------
$routes->get('peta',                  'Peta::index');
$routes->get('kontak',                'Kontak::index');



// -------------------
// Dashboard
// -------------------
$routes->get('dashboard', 'Dashboard::index');
$routes->get('profil', 'Dashboard::profil');
$routes->get('setting', 'Dashboard::setting');

// Login & Auth
$routes->get('login', 'Login::index');    
$routes->post('login', 'Login::index');   
$routes->get('login/logout', 'Login::logout'); 

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
    $routes->match(['get', 'post'], 'verifikasi/(:segment)', 'Adminaspirasi::verifikasi/$1');
    $routes->get('lihat/(:segment)', 'Adminaspirasi::lihat/$1');
    $routes->post('cari', 'Adminaspirasi::cari');
    $routes->get('hapus/(:segment)', 'Adminaspirasi::hapus/$1');
});

// Admin Jalan
$routes->group('adminjalan', function($routes) {
    $routes->get('/', 'Adminjalan::index');
    $routes->post('tambah', 'Adminjalan::proses_tambah_jalan');
    $routes->post('proses_edit_jalan/(:num)', 'Adminjalan::proses_edit_jalan/$1');
    $routes->get('hapus_jalan/(:num)', 'Adminjalan::hapus_jalan/$1');
    $routes->get('lihat/(:num)', 'Adminjalan::lihat/$1');
    $routes->get('get_jalan', 'Adminjalan::get_jalan');
});

// Admin PJU
$routes->get('adminpju',               'Adminpju::index');
$routes->get('adminpju/tambah',        'Adminpju::tambah');
$routes->post('adminpju/proses_tambah','Adminpju::proses_tambah');
$routes->post('adminpju/cari',         'Adminpju::cari');

$routes->get('adminpju/edit/(:num)',   'Adminpju::edit/$1');
$routes->post('adminpju/proses_edit/(:num)', 'Adminpju::proses_edit/$1');
$routes->get('adminpju/hapus/(:num)',  'Adminpju::hapus/$1');
$routes->get('adminpju/lihat/(:num)',  'Adminpju::lihat/$1');

$routes->get('adminpju/peta',          'Adminpju::peta');
$routes->post('adminpju/fpeta',        'Adminpju::fpeta');
$routes->post('adminpju/get_jalan',    'Adminpju::get_jalan');



// Admin Rekap
$routes->group('adminrekap', function($routes) {
    // Halaman rekap PJU
    $routes->get('pju', 'Adminrekap::pju');
    $routes->post('fpju', 'Adminrekap::fpju'); 
    $routes->post('export_pju', 'Adminrekap::export_pju'); 

    // Halaman rekap Pengaduan
    $routes->get('pengaduan', 'Adminrekap::pengaduan');
    $routes->post('fpengaduan', 'Adminrekap::fpengaduan'); 
    $routes->post('export_pengaduan', 'Adminrekap::export_pengaduan'); 
});


// Admin Pengaduan
$routes->group('adminpengaduan', function($routes) {
    // Dashboard / list pengaduan
    $routes->get('/', 'Adminpengaduan::index');

    // Tambah pengaduan
    $routes->get('tambah', 'Adminpengaduan::tambah');
    $routes->post('proses_tambah', 'Adminpengaduan::proses_tambah');

    // Edit pengaduan
    $routes->get('edit/(:num)', 'Adminpengaduan::edit/$1');
    $routes->post('proses_edit/(:num)', 'Adminpengaduan::proses_edit/$1');

    // Hapus pengaduan
    $routes->get('hapus/(:num)', 'Adminpengaduan::hapus/$1');

    // Tolak pengaduan
    $routes->match(['get','post'], 'adminpengaduan/tolak/(:segment)', 'Adminpengaduan::tolak/$1');

    // Verifikasi pengaduan
    $routes->get('verifikasi/(:num)', 'Adminpengaduan::verifikasi/$1');
    $routes->post('verifikasi/(:num)', 'Adminpengaduan::proses_verifikasi/$1');

    // Proses pengaduan (status 3)
    $routes->post('proses_pengaduan/(:num)', 'Adminpengaduan::proses_pengaduan/$1');

    // Input perbaikan
    $routes->get('inputperbaikan/(:num)', 'Adminpengaduan::inputperbaikan/$1');
    $routes->post('inputperbaikan/(:num)', 'Adminpengaduan::proses_perbaikan/$1');
    
    // Input hasil perbaikan
    $routes->get('inputperbaikan/(:segment)', 'Adminpengaduan::inputperbaikan/$1');
    $routes->post('proses_perbaikan/(:segment)', 'Adminpengaduan::proses_perbaikan/$1');

    // Lihat pengaduan
    $routes->get('lihat/(:num)', 'Adminpengaduan::lihat/$1');

    // Peta pengaduan
    $routes->get('peta', 'Adminpengaduan::peta');

    // Cari pengaduan
    $routes->post('cari', 'Adminpengaduan::cari');
});
