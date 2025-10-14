# Panduan Instalasi CMS Church FLOBAMORA

## Persyaratan Sistem

### Minimum Requirements
- PHP 8.1 atau lebih tinggi
- MySQL 5.7 atau MariaDB 10.3
- Apache/Nginx Web Server
- Composer
- 512 MB RAM (minimum)
- 100 MB disk space

### PHP Extensions Required
- intl
- mbstring
- json
- mysqlnd
- libcurl
- gd (untuk image processing)

## Langkah-langkah Instalasi

### 1. Clone atau Download Repository

```bash
# Clone via Git
git clone https://github.com/ikasgr/church-cms.git
cd church-cms

# Atau download ZIP dan extract
```

### 2. Install Dependencies

```bash
composer install
```

Jika Composer belum terinstall, download dari: https://getcomposer.org/

### 3. Konfigurasi Environment

```bash
# Copy file environment
cp env .env

# Edit file .env
nano .env
```

Konfigurasi database di file `.env`:

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------

CI_ENVIRONMENT = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------

app.baseURL = 'http://localhost:8080/'
app.indexPage = ''

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = church_cms
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix = 
database.default.port = 3306

#--------------------------------------------------------------------
# ENCRYPTION
#--------------------------------------------------------------------

encryption.key = [GENERATE_KEY_HERE]
```

### 4. Generate Encryption Key

```bash
php spark key:generate
```

Key akan otomatis ditambahkan ke file `.env`

### 5. Buat Database

```sql
CREATE DATABASE church_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau via phpMyAdmin:
1. Buka phpMyAdmin
2. Klik "New" untuk database baru
3. Nama database: `church_cms`
4. Collation: `utf8mb4_unicode_ci`
5. Klik "Create"

### 6. Jalankan Migration

```bash
php spark migrate
```

Ini akan membuat 24 tabel yang diperlukan:
- users
- church_profile
- majelis
- greeting
- jemaat
- family
- ibadah
- kegiatan
- kegiatan_registration
- keuangan
- news
- gallery
- surveys
- survey_questions
- survey_responses
- feedback
- guestbook
- registrations
- pages
- banners
- links
- faq
- menus
- settings

### 7. Seed Data Awal (Optional)

Buat file seeder untuk user admin:

```bash
php spark make:seeder UserSeeder
```

Edit `app/Database/Seeds/UserSeeder.php`:

```php
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@flobamora.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'full_name' => 'Administrator',
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
```

Jalankan seeder:

```bash
php spark db:seed UserSeeder
```

### 8. Set Permissions (Linux/Mac)

```bash
chmod -R 755 writable/
chmod -R 755 public/uploads/
```

Buat folder uploads jika belum ada:

```bash
mkdir -p public/uploads/{logo,majelis,greeting,jemaat,kegiatan,keuangan,news,gallery,banners,theme}
mkdir -p public/uploads/gallery/{photos,thumbnails}
chmod -R 755 public/uploads/
```

### 9. Konfigurasi Web Server

#### Apache (.htaccess sudah included)

Pastikan `mod_rewrite` aktif:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Virtual Host configuration:

```apache
<VirtualHost *:80>
    ServerName church-cms.local
    DocumentRoot /path/to/church-cms/public
    
    <Directory /path/to/church-cms/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/church-cms-error.log
    CustomLog ${APACHE_LOG_DIR}/church-cms-access.log combined
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name church-cms.local;
    root /path/to/church-cms/public;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

### 10. Jalankan Development Server

Untuk testing cepat tanpa konfigurasi web server:

```bash
php spark serve
```

Akses aplikasi di: `http://localhost:8080`

### 11. Login Admin

```
URL: http://localhost:8080/admin/login
Username: admin
Password: admin123
```

**PENTING**: Segera ubah password default setelah login pertama!

## Post-Installation

### 1. Ubah Password Admin

1. Login ke admin panel
2. Klik menu "Profile" di kanan atas
3. Ubah password
4. Save

