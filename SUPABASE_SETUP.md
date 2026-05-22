# Supabase Database Setup untuk Vercel (GRATIS & UNLIMITED)

## 🎉 Keuntungan Supabase Free Tier

✅ **Unlimited database** (50MB total per project)  
✅ **Unlimited connections**  
✅ **Real-time subscriptions**  
✅ **JWT authentication**  
✅ **PostgreSQL 15+**  
✅ **HTTPS + SSL included**  
✅ Cocok untuk hobby projects & MVP

---

## 🚀 Langkah 1: Buat Project di Supabase

### A. Daftar Akun
1. Buka https://supabase.com
2. Klik **"Start your project"**
3. Sign up dengan GitHub atau email
4. Verifikasi email Anda

### B. Buat Project
1. Di dashboard → **"New Project"**
2. **Project name:** `telda-labuan-bajo`
3. **Password:** Catat untuk nanti
4. **Region:** Singapore (Asia)
5. Klik **"Create new project"**
6. **Tunggu ~2 menit** untuk setup selesai

---

## 🔑 Langkah 2: Dapatkan Connection String

### Cara Mendapatkan Connection String:

1. **Di dashboard Supabase** → Project Anda → **"Settings"**
2. Pilih **"Database"** di sidebar kiri
3. Scroll ke bawah → **"Connection string"** → Pilih **"URI"**
4. Copy connection string format:

```
postgresql://postgres:PASSWORD@db.xxxxx.supabase.co:5432/postgres
```

Atau gunakan **"Connection pooling"** untuk performance lebih baik:

```
postgresql://postgres.xxxxx:PASSWORD@5432-1-aws-xxxx.pooler.supabase.com:6543/postgres
```

---

## 🌐 Langkah 3: Setup di Project Laravel

### A. Update config/database.php

Default PostgreSQL sudah ada di Laravel, pastikan gunakan:

```php
'default' => env('DB_CONNECTION', 'pgsql'),
```

### B. Update .env Lokal untuk Test

```env
DB_CONNECTION=pgsql
DB_HOST=db.xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

### C. Jalankan Migrations Lokal (untuk test)

```bash
php artisan migrate --force
```

---

## 📋 Langkah 4: Setup di Vercel

### Buka Vercel Dashboard:

1. Project Anda → **Settings** → **Environment Variables**
2. Tambahkan:

```
DB_CONNECTION=pgsql
DB_HOST=db.xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=YOUR_PASSWORD
```

**ATAU** gunakan `DATABASE_URL` langsung:

```
DATABASE_URL=postgresql://postgres:PASSWORD@db.xxxxx.supabase.co:5432/postgres
```

Kemudian di Vercel, tambahkan env variable:
```
DB_CONNECTION=pgsql
```

---

## 🔐 Langkah 5: Update Laravel Config untuk Production

Edit **config/database.php** - PostgreSQL section:

```php
'pgsql' => [
    'driver' => 'pgsql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'postgres'),
    'username' => env('DB_USERNAME', 'postgres'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => env('DB_CHARSET', 'utf8'),
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => env('DB_SSLMODE', 'require'),
],
```

---

## 🧪 Langkah 6: Test Connection

### Cara 1: Terminal PowerShell

```powershell
# Set environment variable
$env:DATABASE_URL = "postgresql://postgres:PASSWORD@db.xxxxx.supabase.co:5432/postgres"
$env:DB_CONNECTION = "pgsql"

# Test koneksi
php artisan tinker
>>> DB::connection('pgsql')->getPdo()
>>> DB::table('users')->count()
>>> exit
```

### Cara 2: Artisan Command

```bash
php artisan db:show
```

---

## 🔄 Langkah 7: Run Migrations di Supabase

### Opsi A: Manual (Recommended)

**Test lokal dulu:**
```bash
php artisan migrate --force
```

**Jika berhasil, push ke GitHub:**
```bash
git add .
git commit -m "Setup Supabase PostgreSQL untuk Vercel"
git push
```

### Opsi B: Auto-Migrate saat Deploy

Pastikan di **vercel.json**, `buildCommand` include migration:

```json
"buildCommand": "composer install --prefer-dist && npm install && npm run build && php artisan migrate --force"
```

---

## ✅ Checklist Setup Supabase

- [ ] Akun Supabase dibuat
- [ ] Project dibuat di region Singapore
- [ ] Connection string didapat (catat password!)
- [ ] Migrations berhasil lokal: `php artisan migrate`
- [ ] `.env` diupdate dengan DB credentials
- [ ] Test connection: `php artisan tinker`
- [ ] Environment Variables di Vercel sudah di-set
- [ ] Push ke GitHub & Vercel deploy
- [ ] Akses aplikasi: https://your-app.vercel.app

---

## 📊 Struktur Tabel yang Akan Dibuat

Semua tabel custom Anda akan dimigrasikan:

```sql
users              -- Laravel default
cache              -- Cache store
job_batches        -- Job batching
penggunas          -- Custom
aktivitas          -- Custom + soft delete
indibiz_data       -- Custom + soft delete
survey_data        -- Custom + soft delete + alamat fields
sessions           -- Session storage (PostgreSQL)
migrations         -- Migration tracking
```

---

## 🎯 Environment Variables Lengkap untuk Vercel

```
APP_NAME=Telda
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:XXXXXXXXXXXX
APP_URL=https://your-app.vercel.app

DB_CONNECTION=pgsql
DB_HOST=db.xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
DB_SSLMODE=require

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr

MAIL_MAILER=log
```

---

## 🆘 Troubleshooting

### ❌ Error: "SQLSTATE[08006]"
**Solusi:** 
- Gunakan connection pooling bukan direct connection
- Atau pastikan password benar tanpa special characters yang tidak ter-escape

### ❌ Error: "role 'postgres' does not exist"
**Solusi:** 
- Supabase default user adalah `postgres`
- Check kembali password di Supabase dashboard

### ❌ Error: "SSL certificate rejected"
**Solusi:**
- Set `DB_SSLMODE=require` di .env
- Sudah auto-handled di config database.php

### ❌ Migrations timeout
**Solusi:**
- Vercel free tier punya execution limit 10 detik
- Upgrade ke Pro atau jalankan migrations manual lokal dulu

---

## 💡 Tips Penting untuk Supabase + Vercel

1. **Gunakan Connection Pooling** untuk banyak connections:
   - Vercel serverless = banyak connections concurrent
   - Connection pooling mengatasi "too many connections" error

2. **Set Session Timeout**:
   ```php
   // config/session.php
   'lifetime' => 525600, // 1 year
   'expire_on_close' => false,
   ```

3. **Monitor Database Usage**:
   - Supabase Dashboard → Settings → Usage
   - Pastikan tidak exceed free tier limits

4. **Backup Regular**:
   ```bash
   php artisan migrate:status
   ```

---

## 🔗 Links Berguna

- [Supabase Documentation](https://supabase.com/docs)
- [Supabase + Laravel](https://supabase.com/docs/guides/database/connecting-to-postgres)
- [Laravel + PostgreSQL](https://laravel.com/docs/database)
- [Vercel + Supabase](https://vercel.com/docs/storage/supabase)

---

## 🚀 Langkah Berikutnya

1. ✅ Setup Supabase project
2. ✅ Dapatkan connection string
3. ✅ Update .env lokal
4. ✅ Test migrations
5. ✅ Set environment variables di Vercel
6. ✅ Deploy! 🎉

**Siap setup? Beri tahu saya saat connection string sudah siap!**
