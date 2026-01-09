<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $barangModel = new BarangModel();
        $transaksiModel = new TransaksiModel();

        $data = [
            'total_barang' => $barangModel->countAllResults(),
            'total_stok' => $barangModel->selectSum('stok')->get()->getRow()->stok ?? 0,
            'stok_menipis' => $barangModel->where('stok <', 5)->countAllResults(),
            'transaksi_masuk' => $transaksiModel->where('jenis', 'Masuk')->where('DATE(tanggal)', date('Y-m-d'))->countAllResults(),
            'transaksi_keluar' => $transaksiModel->where('jenis', 'Keluar')->where('DATE(tanggal)', date('Y-m-d'))->countAllResults(),
        ];

        return view('dashboard_view', $data);
    }
}
