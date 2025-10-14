# 🏪 MODUL TOKO UMKM GEREJA

## 📋 Deskripsi
Modul Toko UMKM Gereja adalah fitur e-commerce untuk membantu jemaat memasarkan dan menjual produk lokal (hasil tangan, kuliner, kerajinan, dsb) di lingkungan gereja.

---

## 🎯 Fitur Utama

### 1. **Admin Panel**
- ✅ Dashboard UMKM dengan statistik lengkap
- ✅ Kelola Pelapak (Approve, Suspend, View Detail)
- ✅ Kelola Produk (Moderasi, Aktifkan/Non-aktifkan)
- ✅ Kelola Pesanan (Update Status, Tracking)
- ✅ Kelola Kategori Produk
- ✅ Laporan Penjualan (Per Pelapak & Keseluruhan)

### 2. **Pelapak/Seller** (Akan Dikembangkan)
- Registrasi & Login Pelapak
- Dashboard Pelapak
- CRUD Produk Sendiri
- Kelola Pesanan
- Laporan Penjualan
- Pencairan Dana

### 3. **Public/Customer** (Akan Dikembangkan)
- Katalog Produk (Grid View)
- Filter & Search Produk
- Detail Produk
- Keranjang Belanja
- Checkout & Pembayaran
- Tracking Pesanan

---

## 📊 Struktur Database

### Tabel Utama:
1. **`sellers`** - Data pelapak/UMKM
2. **`product_categories`** - Kategori produk
3. **`products`** - Data produk
4. **`orders`** - Data pesanan
5. **`order_items`** - Item dalam pesanan
6. **`product_reviews`** - Review produk
7. **`cart_items`** - Keranjang belanja
8. **`seller_transactions`** - Transaksi pencairan dana

### Import Database:
```sql
-- Import file database_umkm.sql ke database Anda
mysql -u root -p church_cms < database_umkm.sql
```

---

## 🚀 Instalasi & Setup

### 1. Import Database
```bash
# Jalankan query di database_umkm.sql
```

### 2. Buat Folder Upload
Folder sudah otomatis dibuat:
- `public/uploads/umkm/products/`
- `public/uploads/umkm/sellers/`
- `public/uploads/umkm/payments/`

### 3. Akses Admin Panel
```
URL: http://localhost/church-cms/public/admin/umkm
```

---

## 📁 Struktur File

### Models:
- `app/Models/SellerModel.php`
- `app/Models/ProductModel.php`
- `app/Models/ProductCategoryModel.php`
- `app/Models/OrderModel.php`

### Controllers:
- `app/Controllers/AdminUmkm.php` - Admin panel UMKM

### Views Admin:
- `app/Views/admin/umkm/index.php` - Dashboard
- `app/Views/admin/umkm/sellers/index.php` - Daftar pelapak
- `app/Views/admin/umkm/products/index.php` - Daftar produk
- `app/Views/admin/umkm/orders/index.php` - Daftar pesanan

---

## 🎨 Fitur yang Sudah Tersedia

### ✅ Admin Panel:

#### Dashboard (`/admin/umkm`)
- Statistik: Total Pelapak, Produk, Pesanan, Pendapatan
- Pesanan Terbaru
- Produk Terlaris
- Quick Actions

#### Kelola Pelapak (`/admin/umkm/sellers`)
- Daftar semua pelapak
- Filter by status (Pending, Active, Suspended)
- Approve pelapak baru
- Suspend pelapak
- View detail pelapak

#### Kelola Produk (`/admin/umkm/products`)
- Daftar semua produk
- Aktifkan/Non-aktifkan produk
- View produk dengan gambar

#### Kelola Pesanan (`/admin/umkm/orders`)
- Daftar semua pesanan
- Filter by status
- Update status pesanan
- View detail pesanan

---

## 🔄 Status Pesanan

1. **Pending** - Pesanan baru masuk
2. **Confirmed** - Pesanan dikonfirmasi
3. **Processing** - Sedang diproses
4. **Shipped** - Dikirim
5. **Completed** - Selesai
6. **Cancelled** - Dibatalkan

---

## 💰 Sistem Komisi

- Setiap pelapak bisa diatur komisi gereja (%)
- Komisi otomatis dihitung saat pesanan completed
- Pendapatan seller = Subtotal - Komisi

---

## 📱 Kategori Produk Default

1. Makanan & Minuman
2. Kerajinan Tangan
3. Fashion & Aksesoris
4. Pertanian & Perkebunan
5. Jasa & Layanan
6. Lainnya

---

## 🔐 Keamanan

- ✅ Authentication required untuk admin
- ✅ CSRF Protection
- ✅ File upload validation
- ✅ SQL Injection prevention (Query Builder)
- ✅ XSS Protection

---

## 📈 Fitur yang Akan Dikembangkan

### Phase 2 - Seller Panel:
- [ ] Registrasi Seller
- [ ] Login Seller
- [ ] Dashboard Seller
- [ ] CRUD Produk oleh Seller
- [ ] Kelola Pesanan Seller
- [ ] Pencairan Dana

### Phase 3 - Public Store:
- [ ] Katalog Produk Public
- [ ] Detail Produk
- [ ] Keranjang Belanja
- [ ] Checkout Process
- [ ] Payment Gateway Integration
- [ ] Order Tracking
- [ ] Product Reviews

### Phase 4 - Advanced Features:
- [ ] Multi-image upload per produk
- [ ] Product variants (ukuran, warna, dll)
- [ ] Shipping integration
- [ ] Promo & Discount system
- [ ] Loyalty points
- [ ] WhatsApp notification
- [ ] Email notification

---

## 🎯 Cara Penggunaan

### Untuk Admin:

#### 1. Approve Pelapak Baru
1. Buka `/admin/umkm/sellers`
2. Filter "Pending"
3. Klik "Approve" pada pelapak yang ingin disetujui

#### 2. Moderasi Produk
1. Buka `/admin/umkm/products`
2. Klik "Non-Aktifkan" untuk produk yang melanggar aturan

#### 3. Proses Pesanan
1. Buka `/admin/umkm/orders`
2. Klik "Detail" pada pesanan
3. Update status sesuai progress

#### 4. Lihat Laporan
1. Buka `/admin/umkm/reports`
2. Lihat penjualan harian & per pelapak

---

## 🛠️ Troubleshooting

### Error: Table doesn't exist
**Solusi:** Import file `database_umkm.sql`

### Error: Permission denied upload
**Solusi:** Set permission folder uploads:
```bash
chmod -R 755 public/uploads/umkm/
```

### Gambar tidak muncul
**Solusi:** Pastikan path gambar benar dan file exists

---

## 📞 Support

Jika ada pertanyaan atau bug, silakan hubungi tim developer.

---

## 📝 Changelog

### Version 1.0.0 (14 Oktober 2025)
- ✅ Database structure
- ✅ Models (Seller, Product, Order, Category)
- ✅ Admin Controller
- ✅ Admin Views (Dashboard, Sellers, Products, Orders)
- ✅ Routes configuration
- ✅ Upload folders

### Next Version (Coming Soon)
- Seller Panel
- Public Store
- Payment Integration

---

## 🎉 Selamat Menggunakan Modul UMKM!

Modul ini dirancang untuk membantu jemaat mengembangkan usaha mereka melalui platform gereja. Semoga bermanfaat! 🙏
