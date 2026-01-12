<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model untuk mengelola data barang (handphone) dalam database
 * Menangani operasi CRUD untuk tabel 'barang'
 */
class BarangModel extends Model
{
    // Nama tabel database yang digunakan
    protected $table            = 'barang';

    // Primary key dari tabel
    protected $primaryKey       = 'id';

    // Field-field yang boleh diisi melalui mass assignment
    // Melindungi field lain dari modifikasi tidak sah
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

    // Menggunakan timestamps otomatis (created_at, updated_at)
    protected $useTimestamps    = true;

    /**
     * Helper method untuk menentukan status stok berdasarkan jumlah
     * Digunakan untuk memberikan indikasi visual di dashboard
     *
     * @param int $stok Jumlah stok barang
     * @return string Status stok ('Kosong', 'Menipis', 'Aman')
     */
    public function getStockStatus($stok)
    {
        if ($stok <= 0) return 'Kosong';      // Stok habis
        if ($stok < 5) return 'Menipis';      // Stok hampir habis (perlu restock)
        return 'Aman';                        // Stok cukup aman
    }
}
