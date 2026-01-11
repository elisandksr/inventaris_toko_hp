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

        // 1. Basic Stats
        $total_barang = $barangModel->countAllResults();
        $total_stok = $barangModel->selectSum('stok')->get()->getRow()->stok ?? 0;
        
        // 2. Low Stock Logic (Optimized)
        // Definition: Stok < 5 unit is considered "Critical/Scientific" for Retail Phone Shop
        $threshold = 5; 
        $stok_menipis_count = $barangModel->where('stok <', $threshold)->countAllResults();
        $stok_menipis_list = $barangModel->where('stok <', $threshold)->orderBy('stok', 'ASC')->findAll(5); // Get top 5 most critical

        // 3. Financial Analysis (New Feature for Owner)
        // Calculate Total Assets (Money tied in stock)
        $all_barang = $barangModel->findAll();
        $total_aset = 0;
        foreach ($all_barang as $b) {
            $total_aset += ($b['harga_beli'] * $b['stok']);
        }

        // 4. Daily Activity
        $transaksi_masuk = $transaksiModel->where('jenis', 'Masuk')->where('DATE(tanggal)', date('Y-m-d'))->countAllResults();
        $transaksi_keluar = $transaksiModel->where('jenis', 'Keluar')->where('DATE(tanggal)', date('Y-m-d'))->countAllResults();

        // 5. Recent History
        $recent_activities = $transaksiModel->select('transaksi.*, barang.nama_hp, barang.merek')
                                            ->join('barang', 'barang.id = transaksi.barang_id')
                                            ->orderBy('transaksi.created_at', 'DESC')
                                            ->findAll(5);

        $data = [
            'total_barang' => $total_barang,
            'total_stok' => $total_stok,
            'stok_menipis_count' => $stok_menipis_count,
            'stok_menipis_list' => $stok_menipis_list, // Pass the list for display
            'total_aset' => $total_aset,               // Pass financial data
            'transaksi_masuk' => $transaksi_masuk,
            'transaksi_keluar' => $transaksi_keluar,
            'recent_activities' => $recent_activities
        ];

        return view('dashboard_view', $data);
    }
}
