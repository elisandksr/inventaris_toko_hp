<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['kode_barang', 'nama_hp', 'merek', 'imei', 'harga_beli', 'harga_jual', 'stok', 'lokasi_rak', 'status'];
    protected $useTimestamps    = true;

    // Helper to check stock status
    public function getStockStatus($stok)
    {
        if ($stok <= 0) return 'Kosong';
        if ($stok < 5) return 'Menipis';
        return 'Aman';
    }
}
