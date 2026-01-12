<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model untuk mengelola data transaksi barang (masuk/keluar) dalam database
 * Menangani pencatatan semua aktivitas pergerakan stok barang
 */
class TransaksiModel extends Model
{
    // Nama tabel database
    protected $table            = 'transaksi';

    // Primary key tabel
    protected $primaryKey       = 'id';

    // Field-field yang boleh dimodifikasi melalui mass assignment
    protected $allowedFields    = [
        'jenis',        // Tipe transaksi: 'Masuk' atau 'Keluar'
        'barang_id',    // Foreign key ke tabel barang
        'supplier_id',  // Foreign key ke tabel suppliers (null untuk transaksi keluar)
        'jumlah',       // Jumlah unit yang masuk/keluar
        'tanggal',      // Tanggal terjadinya transaksi
        'keterangan'    // Catatan tambahan untuk transaksi
    ];

    // Menggunakan timestamps otomatis
    protected $useTimestamps    = true;

    // Hanya menggunakan created_at, tidak ada updated_at untuk transaksi
    protected $createdField     = 'created_at';
    protected $updatedField     = '';

    /**
     * Mengambil data transaksi lengkap dengan informasi barang dan supplier
     * Method ini melakukan JOIN untuk mendapatkan detail lengkap transaksi
     *
     * @return array Array of transaksi data dengan detail barang dan supplier
     */
    public function getDetailedTransactions()
    {
        return $this->select('transaksi.*, barang.nama_hp, barang.kode_barang, barang.merek, suppliers.nama_supplier')
                    ->join('barang', 'barang.id = transaksi.barang_id')        // Join dengan tabel barang
                    ->join('suppliers', 'suppliers.id = transaksi.supplier_id', 'left')  // Left join dengan suppliers
                    ->orderBy('transaksi.tanggal', 'DESC')                    // Urutkan berdasarkan tanggal terbaru
                    ->findAll();
    }
}
