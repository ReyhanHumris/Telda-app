# PlanetScale Database Setup untuk Vercel

## 🚀 Langkah 1: Buat Akun & Database di PlanetScale

### A. Daftar di PlanetScale
1. Buka https://app.planetscale.com/register
2. Sign up dengan email atau GitHub
3. Verifikasi email Anda

### B. Buat Database
1. Di dashboard PlanetScale → **"Create Database"**
2. **Nama database:** `telda-labuan-bajo` (atau nama lain)
3. **Region:** Pilih yang terdekat (Asia: Singapore, Tokyo)
4. **Tier:** Starter (free) atau Professional
5. Klik **"Create database"**

---

## 🔑 Langkah 2: Dapatkan Connection String

Setelah database dibuat:

1. Klik database Anda → **"Branches"** → **"main"** → **"Connect"**
2. Pilih **"General"** di dropdown
3. Copy connection string format `DATABASE_URL`:

```
mysql://username:password@pscale_xxx.mysql.planetscale.com/database_name?sslaccept=strict
```

---

## 🌐 Langkah 3: Setup di Vercel

### Di Vercel Dashboard:

1. Buka project Vercel Anda
2. **Settings** → **Environment Variables**
3. Tambahkan variabel baru:

| Key | Value |
|-----|-------|
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | `pscale_xxx.mysql.planetscale.com` |
| `DB_PORT` | `3306` |
| `DB_DATABASE` | `telda-labuan-bajo` |
| `DB_USERNAME` | `xxxxx` |
| `DB_PASSWORD` | `xxxxx` |
| `DB_SSL_MODE` | `REQUIRED` |

**ATAU** langsung paste `DATABASE_URL` yang sudah ada.

### Environment Lengkap untuk Production:

```
APP_NAME=Telda
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:XXXXXXXXXXXX
APP_URL=https://your-project.vercel.app

# Database PlanetScale
DB_CONNECTION=mysql
DB_HOST=pscale_xxx.mysql.planetscale.com
DB_PORT=3306
DB_DATABASE=telda-labuan-bajo
DB_USERNAME=xxxxx
DB_PASSWORD=xxxxx
DB_SSL_MODE=REQUIRED

# Session & Cache (serverless-friendly)
SESSION_DRIVER=database
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr

# Mail (optional - ubah sesuai provider)
MAIL_MAILER=log
```

---

## 📊 Langkah 4: Migrasi Database

Ada 2 cara untuk run migrations:

### Opsi A: Manual (Recommended untuk First Time)

```bash
# Lokal - test migrations
php artisan migrate --database=production

# Atau langsung dengan DATABASE_URL:
# DATABASE_URL="mysql://..." php artisan migrate
```

Kemudian push ke main branch dan Vercel akan deploy otomatis.

### Opsi B: Auto-Migrate saat Deploy (Tidak Recommended)

Jika ingin auto-migrate, buat file bootstrap:

**File: `bootstrap/migration.php`**
```php
<?php
if (app()->environment('production') && !env('APP_MIGRATED')) {
    shell_exec('php artisan migrate --force');
    file_put_contents('.env.migrated', 'done');
}
```

---

## 🔗 Langkah 5: Test Koneksi

Untuk test koneksi lokal dengan PlanetScale:

```bash
# Copy DATABASE_URL dari PlanetScale

# Set di terminal
$env:DATABASE_URL = "mysql://user:pass@host/db"

# Atau di .env
DATABASE_URL=mysql://user:pass@host/db

# Test koneksi
php artisan tinker
>>> DB::connection('mysql')->getPdo()
```

---

## ✅ Checklist Deployment

- [ ] Database dibuat di PlanetScale
- [ ] Connection string didapatkan
- [ ] Environment variables set di Vercel
- [ ] Migrations sudah dijalankan lokal
- [ ] Push ke GitHub
- [ ] Vercel auto-deploy
- [ ] Test aplikasi di URL Vercel

---

## 🚨 Troubleshooting

### ❌ Error: "SQLSTATE[HY000]: General error: 2002"
**Solusi:** 
- Pastikan `DB_SSL_MODE=REQUIRED` 
- SSL certificate sudah dimuat di Laravel

```php
// config/database.php - tambahkan untuk MySQL:
'mysql' => [
    // ...
    'options' => [
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ],
],
```

### ❌ Error: "Access denied for user"
**Solusi:** 
- Cek username & password di PlanetScale
- Pastikan branching diizinkan (PlanetScale settings)

### ❌ Error: "Table doesn't exist"
**Solusi:**
- Jalankan migrations di PlanetScale:
  ```bash
  DATABASE_URL="mysql://..." php artisan migrate --force
  ```

---

## 📝 Konfigurasi Laravel untuk SSL/MySQL

Update **config/database.php** untuk SSL di production:

```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', 3306),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => env('DB_SSL_MODE') === 'REQUIRED' ? true : false,
    ]) : [],
],
```

---

## 🎯 Tabel yang Akan Dimigrasikan

```
users                   (Laravel default)
cache                   (Laravel caching)
jobs                    (Queue system)
penggunas              (Custom)
aktivitas              (Custom)
indibiz_data           (Custom)
survey_data            (Custom)
sessions                (Session storage)
```

---

## 💡 Tips

1. **Backup database** sebelum deploy ke production
2. Gunakan **PlanetScale's branching feature** untuk dev/staging
3. Monitor query performance di PlanetScale dashboard
4. Set **slow query logs** untuk debug

---

## 🔗 Links Berguna

- [PlanetScale Documentation](https://docs.planetscale.com/)
- [Laravel + PlanetScale](https://docs.planetscale.com/frameworks/laravel)
- [Vercel + Database](https://vercel.com/docs/storage)

---

Siap untuk langkah berikutnya? Beri tahu saya saat DATABASE_URL sudah siap! 🚀
