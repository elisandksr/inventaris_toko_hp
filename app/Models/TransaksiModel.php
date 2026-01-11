<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['jenis', 'barang_id', 'supplier_id', 'jumlah', 'tanggal', 'keterangan'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; 

    public function getDetailedTransactions()
    {
        return $this->select('transaksi.*, barang.nama_hp, barang.kode_barang, barang.merek, suppliers.nama_supplier')
                    ->join('barang', 'barang.id = transaksi.barang_id')
                    ->join('suppliers', 'suppliers.id = transaksi.supplier_id', 'left')
                    ->orderBy('transaksi.tanggal', 'DESC')
                    ->findAll();
    }
}
