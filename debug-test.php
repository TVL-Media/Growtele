<?php
/**
 * Debug test file to identify WordPress critical error
 * Access this file directly: yoursite.com/wp-content/themes/growtele/debug-test.php
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>WordPress Theme Debug Test</h1>";
echo "<hr>";

// Test 1: PHP Version
echo "<h2>1. PHP Version</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Required: 7.4+<br>";
echo (version_compare(phpversion(), '7.4', '>=') ? "✓ PASS" : "✗ FAIL") . "<br>";
echo "<hr>";

// Test 2: Check if WordPress is loaded
echo "<h2>2. WordPress Environment</h2>";
if (defined('ABSPATH')) {
    echo "✓ WordPress is loaded<br>";
    echo "ABSPATH: " . ABSPATH . "<br>";
} else {
    echo "✗ WordPress NOT loaded (access through WordPress)<br>";
    echo "Attempting to load WordPress...<br>";
    
    // Try to load WordPress
    $wp_load = dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
    if (file_exists($wp_load)) {
        require_once($wp_load);
        echo "✓ WordPress loaded manually<br>";
    } else {
        die("✗ Cannot find wp-load.php");
    }
}
echo "<hr>";

// Test 3: Check theme directory
echo "<h2>3. Theme Directory</h2>";
$theme_dir = get_template_directory();
echo "Theme Directory: " . $theme_dir . "<br>";
echo (is_dir($theme_dir) ? "✓ PASS" : "✗ FAIL") . "<br>";
echo "<hr>";

// Test 4: Check required files
echo "<h2>4. Required Files</h2>";
$required_files = array(
    '/inc/theme-setup.php',
    '/inc/enqueue.php',
    '/inc/elementor.php',
    '/inc/customizer.php',
    '/inc/content/loader.php',
    '/inc/template-tags.php',
    '/inc/static-pages.php',
    '/inc/theme-activation.php',
);

foreach ($required_files as $file) {
    $path = $theme_dir . $file;
    $exists = file_exists($path);
    $readable = is_readable($path);
    echo "$file: ";
    if ($exists && $readable) {
        echo "✓ EXISTS & READABLE";
    } elseif ($exists) {
        echo "✗ EXISTS BUT NOT READABLE";
    } else {
        echo "✗ MISSING";
    }
    echo "<br>";
}
echo "<hr>";

// Test 5: Check content defaults
echo "<h2>5. Content Defaults Files</h2>";
$defaults = array('global', 'footer', 'shared', 'home', 'products', 'industries', 'company', 'media');
foreach ($defaults as $file) {
    $path = $theme_dir . '/inc/content/defaults/' . $file . '.php';
    echo "$file.php: " . (file_exists($path) ? "✓" : "✗ MISSING") . "<br>";
}
echo "<hr>";

// Test 6: Try loading functions.php
echo "<h2>6. Loading functions.php</h2>";
try {
    $functions_file = $theme_dir . '/functions.php';
    if (file_exists($functions_file)) {
        echo "Attempting to load functions.php...<br>";
        
        // Check for syntax errors
        $syntax_check = shell_exec('php -l ' . escapeshellarg($functions_file) . ' 2>&1');
        if (strpos($syntax_check, 'No syntax errors') !== false) {
            echo "✓ Syntax OK<br>";
        } else {
            echo "✗ Syntax Error:<br><pre>$syntax_check</pre>";
        }
        
        // Try to include it
        echo "Including functions.php...<br>";
        include_once($functions_file);
        echo "✓ functions.php loaded successfully<br>";
    } else {
        echo "✗ functions.php NOT FOUND<br>";
    }
} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "<br>";
}
echo "<hr>";

// Test 7: Check for function conflicts
echo "<h2>7. Function Definitions</h2>";
$functions_to_check = array(
    'growtele_theme_setup',
    'growtele_enqueue_assets',
    'growtele_content_get_defaults',
    'growtele_home_get_section',
    'growtele_get_content_media_url',
);

foreach ($functions_to_check as $func) {
    echo "$func: " . (function_exists($func) ? "✓ DEFINED" : "✗ NOT DEFINED") . "<br>";
}
echo "<hr>";

// Test 8: Memory limit
echo "<h2>8. PHP Memory</h2>";
echo "Memory Limit: " . ini_get('memory_limit') . "<br>";
echo "Memory Usage: " . round(memory_get_usage() / 1024 / 1024, 2) . " MB<br>";
echo "<hr>";

echo "<h2>✓ All Tests Complete</h2>";
echo "<p>If you see this page, the theme files are accessible. The critical error might be:</p>";
echo "<ul>";
echo "<li>A plugin conflict</li>";
echo "<li>Missing PHP extension</li>";
echo "<li>Server configuration issue</li>";
echo "<li>File permission problem</li>";
echo "</ul>";
echo "<p><strong>Next step:</strong> Check WordPress debug log at wp-content/debug.log</p>";
