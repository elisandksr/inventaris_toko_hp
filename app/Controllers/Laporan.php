<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\TransaksiModel;
use App\Models\SupplierModel;

class Laporan extends BaseController
{
    protected $barangModel;
    protected $transaksiModel;
    protected $supplierModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->transaksiModel = new TransaksiModel();
        $this->supplierModel = new SupplierModel();
    }

    /**
     * Halaman utama laporan dengan berbagai tab
     */
    public function index()
    {
        try {
            $data = [
                'laporan_stok' => $this->getLaporanStok(),
                'laporan_transaksi' => $this->getLaporanTransaksi(),
                'laporan_keuangan' => $this->getLaporanKeuangan(),
                'laporan_supplier' => $this->getLaporanSupplier(),
                'total_barang' => count($this->barangModel->findAll()),
                'total_stok' => $this->barangModel->selectSum('stok')->get()->getRow()->stok ?? 0,
                'total_transaksi_masuk' => $this->transaksiModel->where('jenis', 'Masuk')->countAllResults(),
                'total_transaksi_keluar' => $this->transaksiModel->where('jenis', 'Keluar')->countAllResults(),
            ];

            return view('laporan_view', $data);
        } catch (\Exception $e) {
            // Jika ada error, tampilkan halaman error
            return view('laporan_view', ['error' => $e->getMessage()]);
        }
    }


    /**
     * Laporan Stok Barang
     */
    public function stok()
    {
        $data = [
            'laporan_stok' => $this->getLaporanStok(),
            'title' => 'Laporan Stok Barang'
        ];

        return view('laporan_stok_view', $data);
    }

    /**
     * Laporan Transaksi Lengkap
     */
    public function transaksi()
    {
        $data = [
            'laporan_transaksi' => $this->getLaporanTransaksi(),
            'title' => 'Laporan Transaksi'
        ];

        return view('laporan_transaksi_view', $data);
    }

    /**
     * Laporan Keuangan
     */
    public function keuangan()
    {
        $data = [
            'laporan_keuangan' => $this->getLaporanKeuangan(),
            'title' => 'Laporan Keuangan'
        ];

        return view('laporan_keuangan_view', $data);
    }

    /**
     * Laporan Supplier
     */
    public function supplier()
    {
        $data = [
            'laporan_supplier' => $this->getLaporanSupplier(),
            'title' => 'Laporan Supplier'
        ];

        return view('laporan_supplier_view', $data);
    }

    /**
     * Export Laporan Stok ke Excel
     */
    public function exportStok()
    {
        $data = $this->getLaporanStok();

        // Set header untuk download Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="laporan_stok_' . date('Y-m-d') . '.xls"');

        // Generate simple Excel content
        echo "<table border='1'>";
        echo "<tr><th>No</th><th>Kode Barang</th><th>Nama HP</th><th>Merek</th><th>Stok</th><th>Harga Beli</th><th>Harga Jual</th><th>Status</th></tr>";

        $no = 1;
        foreach ($data as $item) {
            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>{$item['kode_barang']}</td>";
            echo "<td>{$item['nama_hp']}</td>";
            echo "<td>{$item['merek']}</td>";
            echo "<td>{$item['stok']}</td>";
            echo "<td>Rp " . number_format($item['harga_beli'], 0, ',', '.') . "</td>";
            echo "<td>Rp " . number_format($item['harga_jual'], 0, ',', '.') . "</td>";
            echo "<td>{$item['status']}</td>";
            echo "</tr>";
            $no++;
        }
        echo "</table>";
        exit;
    }

    /**
     * Export Laporan Transaksi ke Excel
     */
    public function exportTransaksi()
    {
        $data = $this->getLaporanTransaksi();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="laporan_transaksi_' . date('Y-m-d') . '.xls"');

        echo "<table border='1'>";
        echo "<tr><th>No</th><th>Tanggal</th><th>Jenis</th><th>Barang</th><th>Merek</th><th>Jumlah</th><th>Supplier</th><th>Keterangan</th></tr>";

        $no = 1;
        foreach ($data as $item) {
            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>" . date('d/m/Y', strtotime($item['tanggal'])) . "</td>";
            echo "<td>{$item['jenis']}</td>";
            echo "<td>{$item['nama_hp']}</td>";
            echo "<td>{$item['merek']}</td>";
            echo "<td>{$item['jumlah']}</td>";
            echo "<td>" . ($item['nama_supplier'] ?? '-') . "</td>";
            echo "<td>{$item['keterangan']}</td>";
            echo "</tr>";
            $no++;
        }
        echo "</table>";
        exit;
    }

    /**
     * Export Laporan Keuangan ke Excel
     */
    public function exportKeuangan()
    {
        $data = $this->getLaporanKeuangan();
        $total_modal = 0;
        $total_nilai_jual = 0;
        $total_keuntungan = 0;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="laporan_keuangan_' . date('Y-m-d') . '.xls"');

        echo "<table border='1'>";
        echo "<tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama HP</th>
                <th>Merek</th>
                <th>Stok</th>
                <th>Modal Total</th>
                <th>Nilai Jual</th>
                <th>Keuntungan</th>
                <th>Margin</th>
              </tr>";

        $no = 1;
        foreach ($data as $item) {
            $total_modal += $item['modal_total'];
            $total_nilai_jual += $item['nilai_jual_potensial'];
            $total_keuntungan += $item['keuntungan_potensial'];

            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>{$item['kode_barang']}</td>";
            echo "<td>{$item['nama_hp']}</td>";
            echo "<td>{$item['merek']}</td>";
            echo "<td>{$item['stok']}</td>";
            echo "<td>Rp " . number_format($item['modal_total'], 0, ',', '.') . "</td>";
            echo "<td>Rp " . number_format($item['nilai_jual_potensial'], 0, ',', '.') . "</td>";
            echo "<td style='color:" . ($item['keuntungan_potensial'] >= 0 ? 'green' : 'red') . "'>Rp " . number_format($item['keuntungan_potensial'], 0, ',', '.') . "</td>";
            echo "<td>" . number_format($item['margin'], 1) . "%</td>";
            echo "</tr>";
            $no++;
        }
        // TOTAL ROW
        echo "<tr style='background: #f0f0f0; font-weight: bold;'>
                <td colspan='5' style='text-align: right;'>TOTAL:</td>
                <td>Rp " . number_format($total_modal, 0, ',', '.') . "</td>
                <td>Rp " . number_format($total_nilai_jual, 0, ',', '.') . "</td>
                <td style='color:" . ($total_keuntungan >= 0 ? 'green' : 'red') . "'>Rp " . number_format($total_keuntungan, 0, ',', '.') . "</td>
                <td>" . ($total_modal > 0 ? number_format(($total_keuntungan / $total_modal) * 100, 1) : 0) . "%</td>
              </tr>";
        echo "</table>";
        exit;
    }

    /**
     * Export Laporan Supplier ke Excel
     */
    public function exportSupplier()
    {
        $data = $this->getLaporanSupplier();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="laporan_supplier_' . date('Y-m-d') . '.xls"');

        echo "<table border='1'>";
        echo "<tr>
                <th>No</th>
                <th>Supplier</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Total Transaksi</th>
                <th>Total Unit</th>
                <th>Total Nilai</th>
                <th>Transaksi Terakhir</th>
              </tr>";

        $no = 1;
        foreach ($data as $item) {
            $kontak = [];
            if ($item['telepon']) $kontak[] = $item['telepon'];
            if ($item['email']) $kontak[] = $item['email'];
            $kontak_str = implode(", ", $kontak);

            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td>{$item['nama_supplier']}</td>";
            echo "<td>{$item['alamat']}</td>";
            echo "<td>{$kontak_str}</td>";
            echo "<td>{$item['total_transaksi']}x</td>";
            echo "<td>{$item['total_unit']} unit</td>";
            echo "<td>Rp " . number_format($item['total_nilai'], 0, ',', '.') . "</td>";
            echo "<td>{$item['transaksi_terakhir']}</td>";
            echo "</tr>";
            $no++;
        }
        echo "</table>";
        exit;

    }

    // ==================== PRIVATE METHODS ====================

    /**
     * Get data laporan stok
     */
    private function getLaporanStok()
    {
        return $this->barangModel->findAll();
    }

    /**
     * Get data laporan transaksi
     */
    private function getLaporanTransaksi()
    {
        return $this->transaksiModel->getDetailedTransactions();
    }

    /**
     * Get data laporan keuangan
     */
    private function getLaporanKeuangan()
    {
        $barang = $this->barangModel->findAll();
        $transaksi = $this->transaksiModel->getDetailedTransactions();

        $laporan = [];

        foreach ($barang as $item) {
            // Hitung total modal (harga beli × stok)
            $modal_total = $item['harga_beli'] * $item['stok'];

            // Hitung nilai jual potensial (harga jual × stok)
            $nilai_jual = $item['harga_jual'] * $item['stok'];

            // Hitung keuntungan potensial per item
            $keuntungan_potensial = $nilai_jual - $modal_total;

            $laporan[] = [
                'kode_barang' => $item['kode_barang'],
                'nama_hp' => $item['nama_hp'],
                'merek' => $item['merek'],
                'stok' => $item['stok'],
                'harga_beli' => $item['harga_beli'],
                'harga_jual' => $item['harga_jual'],
                'modal_total' => $modal_total,
                'nilai_jual_potensial' => $nilai_jual,
                'keuntungan_potensial' => $keuntungan_potensial,
                'margin' => $item['harga_beli'] > 0 ? (($item['harga_jual'] - $item['harga_beli']) / $item['harga_beli']) * 100 : 0
            ];
        }

        return $laporan;
    }

    /**
     * Get data laporan supplier
     */
    private function getLaporanSupplier()
    {
        $suppliers = $this->supplierModel->findAll();
        $laporan = [];

        foreach ($suppliers as $supplier) {
            // Hitung total transaksi per supplier
            $total_transaksi_masuk = $this->transaksiModel
                ->where('supplier_id', $supplier['id'])
                ->where('jenis', 'Masuk')
                ->countAllResults();

            $total_unit_masuk = $this->transaksiModel
                ->selectSum('jumlah')
                ->where('supplier_id', $supplier['id'])
                ->where('jenis', 'Masuk')
                ->get()
                ->getRow()
                ->jumlah ?? 0;

            // Hitung nilai transaksi
            $transaksi_detail = $this->transaksiModel
                ->select('transaksi.*, barang.harga_beli')
                ->join('barang', 'barang.id = transaksi.barang_id')
                ->where('supplier_id', $supplier['id'])
                ->where('jenis', 'Masuk')
                ->findAll();

            $total_nilai = 0;
            foreach ($transaksi_detail as $t) {
                $total_nilai += ($t['harga_beli'] * $t['jumlah']);
            }

            $laporan[] = [
                'id' => $supplier['id'],
                'nama_supplier' => $supplier['nama_supplier'],
                'alamat' => $supplier['alamat'],
                'telepon' => $supplier['telepon'],
                'email' => $supplier['email'],
                'total_transaksi' => $total_transaksi_masuk,
                'total_unit' => $total_unit_masuk,
                'total_nilai' => $total_nilai,
                'transaksi_terakhir' => $this->getLastTransactionDate($supplier['id'])
            ];
        }

        return $laporan;
    }

    /**
     * Get tanggal transaksi terakhir supplier
     */
    private function getLastTransactionDate($supplier_id)
    {
        $last_transaction = $this->transaksiModel
            ->where('supplier_id', $supplier_id)
            ->orderBy('tanggal', 'DESC')
            ->first();

        return $last_transaction ? date('d/m/Y', strtotime($last_transaction['tanggal'])) : '-';
    }
}
