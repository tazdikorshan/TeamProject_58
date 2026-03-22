$ErrorActionPreference = "Stop"

$serverHost = "cs2410-web01pvm.aston.ac.uk"
$serverUser = "cs2team58"
$targetDir = "/home/cs2team58/TeamProject_58"

Write-Host "Starting Local Deployment..." -ForegroundColor Cyan

Write-Host "Building Frontend Assets..." -ForegroundColor Yellow
npm run build

Write-Host "Zipping Application Files (This may take a minute)..." -ForegroundColor Yellow
if (Test-Path "deployment.zip") { Remove-Item "deployment.zip" -Force }
tar.exe -c -a -f deployment.zip --exclude=.git --exclude=node_modules --exclude=tests --exclude=deployment.zip --exclude=.env *

Write-Host "Uploading to Server (You will be prompted for your remote password: PorTlRNPJACYpo5s)..." -ForegroundColor Yellow
scp deployment.zip ${serverUser}@${serverHost}:/home/cs2team58/

Write-Host "Extracting and Configuring on Server (You will be prompted for your password again)..." -ForegroundColor Yellow

$remoteCommand1 = "mkdir -p $targetDir && unzip -o /home/cs2team58/deployment.zip -d $targetDir && rm /home/cs2team58/deployment.zip"
$remoteCommand2 = "cd $targetDir && chmod -R 775 storage bootstrap/cache"
$remoteCommand3 = "cd $targetDir && if [ -f .env ]; then php artisan optimize:clear && php artisan migrate --force && php artisan config:cache; else echo 'No .env file found!'; fi"

ssh ${serverUser}@${serverHost} "$remoteCommand1 && $remoteCommand2 && $remoteCommand3"

Write-Host "Deployment Complete!" -ForegroundColor Green
