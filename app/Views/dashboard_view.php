<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory Ceria</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Colorful Palette */
            --primary: #6366f1;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --secondary-gradient: linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%);
            --accent-gradient: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);
            
            --bg-body: #f3f4f6;
            --glass-white: rgba(255, 255, 255, 0.95);
            --sidebar-width: 260px;
            --header-height: 70px;
            --text-dark: #1e293b;
            --text-gray: #64748b;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Nunito', sans-serif; }
        body { background: var(--bg-body); color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }
        
        /* 1. HEADER - Colorful & Glassy */
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
        .search-box { position: relative; width: 350px; }
        .search-box input {
            width: 100%; padding: 0.7rem 1rem 0.7rem 3rem; border: 2px solid #e2e8f0; border-radius: 50px;
            background: #f8fafc; transition: 0.3s;
        }
        .search-box input:focus { border-color: #a855f7; outline: none; box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1); }
        .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.2rem; }
        
        .profile { display: flex; align-items: center; gap: 1rem; }
        .avatar { width: 42px; height: 42px; background: var(--secondary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 2px 10px rgba(59, 130, 246, 0.3); }

        /* 2. NAVBAR */
        .app-navbar {
            height: 50px; background: white; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; padding: 0 2rem;
            position: fixed; top: var(--header-height); left: 0; right: 0; z-index: 990;
            padding-left: calc(var(--sidebar-width) + 2rem);
        }
        .nav-link { margin-right: 20px; font-weight: 700; color: var(--text-gray); font-size: 0.95rem; display: flex; align-items: center; gap: 6px; }
        .nav-link:hover, .nav-link.active { color: #8b5cf6; }

        /* 3. SIDEBAR - Vibrant Gradient */
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

        /* 5. MAIN CONTENT */
        .main-content {
            margin-top: 120px; 
            margin-left: var(--sidebar-width); 
            padding: 2rem;
            flex: 1; /* Pushes footer to bottom */
        }

        /* HERO & CARDS */
        .hero {
            background: linear-gradient(120deg, #8b5cf6, #ec4899);
            border-radius: 20px; padding: 3rem; color: white;
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 2.5rem; position: relative; overflow: hidden;
            box-shadow: 0 10px 30px -10px rgba(236, 72, 153, 0.5);
        }
        .hero::after {
            content: ''; position: absolute; right: -50px; top: -50px;
            width: 300px; height: 300px; background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .btn-cta {
            background: white; color: #d946ef; padding: 1rem 2rem; border-radius: 50px;
            font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: inline-flex; align-items: center; gap: 0.5rem;
            transition: 0.3s;
        }
        .btn-cta:hover { transform: scale(1.05); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); }

        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; }
        .card {
            background: white; border-radius: 20px; padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
            transition: 0.3s; display: flex; align-items: center; gap: 1.2rem;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1); }
        .card-icon {
            width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: white;
        }
        .c-purple { background: linear-gradient(135deg, #a855f7 0%, #d8b4fe 100%); }
        .c-blue { background: linear-gradient(135deg, #3b82f6 0%, #93c5fd 100%); }
        .c-orange { background: linear-gradient(135deg, #f97316 0%, #fdba74 100%); }
        .c-red { background: linear-gradient(135deg, #ef4444 0%, #fca5a5 100%); }

        .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--text-dark); line-height: 1; margin-bottom: 0.2rem; }
        .stat-label { font-size: 0.9rem; font-weight: 600; color: #94a3b8; }

        .footer { text-align: center; padding: 2rem; color: #94a3b8; font-weight: 600; margin-left: var(--sidebar-width); }
    </style>
</head>
<body>
    
    <!-- HEADER -->
    <header class="app-header">
        <div class="brand"><i class='bx bxs-rocket'></i> INVENTORY GUDANG</div>
        <div class="search-box">
            <i class='bx bx-search'></i>
            <input type="text" placeholder="Cari barang...">
        </div>
        <div class="profile">
            <div style="text-align:right;">
                <div style="font-weight:700; font-size:0.95rem;"><?= session()->get('nama_admin') ?></div>
                <div style="font-size:0.75rem; color:#f472b6; font-weight:600;">Super Admin</div>
            </div>
            <div class="avatar"><i class='bx bxs-user'></i></div>
        </div>
    </header>

    <!-- NAVBAR -->
    <nav class="app-navbar">
        <a href="<?= base_url('dashboard') ?>" class="nav-link active"><i class='bx bxs-home-smile'></i> Dashboard</a>
        <a href="#" class="nav-link"><i class='bx bxs-heart'></i> About Me</a>
    </nav>

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
        <div class="hero">
            <div>
                <h1 style="font-family: 'Fredoka', sans-serif; margin-bottom: 0.5rem; font-size: 2.2rem;">Halo, <?= session()->get('nama_admin') ?>! 👋</h1>
                <p style="font-size: 1.1rem; opacity: 0.9;">Ayo kelola stok barang hari ini dengan semangat!</p>
            </div>
            <a href="<?= base_url('barang') ?>" class="btn-cta"><i class='bx bx-plus'></i> Kelola Barang</a>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-icon c-purple"><i class='bx bxs-mobile'></i></div>
                <div>
                    <div class="stat-value"><?= $total_barang ?></div>
                    <div class="stat-label">Jenis HP</div>
                </div>
            </div>
            <div class="card">
                <div class="card-icon c-blue"><i class='bx bxs-layer'></i></div>
                <div>
                    <div class="stat-value"><?= $total_stok ?></div>
                    <div class="stat-label">Total Unit</div>
                </div>
            </div>
            <div class="card">
                <div class="card-icon c-orange"><i class='bx bxs-error'></i></div>
                <div>
                    <div class="stat-value"><?= $stok_menipis ?></div>
                    <div class="stat-label">Stok Menipis</div>
                </div>
            </div>
            <div class="card">
                <div class="card-icon c-red"><i class='bx bxs-hot'></i></div>
                <div>
                    <div class="stat-value"><?= $transaksi_masuk ?></div>
                    <div class="stat-label">Masuk Hari Ini</div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        &copy; 2026 Inventory Gudang - Dibuat dengan 💖 dan Kopi.
    </footer>

</body>
</html>
