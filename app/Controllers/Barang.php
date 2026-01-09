<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data = [
            'barang' => $this->barangModel->findAll()
        ];
        return view('barang_view', $data);
    }

    public function save()
    {
        $id = $this->request->getVar('id');
        
        $data = [
            'kode_barang' => $this->request->getVar('kode_barang'),
            'nama_hp'     => $this->request->getVar('nama_hp'),
            'merek'       => $this->request->getVar('merek'),
            'imei'        => $this->request->getVar('imei'),
            'harga_beli'  => $this->request->getVar('harga_beli'),
            'harga_jual'  => $this->request->getVar('harga_jual'),
            'stok'        => $this->request->getVar('stok'),
            'lokasi_rak'  => $this->request->getVar('lokasi_rak'),
            'status'      => ($this->request->getVar('stok') > 0) ? 'Ready' : 'Kosong',
        ];

        if ($id) {
            $this->barangModel->update($id, $data);
            $msg = 'Data berhasil diperbarui.';
        } else {
            $this->barangModel->save($data);
            $msg = 'Data berhasil ditambahkan.';
        }

        return redirect()->to('/barang')->with('success', $msg);
    }

    public function delete($id)
    {
        $this->barangModel->delete($id);
        return redirect()->to('/barang')->with('success', 'Data berhasil dihapus.');
    }
}
