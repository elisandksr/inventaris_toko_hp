<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Inventory Ceria</title>
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
            
            --glass-white: rgba(255, 255, 255, 0.95);
            --bg-body: #f3f4f6;
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
        
        /* SEARCH BOX CONSISTENCY */
        .search-box { position: relative; width: 350px; }
        .search-box input {
            width: 100%; padding: 0.7rem 1rem 0.7rem 3rem; border: 2px solid #e2e8f0; border-radius: 50px;
            background: #f8fafc; transition: 0.3s;
            font-size: 0.95rem; height: 45px;
        }
        .search-box input:focus { border-color: #a855f7; outline: none; box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1); }
        .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.2rem; }
        
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

        /* 2. NAVBAR */
        .app-navbar {
            height: 50px; background: white; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; padding: 0 2rem;
            position: fixed; top: var(--header-height); left: 0; right: 0; z-index: 990;
            padding-left: calc(var(--sidebar-width) + 2rem); /* Offset for sidebar */
        }
        .nav-link { margin-right: 20px; font-weight: 700; color: var(--text-gray); font-size: 0.95rem; display: flex; align-items: center; gap: 6px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #8b5cf6; }

        /* 3. SIDEBAR */
        .app-sidebar {
            width: var(--sidebar-width); background: white; border-right: 2px solid #e2e8f0;
            position: fixed; top: var(--header-height); bottom: 0; left: 0; z-index: 995; padding: 2rem 0; overflow-y: auto;
        }
        .menu-title { font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; padding: 0 1.5rem; margin-top: 1.5rem; font-weight: 800; letter-spacing: 1px; }
        .menu-item {
            display: flex; align-items: center; gap: 1rem; padding: 0.9rem 1.5rem; color: var(--text-gray); font-weight: 600;
            margin: 0.2rem 1rem; border-radius: 12px; transition: 0.3s;
        }
        .menu-item:hover, .menu-item.active { 
            background: var(--primary-gradient); color: white; 
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); 
            transform: translateX(5px);
        }
        .menu-item i { font-size: 1.3rem; }

        /* 4. CONTENT */
        .main-content {
            margin-top: 120px; 
            margin-left: var(--sidebar-width); 
            padding: 2rem;
            flex: 1;
            min-height: calc(100vh - 120px);
        }

        /* ABOUT CARDS */
        .about-hero {
            background: white; border-radius: 20px; padding: 3rem; text-align: center;
            box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05); margin-bottom: 2rem;
            position: relative; overflow: hidden;
        }
        .about-hero::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 10px;
            background: var(--primary-gradient);
        }
        .hero-title { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-desc { color: var(--text-gray); font-size: 1.1rem; max-width: 1000px; margin: 0 auto; line-height: 1.6; }

        .team-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
        .team-card {
            background: white; border-radius: 20px; padding: 2rem; text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: 0.3s; border: 1px solid #f1f5f9;
        }
        .team-card:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); border-color: #e2e8f0; }
        .team-avatar {
            width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%;
            background: var(--secondary-gradient); display: flex; align-items: center; justify-content: center;
            font-size: 3rem; color: white; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }
        .team-name { font-size: 1.5rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem; }
        .team-role { color: #f472b6; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
        
        .tech-stack { margin-top: 3rem; text-align: center; }
        .tech-badges { display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap; }
        .tech-badge {
            padding: 0.5rem 1.5rem; background: white; border-radius: 50px; font-weight: 700; color: var(--text-gray);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 0.5rem;
        }
        .tech-badge i { font-size: 1.2rem; color: #6366f1; }

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

    <!-- NAVBAR -->
    <nav class="app-navbar">
        <a href="<?= base_url('dashboard') ?>" class="nav-link"><i class='bx bxs-home-smile'></i> Dashboard</a>
        <a href="<?= base_url('about') ?>" class="nav-link active"><i class='bx bxs-heart'></i> About Me</a>
    </nav>

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
        <a href="<?= base_url('laporan') ?>" class="menu-item"><i class='bx bxs-pie-chart-alt-2'></i> Laporan</a>
        <a href="<?= base_url('logout') ?>" class="menu-item" style="color:#f43f5e;"><i class='bx bxs-log-out'></i> Logout</a>

        <!-- Copyright text di bagian bawah sidebar -->
        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); text-align: center; color: #94a3b8; font-size: 0.8rem; font-weight: 600; line-height: 1.2;">
            @2026<br>
            Manajemen Inventaris<br>
            Gudang Toko HP
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        
        <div class="about-hero">
            <div class="hero-title">Tentang Kami</div>
            <p class="hero-desc">Web Inventaris Gudang Toko HP Amelia & Elis adalah sebuah solusi sistem informasi berbasis web yang dirancang secara khusus untuk membantu pengelolaan stok barang agar berjalan lebih efisien, terstruktur, dan transparan. Sistem ini hadir sebagai jawaban atas tantangan dalam manajemen inventaris konvensional, memberikan kemudahan dalam pencatatan barang masuk, pelacakan barang keluar, serta pemantauan ketersediaan stok secara real-time dan akurat. Dikembangkan dengan antarmuka yang modern dan user-friendly, web ini bertujuan untuk mendukung seluruh kegiatan operasional toko HP agar administrasi menjadi lebih rapi, meminimalisir kesalahan pencatatan, serta meningkatkan efektivitas kerja dalam mengelola aset usaha.</p>
        </div>

        <div class="team-grid">
            <div class="team-card">
                <div class="team-avatar" style="background: linear-gradient(135deg, #f472b6 0%, #db2777 100%); box-shadow: 0 10px 20px rgba(219, 39, 119, 0.3);">
                    <i class='bx bxs-face'></i>
                </div>
                <div class="team-name">Amelia Flora Aprilianigrum</div>
                <div class="team-role">NIM: 230119003</div>
                <p style="margin-top:1rem; color:#64748b;">Prodi: D4 Teknologi Rekayasa Perangkat Lunak</p>
            </div>

            <div class="team-card">
                <div class="team-avatar" style="background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%); box-shadow: 0 10px 20px rgba(126, 34, 206, 0.3);">
                    <i class='bx bxs-face-mask'></i>
                </div>
                <div class="team-name">Elis Andikasari</div>
                <div class="team-role">NIM: 230119008</div>
                <p style="margin-top:1rem; color:#64748b;">Prodi: D4 Teknologi Rekayasa Perangkat Lunak</p>
            </div>
        </div>

        <div class="tech-stack">
            <h3 style="color:var(--text-dark); margin-bottom:1rem;">Teknologi yang Digunakan</h3>
            <div class="tech-badges">
                <div class="tech-badge"><i class='bx bxl-php'></i> CodeIgniter 4</div>
                <div class="tech-badge"><i class='bx bxl-html5'></i> HTML5</div>
                <div class="tech-badge"><i class='bx bxl-css3'></i> Modern CSS</div>
                <div class="tech-badge"><i class='bx bxl-javascript'></i> JavaScript</div>
                <div class="tech-badge"><i class='bx bxs-data'></i> MySQL</div>
            </div>
        </div>

    </main>

</body>
</html>
