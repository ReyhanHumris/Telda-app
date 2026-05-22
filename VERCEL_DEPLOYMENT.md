# Panduan Deployment Laravel ke Vercel

## 📋 Prasyarat
- ✅ Akun Vercel (https://vercel.com/signup)
- ✅ Repository Git (GitHub, GitLab, atau Bitbucket)
- ✅ Vercel CLI (opsional, untuk testing lokal)

---

## 🚀 Langkah-Langkah Deployment

### 1. **Siapkan Repository Git**

```bash
# Jika belum ada git repository
git init

# Tambahkan semua file
git add .
git commit -m "Initial commit - setup untuk Vercel"

# Push ke GitHub (ganti dengan akun Anda)
git remote add origin https://github.com/username/repo.git
git branch -M main
git push -u origin main
```

---

### 2. **Login ke Vercel**

```bash
# Buka https://vercel.com
# Pilih "Sign Up" atau "Log In"
# Hubungkan dengan akun GitHub/GitLab/Bitbucket Anda
```

---

### 3. **Buat Aplikasi di Vercel**

1. **Di dashboard Vercel**, klik tombol **"New Project"**
2. **Pilih repository** proyek Laravel Anda
3. **Tunggu** Vercel mendeteksi konfigurasi

---

### 4. **Konfigurasi Environment Variables**

Di halaman "Settings" proyek Anda di Vercel:

```
APP_KEY             = base64:XXXXXXXXXXXXX (dari .env lokal)
APP_DEBUG           = false
APP_ENV             = production
LOG_CHANNEL         = stderr

DATABASE_URL        = (mysql://user:pass@host:port/db jika perlu)
SESSION_DRIVER      = database
CACHE_DRIVER        = array
QUEUE_CONNECTION    = sync
```

**Cara mendapatkan APP_KEY:**
```bash
php artisan key:generate --show
```

---

### 5. **Pastikan File yang Diperlukan Ada**

✅ **vercel.json** - Sudah dibuat
✅ **api/index.php** - Sudah dibuat  
✅ **.vercelignore** - Sudah dibuat

---

### 6. **Atur Storage dan Temporary Files**

Tambahkan ke **vercel.json** untuk memory file system:

```json
{
  "build": {
    "env": {
      "LARAVEL_SKIP_BOOTSTRAP": "false"
    }
  }
}
```

---

### 7. **Database Setup (Jika Diperlukan)**

Jika menggunakan database:

1. **Siapkan database external** (Planetscale, AWS RDS, Supabase, etc)
2. **Tambahkan DATABASE_URL** ke Environment Variables
3. **Setup migrations:**

```bash
# Lokal - pastikan migrasi siap
php artisan migrate:fresh --force

# Di Vercel - set command ini di vercel.json jika perlu auto-migrate
# (tidak disarankan untuk production)
```

---

### 8. **Deploy!**

**Opsi A: Auto Deploy (Recommended)**
- Push ke `main` branch → Vercel otomatis deploy
- Vercel akan menjalankan `npm run build` dan composer install

**Opsi B: Manual Deploy via CLI**
```bash
npm i -g vercel
vercel --prod
```

---

## ✨ Hasil Deployment

Setelah berhasil deploy, Anda akan mendapat URL:
```
https://your-project-name.vercel.app
```

---

## 🔧 Troubleshooting

### ❌ Error: "Missing .env"
**Solusi:** Pastikan APP_KEY dan variabel penting sudah di Environment Variables Vercel

### ❌ Error: "Storage folder tidak writable"
**Solusi:** Vercel menggunakan ephemeral filesystem. Gunakan:
- Database sessions (bukan file)
- Cloud storage seperti S3 untuk uploads

### ❌ Error: "PHP version mismatch"
**Solusi:** Vercel mendukung PHP 8.1-8.3. Cek vercel.json sudah set ke 8.3

### ❌ Build timeout
**Solusi:** Buka Settings → Build & Deployment, naikkan Function timeout

---

## 📚 File Penting untuk Deployment

| File | Fungsi |
|------|--------|
| `vercel.json` | Konfigurasi Vercel |
| `api/index.php` | Entry point serverless |
| `.vercelignore` | File yang di-ignore saat deploy |
| `composer.json` | Dependencies PHP |
| `package.json` | Dependencies Node.js |

---

## 🎯 Tips Penting

1. **Session Storage**: Gunakan database bukan file
   ```php
   // .env
   SESSION_DRIVER=database
   ```

2. **Logs**: Gunakan stderr untuk production
   ```php
   // .env
   LOG_CHANNEL=stderr
   ```

3. **Cache**: Gunakan array atau Redis
   ```php
   // .env
   CACHE_DRIVER=array  // atau redis
   ```

4. **Upload Files**: Gunakan cloud storage (S3, Wasabi, etc)
   ```php
   FILESYSTEM_DISK=s3
   ```

---

## 🔗 Resources

- [Vercel Laravel Deployment](https://vercel.com/docs/frameworks/laravel)
- [Laravel Vercel PHP Runtime](https://vercel.com/docs/functions/serverless-functions/runtimes/php)
- [Environment Variables di Vercel](https://vercel.com/docs/projects/environment-variables)

---

## ❓ Pertanyaan Berikutnya?

Beri tahu saya jika ada masalah atau butuh bantuan lebih lanjut!
