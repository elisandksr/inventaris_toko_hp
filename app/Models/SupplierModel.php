<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model untuk mengelola data supplier/pemasok barang dalam database
 * Menangani informasi contact dan statistik supplier
 */
class SupplierModel extends Model
{
    // Nama tabel database
    protected $table            = 'suppliers';

    // Primary key tabel
    protected $primaryKey       = 'id';

    // Field-field yang boleh dimodifikasi
    protected $allowedFields    = [
        'nama_supplier',    // Nama perusahaan supplier
        'alamat',          // Alamat lengkap supplier
        'telepon',         // Nomor telepon contact
        'email'            // Email untuk komunikasi
    ];

    // Menggunakan timestamps otomatis
    protected $useTimestamps    = true;

    /**
     * Mengambil data supplier beserta statistik transaksi
     * Menampilkan jumlah total transaksi yang pernah dilakukan supplier
     * Berguna untuk mengetahui supplier mana yang paling aktif
     *
     * @return array Array of supplier data dengan field total_transaksi
     */
    public function getSuppliersWithStats()
    {
        return $this->select('suppliers.*, COUNT(transaksi.id) as total_transaksi')
                    ->join('transaksi', 'transaksi.supplier_id = suppliers.id', 'left')  // Left join untuk menghitung transaksi
                    ->groupBy('suppliers.id')    // Group by supplier ID
                    ->findAll();
    }
}