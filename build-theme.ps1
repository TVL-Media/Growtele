# Build Growtele WordPress theme package for upload.
# Run from repo root: .\build-theme.ps1

$ErrorActionPreference = "Stop"
$root = $PSScriptRoot
$out  = Join-Path $root "wordpress-theme"

$required = @(
    "style.css",
    "functions.php",
    "inc/static-pages.php",
    "assets/js/smooth-scroll.js",
    "assets/js/animations.js",
    "assets/css/snap-scroll.css",
    "pages/retail/index.html",
    "pages/retail/css/style.css",
    "pages/sms/index.html",
    "pages/sms/js/main.js"
)

Write-Host "Building Growtele theme to $out"

if (Test-Path $out) {
    Remove-Item $out -Recurse -Force
}

$exclude = @(".git", "wordpress-theme", "node_modules", ".cursor")
Get-ChildItem $root -Force | Where-Object {
    $exclude -notcontains $_.Name
} | Copy-Item -Destination $out -Recurse -Force

foreach ($rel in $required) {
    $path = Join-Path $out $rel
    if (-not (Test-Path $path)) {
        throw "Missing required theme file: $rel"
    }
}

Write-Host "Theme package ready: $out"
Write-Host "Zip this folder and upload to wp-content/themes/growtele/"
