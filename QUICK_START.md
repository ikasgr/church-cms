# 🚀 Quick Start Guide - CMS Church FLOBAMORA

## Instalasi Cepat (5 Menit)

### 1. Clone & Install
```bash
git clone https://github.com/ikasgr/church-cms.git
cd church-cms
composer install
```

### 2. Setup Environment
```bash
cp env .env
```

Edit `.env`:
```env
database.default.database = church_cms
database.default.username = root
database.default.password = 
```

### 3. Generate Key & Migrate
```bash
php spark key:generate
php spark migrate
```

### 4. Create Admin User
Buat file `app/Database/Seeds/UserSeeder.php`:
```php
<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@flobamora.com',
            'password' => password_hash('admin123', PASSWORD_BCRYPT),
            'full_name' => 'Administrator',
            'role' => 'admin',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
```

Run seeder:
```bash
php spark db:seed UserSeeder
```

### 5. Start Server
```bash
php spark serve
```

### 6. Login
- URL: http://localhost:8080/admin/login
- Username: `admin`
- Password: `admin123`

## 📁 Struktur Proyek

```
church-cms/
├── app/
│   ├── Controllers/        # 11 Controllers (CRUD lengkap)
│   ├── Models/            # 24 Models (dengan validasi)
│   ├── Views/admin/       # Admin views (layout, dashboard, login)
│   ├── Database/
│   │   └── Migrations/    # 24 Migrations
│   └── Config/
│       └── Routes.php     # 200+ routes
├── public/
│   └── uploads/           # Upload directory
├── README_PROJECT.md      # Dokumentasi lengkap
├── INSTALLATION.md        # Panduan instalasi detail
├── PROGRESS.md           # Progress tracking
└── SUMMARY.md            # Ringkasan proyek
```

## 🎯 Modul yang Tersedia

| No | Modul | Controller | Status |
|----|-------|------------|--------|
| 1 | Dashboard | Admin.php | ✅ |
| 2 | Lembaga | AdminLembaga.php | ✅ |
| 3 | Jemaat | AdminJemaat.php | ✅ |
| 4 | Ibadah & Kegiatan | AdminIbadah.php | ✅ |
| 5 | Keuangan | AdminKeuangan.php | ✅ |
| 6 | Berita & Warta | AdminBerita.php | ✅ |
| 7 | Galeri | AdminGaleri.php | ✅ |
| 8 | Interaksi | AdminInteraksi.php | ✅ |
| 9 | Pendaftaran | AdminPendaftaran.php | ✅ |
| 10 | Konten | AdminKonten.php | ✅ |
| 11 | Konfigurasi | AdminKonfigurasi.php | ✅ |

## 🔑 Admin Routes

### Dashboard
- `GET /admin` - Dashboard
- `GET /admin/login` - Login page
- `GET /admin/logout` - Logout

### Lembaga
- `GET /admin/lembaga/profile` - Profil gereja
- `GET /admin/lembaga/majelis` - Data majelis
- `GET /admin/lembaga/greeting` - Sambutan

### Jemaat
- `GET /admin/jemaat` - List jemaat
- `GET /admin/jemaat/create` - Form tambah
- `GET /admin/jemaat/edit/{id}` - Form edit
- `GET /admin/jemaat/families` - Data keluarga

### Ibadah & Kegiatan
- `GET /admin/ibadah` - Jadwal ibadah
- `GET /admin/ibadah/kegiatan` - List kegiatan
- `GET /admin/ibadah/kegiatan/create` - Form tambah

### Keuangan
- `GET /admin/keuangan` - List transaksi
- `GET /admin/keuangan/report` - Laporan
- `GET /admin/keuangan/export` - Export CSV

### Berita
- `GET /admin/berita` - List berita
- `GET /admin/berita/create` - Form tambah

### Galeri
- `GET /admin/galeri` - List galeri
- `GET /admin/galeri/create` - Form tambah

### Interaksi
- `GET /admin/interaksi/surveys` - Survei
- `GET /admin/interaksi/feedback` - Masukan
- `GET /admin/interaksi/guestbook` - Buku tamu

### Pendaftaran
- `GET /admin/pendaftaran` - List pendaftaran
- `GET /admin/pendaftaran/view/{id}` - Detail
- `GET /admin/pendaftaran/approve/{id}` - Approve

### Konten
- `GET /admin/konten/pages` - Halaman statis
- `GET /admin/konten/banners` - Banner
- `GET /admin/konten/links` - Link terkait
- `GET /admin/konten/faq` - FAQ

### Konfigurasi
- `GET /admin/konfigurasi/settings` - Pengaturan
- `GET /admin/konfigurasi/users` - User management
- `GET /admin/konfigurasi/menus` - Menu management
- `GET /admin/konfigurasi/theme` - Tema

## 📊 Database Tables

24 tabel sudah siap:
1. users
2. church_profile
3. majelis
4. greeting
5. jemaat
6. family
7. ibadah
8. kegiatan
9. kegiatan_registration
10. keuangan
11. news
12. gallery
13. surveys
14. survey_questions
15. survey_responses
16. feedback
17. guestbook
18. registrations
19. pages
20. banners
21. links
22. faq
23. menus
24. settings

## 🎨 Tech Stack

- **Backend**: CodeIgniter 4
- **Frontend**: Tailwind CSS + Alpine.js
- **Database**: MySQL/MariaDB
- **Icons**: Font Awesome 6

## 🔧 Common Commands

```bash
# Start development server
php spark serve

# Run migrations
php spark migrate

# Rollback migrations
php spark migrate:rollback

# Run seeder
php spark db:seed UserSeeder

# Clear cache
php spark cache:clear

# Generate encryption key
php spark key:generate
```

## 📝 Create Upload Directories

```bash
mkdir -p public/uploads/{logo,majelis,greeting,jemaat,kegiatan,keuangan,news,gallery,banners,theme}
mkdir -p public/uploads/gallery/{photos,thumbnails}
chmod -R 755 public/uploads/
```

## 🐛 Troubleshooting

### Database connection failed
```bash
# Check MySQL service
sudo systemctl status mysql
sudo systemctl start mysql
```

### Writable directory error
```bash
chmod -R 755 writable/
```

### Upload failed
```bash
chmod -R 755 public/uploads/
```

### 404 Not Found
```bash
# Enable mod_rewrite (Apache)
sudo a2enmod rewrite
sudo systemctl restart apache2
```

## 📚 Documentation

- **README_PROJECT.md** - Dokumentasi lengkap
- **INSTALLATION.md** - Panduan instalasi detail
- **PROGRESS.md** - Progress tracking
- **SUMMARY.md** - Ringkasan proyek

## 🎯 Next Steps

1. ✅ Backend sudah complete
2. ⏳ Buat admin CRUD views
3. ⏳ Buat frontend views
4. ⏳ Testing

## 💡 Tips

1. **Ubah password default** setelah login pertama
2. **Backup database** secara berkala
3. **Set environment** ke production saat deploy
4. **Gunakan HTTPS** di production
5. **Enable caching** untuk performance

## 📞 Support

- Email: support@ikasmedia.com
- Website: https://ikasmedia.com

---

**Happy Coding! 🚀**
