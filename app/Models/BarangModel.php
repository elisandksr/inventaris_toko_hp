<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model untuk manajemen data barang (CRUD)
 */
class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id';
    
    // Field yang diizinkan untuk manipulasi data
    protected $allowedFields    = [
        'kode_barang',  // Kode unik untuk identifikasi barang
        'nama_hp',      // Nama model handphone
        'merek',        // Brand/merek handphone (Samsung, iPhone, dll)
        'imei',         // International Mobile Equipment Identity
        'harga_beli',   // Harga beli dari supplier
        'harga_jual',   // Harga jual ke customer
        'stok',         // Jumlah unit yang tersedia
        'lokasi_rak',   // Lokasi penyimpanan di gudang
        'status'        // Status ketersediaan (Ready/Kosong/Menipis)
    ];

    // Timestamp otomatis
    protected $useTimestamps    = true;

    // Helper: Tentukan status stok untuk label visual
    public function getStockStatus($stok)
    {
        if ($stok <= 0) return 'Kosong';      // Stok habis
        if ($stok < 5) return 'Menipis';      // Stok hampir habis (perlu restock)
        return 'Aman';                        // Stok cukup aman
    }
}
