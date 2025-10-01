<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::prosesLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/dashboard', 'DashboardController::index');
$routes->get('admin/bahan_baku', 'AdminController::index');
$routes->get('admin/tambah_bahan', 'AdminController::new');
$routes->get('admin/edit_bahan/{id}', 'AdminController::edit');
$routes->get('admin/hapus_bahan/{id}', 'AdminController::delete');



