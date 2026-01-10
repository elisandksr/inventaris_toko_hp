<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Supplier - Inventory Gudang</title>
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
        .header-actions {
            display: flex;
            gap: 1rem;
        }

        /* BUTTONS */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: 0.3s;
            cursor: pointer;
            border: none;
            font-size: 0.95rem;
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
        .btn-success {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        /* SUPPLIER CARDS */
        .suppliers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }
        .supplier-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
            transition: 0.3s;
        }
        .supplier-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
        }
        .supplier-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .supplier-icon {
            width: 50px;
            height: 50px;
            background: var(--secondary-gradient);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        .supplier-info h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }
        .supplier-info .supplier-meta {
            color: var(--text-gray);
            font-size: 0.9rem;
        }
        .supplier-details {
            margin-bottom: 1rem;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        .detail-label {
            color: var(--text-gray);
        }
        .detail-value {
            color: var(--text-dark);
            font-weight: 600;
        }
        .supplier-actions {
            display: flex;
            gap: 0.5rem;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
        }
        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            border-radius: 25px;
        }
        .btn-edit {
            background: #f1f5f9;
            color: var(--text-gray);
        }
        .btn-edit:hover {
            background: #e2e8f0;
        }
        .btn-delete {
            background: #fef2f2;
            color: #dc2626;
        }
        .btn-delete:hover {
            background: #fecaca;
        }

        /* EMPTY STATE */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-gray);
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

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
            .suppliers-grid {
                grid-template-columns: 1fr;
            }
            .header-card {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            .supplier-actions {
                flex-direction: column;
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
            <span>Manajemen Supplier</span>
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

        <!-- HEADER CARD -->
        <div class="header-card">
            <div class="header-info">
                <h1>Manajemen Supplier</h1>
                <p>Kelola data supplier dan distributor untuk inventaris HP Anda</p>
            </div>
            <div class="header-actions">
                <a href="<?= base_url('supplier/create') ?>" class="btn btn-primary">
                    <i class='bx bx-plus'></i>
                    Tambah Supplier
                </a>
                <button onclick="location.reload()" class="btn btn-success">
                    <i class='bx bx-refresh'></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- SUPPLIERS GRID -->
        <div class="suppliers-grid">
            <?php if (empty($suppliers)): ?>
                <div class="empty-state">
                    <i class='bx bx-truck'></i>
                    <h3>Belum ada data supplier</h3>
                    <p>Tambahkan supplier pertama untuk memulai mengelola inventaris</p>
                    <a href="<?= base_url('supplier/create') ?>" class="btn btn-primary" style="margin-top: 1rem;">
                        <i class='bx bx-plus'></i>
                        Tambah Supplier Pertama
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($suppliers as $supplier): ?>
                    <div class="supplier-card">
                        <div class="supplier-header">
                            <div class="supplier-icon">
                                <i class='bx bx-truck'></i>
                            </div>
                            <div class="supplier-info">
                                <h3><?= esc($supplier['nama_supplier']) ?></h3>
                                <div class="supplier-meta">
                                    <i class='bx bx-calendar'></i>
                                    Ditambahkan <?= date('d M Y', strtotime($supplier['created_at'])) ?>
                                </div>
                            </div>
                        </div>

                        <div class="supplier-details">
                            <?php if ($supplier['alamat']): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Alamat:</span>
                                    <span class="detail-value"><?= esc($supplier['alamat']) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($supplier['telepon']): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Telepon:</span>
                                    <span class="detail-value"><?= esc($supplier['telepon']) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($supplier['email']): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Email:</span>
                                    <span class="detail-value"><?= esc($supplier['email']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="supplier-actions">
                            <a href="<?= base_url('supplier/edit/' . $supplier['id']) ?>" class="btn btn-small btn-edit">
                                <i class='bx bx-edit'></i>
                                Edit
                            </a>
                            <a href="<?= base_url('supplier/delete/' . $supplier['id']) ?>"
                               onclick="return confirm('Yakin hapus supplier ini? Pastikan tidak ada transaksi yang terkait.')"
                               class="btn btn-small btn-delete">
                                <i class='bx bx-trash'></i>
                                Hapus
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>
