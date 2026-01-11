<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Inventory Ceria</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --secondary-gradient: linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%);
            --bg-body: #f3f4f6;
            --sidebar-width: 260px;
            --header-height: 70px;
            --text-dark: #1e293b;
            --text-gray: #64748b;
        }

        /* Force Scrollbar to prevent layout shift */
        html { overflow-y: scroll; }
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Nunito', sans-serif; }
        body { background: var(--bg-body); color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }

        /* HEADER & NAVBAR & SIDEBAR (COPIED FROM DASHBOARD FOR CONSISTENCY) */
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
        
        /* 2. SECONDARY NAVBAR (BREADCRUMB BAR) - Consistent Layout */
        .app-navbar {
            height: 50px; background: white; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; padding: 0 2rem;
            position: fixed; top: var(--header-height); left: 0; right: 0; z-index: 990;
            padding-left: calc(var(--sidebar-width) + 2rem);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        
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
        
        /* HEADER CARD */
        /* HEADER CARD */
        .header-card {
            background: white; border-radius: 20px; padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #f1f5f9;
            display: flex; justify-content: space-between; align-items: center;
        }
        .header-info h1 { font-size: 1.8rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem; }
        .header-info p { color: var(--text-gray); font-size: 1rem; }
        .header-actions { display: flex; gap: 1rem; }

        /* TABLE CARD */
        .table-card { 
            background: white; border-radius: 20px; padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        .table th {
            background: #f8fafc;
            padding: 0.75rem 1rem; /* Reduced padding */
            text-align: left;
            font-weight: 700;
            color: var(--text-dark);
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 0.85rem;
            white-space: nowrap; /* Prevent headers form wrapping, keeping height standard */
        }
        .table td {
            padding: 0.75rem 1rem; /* Reduced padding for shorter table */
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background: #f8fafc;
        }

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
        .btn-primary { background: var(--primary-gradient); color: white; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4); }
        .btn-sm { padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 12px; }
        .btn-edit { background: #eff6ff; color: #4f46e5; }
        .btn-delete { background: #fef2f2; color: #ef4444; }

        .badge { padding: 0.3rem 0.8rem; border-radius: 30px; font-size: 0.75rem; font-weight: 700; }
        .badge-ready { background: #dcfce7; color: #166534; }
        .badge-empty { background: #fee2e2; color: #991b1b; }
        .badge-low { background: #fef9c3; color: #854d0e; }

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
        <!-- EXACT COPY FROM DASHBOARD FOR CONSISTENCY -->
        <div class="brand">
            <i class='bx bxs-store' style="font-size: 1.8rem;"></i> 
            Inventory Toko HP Amelia & Elis
        </div>
        
        <form action="<?= base_url('barang') ?>" method="get" class="search-box">
            <input type="text" name="q" placeholder="Cari data barang, supplier..." value="<?= isset($keyword) ? $keyword : '' ?>">
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
        
        <a href="<?= base_url('barang') ?>" class="menu-item active"><i class='bx bxs-component'></i> Data Barang</a>
        <a href="<?= base_url('supplier') ?>" class="menu-item"><i class='bx bxs-truck'></i> Supplier</a>
        
        <div class="menu-title">Transaksi</div>
        <a href="<?= base_url('transaksi/masuk') ?>" class="menu-item"><i class='bx bxs-down-arrow-square'></i> Barang Masuk</a>
        <a href="<?= base_url('transaksi/keluar') ?>" class="menu-item"><i class='bx bxs-up-arrow-square'></i> Barang Keluar</a>
        
        
        <div class="menu-title">Laporan</div>
        <a href="<?= base_url('laporan') ?>" class="menu-item"><i class='bx bxs-pie-chart-alt-2'></i> Laporan</a>
        <a href="<?= base_url('logout') ?>" class="menu-item" style="color:#f43f5e;"><i class='bx bxs-log-out'></i> Logout</a>
    </aside>

    <!-- NAVBAR (BREADCRUMB) -->
    <nav class="app-navbar">
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>"><i class='bx bxs-home-smile'></i> Dashboard</a>
            <i class='bx bx-chevron-right'></i>
            <span style="color: var(--text-gray); font-weight: 600;">Master Data</span>
            <i class='bx bx-chevron-right'></i>
            <span>Data Barang</span>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- ALERTS -->
        <?php if(session()->getFlashdata('success')): ?>
            <div style="background: #ecfdf5; color: #047857; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #a7f3d0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <i class='bx bxs-check-circle'></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- HEADER CARD -->
        <div class="header-card">
            <div class="header-info">
                <h1>Data Barang</h1>
                <p>Khusus input data master handphone baru ke dalam sistem</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="openModal()">
                    <i class='bx bx-plus'></i> Tambah Data
                </button>
            </div>
        </div>

        <div class="table-card">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode / IMEI</th>
                            <th>Nama Barang</th>
                            <th>Merek</th>
                            <th>Lokasi Rak</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($barang as $item): ?>
                        <tr>
                            <td>
                                <span style="font-family:'Courier New'; background:#e0e7ff; color:#4338ca; padding:2px 6px; border-radius:4px; font-weight:700;"><?= $item['kode_barang'] ?></span>
                                <?php if(!empty($item['imei'])): ?>
                                    <div style="font-size:0.75rem; color:#64748b; margin-top:2px;">IMEI: <?= $item['imei'] ?></div>
                                <?php endif; ?>
                            </td>
                            <td style="font-weight:700;"><?= $item['nama_hp'] ?></td>
                            <td><?= $item['merek'] ?></td>
                            <td><?= !empty($item['lokasi_rak']) ? $item['lokasi_rak'] : '-' ?></td>
                            <td>
                                <?php if($item['stok'] < 5): ?>
                                    <span class="badge badge-low"><?= $item['stok'] ?> Warn!</span>
                                <?php else: ?>
                                    <span style="font-weight:700;"><?= $item['stok'] ?> Unit</span>
                                <?php endif; ?>
                            </td>
                            <td style="color:#d946ef; font-weight:700;">Rp <?= number_format($item['harga_beli'], 0, ',', '.') ?></td>
                            <td style="color:#059669; font-weight:700;">Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?></td>
                            <td>
                                <?php if($item['stok'] > 0): ?>
                                    <span class="badge badge-ready">Ready</span>
                                <?php else: ?>
                                    <span class="badge badge-empty">Kosong</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display:flex; gap:0.5rem;">
                                    <button class="btn-sm btn-edit" onclick='editItem(<?= json_encode($item) ?>)'><i class='bx bx-edit'></i></button>
                                    <a href="<?= base_url('barang/delete/'.$item['id']) ?>" class="btn-sm btn-delete" onclick="return confirm('Hapus data ini?')"><i class='bx bx-trash'></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </main>

    <!-- MODAL -->
    <div class="modal" id="barangModal">
        <div class="modal-content">
            <h3 style="margin-bottom:1.5rem; font-size:1.5rem; color:var(--text-dark);" id="modalTitle">✨ Tambah Barang</h3>
            <form action="<?= base_url('barang/save') ?>" method="post" id="barangForm">
                <input type="hidden" name="id" id="itemId">
                
                <div class="form-grid">
                    <div>
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" id="kodeBarang" class="form-control" placeholder="BRG-001" required>
                    </div>
                    <div>
                        <label class="form-label">IMEI (Opsional)</label>
                        <input type="text" name="imei" id="imei" class="form-control" placeholder="123456...">
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label">Nama HP</label>
                        <input type="text" name="nama_hp" id="namaHp" class="form-control" placeholder="Contoh: iPhone 15" required>
                    </div>
                    <div>
                        <label class="form-label">Merek</label>
                        <select name="merek" id="merek" class="form-control">
                            <option value="Samsung">Samsung</option>
                            <option value="Apple">Apple</option>
                            <option value="Xiaomi">Xiaomi</option>
                            <option value="Oppo">Oppo</option>
                            <option value="Vivo">Vivo</option>
                            <option value="Infinix">Infinix</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label">Harga Beli</label>
                        <input type="number" name="harga_beli" id="hargaBeli" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" id="hargaJual" class="form-control" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" required>
                        <small id="stokMsg" style="color:#ef4444; font-weight:600; display:none; margin-top:0.3rem;">* Stok hanya bisa diubah lewat menu Transaksi</small>
                    </div>
                    <div>
                        <label class="form-label">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" id="lokasiRak" class="form-control" placeholder="Rak A1">
                    </div>
                </div>

                <div style="text-align: right; margin-top: 2rem;">
                    <button type="button" onclick="closeModal()" style="background:none; border:none; color:#64748b; font-weight:700; cursor:pointer; margin-right:1rem;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="padding:0.7rem 2rem;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('barangModal').classList.add('active');
            document.getElementById('modalTitle').innerText = '✨ Tambah Barang';
            document.getElementById('barangForm').reset();
            document.getElementById('itemId').value = '';
            
            // Reset Stok Field (Enable)
            document.getElementById('stok').readOnly = false;
            document.getElementById('stok').style.backgroundColor = 'white';
            document.getElementById('stokMsg').style.display = 'none';
        }

        function closeModal() {
            document.getElementById('barangModal').classList.remove('active');
        }

        function editItem(data) {
            openModal();
            document.getElementById('modalTitle').innerText = '✏️ Edit Barang';
            document.getElementById('itemId').value = data.id;
            document.getElementById('kodeBarang').value = data.kode_barang;
            document.getElementById('imei').value = data.imei;
            document.getElementById('namaHp').value = data.nama_hp;
            document.getElementById('merek').value = data.merek;
            document.getElementById('hargaBeli').value = data.harga_beli;
            document.getElementById('hargaJual').value = data.harga_jual;
            document.getElementById('stok').value = data.stok;
            document.getElementById('lokasiRak').value = data.lokasi_rak;

            // Lock Stok Field (Disable)
            document.getElementById('stok').readOnly = true;
            document.getElementById('stok').style.backgroundColor = '#f1f5f9';
            document.getElementById('stokMsg').style.display = 'block';
        }

        window.onclick = function(e) {
            if(e.target == document.getElementById('barangModal')) closeModal();
        }
    </script>
</body>
</html>
