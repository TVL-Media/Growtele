# Creates a clean Growtele deploy zip (excludes old zips, temp folders, dev junk).
# Usage: powershell -ExecutionPolicy Bypass -File scripts/create-deploy-zip.ps1

$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent (Split-Path -Parent $MyInvocation.MyCommand.Path)
$stamp = Get-Date -Format 'yyyyMMdd-HHmm'
$outDir = Join-Path $root 'dist'
$outZip = Join-Path $outDir "growtele-deploy-$stamp.zip"

New-Item -ItemType Directory -Force -Path $outDir | Out-Null

$excludeDirNames = @('.git', '.cursor', 'node_modules', 'dist', '.tmp-contact-loc', '.tmp-health-cards', '.tmp-loc-imgs')
$excludeFilePatterns = @('*.zip')

$files = Get-ChildItem -Path $root -Recurse -File -ErrorAction SilentlyContinue | Where-Object {
    $rel = $_.FullName.Substring($root.Length + 1)
    $parts = $rel -split '[\\/]'
    if ($parts | Where-Object { $excludeDirNames -contains $_ }) { return $false }
    foreach ($pat in $excludeFilePatterns) {
        if ($_.Name -like $pat) { return $false }
    }
    return $true
}

if (-not $files -or $files.Count -eq 0) {
    Write-Error 'No files found to zip.'
}

$totalMb = [math]::Round(($files | Measure-Object Length -Sum).Sum / 1MB, 2)
Write-Host "Files to pack: $($files.Count) ($totalMb MB uncompressed)"

if ($totalMb -gt 64) {
    Write-Warning @"
Zip is about $totalMb MB. WordPress theme upload usually allows 2-64 MB.
Do NOT upload via Appearance > Themes > Upload. Use FTP/SFTP or cPanel File Manager instead.
"@
}

if (Test-Path $outZip) { Remove-Item $outZip -Force }

# Stage into temp folder so zip root is the theme folder, not nested paths.
$stage = Join-Path $env:TEMP "growtele-deploy-$stamp"
if (Test-Path $stage) { Remove-Item $stage -Recurse -Force }
New-Item -ItemType Directory -Force -Path $stage | Out-Null

foreach ($file in $files) {
    $rel = $file.FullName.Substring($root.Length + 1)
    $target = Join-Path $stage $rel
    $targetDir = Split-Path $target -Parent
    if (-not (Test-Path $targetDir)) {
        New-Item -ItemType Directory -Force -Path $targetDir | Out-Null
    }
    Copy-Item -Path $file.FullName -Destination $target -Force
}

Compress-Archive -Path (Join-Path $stage '*') -DestinationPath $outZip -CompressionLevel Optimal
Remove-Item $stage -Recurse -Force

$zipMb = [math]::Round((Get-Item $outZip).Length / 1MB, 2)
Write-Host "Created: $outZip ($zipMb MB compressed)"
Write-Host 'Upload via FTP to wp-content/themes/growtele (extract there), not WP zip uploader.'
