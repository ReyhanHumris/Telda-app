# Script untuk setup Supabase + Vercel Deployment
# Usage: powershell -ExecutionPolicy Bypass -File setup-supabase.ps1

Clear-Host
Write-Host ""
Write-Host "================================" -ForegroundColor Cyan
Write-Host "Supabase + Vercel Setup (FREE)" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

# Step 1
Write-Host "Step 1: Siapkan CONNECTION STRING dari Supabase" -ForegroundColor Yellow
Write-Host ""
Write-Host "Buka https://app.supabase.com"
Write-Host "1. Settings -> Database -> Connection string"
Write-Host "2. Pilih URI format"
Write-Host ""

$DB_HOST = Read-Host "DB_HOST"
$DB_USERNAME = Read-Host "DB_USERNAME (tekan Enter untuk postgres)"
if ([string]::IsNullOrEmpty($DB_USERNAME)) { $DB_USERNAME = "postgres" }
$DB_PASSWORD = Read-Host "DB_PASSWORD"

if (-not $DB_HOST -or -not $DB_PASSWORD) {
    Write-Host "Input tidak lengkap!" -ForegroundColor Red
    exit 1
}

Write-Host "OK" -ForegroundColor Green
Write-Host ""

# Step 2 - Create temp PHP file for testing
Write-Host "Step 2: Test koneksi..." -ForegroundColor Yellow

$phpTestFile = "test-db-connection.php"
$phpCode = @"
<?php
`$host = '$DB_HOST';
`$user = '$DB_USERNAME';
`$pass = '$DB_PASSWORD';

try {
    `$pdo = new PDO(
        "pgsql:host=`$host;port=5432;dbname=postgres;sslmode=require",
        `$user,
        `$pass,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    echo "OK";
    `$pdo = null;
} catch (Exception `$e) {
    echo "ERROR: " . `$e->getMessage();
    exit(1);
}
?>
"@

Set-Content -Path $phpTestFile -Value $phpCode
$result = php $phpTestFile 2>$null
Remove-Item $phpTestFile -Force

if ($result -ne "OK") {
    Write-Host "Koneksi GAGAL!" -ForegroundColor Red
    Write-Host "Error: $result" -ForegroundColor Red
    exit 1
}

Write-Host "Koneksi OK" -ForegroundColor Green
Write-Host ""

# Step 3
Write-Host "Step 3: Menjalankan migrations..." -ForegroundColor Yellow

$runMigration = Read-Host "Jalankan? (Y/n)"
if ($runMigration -eq "" -or $runMigration.ToUpper() -eq "Y") {
    php artisan migrate --force
}

Write-Host ""

# Step 4
Write-Host "Step 4: Buat .env.production..." -ForegroundColor Yellow

$appKey = (php artisan key:generate --show 2>$null).Trim()

$envText = "APP_NAME=Telda
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

MAIL_MAILER=log"

Set-Content -Path ".env.production" -Value $envText
Write-Host "OK" -ForegroundColor Green
Write-Host ""

# Step 5
Write-Host "Step 5: Push ke GitHub..." -ForegroundColor Yellow

$doPush = Read-Host "Push? (Y/n)"
if ($doPush -eq "" -or $doPush.ToUpper() -eq "Y") {
    git add .
    git commit -m "Setup Supabase untuk Vercel"
    git push
    Write-Host "OK" -ForegroundColor Green
}

Write-Host ""
Write-Host "================================" -ForegroundColor Green
Write-Host "SELESAI!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green
Write-Host ""
Write-Host "NEXT:" -ForegroundColor Cyan
Write-Host "1. Vercel Dashboard -> Project -> Settings"
Write-Host "2. Environment Variables"
Write-Host "3. Add:"
Write-Host ""
Write-Host "  DB_CONNECTION = pgsql"
Write-Host "  DB_HOST = $DB_HOST"
Write-Host "  DB_PORT = 5432"
Write-Host "  DB_DATABASE = postgres"
Write-Host "  DB_USERNAME = $DB_USERNAME"
Write-Host "  DB_PASSWORD = (password Supabase)"
Write-Host "  DB_SSLMODE = require"
Write-Host ""
Write-Host "4. Save -> Vercel deploy otomatis"
Write-Host "5. Aplikasi live!"
Write-Host ""
