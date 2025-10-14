# CMS CHURCH FLOBAMORA

Sistem Manajemen Konten Gereja FLOBAMORA yang modular dan lengkap.

## 🚀 Teknologi

- **Backend**: CodeIgniter 4
- **Frontend**: HTML + Tailwind CSS + Alpine.js
- **Database**: MySQL/MariaDB

## 📦 Modul Aplikasi

### 1. Dashboard & Laporan
- Statistik jumlah jemaat
- Statistik keuangan (penerimaan & pengeluaran)
- Statistik kegiatan dan kehadiran
- Aktivitas terbaru
- Kegiatan mendatang

### 2. Modul Lembaga
- **Sambutan Ketua Majelis**: Manajemen sambutan dengan foto dan konten
- **Data Majelis**: Pengelolaan data anggota majelis dengan posisi dan foto
- **Profil Gereja**: 
  - Profil gereja (nama, alamat, kontak)
  - Sejarah gereja
  - Visi & Misi
  - Struktur Organisasi
  - Media sosial

### 3. Modul Jemaat
- Data anggota jemaat lengkap
- Data baptisan, sidi, dan pernikahan
- Keanggotaan keluarga
- Pencarian dan filter (nama, wilayah, status)
- Export data ke CSV
- Manajemen keluarga

### 4. Modul Ibadah & Kegiatan
- Jadwal ibadah mingguan
- Perayaan khusus
- Kegiatan kategorial (remaja, pemuda, lansia, paduan suara, dll)
- Pendaftaran kegiatan online
- Manajemen kehadiran
- Approval pendaftaran

### 5. Modul Keuangan Gereja
- **Penerimaan**: Persembahan, kolekte, donasi
- **Pengeluaran**: Operasional, pelayanan, sosial
- Laporan keuangan bulanan dan tahunan
- Grafik transparansi keuangan
- Export laporan ke CSV
- Upload bukti transaksi

### 6. Modul Berita & Warta Jemaat
- **Artikel**: Berita dan artikel gereja
- **Pengumuman**: Pengumuman penting
- **Renungan**: Renungan harian/mingguan
- **Agenda**: Jadwal kegiatan
- SEO friendly (slug, meta keywords, meta description)
- Featured image
- Publikasi terjadwal

### 7. Modul Galeri
- Manajemen foto kegiatan
- Manajemen video (YouTube, Vimeo, dll)
- Kategorisasi galeri
- Thumbnail otomatis untuk foto
- Statistik views

### 8. Modul Interaksi
- **Survei & Jajak Pendapat**: 
  - Berbagai tipe pertanyaan (text, radio, checkbox, select)
  - Hasil statistik
  - Anonim atau teridentifikasi
- **Masukan dan Saran**: 
  - Form feedback
  - Tanggapan admin
  - Status tracking
- **Buku Tamu**: 
  - Pesan dari pengunjung
  - Approval system

### 9. Modul Pendaftaran Online
- **Pendaftaran Baptis**: Form lengkap dengan data orang tua
- **Pendaftaran Sidi**: Form dengan data konfirmasi
- **Pendaftaran Nikah**: Form calon pengantin
- Approval/reject system
- Notifikasi status
- Export data pendaftaran

### 10. Modul Konten
- **Halaman Statis**: Halaman custom dengan template
- **Banner**: Slider homepage, sidebar, header, footer
- **Infografis**: Konten visual
- **Link Terkait**: Link eksternal dengan kategori
- **Iklan**: Manajemen iklan (opsional)
- **Tanya Jawab (FAQ)**: Pertanyaan umum dengan kategori

### 11. Modul Konfigurasi
- **Pengaturan Umum**: 
  - Konfigurasi aplikasi
  - Pengaturan per grup (general, email, theme, dll)
- **User Manajemen**: 
  - Role-based access (admin, editor, viewer)
  - Aktivasi/deaktivasi user
- **Pengaturan Menu**: 
  - Menu header, footer, sidebar
  - Menu hierarki (parent-child)
