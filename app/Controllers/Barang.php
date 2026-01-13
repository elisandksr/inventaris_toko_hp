<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;

// Controller Data Barang: CRUD (Create, Read, Update, Delete)
class Barang extends BaseController
{
    protected $barangModel;

    /**
     * Constructor - inisialisasi model barang
     */
    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    // Tampilkan daftar barang (support pencarian)
    public function index()
    {
        $keyword = $this->request->getVar('q');

        if ($keyword) {
            // Filter berdasarkan: Nama, Kode, atau IMEI
            $barang = $this->barangModel->like('nama_hp', $keyword)
                        ->orLike('kode_barang', $keyword)
                        ->orLike('imei', $keyword)
                        ->findAll();
        } else {
            // Ambil semua data
            $barang = $this->barangModel->findAll();
        }

        $data = [
            'barang' => $barang,
            'keyword' => $keyword
        ];

        return view('barang_view', $data);
    }

    // Simpan data (Tambah baru atau Update)
    public function save()
    {
        $id = $this->request->getVar('id');

        // Mengumpulkan data dari form input
        $data = [
            'kode_barang' => $this->request->getVar('kode_barang'),
            'nama_hp'     => $this->request->getVar('nama_hp'),
            'merek'       => $this->request->getVar('merek'),
            'imei'        => $this->request->getVar('imei'),
            'harga_beli'  => $this->request->getVar('harga_beli'),
            'harga_jual'  => $this->request->getVar('harga_jual'),
            'stok'        => $this->request->getVar('stok'),
            'lokasi_rak'  => $this->request->getVar('lokasi_rak'),
            'status'      => ($this->request->getVar('stok') > 0) ? 'Ready' : 'Kosong', // Status otomatis berdasarkan stok
        ];

        if ($id) {
            // Update data jika ID ada
            $this->barangModel->update($id, $data);
            $msg = 'Data berhasil diperbarui.';
        } else {
            // Create data baru jika ID kosong
            $this->barangModel->save($data);
            $msg = 'Data berhasil ditambahkan.';
        }

        return redirect()->to('/barang')->with('success', $msg);
    }

    // Hapus data berdasarkan ID
    public function delete($id)
    {
        $this->barangModel->delete($id);
        return redirect()->to('/barang')->with('success', 'Data berhasil dihapus.');
    }
}
