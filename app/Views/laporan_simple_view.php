<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sederhana - Inventory Gudang HP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; text-align: center; }
        .error { background: #fee; color: #c33; padding: 10px; border-radius: 4px; margin: 20px 0; }
        .success { background: #efe; color: #363; padding: 10px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Halaman Laporan (Testing Mode)</h1>

        <div class="success">
            ✅ Halaman laporan berhasil dimuat dalam mode sederhana!<br>
            Ini menandakan bahwa controller dan route sudah berfungsi dengan baik.
        </div>

        <div class="error">
            ⚠️ Ada error di method utama laporan. Kemungkinan masalah:<br>
            - Query database error<br>
            - Method getLaporanStok() / getLaporanTransaksi() error<br>
            - View laporan_view.php terlalu kompleks
        </div>

        <p><strong>Solusi:</strong> Developer akan memperbaiki error di method laporan utama.</p>

        <p><a href="/dashboard">← Kembali ke Dashboard</a></p>
    </div>
</body>
</html>
