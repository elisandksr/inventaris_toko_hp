<!-- =================================================================
     DASHBOARD - HALAMAN UTAMA APLIKASI INVENTARIS TOKO HP
     =================================================================
     File ini merupakan tampilan utama dashboard yang menampilkan:
     - Ringkasan statistik inventaris (total barang, stok, aset)
     - Peringatan stok menipis
     - Log aktivitas terakhir hari ini
     - Navigasi sidebar untuk semua fitur aplikasi
===================================================================== -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul halaman yang muncul di tab browser -->
    <title>Dashboard - Inventory Ceria</title>

    <!-- CDN untuk ikon BoxIcons - pustaka ikon modern dan responsif -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Google Fonts - Font custom untuk tampilan yang menarik -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- ========================================================
         CSS INTERNAL - STYLING KHUSUS DASHBOARD
         ======================================================== -->
    <style>
        /* ============================================================
             VARIABEL CSS GLOBAL - PALET WARNA & DIMENSI
             ============================================================
             Menggunakan CSS Custom Properties untuk konsistensi warna
             dan memudahkan perubahan tema di masa depan
        ============================================================ */
        :root {
            /* Palet Warna Utama - Menggunakan gradient untuk tampilan modern */
            --primary: #6366f1;                    /* Biru utama */
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);    /* Gradient biru-ungu */
            --secondary-gradient: linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%);  /* Gradient biru-hijau */
            --accent-gradient: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);     /* Gradient kuning-orange */
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);     /* Gradient merah-pink */

            /* Warna Background & Layout */
            --bg-body: #f3f4f6;                   /* Background halaman utama */
            --glass-white: rgba(255, 255, 255, 0.95);  /* Efek kaca transparan */
            --sidebar-width: 260px;              /* Lebar sidebar navigasi */
            --header-height: 70px;               /* Tinggi header atas */
            --text-dark: #1e293b;                 /* Warna teks utama */
            --text-gray: #64748b;                 /* Warna teks sekunder */
        }

        /* ============================================================
             RESET CSS & STYLING DASAR
             ============================================================
             Mengatur ulang default browser dan menetapkan font dasar
        ============================================================ */
        * {
            margin:0; padding:0; box-sizing:border-box;
            font-family: 'Nunito', sans-serif;  /* Font utama untuk seluruh aplikasi */
        }
        html { overflow-y: scroll; } /* Memaksa scrollbar vertikal untuk konsistensi tampilan */
        body {
            background: var(--bg-body);           /* Background halaman */
            color: var(--text-dark);              /* Warna teks default */
            display: flex; flex-direction: column; /* Layout flexbox vertikal */
            min-height: 100vh;                    /* Minimal tinggi viewport penuh */
        }
        
        /* ============================================================
             1. HEADER - BAGIAN ATAS APLIKASI (WARNA-WARNI & EFEK KACA)
             ============================================================
             Header dengan efek glassmorphism dan gradient border
             Berisi: Logo, Search Box, dan Info Profil User
        ============================================================ */
        .app-header {
            height: var(--header-height);         /* Tinggi header */
            background: rgba(255, 255, 255, 0.9); /* Background semi-transparan */
            backdrop-filter: blur(10px);          /* Efek blur glassmorphism */
            border-bottom: 2px solid transparent; /* Border gradient */
            border-image: linear-gradient(to right, #6366f1, #a855f7, #ec4899) 1;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); /* Shadow halus */
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

        /* ============================================================
             2. NAVBAR - NAVIGASI ATAS (DI BAWAH HEADER)
             ============================================================
             Navbar mini untuk navigasi halaman dalam dashboard
        ============================================================ */
        .app-navbar {
            height: 50px; background: white; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; padding: 0 2rem;
            position: fixed; top: var(--header-height); left: 0; right: 0; z-index: 990;
            padding-left: calc(var(--sidebar-width) + 2rem); /* Memberi ruang untuk sidebar */
        }
        .nav-link {
            margin-right: 20px; font-weight: 700; color: var(--text-gray);
            font-size: 0.95rem; display: flex; align-items: center; gap: 6px;
        }
        .nav-link:hover, .nav-link.active { color: #8b5cf6; } /* Hover effect ungu */

        /* ============================================================
             3. SIDEBAR - MENU NAVIGASI UTAMA (GRADIENT CERAH)
             ============================================================
             Sidebar kiri dengan menu navigasi lengkap aplikasi
             Berisi: Dashboard, Master Data, Transaksi, Laporan, Logout
        ============================================================ */
        .app-sidebar {
            width: var(--sidebar-width);          /* Lebar sidebar */
            background: white;                    /* Background putih */
            border-right: 2px solid #e2e8f0;      /* Border kanan */
            position: fixed; top: var(--header-height); bottom: 0; left: 0; z-index: 995;
            padding: 2rem 0; overflow-y: auto;    /* Scroll jika konten panjang */
        }
        /* Styling untuk judul grup menu (Master Data, Transaksi, Laporan) */
        .menu-title {
            font-size: 0.8rem; text-transform: uppercase; color: #94a3b8;
            padding: 0 1.5rem; margin-top: 1.5rem; font-weight: 800; letter-spacing: 1px;
        }

        /* Styling untuk item menu sidebar */
        .menu-item {
            display: flex; align-items: center; gap: 1rem; padding: 0.9rem 1.5rem;
            color: var(--text-gray); font-weight: 600; transition: 0.3s;
            margin: 0.2rem 1rem; border-radius: 12px;
            text-decoration: none; /* Menghilangkan underline default link */
        }
        .menu-item:hover, .menu-item.active {
            background: var(--primary-gradient); color: white;    /* Background gradient saat hover/active */
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);     /* Shadow efek */
            transform: translateX(5px);                          /* Geser ke kanan saat hover */
        }
        .menu-item i { font-size: 1.3rem; } /* Ukuran ikon menu */

        /* ============================================================
             4. KONTEN UTAMA - AREA DASHBOARD
             ============================================================
             Bagian utama yang menampilkan konten dashboard
             Berisi: Hero section, Cards statistik, Detail stok, Aktivitas
        ============================================================ */
        .main-content {
            margin-top: 120px;                   /* Jarak dari header */
            margin-left: var(--sidebar-width);   /* Memberi ruang untuk sidebar */
            padding: 2rem;                       /* Padding dalam */
            flex: 1;                             /* Mengisi ruang tersisa */
        }

        /* ============================================================
             HERO SECTION & CARDS STATISTIK
             ============================================================
             Bagian atas dashboard dengan welcome message dan tombol CTA
        ============================================================ */
        .hero {
            background: linear-gradient(120deg, #8b5cf6, #ec4899);  /* Background gradient ungu-pink */
            border-radius: 20px; padding: 3rem; color: white;        /* Styling rounded dan padding */
            display: flex; align-items: center; justify-content: space-between; /* Layout flex horizontal */
            margin-bottom: 2.5rem; position: relative; overflow: hidden;        /* Posisi dan efek */
            box-shadow: 0 10px 30px -10px rgba(236, 72, 153, 0.5);   /* Shadow dengan warna gradient */
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
            background: white; border-radius: 20px; padding: 2rem;
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

    <!-- ============================================================
         HEADER - BAGIAN ATAS APLIKASI
         ============================================================
         Berisi branding, search box, dan informasi profil user
    ============================================================ -->
    <header class="app-header">
        <!-- Logo dan nama aplikasi dengan ikon toko -->
        <div class="brand">
            <i class='bx bxs-store' style="font-size: 1.8rem;"></i>
            Inventory Toko HP Amelia & Elis
        </div>

        <!-- Search box untuk pencarian global data barang dan supplier -->
        <form action="<?= base_url('barang') ?>" method="get" class="search-box">
            <input type="text" name="q" placeholder="Cari data barang, supplier..." value="<?= isset($keyword) ? $keyword : '' ?>">
            <i class='bx bx-search'></i>
        </form>

        <!-- Informasi profil user dan avatar -->
        <div class="profile">
            <div style="text-align:right;">
                <!-- Nama admin dari session -->
                <div style="font-weight:700; font-size:0.95rem; color: #1e293b;"><?= session()->get('nama_admin') ?></div>
                <!-- Role/posisi user -->
                <div style="font-size:0.75rem; color:#d946ef; font-weight:700;">Owner & Admin</div>
            </div>
            <!-- Avatar dengan ikon wajah -->
            <div class="avatar"><i class='bx bxs-face'></i></div>
        </div>
    </header>

    <!-- ============================================================
         NAVBAR - NAVIGASI MINI ATAS
         ============================================================
         Navigasi halaman dalam dashboard (Dashboard & About)
    ============================================================ -->
    <nav class="app-navbar">
        <a href="<?= base_url('dashboard') ?>" class="nav-link active"><i class='bx bxs-home-smile'></i> Dashboard</a>
        <a href="<?= base_url('about') ?>" class="nav-link"><i class='bx bxs-heart'></i> About Me</a>
    </nav>

    <!-- ============================================================
         SIDEBAR - MENU NAVIGASI UTAMA
         ============================================================
         Menu navigasi lengkap dengan pengelompokan:
         - Dashboard (halaman aktif)
         - Master Data: Data Barang, Supplier
         - Transaksi: Barang Masuk, Barang Keluar
         - Laporan: Laporan, Logout
    ============================================================ -->
    <aside class="app-sidebar">
        <!-- Menu Dashboard (aktif) -->
        <a href="<?= base_url('dashboard') ?>" class="menu-item active"><i class='bx bxs-dashboard'></i> Dashboard</a>

        <!-- Grup Master Data -->
        <div class="menu-title">Master Data</div>
        <a href="<?= base_url('barang') ?>" class="menu-item"><i class='bx bxs-component'></i> Data Barang</a>
        <a href="<?= base_url('supplier') ?>" class="menu-item"><i class='bx bxs-truck'></i> Supplier</a>

        <!-- Grup Transaksi -->
        <div class="menu-title">Transaksi</div>
        <a href="<?= base_url('transaksi/masuk') ?>" class="menu-item"><i class='bx bxs-down-arrow-square'></i> Barang Masuk</a>
        <a href="<?= base_url('transaksi/keluar') ?>" class="menu-item"><i class='bx bxs-up-arrow-square'></i> Barang Keluar</a>

        <!-- Grup Laporan -->
        <div class="menu-title">Laporan</div>
        <a href="<?= base_url('laporan') ?>" class="menu-item"><i class='bx bxs-pie-chart-alt-2'></i> Laporan</a>
        <!-- Menu Logout dengan warna merah untuk peringatan -->
        <a href="<?= base_url('logout') ?>" class="menu-item" style="color:#f43f5e;"><i class='bx bxs-log-out'></i> Logout</a>

        <!-- Copyright text di bagian bawah sidebar -->
        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); text-align: center; color: #94a3b8; font-size: 0.8rem; font-weight: 600; line-height: 1.2;">
            @2026<br>
            Manajemen Inventaris<br>
            Gudang Toko HP
        </div>
    </aside>

    <!-- ============================================================
         KONTEN UTAMA DASHBOARD
         ============================================================
         Area utama yang menampilkan:
         - Hero section dengan salam dan tombol
         - 4 Cards statistik (Total Barang, Stok, Aset, Restock)
         - 2 Kolom detail (Stok Menipis & Aktivitas Terakhir)
    ============================================================ -->
    <main class="main-content">
        <!-- ============================================================
             HERO SECTION - BAGIAN ATAS DASHBOARD
             ============================================================
             Menampilkan salam personal dan tombol Call-to-Action
             untuk mengarahkan user ke fitur input barang masuk
        ============================================================ -->
        <div class="hero">
            <div>
                <!-- Salam personal dengan nama admin dari session -->
                <h1 style="font-family: 'Fredoka', sans-serif; margin-bottom: 0.5rem; font-size: 2.2rem;">
                    Halo, <?= session()->get('nama_admin') ?>! 👋
                </h1>
                <!-- Pesan motivasi untuk user -->
                <p style="font-size: 1.1rem; opacity: 0.9;">Ayo kelola stok barang hari ini dengan semangat!</p>
            </div>
            <!-- Tombol CTA untuk input barang masuk -->
            <a href="<?= base_url('transaksi/masuk') ?>" class="btn-cta">
                <i class='bx bx-plus-circle'></i> Input Barang Masuk
            </a>
        </div>

        <!-- ============================================================
             CARDS STATISTIK - RINGKASAN DATA INVENTARIS
             ============================================================
             Grid 4 kolom menampilkan statistik utama:
             1. Total Jenis HP, 2. Total Unit, 3. Total Aset, 4. Perlu Restock
        ============================================================ -->
        <div class="dashboard-grid">
            <!-- Card 1: Total Jenis HP (berdasarkan data unik) -->
            <div class="card">
                <div class="card-icon c-purple"><i class='bx bxs-mobile'></i></div>
                <div>
                    <div class="stat-value"><?= $total_barang ?></div>
                    <div class="stat-label">Jenis HP</div>
                </div>
            </div>

            <!-- Card 2: Total Unit/Stok semua barang -->
            <div class="card">
                <div class="card-icon c-blue"><i class='bx bxs-layer'></i></div>
                <div>
                    <div class="stat-value"><?= $total_stok ?></div>
                    <div class="stat-label">Total Unit</div>
                </div>
            </div>

            <!-- Card 3: Total Nilai Aset (harga beli × stok) -->
            <div class="card">
                <div class="card-icon c-green" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class='bx bxs-wallet'></i>
                </div>
                <div>
                    <div class="stat-value" style="font-size: 1.4rem;">
                        Rp <?= number_format($total_aset, 0, ',', '.') ?>
                    </div>
                    <div class="stat-label">Total Aset</div>
                </div>
            </div>

            <!-- Card 4: Jumlah barang yang stoknya < 5 unit (clickable) -->
            <div class="card" onclick="document.getElementById('stok-warning-section').scrollIntoView({behavior: 'smooth'})" style="cursor: pointer;">
                <div class="card-icon c-orange"><i class='bx bxs-error'></i></div>
                <div>
                    <div class="stat-value"><?= $stok_menipis_count ?></div>
                    <div class="stat-label">Perlu Restock</div>
                </div>
            </div>
        </div>

        <!-- ============================================================
             DETAIL SECTION - LAYOUT 2 KOLOM
             ============================================================
             Menampilkan informasi detail dalam 2 kolom:
             Kiri: Daftar barang stok menipis
             Kanan: Log aktivitas transaksi hari ini
        ============================================================ -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-top: 2.5rem;">

            <!-- ============================================================
                 KOLOM KIRI: DETAIL BARANG STOK MENIPIS
                 ============================================================
                 Menampilkan daftar barang yang stoknya kurang dari 5 unit
                 dengan informasi nama HP, merek, dan jumlah stok saat ini
            ============================================================ -->
            <div id="stok-warning-section" style="background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class='bx bxs-alarm-exclamation' style="color: #f59e0b;"></i> Stok Menipis
                    </h3>
                    <a href="<?= base_url('laporan') ?>" style="font-size: 0.85rem; color: #6366f1; text-decoration: none; font-weight: 700;">Lihat Semua &rarr;</a>
                </div>

                <?php if(!empty($stok_menipis_list)): ?>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <?php foreach($stok_menipis_list as $item): ?>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #fffbeb; border-radius: 12px; border: 1px solid #fcd34d;">
                                <div>
                                    <div style="font-weight: 700; color: #1e293b;"><?= $item['nama_hp'] ?></div>
                                    <div style="font-size: 0.8rem; color: #b45309;"><?= $item['merek'] ?></div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 1.2rem; font-weight: 800; color: #d97706;"><?= $item['stok'] ?></div>
                                    <div style="font-size: 0.75rem; color: #b45309;">Unit</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem; color: #64748b;">
                        <i class='bx bx-check-circle' style="font-size: 3rem; color: #10b981; margin-bottom: 0.5rem;"></i>
                        <p>Stok aman terkendali!</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ============================================================
                 KOLOM KANAN: LOG AKTIVITAS TERAKHIR
                 ============================================================
                 Menampilkan 5 aktivitas transaksi terakhir hari ini
                 dengan informasi waktu, jenis transaksi, dan jumlah
            ============================================================ -->
            <div style="background: white; padding: 1.5rem; border-radius: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class='bx bx-history' style="color: #3b82f6;"></i> Aktivitas Terakhir
                    </h3>
                    <div style="font-size: 0.85rem; color: #94a3b8;">Hari ini</div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php if(!empty($recent_activities)): ?>
                        <?php foreach($recent_activities as $act): ?>
                            <div style="display: flex; align-items: center; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                                <div style="
                                    width: 40px; height: 40px; border-radius: 10px; 
                                    display: flex; align-items: center; justify-content: center;
                                    font-size: 1.2rem; color: white;
                                    background: <?= $act['jenis'] == 'Masuk' ? '#10b981' : '#ef4444' ?>;
                                ">
                                    <i class='bx <?= $act['jenis'] == 'Masuk' ? 'bxs-down-arrow-circle' : 'bxs-up-arrow-circle' ?>'></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; color: #334155; font-size: 0.95rem;">
                                        <?= $act['nama_hp'] ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: #94a3b8;">
                                        <?= date('H:i', strtotime($act['created_at'])) ?> • <?= $act['jenis'] ?>
                                    </div>
                                </div>
                                <div style="font-weight: 700; color: <?= $act['jenis'] == 'Masuk' ? '#10b981' : '#ef4444' ?>;">
                                    <?= $act['jenis'] == 'Masuk' ? '+' : '-' ?><?= $act['jumlah'] ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; color: #94a3b8; padding: 2rem;">
                            Belum ada aktivitas hari ini.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
