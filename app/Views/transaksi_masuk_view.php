<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk - Inventory Gudang</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --secondary-gradient: linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --bg-body: #f3f4f6;
            --glass-white: rgba(255, 255, 255, 0.95);
            --sidebar-width: 260px;
            --header-height: 70px;
            --text-dark: #1e293b;
            --text-gray: #64748b;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Nunito', sans-serif; }
        html { overflow-y: scroll; } /* Force Scrollbar for consistency */
        body { background: var(--bg-body); color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }

        /* HEADER */
        /* 1. HEADER - Colorful & Glassy */
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
            margin-top: 120px; /* Header (70px) + Navbar (50px) */
            margin-left: var(--sidebar-width);
            padding: 2rem;
            flex: 1;
        }

        /* BREADCRUMB */
        /* The original breadcrumb styling is now overridden by the new .breadcrumb within .app-navbar */
        /* .breadcrumb {
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
        } */

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
            background: var(--primary-gradient);
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
            border-color: #a855f7;
            outline: none;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
            background: white;
        }
        .form-control.select {
            cursor: pointer;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 80px;
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
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
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
        .status-success { background: #dcfce7; color: #166534; }
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
  <!-- SIDEBAR -->
  <aside class="app-sidebar">
    <a href="<?= base_url('dashboard') ?>" class="menu-item"><i class='bx bxs-dashboard'></i> Dashboard</a>
        <div class="menu-title">Master Data</div>
        
        <a href="<?= base_url('barang') ?>" class="menu-item"><i class='bx bxs-component'></i> Data Barang</a>
        <a href="<?= base_url('supplier') ?>" class="menu-item"><i class='bx bxs-truck'></i> Supplier</a>
        
        <div class="menu-title">Transaksi</div>
        <a href="<?= base_url('transaksi/masuk') ?>" class="menu-item active"><i class='bx bxs-down-arrow-square'></i> Barang Masuk</a>
        <a href="<?= base_url('transaksi/keluar') ?>" class="menu-item"><i class='bx bxs-up-arrow-square'></i> Barang Keluar</a>
        
        
        <div class="menu-title">Laporan</div>
        <a href="<?= base_url('laporan') ?>" class="menu-item"><i class='bx bxs-pie-chart-alt-2'></i> Laporan</a>

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
            <!-- Link Navigasi Breadcrumb -->
            <a href="<?= base_url('dashboard') ?>"><i class='bx bxs-home-smile'></i> Dashboard</a>
            <i class='bx bx-chevron-right'></i>
            <span style="color: var(--text-gray); font-weight: 600;">Transaksi</span>
            <i class='bx bx-chevron-right'></i>
            <span>Barang Masuk</span>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- ALERTS -->
        <!-- Cek Flash Message Sukses -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class='bx bx-check-circle'></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Cek Flash Message Error -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <i class='bx bx-error-circle'></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- FORM BARANG MASUK -->
        <div class="form-card">
            <div class="form-header">
                <i class='bx bx-plus-circle'></i>
                <div class="form-title">Input Barang Masuk</div>
            </div>

            <!-- Form Action: Kirim data POST ke Transaksi::prosesMasuk -->
            <form action="<?= base_url('transaksi/prosesMasuk') ?>" method="post">
                <div class="form-row">
                    <!-- Dropdown Pilih Barang -->
                    <div class="form-group">
                        <label class="form-label">Pilih Barang HP</label>
                        <select name="barang_id" class="form-control select" required>
                            <option value="">-- Pilih Barang --</option>
                            <!-- Loop Data Barang untuk Opsi Select -->
                            <?php foreach ($barang as $item): ?>
                                <option value="<?= $item['id'] ?>">
                                    <?= $item['nama_hp'] ?> (<?= $item['merek'] ?>) - Stok: <?= $item['stok'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-control select" required>
                            <option value="">-- Pilih Supplier --</option>
                            <?php foreach ($suppliers as $supplier): ?>
                                <option value="<?= $supplier['id'] ?>">
                                    <?= $supplier['nama_supplier'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Jumlah Masuk</label>
                        <!-- Input Jumlah (Min 1) -->
                        <input type="number" name="jumlah" class="form-control" placeholder="0" min="1" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <!-- Tombol Submit Form -->
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-save'></i>
                        Simpan Transaksi
                    </button>
                    <a href="<?= base_url('transaksi/masuk') ?>" class="btn btn-secondary">
                        <i class='bx bx-refresh'></i>
                        Reset Form
                    </a>
                </div>
            </form>
        </div>

        <!-- RIWAYAT TRANSAKSI MASUK -->
        <div class="table-card">
            <div class="table-header">
                <div class="table-title">Riwayat Barang Masuk</div>
                <!-- Menampilkan Total Transaksi (Count Array) -->
                <div style="font-size: 0.9rem; color: var(--text-gray);">
                    Total: <?= count($transaksi_masuk) ?> transaksi
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Supplier</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Cek jika data kosong -->
                        <?php if (empty($transaksi_masuk)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-gray); padding: 3rem;">
                                    <i class='bx bx-info-circle' style="font-size: 2rem; margin-bottom: 0.5rem;"></i><br>
                                    Belum ada data transaksi barang masuk
                                </td>
                            </tr>
                        <?php else: ?>
                            <!-- Loop Data Transaksi -->
                            <?php foreach ($transaksi_masuk as $transaksi):
                                // Logika pencarian detail barang berdasarkan ID
                                $barang_info = array_filter($barang, function($b) use ($transaksi) {
                                    return $b['id'] == $transaksi['barang_id'];
                                });
                                $barang_info = reset($barang_info);

                                $supplier_info = array_filter($suppliers, function($s) use ($transaksi) {
                                    return $s['id'] == $transaksi['supplier_id'];
                                });
                                $supplier_info = reset($supplier_info);
                            ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($transaksi['tanggal'])) ?></td>
                                    <td>
                                        <strong><?= $barang_info ? $barang_info['nama_hp'] : 'Unknown' ?></strong><br>
                                        <small style="color: var(--text-gray);"><?= $barang_info ? $barang_info['merek'] : '' ?></small>
                                    </td>
                                    <td><?= $supplier_info ? $supplier_info['nama_supplier'] : 'Unknown' ?></td>
                                    <td>
                                        <span class="status-badge status-success">
                                            +<?= $transaksi['jumlah'] ?> unit
                                        </span>
                                    </td>
                                    <td><?= $transaksi['keterangan'] ?: '-' ?></td>
                                    <td>
                                        <!-- Link Hapus dengan Konfirmasi JS -->
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

</body>
</html>
