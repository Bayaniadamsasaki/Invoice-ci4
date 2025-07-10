<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Auth::index');

// Authentication routes
$routes->group('auth', static function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::attemptRegister');
});

// Protected routes (require authentication)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');
    
    // Produk routes
    $routes->group('produk', static function ($routes) {
        $routes->get('/', 'Produk::index');
        $routes->get('create', 'Produk::create');
        $routes->post('store', 'Produk::store');
        $routes->get('edit/(:num)', 'Produk::edit/$1');
        $routes->post('update/(:num)', 'Produk::update/$1');
        $routes->get('delete/(:num)', 'Produk::delete/$1');
        $routes->get('show/(:num)', 'Produk::show/$1');
    });
    
    // Rekanan routes
    $routes->group('rekanan', static function ($routes) {
        $routes->get('/', 'Rekanan::index');
        $routes->get('create', 'Rekanan::create');
        $routes->post('store', 'Rekanan::store');
        $routes->get('edit/(:num)', 'Rekanan::edit/$1');
        $routes->post('update/(:num)', 'Rekanan::update/$1');
        $routes->get('delete/(:num)', 'Rekanan::delete/$1');
        $routes->get('show/(:num)', 'Rekanan::show/$1');
    });
    
    // Pemesanan routes
    $routes->group('pemesanan', static function ($routes) {
        $routes->get('/', 'Pemesanan::index');
        $routes->get('create', 'Pemesanan::create');
        $routes->post('store', 'Pemesanan::store');
        $routes->get('edit/(:num)', 'Pemesanan::edit/$1');
        $routes->post('update/(:num)', 'Pemesanan::update/$1');
        $routes->get('delete/(:num)', 'Pemesanan::delete/$1');
        $routes->get('show/(:num)', 'Pemesanan::show/$1');
        $routes->post('approve/(:num)', 'Pemesanan::approve/$1');
    });
    
    // Invoice routes
    $routes->group('invoice', static function ($routes) {
        $routes->get('/', 'Invoice::index');
        $routes->get('create', 'Invoice::create');
        $routes->get('create/(:num)', 'Invoice::create/$1');
        $routes->post('store', 'Invoice::store');
        $routes->get('show/(:segment)', 'Invoice::show/$1');
        $routes->get('print/(:segment)', 'Invoice::print/$1');
        $routes->post('payment/(:num)', 'Invoice::payment/$1');
        $routes->get('edit/(:num)', 'Invoice::edit/$1');
        $routes->post('update/(:num)', 'Invoice::update/$1');
        $routes->get('invoice/print/(:num)', 'Invoice::print/$1');
    });
    
    // Laporan routes
    $routes->group('laporan', static function ($routes) {
        $routes->get('/', 'Laporan::index');
        $routes->get('invoice', 'Laporan::invoice');
        $routes->get('pemesanan', 'Laporan::pemesanan');
        $routes->get('rekanan', 'Laporan::rekanan');
        $routes->get('produk', 'Laporan::produk');
        $routes->post('export', 'Laporan::export');
    });
    
    // API routes for AJAX
    $routes->group('api', static function ($routes) {
        $routes->get('produk/(:num)', 'Api::getProduk/$1');
        $routes->get('rekanan/(:num)', 'Api::getRekanan/$1');
        $routes->get('dashboard/stats', 'Api::getDashboardStats');
    });
});
