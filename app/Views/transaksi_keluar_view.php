<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar - Inventory Gudang</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --secondary-gradient: linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --bg-body: #f3f4f6;
            --glass-white: rgba(255, 255, 255, 0.95);
            --sidebar-width: 260px;
            --header-height: 70px;
            --text-dark: #1e293b;
            --text-gray: #64748b;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Nunito', sans-serif; }
        body { background: var(--bg-body); color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }

        /* HEADER */
        .app-header {
            height: var(--header-height);
            background: var(--glass-white);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .brand {
            font-family: 'Fredoka', sans-serif; font-size: 1.5rem; font-weight: 600;
            background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            display: flex; align-items: center; gap: 0.5rem; letter-spacing: 0.5px;
        }
        .profile { display: flex; align-items: center; gap: 1rem; }
        .avatar { width: 42px; height: 42px; background: var(--secondary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 2px 10px rgba(59, 130, 246, 0.3); }

        /* SIDEBAR */
        .app-sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 2px solid #e2e8f0;
            position: fixed; top: var(--header-height); bottom: 0; left: 0; z-index: 995;
            padding: 2rem 0; overflow-y: auto;
        }
        .menu-title { font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; padding: 0 1.5rem; margin-top: 1.5rem; font-weight: 800; letter-spacing: 1px; }
        .menu-item {
            display: flex; align-items: center; gap: 1rem; padding: 0.9rem 1.5rem;
            color: var(--text-gray); font-weight: 600; transition: 0.3s;
            margin: 0.2rem 1rem; border-radius: 12px;
        }
        .menu-item:hover, .menu-item.active {
            background: var(--primary-gradient); color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            transform: translateX(5px);
        }
        .menu-item i { font-size: 1.3rem; }

        /* MAIN CONTENT */
        .main-content {
            margin-top: var(--header-height);
            margin-left: var(--sidebar-width);
            padding: 2rem;
            flex: 1;
        }

        /* BREADCRUMB */
        .breadcrumb {
            background: white;
            padding: 12px 24px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* FORM CARD */
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
        }
        .form-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }
        .form-header i {
            font-size: 2rem;
            background: var(--warning-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* FORM STYLES */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: 0.3s;
            background: #f8fafc;
        }
        .form-control:focus {
            border-color: #f59e0b;
            outline: none;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            background: white;
        }
        .form-control.select {
            cursor: pointer;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* STOCK INFO */
        .stock-info {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .stock-info i {
            color: #d97706;
            font-size: 1.5rem;
        }

        /* BUTTONS */
        .btn {
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: 0.3s;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }
        .btn-warning {
            background: var(--warning-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }
        .btn-secondary {
            background: #f1f5f9;
            color: var(--text-gray);
        }
        .btn-secondary:hover {
            background: #e2e8f0;
        }

        /* TABLE */
        .table-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }
        .table-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .table-responsive {
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            background: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 700;
            color: var(--text-dark);
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.9rem;
        }
        .table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.95rem;
        }
        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* STATUS BADGES */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-warning { background: #fef3c7; color: #92400e; }
        .status-info { background: #dbeafe; color: #1e40af; }

        /* ALERTS */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .app-sidebar {
                transform: translateX(-100%);
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="app-header">
        <div class="brand"><i class='bx bxs-mobile-vibration'></i> INVENTORY GUDANG</div>
        <div class="profile">
            <div style="text-align:right;">
                <div style="font-weight:700; font-size:0.95rem;"><?= session()->get('nama_admin') ?></div>
                <div style="font-size:0.75rem; color:#f472b6; font-weight:600;">Super Admin</div>
            </div>
            <div class="avatar"><i class='bx bxs-user'></i></div>
        </div>
    </header>

  <!-- SIDEBAR -->
  <aside class="app-sidebar">
    <a href="<?= base_url('dashboard') ?>" class="menu-item active"><i class='bx bxs-dashboard'></i> Dashboard</a>
        <div class="menu-title">Master Data</div>
        
        <a href="<?= base_url('barang') ?>" class="menu-item"><i class='bx bxs-component'></i> Data Barang</a>
        <a href="<?= base_url('supplier') ?>" class="menu-item"><i class='bx bxs-truck'></i> Supplier</a>
        
        <div class="menu-title">Transaksi</div>
        <a href="<?= base_url('transaksi/masuk') ?>" class="menu-item"><i class='bx bxs-down-arrow-square'></i> Barang Masuk</a>
        <a href="<?= base_url('transaksi/keluar') ?>" class="menu-item"><i class='bx bxs-up-arrow-square'></i> Barang Keluar</a>
        
        
        <div class="menu-title">Laporan</div>
        <a href="<?= base_url('laporan') ?>" class="menu-item"><i class='bx bxs-pie-chart-alt-2'></i> Laporan</a>
        <a href="<?= base_url('logout') ?>" class="menu-item" style="color:#f43f5e;"><i class='bx bxs-log-out'></i> Logout</a>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- BREADCRUMB -->
        <nav class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <i class='bx bx-chevron-right'></i>
            <a href="<?= base_url('transaksi/keluar') ?>">Transaksi</a>
            <i class='bx bx-chevron-right'></i>
            <span>Barang Keluar</span>
        </nav>

        <!-- ALERTS -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class='bx bx-check-circle'></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <i class='bx bx-error-circle'></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FORM BARANG KELUAR -->
        <div class="form-card">
            <div class="form-header">
                <i class='bx bx-minus-circle'></i>
                <div class="form-title">Input Barang Keluar</div>
            </div>

            <form action="<?= base_url('transaksi/prosesKeluar') ?>" method="post" id="formBarangKeluar">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Pilih Barang HP</label>
                        <select name="barang_id" class="form-control select" id="barangSelect" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php foreach ($barang as $item): ?>
                                <option value="<?= $item['id'] ?>" data-stok="<?= $item['stok'] ?>" data-nama="<?= $item['nama_hp'] ?>">
                                    <?= $item['nama_hp'] ?> (<?= $item['merek'] ?>) - Stok: <?= $item['stok'] ?> unit
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Keluar</label>
                        <input type="number" name="jumlah" id="jumlahInput" class="form-control" placeholder="0" min="1" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Tanggal Keluar</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tujuan (Opsional)</label>
                        <select name="tujuan" class="form-control select">
                            <option value="">-- Pilih Tujuan --</option>
                            <option value="Penjualan">Penjualan</option>
                            <option value="Service">Service</option>
                            <option value="Return">Return ke Supplier</option>
                            <option value="Rusak">Barang Rusak</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>

                <!-- STOCK INFO - akan diisi JavaScript -->
                <div id="stockInfo" class="stock-info" style="display: none;">
                    <i class='bx bx-info-circle'></i>
                    <div id="stockText"></div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-warning">
                        <i class='bx bx-save'></i>
                        Simpan Transaksi
                    </button>
                    <a href="<?= base_url('transaksi/keluar') ?>" class="btn btn-secondary">
                        <i class='bx bx-refresh'></i>
                        Reset Form
                    </a>
                </div>
            </form>
        </div>

        <!-- RIWAYAT TRANSAKSI KELUAR -->
        <div class="table-card">
            <div class="table-header">
                <div class="table-title">Riwayat Barang Keluar</div>
                <div style="font-size: 0.9rem; color: var(--text-gray);">
                    Total: <?= count($transaksi_keluar) ?> transaksi
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Tujuan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transaksi_keluar)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-gray); padding: 3rem;">
                                    <i class='bx bx-info-circle' style="font-size: 2rem; margin-bottom: 0.5rem;"></i><br>
                                    Belum ada data transaksi barang keluar
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transaksi_keluar as $transaksi):
                                // Get detailed info
                                $barang_info = array_filter($barang, function($b) use ($transaksi) {
                                    return $b['id'] == $transaksi['barang_id'];
                                });
                                $barang_info = reset($barang_info);
                            ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($transaksi['tanggal'])) ?></td>
                                    <td>
                                        <strong><?= $barang_info ? $barang_info['nama_hp'] : 'Unknown' ?></strong><br>
                                        <small style="color: var(--text-gray);"><?= $barang_info ? $barang_info['merek'] : '' ?></small>
                                    </td>
                                    <td>
                                        <span class="status-badge status-warning">
                                            -<?= $transaksi['jumlah'] ?> unit
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $keterangan = $transaksi['keterangan'];
                                        if (strpos($keterangan, 'Penjualan') !== false) echo 'Penjualan';
                                        elseif (strpos($keterangan, 'Service') !== false) echo 'Service';
                                        elseif (strpos($keterangan, 'Return') !== false) echo 'Return';
                                        elseif (strpos($keterangan, 'Rusak') !== false) echo 'Rusak';
                                        else echo 'Lainnya';
                                        ?>
                                    </td>
                                    <td><?= $transaksi['keterangan'] ?: '-' ?></td>
                                    <td>
                                        <a href="<?= base_url('transaksi/delete/' . $transaksi['id']) ?>"
                                           onclick="return confirm('Yakin hapus transaksi ini? Stok akan dikembalikan.')"
                                           style="color: #dc2626; text-decoration: none;">
                                            <i class='bx bx-trash'></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        // JavaScript untuk validasi stok real-time
        document.getElementById('barangSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
            const namaBarang = selectedOption.getAttribute('data-nama') || '';

            const stockInfo = document.getElementById('stockInfo');
            const stockText = document.getElementById('stockText');
            const jumlahInput = document.getElementById('jumlahInput');

            if (stok > 0) {
                stockText.innerHTML = `<strong>${namaBarang}</strong> - Stok tersedia: <strong>${stok} unit</strong>`;
                stockInfo.style.display = 'flex';
                jumlahInput.max = stok;
            } else {
                stockInfo.style.display = 'none';
                jumlahInput.max = '';
            }
        });

        // Validasi form sebelum submit
        document.getElementById('formBarangKeluar').addEventListener('submit', function(e) {
            const selectedOption = document.getElementById('barangSelect').options[document.getElementById('barangSelect').selectedIndex];
            const stok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
            const jumlah = parseInt(document.getElementById('jumlahInput').value) || 0;

            if (jumlah > stok) {
                e.preventDefault();
                alert('Jumlah keluar tidak boleh melebihi stok tersedia!');
                return false;
            }
        });
    </script>

</body>
</html>
