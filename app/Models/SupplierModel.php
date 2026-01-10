<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table            = 'suppliers';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_supplier', 'alamat', 'telepon', 'email'];
    protected $useTimestamps    = true;

    /**
     * Get supplier with transaction count
     */
    public function getSuppliersWithStats()
    {
        return $this->select('suppliers.*, COUNT(transaksi.id) as total_transaksi')
                    ->join('transaksi', 'transaksi.supplier_id = suppliers.id', 'left')
                    ->groupBy('suppliers.id')
                    ->findAll();
    }
}