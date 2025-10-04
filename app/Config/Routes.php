<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::prosesLogin');
$routes->get('logout', 'AuthController::logout');


// filter
$routes->group('', ['filter' => 'auth'], function($routes) {

    $routes->get('dashboard', 'DashboardController::index');

    // rute untuk gudang
    $routes->group('admin', ['filter' => 'role:gudang', 'namespace' => 'App\Controllers\Admin'], function ($routes) {

        // CRUD bahan baku
        $routes->get('bahan-baku', 'BahanBakuController::index');
        $routes->get('bahan-baku/new', 'BahanBakuController::new');
        $routes->post('bahan-baku', 'BahanBakuController::create');
        $routes->get('bahan-baku/edit/(:num)', 'BahanBakuController::edit/$1');
        $routes->post('bahan-baku/update/(:num)', 'BahanBakuController::update/$1');
        $routes->post('bahan-baku/delete/(:num)', 'BahanBakuController::delete/$1');

        //control permintaan
        $routes->get('permintaan', 'PermintaanController::index');
        $routes->get('permintaan/detail/(:num)', 'PermintaanController::detail/$1');
        $routes->post('permintaan/approve/(:num)', 'PermintaanController::approve/$1');
        $routes->post('permintaan/reject/(:num)', 'PermintaanController::reject/$1');
    });

    // routes dapur
    $routes->group('dapur', ['namespace' => 'App\Controllers\dapur'], function ($routes) {
        $routes->get('permintaan/new', 'PermintaanController::new');
        $routes->post('permintaan', 'PermintaanController::create');
        $routes->get('permintaan/riwayat', 'PermintaanController::riwayat');
    });
});