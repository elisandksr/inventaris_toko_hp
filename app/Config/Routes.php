<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default Route
$routes->get('/', 'Auth::login');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');

// Protected Routes (Admin Only)
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    $routes->get('dashboard', 'Dashboard::index');
    
    // Barang (Simplifed Routes)
    $routes->get('barang', 'Barang::index');
    $routes->post('barang/save', 'Barang::save');
    $routes->get('barang/delete/(:num)', 'Barang::delete/$1');
    
    // Transaksi (Placeholder)
    $routes->get('transaksi/masuk', 'Transaksi::masuk');
    $routes->get('transaksi/keluar', 'Transaksi::keluar');
    
    $routes->get('laporan', 'Laporan::index');
});
