# Creates a WordPress-installable theme zip.
# Entry paths use forward slashes so Linux/cPanel unzip finds growtele/style.css.
# Usage: powershell -ExecutionPolicy Bypass -File scripts/create-theme-install-zip.ps1

$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent (Split-Path -Parent $MyInvocation.MyCommand.Path)
$stamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$desktop = [Environment]::GetFolderPath('Desktop')
$outZip = Join-Path $desktop "growtele-PRODUCTION-$stamp.zip"

$excludeDirNames = @(
    '.git', '.cursor', 'node_modules', 'dist', 'wordpress-theme',
    '.tmp-contact-loc', '.tmp-health-cards', '.tmp-loc-imgs', 'agent-transcripts'
)
$excludeFileNames = @(
    'debug-test.php',
    'functions-current.php',
    'functions-minimal.php',
    'functions-original-backup.php',
    'functions-safe.php',
    'functions.php.backup'
)

$files = Get-ChildItem -Path $root -Recurse -File -Force -ErrorAction SilentlyContinue | Where-Object {
    $rel = $_.FullName.Substring($root.Length).TrimStart('\', '/')
    $parts = $rel -split '[\\/]'
    if ($parts | Where-Object { $excludeDirNames -contains $_ }) { return $false }
    if ($excludeFileNames -contains $_.Name) { return $false }
    if ($_.Name -like '*.zip') { return $false }
    if ($_.Name -like '.tmp-*') { return $false }
    return $true
}

$styleFile = $files | Where-Object { $_.FullName.Substring($root.Length).TrimStart('\', '/') -replace '\\','/' -eq 'style.css' }
if (-not $styleFile) {
    throw 'style.css not found in theme root'
}

Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

if (Test-Path $outZip) { Remove-Item $outZip -Force }

$zipStream = [System.IO.File]::Open($outZip, [System.IO.FileMode]::Create)
try {
    $archive = New-Object System.IO.Compression.ZipArchive($zipStream, [System.IO.Compression.ZipArchiveMode]::Create)
    try {
        foreach ($file in $files) {
            $rel = $file.FullName.Substring($root.Length).TrimStart('\', '/').Replace('\', '/')
            $entryName = 'growtele/' + $rel
            [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile(
                $archive,
                $file.FullName,
                $entryName,
                [System.IO.Compression.CompressionLevel]::Fastest
            ) | Out-Null
        }
    } finally {
        $archive.Dispose()
    }
} finally {
    $zipStream.Dispose()
}

$zipMb = [math]::Round((Get-Item $outZip).Length / 1MB, 2)
Write-Host "Created: $outZip"
Write-Host "Size: $zipMb MB"
Write-Host 'First entries:'
$z = [System.IO.Compression.ZipFile]::OpenRead($outZip)
$z.Entries | Where-Object { $_.FullName -eq 'growtele/style.css' -or $_.FullName -eq 'growtele/functions.php' } | ForEach-Object { Write-Host ('  ' + $_.FullName) }
$z.Dispose()
