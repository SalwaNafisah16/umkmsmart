#!/bin/bash
# =================================================
# SCRIPT DEPLOYMENT CHECK - FORUM UMKM
# Jalankan di server: bash deploy-check.sh
# =================================================

echo "========================================"
echo " DEPLOYMENT CHECK SCRIPT"
echo " Forum UMKM - Laravel Project"
echo "========================================"
echo ""

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# =====================
# 0. COPY ENV PRODUCTION
# =====================
echo "🔍 [0/10] Copying .env.production to .env..."
if [ -f ".env.production" ]; then
    cp .env.production .env
    echo -e "  ${GREEN}✓${NC} .env copied from .env.production"
else
    echo -e "  ${RED}✗${NC} .env.production NOT FOUND!"
fi
echo ""

# =====================
# 1. CHECK PHP VERSION
# =====================
echo "🔍 [1/10] Checking PHP Version..."
php -v | head -n 1
echo ""

# =====================
# 2. CHECK FOLDER PERMISSIONS
# =====================
echo "🔍 [2/10] Checking Folder Permissions..."

FOLDERS=("storage" "storage/app" "storage/app/public" "storage/framework" "storage/framework/cache" "storage/framework/cache/data" "storage/framework/sessions" "storage/framework/views" "storage/logs" "bootstrap/cache")

for folder in "${FOLDERS[@]}"; do
    if [ -d "$folder" ]; then
        chmod -R 775 "$folder" 2>/dev/null
        echo -e "  ${GREEN}✓${NC} $folder (775)"
    else
        mkdir -p "$folder"
        chmod -R 775 "$folder"
        echo -e "  ${YELLOW}+ Created${NC} $folder"
    fi
done
echo ""

# =====================
# 3. CHECK .ENV FILE
# =====================
echo "🔍 [3/10] Checking .env file..."
if [ -f ".env" ]; then
    echo -e "  ${GREEN}✓${NC} .env exists"
    
    # Check critical values
    if grep -q "APP_KEY=base64:" .env; then
        echo -e "  ${GREEN}✓${NC} APP_KEY is set"
    else
        echo -e "  ${RED}✗${NC} APP_KEY is MISSING!"
        echo "    Run: php artisan key:generate"
    fi
    
    if grep -q "SESSION_DRIVER=file" .env; then
        echo -e "  ${GREEN}✓${NC} SESSION_DRIVER=file"
    else
        echo -e "  ${RED}!${NC} SESSION_DRIVER should be 'file' for shared hosting"
    fi
    
    if grep -q "CACHE_STORE=file" .env; then
        echo -e "  ${GREEN}✓${NC} CACHE_STORE=file"
    else
        echo -e "  ${RED}!${NC} CACHE_STORE should be 'file' for shared hosting"
    fi

    if grep -q "QUEUE_CONNECTION=sync" .env; then
        echo -e "  ${GREEN}✓${NC} QUEUE_CONNECTION=sync"
    else
        echo -e "  ${RED}!${NC} QUEUE_CONNECTION should be 'sync' for shared hosting"
    fi

    if grep -q "SESSION_DOMAIN=umkmsmart" .env; then
        echo -e "  ${GREEN}✓${NC} SESSION_DOMAIN is set correctly"
    else
        echo -e "  ${YELLOW}!${NC} SESSION_DOMAIN may need to be set"
    fi
else
    echo -e "  ${RED}✗${NC} .env file NOT FOUND!"
    echo "    Copy from .env.production"
fi
echo ""

# =====================
# 4. CHECK STORAGE LINK
# =====================
echo "🔍 [4/10] Checking storage link..."
if [ -L "public/storage" ]; then
    echo -e "  ${GREEN}✓${NC} Storage link exists"
else
    echo -e "  ${YELLOW}!${NC} Creating storage link..."
    php artisan storage:link
fi
echo ""

# =====================
# 5. CLEAR ALL CACHES
# =====================
echo "🔍 [5/10] Clearing all caches..."
php artisan config:clear 2>/dev/null
php artisan cache:clear 2>/dev/null
php artisan view:clear 2>/dev/null
php artisan route:clear 2>/dev/null
echo -e "  ${GREEN}✓${NC} All caches cleared"
echo ""

# =====================
# 6. CHECK DATABASE CONNECTION
# =====================
echo "🔍 [6/10] Testing database connection..."
php -r "
try {
    \$pdo = new PDO(
        'mysql:host=localhost;dbname=sistem18_umkmsmart',
        'sistem18_umkmsmart',
        'gJaMX(qmcSr4-Myq'
    );
    echo '  ✓ Database connection OK\n';
} catch (Exception \$e) {
    echo '  ✗ Database error: ' . \$e->getMessage() . '\n';
}
" 2>/dev/null || echo -e "  ${YELLOW}!${NC} Could not verify database connection"
echo ""

# =====================
# 7. CACHE FOR PRODUCTION
# =====================
echo "🔍 [7/10] Building production cache..."
php artisan config:cache 2>/dev/null
php artisan route:cache 2>/dev/null
php artisan view:cache 2>/dev/null
echo -e "  ${GREEN}✓${NC} Production cache built"
echo ""

# =====================
# 8. CHECK LOGS FOLDER
# =====================
echo "🔍 [8/10] Checking log files..."
if [ -f "storage/logs/laravel.log" ]; then
    # Clear old logs
    > storage/logs/laravel.log
    echo -e "  ${GREEN}✓${NC} Laravel log cleared"
else
    touch storage/logs/laravel.log
    chmod 664 storage/logs/laravel.log
    echo -e "  ${GREEN}✓${NC} Laravel log created"
fi
echo ""

# =====================
# 9. CHECK SESSIONS FOLDER
# =====================
echo "🔍 [9/10] Checking sessions folder..."
if [ -d "storage/framework/sessions" ]; then
    find storage/framework/sessions -type f -name "*" -mtime +7 -delete 2>/dev/null
    echo -e "  ${GREEN}✓${NC} Old sessions cleaned"
else
    mkdir -p storage/framework/sessions
    chmod 775 storage/framework/sessions
    echo -e "  ${GREEN}✓${NC} Sessions folder created"
fi
echo ""

# =====================
# 10. FINAL STATUS
# =====================
echo "🔍 [10/10] Final check..."
echo ""

php artisan --version 2>/dev/null || echo "Laravel version check failed"
echo ""
echo "========================================"
echo " DEPLOYMENT CHECK COMPLETE!"
echo "========================================"
echo ""
echo "PENTING! Pastikan di .env:"
echo "  SESSION_DRIVER=file"
echo "  CACHE_STORE=file"
echo "  QUEUE_CONNECTION=sync"
echo "  SESSION_DOMAIN=umkmsmart.sisteminformasikotacerdas.id"
echo ""
echo "Jika masih ada error:"
echo "1. Enable debug: nano .env -> APP_DEBUG=true"
echo "2. Clear cache: php artisan config:clear"
echo "3. Cek log: tail -100 storage/logs/laravel.log"
echo ""
