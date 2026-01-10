<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;

class Transaksi extends BaseController
{
    protected $transaksiModel;
    protected $barangModel;
    protected $supplierModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->barangModel = new BarangModel();
        $this->supplierModel = new SupplierModel();
    }

    /**
     * BARANG MASUK - Menampilkan form dan riwayat
     */
    public function masuk()
    {
        $data = [
            'barang' => $this->barangModel->findAll(),
            'suppliers' => $this->supplierModel->findAll(),
            'transaksi_masuk' => $this->transaksiModel->where('jenis', 'Masuk')->findAll()
        ];
        return view('transaksi_masuk_view', $data);
    }

    /**
     * BARANG KELUAR - Menampilkan form dan riwayat
     */
    public function keluar()
    {
        $data = [
            'barang' => $this->barangModel->findAll(),
            'transaksi_keluar' => $this->transaksiModel->where('jenis', 'Keluar')->findAll()
        ];
        return view('transaksi_keluar_view', $data);
    }

    /**
     * PROSES BARANG MASUK
     * Logika: Tambah transaksi + Update stok barang
     */
    public function prosesMasuk()
    {
        $barang_id = $this->request->getVar('barang_id');
        $supplier_id = $this->request->getVar('supplier_id');
        $jumlah = $this->request->getVar('jumlah');
        $tanggal = $this->request->getVar('tanggal');
        $keterangan = $this->request->getVar('keterangan');

        // Validasi input
        if (!$barang_id || !$supplier_id || !$jumlah || !$tanggal) {
            return redirect()->back()->with('error', 'Semua field harus diisi!');
        }

        // Cek apakah barang ada
        $barang = $this->barangModel->find($barang_id);
        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan!');
        }

        // Simpan transaksi
        $transaksiData = [
            'jenis' => 'Masuk',
            'barang_id' => $barang_id,
            'supplier_id' => $supplier_id,
            'jumlah' => $jumlah,
            'tanggal' => $tanggal,
            'keterangan' => $keterangan
        ];

        $this->transaksiModel->save($transaksiData);

        // UPDATE STOK BARANG - TAMBAH STOK
        $stok_baru = $barang['stok'] + $jumlah;
        $status_baru = $this->tentukanStatusStok($stok_baru);

        $this->barangModel->update($barang_id, [
            'stok' => $stok_baru,
            'status' => $status_baru
        ]);

        return redirect()->to('/transaksi/masuk')->with('success', "Barang masuk berhasil dicatat. Stok {$barang['nama_hp']} bertambah {$jumlah} unit.");
    }

    /**
     * PROSES BARANG KELUAR
     * Logika: Tambah transaksi + Update stok barang
     */
    public function prosesKeluar()
    {
        $barang_id = $this->request->getVar('barang_id');
        $jumlah = $this->request->getVar('jumlah');
        $tanggal = $this->request->getVar('tanggal');
        $keterangan = $this->request->getVar('keterangan');

        // Validasi input
        if (!$barang_id || !$jumlah || !$tanggal) {
            return redirect()->back()->with('error', 'Semua field harus diisi!');
        }

        // Cek apakah barang ada
        $barang = $this->barangModel->find($barang_id);
        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan!');
        }

        // Cek stok cukup
        if ($barang['stok'] < $jumlah) {
            return redirect()->back()->with('error', "Stok tidak cukup! Stok tersedia: {$barang['stok']} unit.");
        }

        // Simpan transaksi
        $transaksiData = [
            'jenis' => 'Keluar',
            'barang_id' => $barang_id,
            'supplier_id' => null, // Barang keluar tidak perlu supplier
            'jumlah' => $jumlah,
            'tanggal' => $tanggal,
            'keterangan' => $keterangan
        ];

        $this->transaksiModel->save($transaksiData);

        // UPDATE STOK BARANG - KURANGI STOK
        $stok_baru = $barang['stok'] - $jumlah;
        $status_baru = $this->tentukanStatusStok($stok_baru);

        $this->barangModel->update($barang_id, [
            'stok' => $stok_baru,
            'status' => $status_baru
        ]);

        return redirect()->to('/transaksi/keluar')->with('success', "Barang keluar berhasil dicatat. Stok {$barang['nama_hp']} berkurang {$jumlah} unit.");
    }

    /**
     * RIWAYAT TRANSAKSI
     */
    public function riwayat()
    {
        $data = [
            'transaksi' => $this->transaksiModel->getDetailedTransactions()
        ];
        return view('transaksi_riwayat_view', $data);
    }

    /**
     * Helper: Tentukan status stok berdasarkan jumlah
     */
    private function tentukanStatusStok($stok)
    {
        if ($stok <= 0) return 'Kosong';
        if ($stok < 5) return 'Menipis';
        return 'Ready';
    }

    /**
     * Hapus transaksi (untuk koreksi jika salah input)
     * PERHATIAN: Ini akan rollback stok juga
     */
    public function delete($id)
    {
        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan!');
        }

        // Rollback stok
        $barang = $this->barangModel->find($transaksi['barang_id']);
        if ($transaksi['jenis'] == 'Masuk') {
            // Jika hapus transaksi masuk, kurangi stok
            $stok_baru = $barang['stok'] - $transaksi['jumlah'];
        } else {
            // Jika hapus transaksi keluar, tambah stok
            $stok_baru = $barang['stok'] + $transaksi['jumlah'];
        }

        $status_baru = $this->tentukanStatusStok($stok_baru);

        $this->barangModel->update($transaksi['barang_id'], [
            'stok' => $stok_baru,
            'status' => $status_baru
        ]);

        // Hapus transaksi
        $this->transaksiModel->delete($id);

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus dan stok telah dirollback.');
    }
}
