# 🏪 Sistem Manajemen Inventaris Toko HP Amelia & Elis

Aplikasi web-based untuk mengelola inventaris handphone (HP) di toko retail menggunakan framework CodeIgniter 4.

## 📋 Deskripsi Aplikasi

Sistem ini dirancang untuk membantu pemilik toko HP dalam mengelola:
- ✅ Data barang (handphone) dengan detail lengkap
- ✅ Data supplier/pemasok
- ✅ Transaksi barang masuk dan keluar
- ✅ Monitoring stok real-time
- ✅ Laporan keuangan dan aktivitas
- ✅ Dashboard dengan statistik visual

## 🏗️ Arsitektur Aplikasi

### Struktur MVC (Model-View-Controller)
```
app/
├── Controllers/     # Mengatur logika aplikasi dan response ke user
│   ├── BaseController.php    # Controller base class
│   ├── Dashboard.php         # Halaman dashboard utama
│   ├── Barang.php           # CRUD data barang
│   ├── Supplier.php         # CRUD data supplier
│   ├── Transaksi.php        # Mengelola transaksi masuk/keluar
│   ├── Laporan.php          # Generate laporan
│   ├── About.php           # Halaman about
│   └── Auth.php            # Sistem authentication
├── Models/          # Mengelola interaksi dengan database
│   ├── BarangModel.php      # Model untuk tabel barang
│   ├── SupplierModel.php    # Model untuk tabel suppliers
│   ├── TransaksiModel.php   # Model untuk tabel transaksi
│   └── AdminModel.php       # Model untuk tabel admins
├── Views/          # Template tampilan HTML
│   ├── dashboard_view.php   # Dashboard dengan statistik
│   ├── barang_view.php      # List dan form data barang
│   ├── supplier_view.php    # List dan form data supplier
│   ├── transaksi_masuk_view.php  # Form transaksi masuk
│   ├── transaksi_keluar_view.php # Form transaksi keluar
│   ├── laporan_view.php     # Halaman laporan
│   └── login_view.php       # Halaman login
└── Config/         # Konfigurasi aplikasi
    ├── Database.php         # Setup koneksi database
    ├── Routes.php          # Definisi routing URL
    └── App.php            # Konfigurasi aplikasi utama
```

### Database Schema
```sql
- admins: Data administrator sistem
- barang: Data handphone (nama, merek, IMEI, harga, stok, dll)
- suppliers: Data pemasok/supplier
- transaksi: Riwayat transaksi masuk/keluar
```

## 🚀 Fitur Utama

### 1. Dashboard
- **Statistik Real-time**: Total jenis HP, total unit, total aset, item perlu restock
- **Alert Stok Menipis**: Notifikasi otomatis untuk barang yang stok < 5 unit
- **Aktivitas Terakhir**: Log transaksi hari ini

### 2. Manajemen Barang
- **CRUD Lengkap**: Tambah, edit, hapus, dan cari data HP
- **Detail Lengkap**: Kode barang, nama, merek, IMEI, harga beli/jual, stok, lokasi rak
- **Status Otomatis**: Ready/Kosong/Menipis berdasarkan jumlah stok

### 3. Manajemen Supplier
- **Data Contact**: Nama, alamat, telepon, email
- **Statistik**: Jumlah transaksi per supplier
- **Validasi**: Cek supplier yang masih memiliki riwayat sebelum dihapus

### 4. Transaksi
- **Barang Masuk**: Penerimaan dari supplier dengan update stok otomatis
- **Barang Keluar**: Penjualan dengan validasi stok cukup
- **Rollback**: Koreksi transaksi dengan pengembalian stok

### 5. Laporan
- **Laporan Stok**: Kondisi inventory saat ini
- **Laporan Transaksi**: Riwayat masuk/keluar
- **Laporan Keuangan**: Analisis aset dan profit
- **Export Excel**: Download laporan dalam format spreadsheet

## 🛠️ Teknologi

- **Framework**: CodeIgniter 4.4.x
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript, BoxIcons
- **Authentication**: Session-based
- **Styling**: Custom CSS dengan gradient dan glassmorphism

## 📦 Instalasi

### Prerequisites
- PHP 8.1+
- MySQL/MariaDB
- Composer
- Web Server (Apache/Nginx)

### Langkah Instalasi
1. **Clone Repository**
   ```bash
   git clone https://github.com/elisandksr/inventaris_toko_hp.git
   cd inventaris_toko_hp
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Setup Database**
   - Import file `uas_web_2.sql` ke MySQL
   - Sesuaikan konfigurasi di `app/Config/Database.php`

4. **Konfigurasi Environment**
   ```bash
   cp env .env
   # Edit .env untuk baseURL dan database settings
   ```

5. **Jalankan Aplikasi**
   ```bash
   php spark serve
   ```

## 🔐 Default Login
- **Username**: admin
- **Password**: admin123

## 📊 Flow Aplikasi

1. **Login** → Dashboard dengan overview
2. **Kelola Barang** → CRUD data HP
3. **Kelola Supplier** → CRUD data pemasok
4. **Transaksi Masuk** → Penerimaan barang dari supplier
5. **Transaksi Keluar** → Penjualan barang
6. **Laporan** → Export data untuk analisis

## 🤝 Developer

- **Amelia & Elis** - Developer & Designer
- **Framework**: CodeIgniter 4
- **UI/UX**: Modern gradient design dengan responsive layout

## 📝 Lisensi

MIT License - bebas digunakan untuk keperluan edukasi dan komersial.
