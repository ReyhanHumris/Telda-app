# Script untuk setup Supabase + Vercel Deployment
# Usage: powershell -ExecutionPolicy Bypass -File setup-supabase.ps1

Write-Host ""
Write-Host "================================" -ForegroundColor Cyan
Write-Host "🚀 Supabase + Vercel Setup (FREE)" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "📌 Step 1: Siapkan CONNECTION STRING dari Supabase" -ForegroundColor Yellow
Write-Host ""
Write-Host "Cara mendapatkan:" -ForegroundColor Gray
Write-Host "1. Buka https://app.supabase.com"
Write-Host "2. Pilih project Anda → Settings → Database"
Write-Host "3. Lihat 'Connection string' - pilih 'URI' format"
Write-Host ""

$DB_HOST = Read-Host "Masukkan DB_HOST (contoh: db.xxxxx.supabase.co)"
$DB_USERNAME = Read-Host "Masukkan DB_USERNAME (tekan Enter = postgres)"
if ([string]::IsNullOrEmpty($DB_USERNAME)) { $DB_USERNAME = "postgres" }
$DB_PASSWORD = Read-Host "Masukkan DB_PASSWORD"

if (-not $DB_HOST -or -not $DB_PASSWORD) {
    Write-Host "❌ Input tidak lengkap!" -ForegroundColor Red
    exit 1
}

Write-Host "✅ Connection details OK" -ForegroundColor Green
Write-Host ""

Write-Host "📌 Step 2: Testing koneksi..." -ForegroundColor Yellow

$phpTest = @"
`$host = '$DB_HOST';
`$user = '$DB_USERNAME';
`$pass = '$DB_PASSWORD';
`$db = 'postgres';

try {
    `$pdo = new PDO(
        "pgsql:host=`$host;port=5432;dbname=`$db;sslmode=require",
        `$user,
        `$pass
    );
    echo "✅ Koneksi Supabase BERHASIL!\n";
    `$pdo = null;
} catch (Exception `$e) {
    echo "❌ Error: " . `$e->getMessage() . "\n";
    exit(1);
}
"@

php -r $phpTest
if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠️ Connection failed! Check credentials." -ForegroundColor Red
    exit 1
}

Write-Host ""

Write-Host "📌 Step 3: Menjalankan migrations..." -ForegroundColor Yellow

$migrate = Read-Host "Jalankan migrations? (Y/n)"
if ($migrate -eq "" -or $migrate -eq "Y" -or $migrate -eq "y") {
    php artisan migrate --force
    Write-Host "✅ Migrations done!" -ForegroundColor Green
}

Write-Host ""
Write-Host "📌 Step 4: Membuat .env.production..." -ForegroundColor Yellow

$appKey = (php artisan key:generate --show 2>$null).Trim()
if ($LASTEXITCODE -ne 0) {
    $appKey = "base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
}

$envContent = @"
APP_NAME=Telda
APP_ENV=production
APP_DEBUG=false
APP_KEY=$appKey
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
"@

Set-Content -Path ".env.production" -Value $envContent
Write-Host "✅ .env.production created!" -ForegroundColor Green
Write-Host ""

Write-Host "📌 Step 5: Push ke GitHub..." -ForegroundColor Yellow
$gitPush = Read-Host "Commit & push? (Y/n)"
if ($gitPush -eq "" -or $gitPush -eq "Y" -or $gitPush -eq "y") {
    git add .
    git commit -m "Setup Supabase untuk Vercel"
    git push
    Write-Host "✅ GitHub push OK!" -ForegroundColor Green
}

Write-Host ""
Write-Host "================================" -ForegroundColor Green
Write-Host "✨ Setup Selesai!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green
Write-Host ""
Write-Host "📝 NEXT STEPS:" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Buka Vercel Dashboard → Project → Settings"
Write-Host "2. Klik 'Environment Variables'"
Write-Host "3. Add variables (copy dari output di bawah):"
Write-Host ""
Write-Host "   DB_CONNECTION = pgsql" -ForegroundColor Gray
Write-Host "   DB_HOST = $DB_HOST" -ForegroundColor Gray
Write-Host "   DB_PORT = 5432" -ForegroundColor Gray
Write-Host "   DB_DATABASE = postgres" -ForegroundColor Gray
Write-Host "   DB_USERNAME = $DB_USERNAME" -ForegroundColor Gray
Write-Host "   DB_PASSWORD = (password dari Supabase)" -ForegroundColor Gray
Write-Host "   DB_SSLMODE = require" -ForegroundColor Gray
Write-Host ""
Write-Host "4. Save & Deploy"
Write-Host "5. Aplikasi live di: https://your-project.vercel.app"
Write-Host ""
