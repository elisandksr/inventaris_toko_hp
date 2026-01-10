<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($supplier) ? 'Edit' : 'Tambah' ?> Supplier - Inventory Gudang</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --secondary-gradient: linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%);
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
            display: flex;
            justify-content: center;
            align-items: flex-start;
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
            position: fixed;
            top: var(--header-height);
            left: var(--sidebar-width);
            right: 0;
            z-index: 990;
            margin: 0;
        }
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* FORM CARD */
        .form-container {
            width: 100%;
            max-width: 600px;
            margin-top: 80px; /* Space for breadcrumb */
        }
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.1);
            border: 1px solid #f1f5f9;
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }
        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        .form-subtitle {
            color: var(--text-gray);
            font-size: 1rem;
        }

        /* FORM STYLES */
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: 0.3s;
            background: #f8fafc;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #a855f7;
            outline: none;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
            background: white;
        }
        .form-control.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* REQUIRED INDICATOR */
        .required {
            color: #ef4444;
            font-weight: bold;
        }

        /* BUTTONS */
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #f1f5f9;
        }
        .btn {
            padding: 0.875rem 2rem;
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
            .breadcrumb {
                left: 0;
                margin: 0 1rem;
            }
            .form-container {
                margin-top: 100px;
            }
            .form-card {
                padding: 1.5rem;
            }
            .form-actions {
                flex-direction: column;
            }
            .btn {
                width: 100%;
                justify-content: center;
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

    <!-- BREADCRUMB -->
    <nav class="breadcrumb">
        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
        <i class='bx bx-chevron-right'></i>
        <a href="<?= base_url('supplier') ?>">Supplier</a>
        <i class='bx bx-chevron-right'></i>
        <span><?= isset($supplier) ? 'Edit Supplier' : 'Tambah Supplier' ?></span>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="form-container">
            <div class="form-card">
                <div class="form-header">
                    <div class="form-icon">
                        <i class='bx bx-truck'></i>
                    </div>
                    <h1 class="form-title">
                        <?= isset($supplier) ? 'Edit Supplier' : 'Tambah Supplier Baru' ?>
                    </h1>
                    <p class="form-subtitle">
                        <?= isset($supplier) ? 'Perbarui informasi supplier' : 'Masukkan data supplier untuk mengelola inventaris' ?>
                    </p>
                </div>

                <!-- ALERTS -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-error">
                        <i class='bx bx-error-circle'></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= isset($supplier) ? base_url('supplier/update/' . $supplier['id']) : base_url('supplier/store') ?>" method="post">
                    <div class="form-group">
                        <label class="form-label">
                            Nama Supplier <span class="required">*</span>
                        </label>
                        <input type="text" name="nama_supplier" class="form-control"
                               placeholder="Masukkan nama supplier"
                               value="<?= isset($supplier) ? esc($supplier['nama_supplier']) : '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"
                                  placeholder="Masukkan alamat lengkap supplier (opsional)"><?= isset($supplier) ? esc($supplier['alamat']) : '' ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" name="telepon" class="form-control"
                               placeholder="Contoh: 081234567890"
                               value="<?= isset($supplier) ? esc($supplier['telepon']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               placeholder="Contoh: supplier@email.com"
                               value="<?= isset($supplier) ? esc($supplier['email']) : '' ?>">
                    </div>

                    <div class="form-actions">
                        <a href="<?= base_url('supplier') ?>" class="btn btn-secondary">
                            <i class='bx bx-x'></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save'></i>
                            <?= isset($supplier) ? 'Update Supplier' : 'Simpan Supplier' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
