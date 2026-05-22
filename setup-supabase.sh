#!/bin/bash
# Script untuk setup Supabase + Vercel Deployment
# Usage: bash setup-supabase.sh

echo "================================"
echo "🚀 Supabase + Vercel Setup (FREE)"
echo "================================"
echo ""

# Step 1: Get DATABASE Details
echo "📌 Step 1: Siapkan CONNECTION STRING dari Supabase"
echo ""
echo "Cara mendapatkan:"
echo "1. Buka https://app.supabase.com"
echo "2. Pilih project Anda → Settings → Database → Connection string"
echo "3. Pilih 'URI' format"
echo ""

read -p "Masukkan DB_HOST (db.xxxxx.supabase.co): " DB_HOST
read -p "Masukkan DB_USERNAME (default: postgres): " DB_USERNAME
DB_USERNAME=${DB_USERNAME:-postgres}
read -sp "Masukkan DB_PASSWORD: " DB_PASSWORD
echo ""

# Validate
if [[ -z "$DB_HOST" ]] || [[ -z "$DB_PASSWORD" ]]; then
    echo "❌ Input tidak lengkap!"
    exit 1
fi

echo "✅ Connection details tervalidasi"
echo ""

# Step 2: Test connection
echo "📌 Step 2: Testing koneksi ke Supabase..."
echo ""

# Create .env.test temporarily
cat > .env.test << EOF
DB_CONNECTION=pgsql
DB_HOST=$DB_HOST
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=$DB_USERNAME
DB_PASSWORD=$DB_PASSWORD
DB_SSLMODE=require
EOF

php artisan tinker << 'TINKER'
try {
    DB::connection('pgsql')->getPdo();
    echo "✅ Koneksi Supabase BERHASIL!\n";
} catch (Exception $e) {
    echo "❌ Error koneksi: " . $e->getMessage() . "\n";
}
exit();
TINKER

echo ""

# Step 3: Run migrations
echo "📌 Step 3: Menjalankan migrations..."
echo ""

read -p "Jalankan migrations sekarang? (y/n): " -n 1 -r
echo

if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    echo "✅ Migrations selesai!"
else
    echo "⏭️ Migrations di-skip. Jalankan nanti dengan: php artisan migrate --force"
fi

echo ""

# Step 4: Update .env
echo "📌 Step 4: Update .env.production..."
echo ""

APP_KEY=$(php artisan key:generate --show 2>/dev/null || echo "base64:XXX")

cat > .env.production << EOF
APP_NAME=Telda
APP_ENV=production
APP_DEBUG=false
APP_KEY=$APP_KEY
APP_URL=https://your-app.vercel.app

DB_CONNECTION=pgsql
DB_HOST=$DB_HOST
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=$DB_USERNAME
DB_PASSWORD=$DB_PASSWORD
DB_SSLMODE=require

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr

MAIL_MAILER=log
EOF

echo "✅ .env.production sudah diupdate"
echo ""

# Step 5: Git commit
echo "📌 Step 5: Push ke GitHub..."
echo ""

read -p "Commit dan push ke GitHub sekarang? (y/n): " -n 1 -r
echo

if [[ $REPLY =~ ^[Yy]$ ]]; then
    git add .
    git commit -m "Setup Supabase PostgreSQL untuk Vercel"
    git push
    echo "✅ Push ke GitHub berhasil!"
else
    echo "⏭️ Lakukan manual push:"
    echo "  git add ."
    echo "  git commit -m 'Setup Supabase PostgreSQL untuk Vercel'"
    echo "  git push"
fi

# Cleanup
rm -f .env.test

echo ""
echo "================================"
echo "✨ Setup selesai!"
echo "================================"
echo ""
echo "📝 Langkah berikutnya:"
echo "1. Buka Vercel Dashboard"
echo "2. Add Environment Variables:"
echo "   - DB_CONNECTION = pgsql"
echo "   - DB_HOST = $DB_HOST"
echo "   - DB_USERNAME = $DB_USERNAME"
echo "   - DB_PASSWORD = (dari Supabase)"
echo "3. Vercel akan otomatis deploy"
echo "4. Akses aplikasi di: https://your-project.vercel.app"
echo ""