- **Pengaturan Modul**: 
  - Enable/disable modul
- **Pengaturan Tema**: 
  - Warna primer dan sekunder
  - Font family
  - Logo
  - Layout

## 📁 Struktur Direktori

```
church-cms/
├── app/
│   ├── Controllers/
│   │   ├── Admin.php                    # Dashboard & Auth
│   │   ├── AdminLembaga.php             # Modul Lembaga
│   │   ├── AdminJemaat.php              # Modul Jemaat
│   │   ├── AdminIbadah.php              # Modul Ibadah & Kegiatan
│   │   ├── AdminKeuangan.php            # Modul Keuangan
│   │   ├── AdminBerita.php              # Modul Berita
│   │   ├── AdminGaleri.php              # Modul Galeri
│   │   ├── AdminInteraksi.php           # Modul Interaksi
│   │   ├── AdminPendaftaran.php         # Modul Pendaftaran
│   │   ├── AdminKonten.php              # Modul Konten
│   │   ├── AdminKonfigurasi.php         # Modul Konfigurasi
│   │   └── Home.php                     # Frontend Controller
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── ChurchProfileModel.php
│   │   ├── MajelisModel.php
│   │   ├── GreetingModel.php
│   │   ├── JemaatModel.php
│   │   ├── FamilyModel.php
│   │   ├── IbadahModel.php
│   │   ├── KegiatanModel.php
│   │   ├── KegiatanRegistrationModel.php
│   │   ├── KeuanganModel.php
│   │   ├── NewsModel.php
│   │   ├── GalleryModel.php
│   │   ├── SurveyModel.php
│   │   ├── SurveyQuestionModel.php
│   │   ├── SurveyResponseModel.php
│   │   ├── FeedbackModel.php
│   │   ├── GuestbookModel.php
│   │   ├── RegistrationModel.php
│   │   ├── PageModel.php
│   │   ├── BannerModel.php
│   │   ├── LinkModel.php
│   │   ├── FaqModel.php
│   │   ├── MenuModel.php
│   │   └── SettingModel.php
│   ├── Database/
│   │   └── Migrations/                  # 24 migration files
│   └── Views/
│       ├── admin/                       # Admin views (to be created)
│       └── frontend/                    # Frontend views (to be created)
├── public/
│   ├── uploads/                         # Upload directory
│   └── assets/                          # CSS, JS, Images
└── writable/
```

## 🗄️ Database Schema

Aplikasi menggunakan 24 tabel database:

1. `users` - User management
2. `church_profile` - Profil gereja
3. `majelis` - Data majelis
4. `greeting` - Sambutan ketua majelis
5. `jemaat` - Data jemaat
6. `family` - Data keluarga
7. `ibadah` - Jadwal ibadah
8. `kegiatan` - Kegiatan gereja
9. `kegiatan_registration` - Pendaftaran kegiatan
10. `keuangan` - Transaksi keuangan
11. `news` - Berita & warta
12. `gallery` - Galeri foto/video
13. `surveys` - Survei
14. `survey_questions` - Pertanyaan survei
15. `survey_responses` - Jawaban survei
16. `feedback` - Masukan & saran
17. `guestbook` - Buku tamu
18. `registrations` - Pendaftaran baptis/sidi/nikah
19. `pages` - Halaman statis
20. `banners` - Banner
21. `links` - Link terkait
22. `faq` - Tanya jawab
23. `menus` - Menu navigasi
24. `settings` - Pengaturan aplikasi

## 🔐 Role & Permission

### Admin
- Full access ke semua modul
- Manajemen user
- Konfigurasi sistem

### Editor
- Akses ke konten (berita, galeri, kegiatan)
- Tidak bisa mengubah konfigurasi

### Viewer
- Read-only access
- Lihat laporan dan statistik

## 🚦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/ikasgr/church-cms.git
cd church-cms
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Database
```bash
cp env .env
```

