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

    // Barang Routes
    $routes->get('barang', 'Barang::index');
    $routes->post('barang/save', 'Barang::save');
    $routes->get('barang/delete/(:num)', 'Barang::delete/$1');

    // Transaksi Routes
    $routes->get('transaksi/masuk', 'Transaksi::masuk');
    $routes->get('transaksi/keluar', 'Transaksi::keluar');
    $routes->post('transaksi/prosesMasuk', 'Transaksi::prosesMasuk');
    $routes->post('transaksi/prosesKeluar', 'Transaksi::prosesKeluar');
    $routes->get('transaksi/riwayat', 'Transaksi::riwayat');
    $routes->get('transaksi/delete/(:num)', 'Transaksi::delete/$1');

    // Supplier Routes
    $routes->get('supplier', 'Supplier::index');
    $routes->get('supplier/create', 'Supplier::create');
    $routes->post('supplier/store', 'Supplier::store');
    $routes->get('supplier/edit/(:num)', 'Supplier::edit/$1');
    $routes->post('supplier/update/(:num)', 'Supplier::update/$1');
    $routes->get('supplier/delete/(:num)', 'Supplier::delete/$1');

    // Laporan Routes
    $routes->get('laporan', 'Laporan::index');
    $routes->get('laporan/stok', 'Laporan::stok');
    $routes->get('laporan/transaksi', 'Laporan::transaksi');
    $routes->get('laporan/keuangan', 'Laporan::keuangan');
    $routes->get('laporan/supplier', 'Laporan::supplier');
    $routes->get('laporan/exportStok', 'Laporan::exportStok');
    $routes->get('laporan/exportTransaksi', 'Laporan::exportTransaksi');
});
