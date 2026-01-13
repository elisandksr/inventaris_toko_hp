<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model untuk mencatat riwayat transaksi barang (Masuk/Keluar)
 */
class TransaksiModel extends Model
{
    // Konfigurasi Tabel
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    
    // Field yang diizinkan
    protected $allowedFields    = [
        'jenis',        // Tipe transaksi: 'Masuk' atau 'Keluar'
        'barang_id',    // Foreign key ke tabel barang
        'supplier_id',  // Foreign key ke tabel suppliers (null untuk transaksi keluar)
        'jumlah',       // Jumlah unit yang masuk/keluar
        'tanggal',      // Tanggal terjadinya transaksi
        'keterangan'    // Catatan tambahan untuk transaksi
    ];

    // Timestamp otomatis (hanya created_at)
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = '';

    // Ambil transaksi lengkap dengan data Barang & Supplier (JOIN)
    public function getDetailedTransactions()
    {
        return $this->select('transaksi.*, barang.nama_hp, barang.kode_barang, barang.merek, suppliers.nama_supplier')
                    ->join('barang', 'barang.id = transaksi.barang_id')        // Join dengan tabel barang
                    ->join('suppliers', 'suppliers.id = transaksi.supplier_id', 'left')  // Left join dengan suppliers
                    ->orderBy('transaksi.tanggal', 'DESC')                    // Urutkan berdasarkan tanggal terbaru
                    ->findAll();
    }
}
