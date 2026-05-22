#!/bin/bash
# Script untuk setup PlanetScale + Vercel Deployment
# Usage: bash setup-planetscale.sh

echo "================================"
echo "🚀 PlanetScale + Vercel Setup"
echo "================================"
echo ""

# Step 1: Get DATABASE_URL
echo "📌 Step 1: Siapkan CONNECTION STRING dari PlanetScale"
echo ""
read -p "Masukkan DATABASE_URL dari PlanetScale: " DATABASE_URL

# Validate URL format
if [[ ! $DATABASE_URL =~ ^mysql:// ]]; then
    echo "❌ Format DATABASE_URL tidak valid!"
    echo "Format yang benar: mysql://username:password@pscale_xxx.mysql.planetscale.com/database_name?sslaccept=strict"
    exit 1
fi

echo "✅ DATABASE_URL tervalidasi"
echo ""

# Step 2: Test connection
echo "📌 Step 2: Testing koneksi..."
echo ""

DATABASE_URL=$DATABASE_URL php artisan tinker << 'EOF'
try {
    DB::connection()->getPdo();
    echo "✅ Koneksi PlanetScale BERHASIL!\n";
} catch (Exception $e) {
    echo "❌ Error koneksi: " . $e->getMessage() . "\n";
}
exit();
EOF

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

# Step 4: Save to .env
echo "📌 Step 4: Simpan ke .env.production..."
echo ""

cat > .env.production << EOF
APP_NAME=Telda
APP_ENV=production
APP_DEBUG=false
APP_KEY=$(php artisan key:generate --show 2>/dev/null || echo "base64:XXX")
APP_URL=https://your-app.vercel.app

DATABASE_URL=$DATABASE_URL
DB_SSL_MODE=REQUIRED

SESSION_DRIVER=database
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr

MAIL_MAILER=log
EOF

echo "✅ .env.production sudah disimpan"
echo ""

# Step 5: Git commit
echo "📌 Step 5: Push ke GitHub..."
echo ""

read -p "Commit dan push ke GitHub sekarang? (y/n): " -n 1 -r
echo

if [[ $REPLY =~ ^[Yy]$ ]]; then
    git add .
    git commit -m "Setup PlanetScale database untuk Vercel"
    git push
    echo "✅ Push ke GitHub berhasil!"
else
    echo "⏭️ Lakukan manual push:"
    echo "  git add ."
    echo "  git commit -m 'Setup PlanetScale database untuk Vercel'"
    echo "  git push"
fi

echo ""
echo "================================"
echo "✨ Setup selesai!"
echo "================================"
echo ""
echo "📝 Langkah berikutnya:"
echo "1. Buka Vercel Dashboard"
echo "2. Add Environment Variable DATABASE_URL dengan nilai dari PlanetScale"
echo "3. Vercel akan otomatis deploy"
echo "4. Akses aplikasi di: https://your-project.vercel.app"
echo ""
