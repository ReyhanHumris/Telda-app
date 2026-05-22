@echo off
REM Script untuk setup PlanetScale + Vercel Deployment (Windows PowerShell)
REM Usage: powershell -ExecutionPolicy Bypass -File setup-planetscale.ps1

Write-Host "================================" -ForegroundColor Cyan
Write-Host "🚀 PlanetScale + Vercel Setup" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

# Step 1: Get DATABASE_URL
Write-Host "📌 Step 1: Siapkan CONNECTION STRING dari PlanetScale" -ForegroundColor Yellow
Write-Host ""
$DATABASE_URL = Read-Host "Masukkan DATABASE_URL dari PlanetScale"

# Validate URL format
if ($DATABASE_URL -notmatch '^mysql://') {
    Write-Host "❌ Format DATABASE_URL tidak valid!" -ForegroundColor Red
    Write-Host "Format yang benar: mysql://username:password@pscale_xxx.mysql.planetscale.com/database_name?sslaccept=strict"
    exit 1
}

Write-Host "✅ DATABASE_URL tervalidasi" -ForegroundColor Green
Write-Host ""

# Step 2: Test connection
Write-Host "📌 Step 2: Testing koneksi..." -ForegroundColor Yellow
Write-Host ""

$env:DATABASE_URL = $DATABASE_URL
php artisan tinker 2>&1 << 'EOF'
try {
    DB::connection()->getPdo();
    echo "✅ Koneksi PlanetScale BERHASIL!\n";
} catch (Exception $e) {
    echo "❌ Error koneksi: " . $e->getMessage() . "\n";
}
exit();
EOF

Write-Host ""

# Step 3: Run migrations
Write-Host "📌 Step 3: Menjalankan migrations..." -ForegroundColor Yellow
Write-Host ""

$confirmMigration = Read-Host "Jalankan migrations sekarang? (Y/n)"

if ($confirmMigration -eq "Y" -or $confirmMigration -eq "y" -or $confirmMigration -eq "") {
    php artisan migrate --force
    Write-Host "✅ Migrations selesai!" -ForegroundColor Green
} else {
    Write-Host "⏭️ Migrations di-skip. Jalankan nanti dengan: php artisan migrate --force"
}

Write-Host ""

# Step 4: Save to .env
Write-Host "📌 Step 4: Simpan ke .env.production..." -ForegroundColor Yellow
Write-Host ""

$appKey = (php artisan key:generate --show 2>$null) || "base64:XXX"

@"
APP_NAME=Telda
APP_ENV=production
APP_DEBUG=false
APP_KEY=$appKey
APP_URL=https://your-app.vercel.app

DATABASE_URL=$DATABASE_URL
DB_SSL_MODE=REQUIRED

SESSION_DRIVER=database
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr

MAIL_MAILER=log
"@ | Set-Content -Path ".env.production"

Write-Host "✅ .env.production sudah disimpan" -ForegroundColor Green
Write-Host ""

# Step 5: Git commit
Write-Host "📌 Step 5: Push ke GitHub..." -ForegroundColor Yellow
Write-Host ""

$confirmGit = Read-Host "Commit dan push ke GitHub sekarang? (Y/n)"

if ($confirmGit -eq "Y" -or $confirmGit -eq "y" -or $confirmGit -eq "") {
    git add .
    git commit -m "Setup PlanetScale database untuk Vercel"
    git push
    Write-Host "✅ Push ke GitHub berhasil!" -ForegroundColor Green
} else {
    Write-Host "⏭️ Lakukan manual push:" -ForegroundColor Yellow
    Write-Host "  git add ."
    Write-Host "  git commit -m 'Setup PlanetScale database untuk Vercel'"
    Write-Host "  git push"
}

Write-Host ""
Write-Host "================================" -ForegroundColor Green
Write-Host "✨ Setup selesai!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green
Write-Host ""
Write-Host "📝 Langkah berikutnya:" -ForegroundColor Cyan
Write-Host "1. Buka Vercel Dashboard"
Write-Host "2. Add Environment Variable DATABASE_URL dengan nilai dari PlanetScale"
Write-Host "3. Vercel akan otomatis deploy"
Write-Host "4. Akses aplikasi di: https://your-project.vercel.app"
Write-Host ""
