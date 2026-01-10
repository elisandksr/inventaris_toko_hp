<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Laporan Inventory</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #c33; text-align: center; }
        .error { background: #fee; color: #c33; padding: 15px; border-radius: 4px; border-left: 4px solid #c33; margin: 20px 0; }
        .debug { background: #f8f8f8; padding: 15px; border-radius: 4px; font-family: monospace; margin: 20px 0; }
        pre { margin: 0; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="container">
        <h1>❌ Error di Halaman Laporan</h1>

        <div class="error">
            <strong>Terjadi kesalahan saat memuat halaman laporan:</strong><br>
            <?= esc($error ?? 'Unknown error') ?>
        </div>

        <div class="debug">
            <strong>Debug Information:</strong>
            <pre>
Controller: Laporan::index()
View: laporan_view.php
Route: /laporan

Possible causes:
1. Database connection error
2. Model method error (getLaporanStok, getLaporanTransaksi, etc.)
3. View syntax error
4. Missing table or column in database
            </pre>
        </div>

        <p><strong>Solusi yang bisa dicoba:</strong></p>
        <ul>
            <li>Pastikan database sudah ter-import dengan benar</li>
            <li>Periksa apakah tabel 'barang', 'transaksi', 'suppliers' ada</li>
            <li>Coba akses halaman lain seperti /dashboard</li>
        </ul>

        <p>
            <a href="/dashboard" style="color: #0066cc;">← Kembali ke Dashboard</a> |
            <a href="/barang" style="color: #0066cc;">Ke Data Barang</a>
        </p>
    </div>
</body>
</html>
