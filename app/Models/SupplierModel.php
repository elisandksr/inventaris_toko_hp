<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model untuk manajemen data supplier dan statistik transaksi
 */
class SupplierModel extends Model
{
    // Konfigurasi Tabel
    protected $table            = 'suppliers';
    protected $primaryKey       = 'id';
    
    // Field yang diizinkan
    protected $allowedFields    = ['nama_supplier', 'alamat', 'telepon', 'email'];

    // Timestamp otomatis
    protected $useTimestamps    = true;

    // Ambil data supplier + total transaksi (LEFT JOIN)
    public function getSuppliersWithStats()
    {
        return $this->select('suppliers.*, COUNT(transaksi.id) as total_transaksi')
                    ->join('transaksi', 'transaksi.supplier_id = suppliers.id', 'left')  // Left join untuk menghitung transaksi
                    ->groupBy('suppliers.id')    // Group by supplier ID
                    ->findAll();
    }
}