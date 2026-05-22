# ✅ Deployment ke Vercel - Langkah Final

## 📝 Environment Variables untuk Vercel

Buka **Vercel Dashboard** → Project Anda → **Settings** → **Environment Variables**

Tambahkan variables berikut:

```
APP_NAME                = Telda
APP_ENV                 = production
APP_DEBUG               = false
APP_KEY                 = base64:htM9/I4+t88ooODjXZN3OtwcRFn9B76+4anulgqQTRc=
APP_URL                 = https://YOUR-PROJECT-NAME.vercel.app

DB_CONNECTION           = pgsql
DB_HOST                 = db.ojmgozpgzqdt1uahwunl.supabase.co
DB_PORT                 = 5432
DB_DATABASE             = postgres
DB_USERNAME             = postgres
DB_PASSWORD             = P0ydUkGx72Eirpg
DB_SSLMODE              = require

SESSION_DRIVER          = database
CACHE_DRIVER            = database
QUEUE_CONNECTION        = sync
LOG_CHANNEL             = stderr

MAIL_MAILER             = log
```

---

## 🚀 Langkah-Langkah:

### 1️⃣ Buka Vercel Dashboard
- Buka https://vercel.com/dashboard
- Pilih project **Telda-app** Anda

### 2️⃣ Masuk ke Settings
- Klik **Settings** di menu atas
- Pilih **Environment Variables** di sidebar kiri

### 3️⃣ Tambahkan Variables
Klik **"Add New"** dan input masing-masing:

| Variable | Value |
|----------|-------|
| `APP_NAME` | `Telda` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | `base64:htM9/I4+t88ooODjXZN3OtwcRFn9B76+4anulgqQTRc=` |
| `APP_URL` | `https://YOUR-PROJECT.vercel.app` |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | `db.ojmgozpgzqdt1uahwunl.supabase.co` |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | `postgres` |
| `DB_USERNAME` | `postgres` |
| `DB_PASSWORD` | `P0ydUkGx72Eirpg` |
| `DB_SSLMODE` | `require` |
| `SESSION_DRIVER` | `database` |
| `CACHE_DRIVER` | `database` |
| `QUEUE_CONNECTION` | `sync` |
| `LOG_CHANNEL` | `stderr` |
| `MAIL_MAILER` | `log` |

### 4️⃣ Save
Klik **Save** untuk menyimpan semua variables

### 5️⃣ Vercel Redeploy
Setelah save, Vercel akan **otomatis deploy ulang** dengan environment variables baru

### 6️⃣ Tunggu Deploy Selesai
- Buka **Deployments** tab
- Tunggu sampai status menjadi ✅ **Ready**
- Seharusnya ~3-5 menit

---

## 🔗 Akses Aplikasi

Setelah deploy selesai:
```
https://telda-app.vercel.app
```

(atau sesuai nama project Anda di Vercel)

---

## 🆘 Troubleshooting

### ❌ Build Error
- Cek **Deployments** → Lihat log error
- Likely: Migrations perlu dirun manual

### ❌ Database Connection Error
- Verifikasi credentials Supabase
- Pastikan `DB_SSLMODE=require`
- Check Supabase status: https://status.supabase.com

### ❌ "Table doesn't exist"
- Jalankan migrations manual lokal:
  ```bash
  php artisan migrate --force
  ```
- Push lagi ke GitHub

---

## ✅ Selesai!

Aplikasi Anda sekarang **LIVE** di Vercel dengan database Supabase PostgreSQL! 🎉

**URL Aplikasi:** https://telda-app.vercel.app

Happy coding! 🚀
