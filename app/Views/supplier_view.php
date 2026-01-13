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

        /* MAIN CONTENT */
        .main-content {
            margin-top: 120px; /* Header (70px) + Navbar (50px) */
            margin-left: var(--sidebar-width);
            padding: 2rem;
            flex: 1;
        }

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
        /* MODAL */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(5px); z-index: 2000; justify-content: center; align-items: center; }
        .modal.active { display: flex; }
        .modal-content { background: white; width: 100%; max-width: 600px; padding: 2rem; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); animation: popUp 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        @keyframes popUp { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.9rem; color: #475569; }
        .form-control { width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-weight: 600; color: #334155; transition: 0.3s; }
        .form-control:focus { border-color: #a855f7; outline: none; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="app-header">
        <div class="brand">
            <i class='bx bxs-store' style="font-size: 1.8rem;"></i> 
            Inventory Toko HP Amelia & Elis
        </div>
        
        <!-- Form Pencarian Supplier -->
        <form action="<?= base_url('supplier') ?>" method="get" class="search-box">
            <input type="text" name="q" placeholder="Cari data supplier..." value="<?= isset($keyword) ? $keyword : '' ?>">
            <i class='bx bx-search'></i>
        </form>

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
        <a href="<?= base_url('supplier') ?>" class="menu-item active"><i class='bx bxs-truck'></i> Supplier</a>
        
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

    <!-- NAVBAR (BREADCRUMB) -->
    <nav class="app-navbar">
        <div class="breadcrumb">
            <!-- Link Breadcrumb -->
            <a href="<?= base_url('dashboard') ?>"><i class='bx bxs-home-smile'></i> Dashboard</a>
            <i class='bx bx-chevron-right'></i>
            <span style="color: var(--text-gray); font-weight: 600;">Master Data</span>
            <i class='bx bx-chevron-right'></i>
            <span>Manajemen Supplier</span>
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

        <!-- HEADER CARD -->
        <div class="header-card">
            <div class="header-info">
                <h1>Manajemen Supplier</h1>
                <p>Kelola data supplier dan distributor untuk inventaris HP Anda</p>
            </div>
            <div class="header-actions">
                <!-- Tombol Buka Modal Tambah -->
                <button class="btn btn-primary" onclick="openModal()">
                    <i class='bx bx-plus'></i>
                    Tambah Supplier
                </button>
                <!-- Tombol Refresh Halaman -->
                <button onclick="location.reload()" class="btn btn-success">
                    <i class='bx bx-refresh'></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- SUPPLIERS GRID -->
        <div class="suppliers-grid">
            <!-- Cek jika data kosong -->
            <?php if (empty($suppliers)): ?>
                <div class="empty-state">
                    <i class='bx bx-truck'></i>
                    <h3>Belum ada data supplier</h3>
                    <p>Tambahkan supplier pertama untuk memulai mengelola inventaris</p>
                    <button class="btn btn-primary" style="margin-top: 1rem;" onclick="openModal()">
                        <i class='bx bx-plus'></i>
                        Tambah Supplier Pertama
                    </button>
                </div>
            <?php else: ?>
                <!-- Loop Data Supplier -->
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

                        <!-- Detail Informasi Supplier (Alamat, Telp, Email) -->
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
                            <!-- Tombol Edit: Panggil JS editSupplier -->
                            <button class="btn btn-small btn-edit" onclick='editSupplier(<?= json_encode($supplier) ?>)'>
                                <i class='bx bx-edit'></i>
                                Edit
                            </button>
                            <!-- Tombol Hapus: Link dengan Konfirmasi -->
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


    <!-- MODAL FORM -->
    <div class="modal" id="supplierModal">
        <div class="modal-content">
            <h3 style="margin-bottom:1.5rem; font-size:1.5rem; color:var(--text-dark);" id="modalTitle">✨ Tambah Supplier</h3>
            <!-- Form Action: Kirim ke Supplier::save -->
            <form action="<?= base_url('supplier/save') ?>" method="post" id="supplierForm">
                <input type="hidden" name="id" id="supplierId">
                
                <div class="form-grid">
                    <div>
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" name="nama_supplier" id="namaSupplier" class="form-control" placeholder="PT. Jaya Abadi" required>
                    </div>
                    <div>
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control" placeholder="0812...">
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Jl. Sudirman No...">
                    </div>
                </div>

                <div style="text-align: right; margin-top: 2rem;">
                    <!-- Tombol Batal & Simpan -->
                    <button type="button" onclick="closeModal()" style="background:none; border:none; color:#64748b; font-weight:700; cursor:pointer; margin-right:1rem;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="padding:0.7rem 2rem;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi Buka Modal Tambah
        function openModal() {
            document.getElementById('supplierModal').classList.add('active');
            document.getElementById('modalTitle').innerText = '✨ Tambah Supplier';
            document.getElementById('supplierForm').reset();
            document.getElementById('supplierId').value = '';
        }

        // Fungsi Tutup Modal
        function closeModal() {
            document.getElementById('supplierModal').classList.remove('active');
        }

        // Fungsi Isi Data ke Modal (Edit Mode)
        function editSupplier(data) {
            openModal();
            document.getElementById('modalTitle').innerText = '✏️ Edit Supplier';
            document.getElementById('supplierId').value = data.id;
            document.getElementById('namaSupplier').value = data.nama_supplier;
            document.getElementById('telepon').value = data.telepon;
            document.getElementById('email').value = data.email;
            document.getElementById('alamat').value = data.alamat;
        }

        // Tutup Modal jika klik di luar
        window.onclick = function(e) {
            if(e.target == document.getElementById('supplierModal')) closeModal();
        }
    </script>
</body>
</html>
