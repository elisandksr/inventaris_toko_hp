<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupplierModel;

class Supplier extends BaseController
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    /**
     * Tampilkan daftar supplier
     */
    public function index()
    {
        $data = [
            'suppliers' => $this->supplierModel->findAll()
        ];
        return view('supplier_view', $data);
    }

    /**
     * Form tambah supplier baru
     */
    public function create()
    {
        return view('supplier_form_view');
    }

    /**
     * Simpan supplier baru
     */
    public function store()
    {
        $data = [
            'nama_supplier' => $this->request->getVar('nama_supplier'),
            'alamat' => $this->request->getVar('alamat'),
            'telepon' => $this->request->getVar('telepon'),
            'email' => $this->request->getVar('email')
        ];

        // Validasi
        if (empty($data['nama_supplier'])) {
            return redirect()->back()->with('error', 'Nama supplier harus diisi!');
        }

        $this->supplierModel->save($data);
        return redirect()->to('/supplier')->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Form edit supplier
     */
    public function edit($id)
    {
        $supplier = $this->supplierModel->find($id);
        if (!$supplier) {
            return redirect()->to('/supplier')->with('error', 'Supplier tidak ditemukan!');
        }

        $data = [
            'supplier' => $supplier
        ];
        return view('supplier_form_view', $data);
    }

    /**
     * Update supplier
     */
    public function update($id)
    {
        $supplier = $this->supplierModel->find($id);
        if (!$supplier) {
            return redirect()->to('/supplier')->with('error', 'Supplier tidak ditemukan!');
        }

        $data = [
            'nama_supplier' => $this->request->getVar('nama_supplier'),
            'alamat' => $this->request->getVar('alamat'),
            'telepon' => $this->request->getVar('telepon'),
            'email' => $this->request->getVar('email')
        ];

        if (empty($data['nama_supplier'])) {
            return redirect()->back()->with('error', 'Nama supplier harus diisi!');
        }

        $this->supplierModel->update($id, $data);
        return redirect()->to('/supplier')->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Hapus supplier
     */
    public function delete($id)
    {
        $supplier = $this->supplierModel->find($id);
        if (!$supplier) {
            return redirect()->to('/supplier')->with('error', 'Supplier tidak ditemukan!');
        }

        // Cek apakah supplier masih digunakan di transaksi
        $db = \Config\Database::connect();
        $transaksiCount = $db->table('transaksi')->where('supplier_id', $id)->countAllResults();

        if ($transaksiCount > 0) {
            return redirect()->to('/supplier')->with('error', 'Supplier tidak dapat dihapus karena masih memiliki riwayat transaksi!');
        }

        $this->supplierModel->delete($id);
        return redirect()->to('/supplier')->with('success', 'Supplier berhasil dihapus.');
    }
}