### 2. Konfigurasi Profil Gereja

1. Menu: **Lembaga > Profil Gereja**
2. Isi data:
   - Nama gereja
   - Alamat
   - Kontak (telepon, email, website)
   - Upload logo
   - Sejarah gereja
   - Visi & Misi
   - Media sosial

### 3. Setup Menu

1. Menu: **Konfigurasi > Menu**
2. Buat menu untuk header dan footer
3. Atur urutan menu

### 4. Konfigurasi Tema

1. Menu: **Konfigurasi > Tema**
2. Pilih warna primer dan sekunder
3. Upload logo
4. Pilih font

### 5. Buat User Tambahan

1. Menu: **Konfigurasi > User**
2. Tambah user dengan role sesuai kebutuhan:
   - **Admin**: Full access
   - **Editor**: Kelola konten
   - **Viewer**: Read-only

## Troubleshooting

### Error: "Database connection failed"

**Solusi:**
1. Cek kredensial database di `.env`
2. Pastikan MySQL service running
3. Cek apakah database sudah dibuat

```bash
# Check MySQL service
sudo systemctl status mysql

# Restart MySQL
sudo systemctl restart mysql
```

### Error: "Encryption key not set"

**Solusi:**
```bash
php spark key:generate
```

### Error: "writable directory not writable"

**Solusi:**
```bash
chmod -R 755 writable/
chown -R www-data:www-data writable/
```

### Error: "404 Not Found" untuk semua route

**Solusi Apache:**
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

**Solusi Nginx:**
Pastikan konfigurasi `try_files` sudah benar

### Upload file gagal

**Solusi:**
```bash
# Buat folder uploads
mkdir -p public/uploads
chmod -R 755 public/uploads/
chown -R www-data:www-data public/uploads/

# Cek php.ini
upload_max_filesize = 10M
post_max_size = 10M
```

### Migration error

**Solusi:**
```bash
# Reset migration
php spark migrate:rollback

# Jalankan ulang
php spark migrate
```

## Update Aplikasi

### Via Git

```bash
# Backup database terlebih dahulu
mysqldump -u root -p church_cms > backup.sql

# Pull update
git pull origin main

# Update dependencies
composer update

# Jalankan migration baru (jika ada)
php spark migrate

# Clear cache
php spark cache:clear
```

### Manual Update

1. Backup database dan files
2. Download versi terbaru
3. Replace files (kecuali `.env` dan `writable/`)
4. Run `composer update`
5. Run `php spark migrate`

## Backup & Restore

### Backup Database

```bash
# Via command line
mysqldump -u root -p church_cms > backup_$(date +%Y%m%d).sql

# Via phpMyAdmin
# Export > SQL > Go
```

### Restore Database

```bash
mysql -u root -p church_cms < backup.sql
```

### Backup Files

```bash
# Backup uploads
tar -czf uploads_backup.tar.gz public/uploads/

# Backup full application
tar -czf church_cms_backup.tar.gz church-cms/
```

## Production Deployment

### 1. Set Environment ke Production

Edit `.env`:
```env
CI_ENVIRONMENT = production
app.baseURL = 'https://yourdomain.com/'
```

### 2. Disable Debug Mode

```env
CI_DEBUG = false
```

### 3. Setup SSL Certificate

```bash
# Let's Encrypt
sudo certbot --apache -d yourdomain.com
```

### 4. Optimize Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

### 5. Setup Cron Jobs (Optional)

```bash
# Edit crontab
crontab -e

# Add backup job (daily at 2 AM)
0 2 * * * /usr/bin/mysqldump -u root -pPASSWORD church_cms > /backups/church_cms_$(date +\%Y\%m\%d).sql
```

## Support

Jika mengalami masalah:
1. Cek dokumentasi di `/docs`
2. Cek log error di `writable/logs/`
3. Contact: support@ikasmedia.com

---

**Selamat menggunakan CMS Church FLOBAMORA!**