Edit file `.env`:
```
database.default.hostname = localhost
database.default.database = church_cms
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### 4. Jalankan Migration
```bash
php spark migrate
```

### 5. Seed Data (Optional)
```bash
php spark db:seed UserSeeder
```

### 6. Jalankan Development Server
```bash
php spark serve
```

Akses aplikasi di: `http://localhost:8080`

## 📝 Default Login

**Admin Account:**
- Username: `admin`
- Password: `admin123`

⚠️ **Penting**: Ubah password default setelah login pertama!

## 🎨 Frontend Routes

- `/` - Homepage
- `/about` - Tentang gereja
- `/profile` - Profil gereja
- `/majelis` - Data majelis
- `/news` - Berita & warta
- `/events` - Kegiatan
- `/ibadah` - Jadwal ibadah
- `/gallery` - Galeri
- `/registration` - Pendaftaran online
- `/feedback` - Masukan & saran
- `/guestbook` - Buku tamu
- `/faq` - Tanya jawab

## 🔧 Admin Routes

- `/admin/login` - Login admin
- `/admin` - Dashboard
- `/admin/lembaga/*` - Modul lembaga
- `/admin/jemaat/*` - Modul jemaat
- `/admin/ibadah/*` - Modul ibadah & kegiatan
- `/admin/keuangan/*` - Modul keuangan
- `/admin/berita/*` - Modul berita
- `/admin/galeri/*` - Modul galeri
- `/admin/interaksi/*` - Modul interaksi
- `/admin/pendaftaran/*` - Modul pendaftaran
- `/admin/konten/*` - Modul konten
- `/admin/konfigurasi/*` - Modul konfigurasi

## 📊 Fitur Laporan

### Dashboard
- Total jemaat (aktif/non-aktif)
- Saldo keuangan
- Pemasukan & pengeluaran bulan ini
- Kegiatan mendatang
- Pendaftaran pending
- Feedback baru

### Laporan Keuangan
- Laporan bulanan
- Laporan tahunan
- Grafik pemasukan vs pengeluaran
- Breakdown per kategori
- Export ke CSV

### Laporan Jemaat
- Data lengkap jemaat
- Filter berdasarkan wilayah, status
- Export ke CSV

## 🔒 Security Features

- Password hashing (bcrypt)
- CSRF protection
- XSS filtering
- SQL injection prevention
- Session management
- Role-based access control

## 📱 Responsive Design

- Mobile-first approach
- Tailwind CSS untuk styling
- Alpine.js untuk interaktivitas
- Optimized untuk semua device

## 🛠️ Development

### Requirements
- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Node.js & NPM (untuk compile assets)

### Compile Assets
```bash
npm install
npm run dev    # Development
npm run build  # Production
```

## 📄 License

This project is licensed under the MIT License.

## 👥 Contributors

- IKAS MEDIA - Initial work

## 📞 Support

Untuk bantuan dan pertanyaan:
- Email: support@ikasmedia.com
- Website: https://ikasmedia.com

## 🔄 Changelog

### Version 1.0.0 (2024)
- Initial release
- 10 modul lengkap
- 24 tabel database
- Admin panel dengan Tailwind CSS
- Frontend responsive
- Role-based access control
- Export data (CSV)
- Upload file (foto, dokumen)
- SEO friendly

## 🚀 Roadmap

### Version 1.1.0
- [ ] Email notifications
- [ ] SMS gateway integration
- [ ] Mobile app (React Native)
- [ ] API REST untuk integrasi
- [ ] Multi-language support
- [ ] Advanced reporting dengan Chart.js
- [ ] Backup & restore database
- [ ] Activity log

### Version 1.2.0
- [ ] Online payment gateway
- [ ] Live streaming integration
- [ ] Mobile attendance (QR Code)
- [ ] WhatsApp integration
- [ ] Push notifications
- [ ] Advanced analytics

## 📚 Documentation

Dokumentasi lengkap tersedia di folder `/docs`:
- User Manual
- Admin Manual
- API Documentation
- Database Schema
- Deployment Guide

---

**Dibuat dengan ❤️ untuk Gereja FLOBAMORA**
