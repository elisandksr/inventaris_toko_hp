# 📋 DOKUMENTASI KODE APLIKASI INVENTARIS TOKO HP
## Presentasi & Penjelasan Teknis

### 🎯 **TUJUAN APLIKASI**
Aplikasi web berbasis CodeIgniter 4 untuk mengelola inventaris toko handphone dengan fitur lengkap manajemen stok, transaksi, dan pelaporan.

---

## 📁 **STRUKTUR FILE UTAMA**

### 1. **`app/Views/dashboard_view.php`** - HALAMAN UTAMA
**Fungsi:** Menampilkan ringkasan keseluruhan sistem inventaris

**Fitur Utama:**
- ✅ **Header dengan Glassmorphism Effect** - Desain modern dengan efek transparan
- ✅ **Sidebar Navigasi** - Menu lengkap dengan pengelompokan (Master Data, Transaksi, Laporan)
- ✅ **Cards Statistik** - 4 card menampilkan: Total Jenis HP, Total Unit, Total Aset, Perlu Restock
- ✅ **Hero Section** - Salam personal + tombol Call-to-Action
- ✅ **Section Detail 2 Kolom:**
  - Kiri: Daftar barang stok menipis (< 5 unit)
  - Kanan: Log aktivitas transaksi hari ini
- ✅ **Copyright Multi-line** - Di bagian bawah sidebar

**Teknologi CSS:**
- CSS Custom Properties untuk konsistensi warna
- CSS Grid untuk layout responsif
- Flexbox untuk alignment yang fleksibel
- Gradient backgrounds untuk tampilan modern

---

### 2. **`app/Views/transaksi_keluar_view.php`** - TRANSAKSI BARANG KELUAR
**Fungsi:** Mengelola pengeluaran barang dari gudang

**Fitur Utama:**
- ✅ **Form Input Transaksi** dengan validasi real-time stok
- ✅ **Dropdown Barang** dengan informasi stok saat ini
- ✅ **Breadcrumb Navigation** - Dashboard > Transaksi > Barang Keluar
- ✅ **Flash Messages** - Notifikasi sukses/error
- ✅ **Tabel Riwayat** - Log semua transaksi keluar dengan opsi edit/hapus
- ✅ **Validasi Stok** - Mencegah pengeluaran melebihi stok tersedia

**Logika Validasi:**
```javascript
// JavaScript untuk validasi real-time
if (jumlahInput > stokTersedia) {
    tampilkanPeringatan("Stok tidak mencukupi!");
}
```

---

### 3. **`app/Views/barang_view.php`** - MANAJEMEN DATA BARANG
**Fungsi:** Mengelola master data barang HP

**Fitur Utama:**
- ✅ **Tabel Data Barang** - Tampilan grid dengan pagination
- ✅ **Form Tambah Barang** - Input data lengkap (nama, merek, harga, stok)
- ✅ **Modal Edit/Hapus** - Operasi CRUD tanpa reload halaman
- ✅ **Search & Filter** - Pencarian real-time berdasarkan nama/merek
- ✅ **Status Stok** - Badge warna untuk status stok (Normal, Rendah, Habis)

---

## 🎨 **DESAIN & UI/UX**

### **Palet Warna Utama:**
- **Primary:** `#6366f1` (Biru Ungu)
- **Secondary:** `#3b82f6` (Biru)
- **Warning:** `#f59e0b` (Orange)
- **Danger:** `#ef4444` (Merah)
- **Success:** `#10b981` (Hijau)

### **Prinsip Desain:**
1. **Glassmorphism** - Efek transparan pada header
2. **Gradient Backgrounds** - Untuk cards dan buttons
3. **Rounded Corners** - Border radius 20px untuk kesan modern
4. **Hover Effects** - Transform dan shadow untuk interaktivitas
5. **Responsive Grid** - Layout yang menyesuaikan ukuran layar

---

## 🔧 **TEKNOLOGI & FRAMEWORK**

### **Backend:**
- **CodeIgniter 4** - PHP Framework MVC
- **MySQL** - Database untuk penyimpanan data
- **PHP 8.1+** - Bahasa pemrograman server

### **Frontend:**
- **HTML5** - Struktur markup
- **CSS3** - Styling dengan custom properties
- **JavaScript** - Interaktivitas dan validasi
- **BoxIcons** - Library ikon modern
- **Google Fonts** - Typography (Nunito & Fredoka)

### **Fitur Teknis:**
- **AJAX** - Update real-time tanpa reload
- **Session Management** - Autentikasi user
- **Form Validation** - Validasi client & server side
- **Responsive Design** - Mobile-friendly
- **CRUD Operations** - Create, Read, Update, Delete

---

## 📊 **FITUR BISNIS UTAMA**

### **1. Manajemen Stok**
- ✅ Input barang masuk/keluar
- ✅ Tracking stok real-time
- ✅ Peringatan stok rendah
- ✅ Hitung total aset otomatis

### **2. Pelaporan**
- ✅ Laporan transaksi masuk/keluar
- ✅ Filter berdasarkan periode
- ✅ Export laporan
- ✅ Dashboard statistik

### **3. Master Data**
- ✅ Kelola data barang HP
- ✅ Manajemen supplier
- ✅ Kategori dan merek
- ✅ Harga dan spesifikasi

---

## 🚀 **CARA MENJALANKAN APLIKASI**

### **Persyaratan Sistem:**
```bash
- PHP 8.1 atau lebih tinggi
- MySQL 5.7+
- Composer
- Web Server (Apache/Nginx)
```

### **Langkah Instalasi:**
1. Clone repository dari GitHub
2. Install dependencies: `composer install`
3. Setup database dan import `uas_web_2.sql`
4. Konfigurasi `.env` file
5. Jalankan: `php spark serve`

---

## 👥 **TARGET PENGGUNA**

- **Owner/Admin Toko** - Mengelola keseluruhan sistem
- **Staff Gudang** - Input transaksi barang
- **Manager** - Monitoring laporan dan statistik

---

## 🎯 **KEUNGGULAN APLIKASI**

1. **User-Friendly Interface** - Desain intuitif dan modern
2. **Real-time Validation** - Validasi stok otomatis
3. **Responsive Design** - Bisa diakses dari mobile
4. **Data Security** - Session-based authentication
5. **Performance Optimized** - Loading cepat dengan optimasi query
6. **Scalable Architecture** - Mudah dikembangkan fitur baru

---

## 🔄 **FLOWSISTEM UTAMA**

### **Flow Input Barang Masuk:**
1. User pilih menu "Barang Masuk"
2. Isi form: pilih barang, jumlah, supplier, tanggal
3. Sistem validasi data
4. Update stok otomatis
5. Redirect ke dashboard dengan notifikasi

### **Flow Monitoring Stok:**
1. Dashboard menampilkan statistik real-time
2. Card "Perlu Restock" menunjukkan barang < 5 unit
3. Klik card untuk scroll ke detail
4. Staff dapat segera melakukan restock

---

## 📞 **KONTAK & SUPPORT**

**Developer:** Amelia & Elis
**Version:** 1.0.0
**Last Update:** Januari 2026

---

*📝 Dokumentasi ini dibuat untuk memudahkan presentasi dan penjelasan teknis aplikasi inventaris toko HP kepada stakeholder atau tim development.*
