$ErrorActionPreference = 'Stop'
Add-Type -AssemblyName System.IO.Compression.FileSystem
$path = $args[0]
if (-not $path) {
    $path = Get-ChildItem (Join-Path ([Environment]::GetFolderPath('Desktop')) 'growtele-PRODUCTION-*.zip') |
        Sort-Object LastWriteTime -Descending |
        Select-Object -First 1 -ExpandProperty FullName
}
$z = [IO.Compression.ZipFile]::OpenRead($path)
$js = $z.Entries | Where-Object { $_.FullName -eq 'growtele/pages/shared/js/journey-card-stack.js' }
if (-not $js) { throw 'journey-card-stack.js missing in zip' }
$sr = New-Object IO.StreamReader($js.Open())
$c = $sr.ReadToEnd()
$sr.Close()
foreach ($m in @('clampMobScrollDelta', 'MOB_SCROLL_DELTA_CAP', 'syncMobStackTouchCapture')) {
    if ($c.Contains($m)) { Write-Host "OK $m" } else { throw "MISSING $m" }
}
$email = $z.Entries | Where-Object { $_.FullName -eq 'growtele/pages/email/index.html' }
$sr2 = New-Object IO.StreamReader($email.Open())
$h = $sr2.ReadToEnd()
$sr2.Close()
$z.Dispose()
if ($h -notmatch 'journey-stack-106') { throw 'MISSING journey-stack-106 in email index' }
Write-Host 'OK journey-stack-106 in email index'
if (-not $c.Contains('mobAndroidStable')) { throw 'MISSING mobAndroidStable in journey JS' }
Write-Host 'OK mobAndroidStable'
$mobCss = $z.Entries | Where-Object { $_.FullName -eq 'growtele/pages/shared/css/mobile-product.css' }
$sr3 = New-Object IO.StreamReader($mobCss.Open())
$mc = $sr3.ReadToEnd()
$sr3.Close()
if ($mc -notmatch 'journey--mob-pinned.*journey__phone') { throw 'MISSING android shake CSS in mobile-product.css' }
Write-Host 'OK mobile-product pinned phone CSS'
Write-Host "Verified: $path"
