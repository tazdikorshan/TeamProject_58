

$serverHost = "cs2410-web01pvm.aston.ac.uk"
$serverUser = "cs2team58"
$targetDir = "/home/cs2team58/TeamProject_58"
$stagingDir = "$PSScriptRoot\deployment_staging"

Write-Host "Starting Local Deployment (No-Zip)..." -ForegroundColor Cyan

Write-Host "Building Frontend Assets..." -ForegroundColor Yellow
npm run build

Write-Host "Preparing Staging Directory..." -ForegroundColor Yellow
if (Test-Path $stagingDir) { Remove-Item $stagingDir -Recurse -Force }
New-Item -ItemType Directory -Path $stagingDir | Out-Null

$excludeList = @(
    "node_modules",
    "vendor",
    ".git",
    "tests",
    "deployment_staging",
    "deploy.ps1",
    ".env",
    ".env.example",
    "storage"
)

# Use simple copy in PowerShell for the root items
Get-ChildItem -Path $PSScriptRoot -Exclude $excludeList | Copy-Item -Destination $stagingDir -Recurse -Force

Write-Host "Uploading to Server (You will be prompted for your remote password: PorTlRNPJACYpo5s)..." -ForegroundColor Yellow
scp -o StrictHostKeyChecking=no -r $stagingDir ${serverUser}@${serverHost}:/home/cs2team58/

Write-Host "Extracting & Configuring on Server (You will be prompted for your password again)..." -ForegroundColor Yellow
$remoteCommands = @"
mkdir -p $targetDir
mkdir -p $targetDir/storage/app/public
mkdir -p $targetDir/storage/framework/cache/data
mkdir -p $targetDir/storage/framework/sessions
mkdir -p $targetDir/storage/framework/views
mkdir -p $targetDir/storage/logs
cp -r /home/cs2team58/deployment_staging/* $targetDir/
rm -rf /home/cs2team58/deployment_staging
cd $targetDir
chmod -R 775 storage bootstrap/cache
rm -rf /home/cs2team58/public_html
ln -sfn $targetDir/public /home/cs2team58/public_html
composer install --optimize-autoloader --no-dev
if [ -f .env ]; then
    php artisan optimize:clear
    php artisan migrate --force
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    echo "WARNING: No .env found on server! artisan commands might not work correctly."
fi
"@

ssh -o StrictHostKeyChecking=no ${serverUser}@${serverHost} $remoteCommands

Write-Host "Cleaning up local staging directory..." -ForegroundColor Yellow
if (Test-Path $stagingDir) { Remove-Item $stagingDir -Recurse -Force }

Write-Host "✅ Deployment Complete!" -ForegroundColor Green
