<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Beranda');  // default controller
$routes->setDefaultMethod('index');        // default method
$routes->setTranslateURIDashes(false);     // sama dengan FALSE di CI3
$routes->set404Override();                 // kosong = default 404 bawaan CI4

$routes->get('/', 'Beranda::index');
