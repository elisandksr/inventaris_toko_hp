<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Inventory Gudang HP</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --secondary-gradient: linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);
            --bg-body: #f3f4f6;
            --glass-white: rgba(255, 255, 255, 0.95);
            --sidebar-width: 260px;
            --header-height: 70px;
            --text-dark: #1e293b;
            --text-gray: #64748b;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Nunito', sans-serif; }
        html { overflow-y: scroll; } 
        body { background: var(--bg-body); color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }

        /* HEADER */
        .app-header {
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid transparent;
            border-image: linear-gradient(to right, #6366f1, #a855f7, #ec4899) 1;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .brand { 
            font-family: 'Fredoka', sans-serif; font-size: 1.6rem; font-weight: 700; 
            background: linear-gradient(to right, #6366f1, #d946ef, #f43f5e); 
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            display: flex; align-items: center; gap: 0.8rem; letter-spacing: 0.5px;
            filter: drop-shadow(0 2px 4px rgba(99, 102, 241, 0.2));
        }
        .search-box { position: relative; width: 400px; }
        .search-box input {
            width: 100%; padding: 0.8rem 1.2rem 0.8rem 3.2rem; 
            border: 2px solid #e2e8f0; border-radius: 50px;
            background: #f8fafc; transition: all 0.3s ease;
            font-size: 0.95rem; height: 48px; color: var(--text-dark);
        }
        .search-box input:focus { 
            border-color: #d946ef; background: white; 
            box-shadow: 0 0 0 4px rgba(217, 70, 239, 0.15); 
        }
        .search-box i { 
            position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%); 
            color: #94a3b8; font-size: 1.4rem; transition: 0.3s;
        }
        .search-box input:focus + i { color: #d946ef; }
        
        .profile { display: flex; align-items: center; gap: 1rem; padding-left: 1rem; border-left: 1px solid #e2e8f0; height: 40px; margin-left: 1rem; }
        .avatar { 
            width: 45px; height: 45px; 
            background: linear-gradient(135deg, #f43f5e 0%, #a855f7 100%); 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            color: white; font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(244, 63, 94, 0.4); 
            transition: 0.3s;
            border: 2px solid white;
            outline: 2px solid #f43f5e;
        }
        .avatar:hover { transform: scale(1.1) rotate(5deg); }

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
        
        /* 2. SECONDARY NAVBAR (BREADCRUMB BAR) - Consistent Layout */
        .app-navbar {
            height: 50px; background: white; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; padding: 0 2rem;
            position: fixed; top: var(--header-height); left: 0; right: 0; z-index: 990;
            padding-left: calc(var(--sidebar-width) + 2rem);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        
        /* BREADCRUMB STYLING WITHIN NAVBAR */
        .breadcrumb {
            background: transparent; padding: 0; margin: 0;
            box-shadow: none; display: flex; align-items: center; gap: 8px;
            font-size: 0.9rem; font-weight: 600; color: var(--text-gray);
        }
        .breadcrumb a { color: var(--text-gray); text-decoration: none; transition: 0.3s; display: flex; align-items: center; gap: 5px; }
        .breadcrumb a:hover { color: var(--primary); }
        .breadcrumb i { color: #cbd5e1; font-size: 1.2rem; }
        .breadcrumb span { color: var(--primary); font-weight: 700; }

        /* MAIN CONTENT */
        .main-content {
            margin-top: 120px;
            margin-left: var(--sidebar-width);
            padding: 2rem;
            flex: 1;
        }

        /* HEADER CARD */
        .header-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-info h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        .header-info p {
            color: var(--text-gray);
            font-size: 1rem;
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        .stat-info .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
            margin-bottom: 0.2rem;
        }
        .stat-info .stat-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #94a3b8;
        }

        /* TABS */
        .tabs {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
        }
        .tab-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 1rem;
        }
        .tab-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            background: none;
            color: var(--text-gray);
            font-weight: 600;
            cursor: pointer;
            border-radius: 12px;
            transition: 0.3s;
        }
        .tab-btn.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }

        /* TABLE */
        .table-responsive {
            overflow-x: auto;
            background: white;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
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
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        .table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
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
        .status-ready { background: #dcfce7; color: #166534; }
        .status-low { background: #fef3c7; color: #92400e; }
        .status-empty { background: #fee2e2; color: #dc2626; }

        /* BUTTONS */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: 0.3s;
            cursor: pointer;
            border: none;
            font-size: 0.85rem;
        }
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        .btn-success {
            background: var(--success-gradient);
            color: white;
        }

        /* CURRENCY FORMATTING */
        .currency {
            font-weight: 700;
            color: var(--text-dark);
        }
        .profit { color: #10b981; }
        .loss { color: #ef4444; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .app-sidebar {
                transform: translateX(-100%);
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .header-card {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            .tab-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Cek Error (Misal error DB connection) -->
    <?php if(isset($error)): ?>
        <div style="max-width:800px; margin:50px auto; padding:20px; background:white; border-radius:12px; box-shadow:0 4px 6px rgba(0,0,0,0.1); font-family:'Nunito', sans-serif;">
            <h1 style="color:#ef4444; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;"><i class='bx bxs-error-circle'></i> Terjadi Kesalahan</h1>
            <div style="background:#fef2f2; color:#b91c1c; padding:15px; border-radius:8px; border:1px solid #fecaca; margin-bottom:1.5rem;">
                <?= esc($error) ?>
            </div>
            <p>Silakan coba refresh halaman atau hubungi pengembang jika masalah berlanjut.</p>
            <a href="<?= base_url('dashboard') ?>" style="display:inline-block; margin-top:1rem; padding:0.75rem 1.5rem; background:#6366f1; color:white; text-decoration:none; border-radius:8px; font-weight:700;">Kembali ke Dashboard</a>
        </div>
        </body></html>
        <?php exit; endif; ?>

    <!-- HEADER -->
    <header class="app-header">
        <div class="brand">
            <i class='bx bxs-store' style="font-size: 1.8rem;"></i> 
            Inventory Toko HP Amelia & Elis
        </div>
        
        <!-- Search removed for this page -->

        <div class="profile">
            <div style="text-align:right;">
                <div style="font-weight:700; font-size:0.95rem; color: #1e293b;"><?= session()->get('nama_admin') ?></div>
                <div style="font-size:0.75rem; color:#d946ef; font-weight:700;">Owner & Admin</div>
            </div>
            <div class="avatar"><i class='bx bxs-face'></i></div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside class="app-sidebar">
        <a href="<?= base_url('dashboard') ?>" class="menu-item"><i class='bx bxs-dashboard'></i> Dashboard</a>
        <div class="menu-title">Master Data</div>
        
        <a href="<?= base_url('barang') ?>" class="menu-item"><i class='bx bxs-component'></i> Data Barang</a>
        <a href="<?= base_url('supplier') ?>" class="menu-item"><i class='bx bxs-truck'></i> Supplier</a>
        
        <div class="menu-title">Transaksi</div>
        <a href="<?= base_url('transaksi/masuk') ?>" class="menu-item"><i class='bx bxs-down-arrow-square'></i> Barang Masuk</a>
        <a href="<?= base_url('transaksi/keluar') ?>" class="menu-item"><i class='bx bxs-up-arrow-square'></i> Barang Keluar</a>
        
        
        <div class="menu-title">Laporan</div>
        <!-- Link ke Laporan (Aktif) -->
        <a href="<?= base_url('laporan') ?>" class="menu-item active"><i class='bx bxs-pie-chart-alt-2'></i> Laporan</a>
        <!-- Link Logout -->
        <a href="<?= base_url('logout') ?>" class="menu-item" style="color:#f43f5e;"><i class='bx bxs-log-out'></i> Logout</a>

        <!-- Copyright text di bagian bawah sidebar -->
        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); text-align: center; color: #94a3b8; font-size: 0.8rem; font-weight: 600; line-height: 1.2;">
            @2026<br>
            Manajemen Inventaris<br>
            Gudang Toko HP
        </div>
    </aside>

    <!-- NAVBAR (BREADCRUMB) -->
    <nav class="app-navbar">
        <div class="breadcrumb">
            <!-- Link Breadcrumb -->
            <a href="<?= base_url('dashboard') ?>"><i class='bx bxs-home-smile'></i> Dashboard</a>
            <i class='bx bx-chevron-right'></i>
            <span>Laporan</span>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- HEADER CARD -->
        <div class="header-card">
            <div class="header-info">
                <h1>📊 Sistem Laporan</h1>
                <p>Monitor performa inventory dan analisis data gudang HP</p>
            </div>
        </div>

        <!-- STATS CARDS RINGKASAN DATA -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--primary-gradient);">
                    <i class='bx bx-mobile'></i>
                </div>
                <div class="stat-info">
                    <!-- Total Varian Barang -->
                    <div class="stat-value"><?= $total_barang ?></div>
                    <div class="stat-label">Jenis HP</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--secondary-gradient);">
                    <i class='bx bx-layer'></i>
                </div>
                <div class="stat-info">
                    <!-- Total Stok Unit Keseluruhan -->
                    <div class="stat-value"><?= $total_stok ?></div>
                    <div class="stat-label">Total Unit</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--success-gradient);">
                    <i class='bx bx-trending-up'></i>
                </div>
                <div class="stat-info">
                    <!-- Total Transaksi Masuk -->
                    <div class="stat-value"><?= $total_transaksi_masuk ?></div>
                    <div class="stat-label">Transaksi Masuk</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--warning-gradient);">
                    <i class='bx bx-trending-down'></i>
                </div>
                <div class="stat-info">
                    <!-- Total Transaksi Keluar -->
                    <div class="stat-value"><?= $total_transaksi_keluar ?></div>
                    <div class="stat-label">Transaksi Keluar</div>
                </div>
            </div>
        </div>

        <!-- TABS NAVIGASI LAPORAN -->
        <div class="tabs">
            <div class="tab-buttons">
                <!-- Tombol Switch Tab (JS) -->
                <button class="tab-btn active" onclick="showTab('stok')">📦 Stok Barang</button>
                <button class="tab-btn" onclick="showTab('transaksi')">🔄 Riwayat Transaksi</button>
                <button class="tab-btn" onclick="showTab('keuangan')">💰 Laporan Keuangan</button>
                <button class="tab-btn" onclick="showTab('supplier')">🚛 Laporan Supplier</button>
            </div>

            <!-- TAB STOK -->
            <div id="stok" class="tab-content active">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="margin: 0; color: var(--text-dark);">Laporan Stok Barang</h3>
                    <!-- Tombol Export Excel -->
                    <a href="<?= base_url('laporan/exportStok') ?>" class="btn btn-success">
                        <i class='bx bx-download'></i> Export Excel
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama HP</th>
                                <th>Merek</th>
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop Data Laporan Stok -->
                            <?php foreach ($laporan_stok as $item): ?>
                                <tr>
                                    <td><strong><?= $item['kode_barang'] ?></strong></td>
                                    <td><?= $item['nama_hp'] ?></td>
                                    <td><?= $item['merek'] ?></td>
                                    <td><strong><?= $item['stok'] ?> unit</strong></td>
                                    <!-- Format Harga -->
                                    <td class="currency">Rp <?= number_format($item['harga_beli'], 0, ',', '.') ?></td>
                                    <td class="currency">Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?></td>
                                    <td>
                                        <!-- Cek Status Stok (Badge) -->
                                        <?php if ($item['stok'] > 5): ?>
                                            <span class="status-badge status-ready">Ready</span>
                                        <?php elseif ($item['stok'] > 0): ?>
                                            <span class="status-badge status-low">Menipis</span>
                                        <?php else: ?>
                                            <span class="status-badge status-empty">Kosong</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB TRANSAKSI -->
            <div id="transaksi" class="tab-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="margin: 0; color: var(--text-dark);">Riwayat Transaksi Lengkap</h3>
                    <!-- Export Excel Transaksi -->
                    <a href="<?= base_url('laporan/exportTransaksi') ?>" class="btn btn-success">
                        <i class='bx bx-download'></i> Export Excel
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Barang</th>
                                <th>Merek</th>
                                <th>Jumlah</th>
                                <th>Supplier</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop Data Riwayat Transaksi (Masuk & Keluar) -->
                            <?php foreach ($laporan_transaksi as $item): ?>
                                <tr>
                                    <td><strong><?= date('d/m/Y', strtotime($item['tanggal'])) ?></strong></td>
                                    <td>
                                        <!-- Cek Jenis Transaksi -->
                                        <?php if ($item['jenis'] == 'Masuk'): ?>
                                            <span style="color: #10b981; font-weight: 700;">📥 Masuk</span>
                                        <?php else: ?>
                                            <span style="color: #ef4444; font-weight: 700;">📤 Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= $item['nama_hp'] ?></strong></td>
                                    <td><?= $item['merek'] ?></td>
                                    <td><strong><?= $item['jumlah'] ?> unit</strong></td>
                                    <td><?= $item['nama_supplier'] ?? '-' ?></td>
                                    <td><?= $item['keterangan'] ?? '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB KEUANGAN -->
            <div id="keuangan" class="tab-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="margin: 0; color: var(--text-dark);">Laporan Keuangan</h3>
                    <a href="<?= base_url('laporan/exportKeuangan') ?>" class="btn btn-success">
                        <i class='bx bx-download'></i> Export Excel
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama HP</th>
                                <th>Merek</th>
                                <th>Stok</th>
                                <th>Modal Total</th>
                                <th>Nilai Jual</th>
                                <th>Keuntungan</th>
                                <th>Margin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop + Hitung Total Keuangan secara Langsung -->
                            <?php
                            $total_modal = 0;
                            $total_nilai_jual = 0;
                            $total_keuntungan = 0;
                            foreach ($laporan_keuangan as $item):
                                $total_modal += $item['modal_total'];
                                $total_nilai_jual += $item['nilai_jual_potensial'];
                                $total_keuntungan += $item['keuntungan_potensial'];
                            ?>
                                <tr>
                                    <td><strong><?= $item['kode_barang'] ?></strong></td>
                                    <td><?= $item['nama_hp'] ?></td>
                                    <td><?= $item['merek'] ?></td>
                                    <td><strong><?= $item['stok'] ?> unit</strong></td>
                                    <td class="currency">Rp <?= number_format($item['modal_total'], 0, ',', '.') ?></td>
                                    <td class="currency">Rp <?= number_format($item['nilai_jual_potensial'], 0, ',', '.') ?></td>
                                    <!-- Warna Keuntungan (Hijau/Merah) -->
                                    <td class="currency <?= $item['keuntungan_potensial'] >= 0 ? 'profit' : 'loss' ?>">
                                        Rp <?= number_format($item['keuntungan_potensial'], 0, ',', '.') ?>
                                    </td>
                                    <td class="currency <?= $item['margin'] >= 0 ? 'profit' : 'loss' ?>">
                                        <?= number_format($item['margin'], 1) ?>%
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- BARIS TOTAL (SUMMARY) -->
                            <tr style="background: #f8fafc; border-top: 2px solid var(--primary);">
                                <td colspan="4" style="font-weight: 800; text-align: right;">TOTAL:</td>
                                <td class="currency" style="font-weight: 800;">Rp <?= number_format($total_modal, 0, ',', '.') ?></td>
                                <td class="currency" style="font-weight: 800;">Rp <?= number_format($total_nilai_jual, 0, ',', '.') ?></td>
                                <td class="currency <?= $total_keuntungan >= 0 ? 'profit' : 'loss' ?>" style="font-weight: 800;">
                                    Rp <?= number_format($total_keuntungan, 0, ',', '.') ?>
                                </td>
                                <!-- Hitung Margin Rata-rata Total -->
                                <td class="currency <?= $total_keuntungan >= 0 ? 'profit' : 'loss' ?>" style="font-weight: 800;">
                                    <?= $total_modal > 0 ? number_format(($total_keuntungan / $total_modal) * 100, 1) : 0 ?>%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB SUPPLIER -->
            <div id="supplier" class="tab-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="margin: 0; color: var(--text-dark);">Laporan Supplier</h3>
                    <a href="<?= base_url('laporan/exportSupplier') ?>" class="btn btn-success">
                        <i class='bx bx-download'></i> Export Excel
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Supplier</th>
                                <th>Kontak</th>
                                <th>Total Transaksi</th>
                                <th>Total Unit</th>
                                <th>Total Nilai</th>
                                <th>Transaksi Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop Data Laporan Supplier -->
                            <?php foreach ($laporan_supplier as $supplier): ?>
                                <tr>
                                    <td>
                                        <strong><?= $supplier['nama_supplier'] ?></strong>
                                        <?php if ($supplier['alamat']): ?>
                                            <br><small style="color: var(--text-gray);"><?= $supplier['alamat'] ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($supplier['telepon']): ?>
                                            <div><i class='bx bx-phone'></i> <?= $supplier['telepon'] ?></div>
                                        <?php endif; ?>
                                        <?php if ($supplier['email']): ?>
                                            <div><i class='bx bx-envelope'></i> <?= $supplier['email'] ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Statistik Supplier Data -->
                                    <td><strong style="color: var(--primary);"><?= $supplier['total_transaksi'] ?>x</strong></td>
                                    <td><strong><?= $supplier['total_unit'] ?> unit</strong></td>
                                    <td class="currency">Rp <?= number_format($supplier['total_nilai'], 0, ',', '.') ?></td>
                                    <td><strong><?= $supplier['transaksi_terakhir'] ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Fungsi JavaScript Manipulasi Tab (Show/Hide)
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));

            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(button => button.classList.remove('active'));

            // Show selected tab content
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked button
            event.target.classList.add('active');
        }
    </script>

</body>
</html>
