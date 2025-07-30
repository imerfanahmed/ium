<?php
/**
 * App finder utility for IUM development environment
 * This script helps route requests to the correct PHP version based on app location
 * Automatically detects Laravel/framework public directories
 */

$app = $_GET['app'] ?? '';
$path = $_GET['path'] ?? '';

if (empty($app)) {
    http_response_code(404);
    echo "App not specified";
    exit;
}

// Define possible PHP versions in order of preference
$phpVersions = ['php74', 'php84'];
$foundPath = null;
$hasPublicDir = false;

// Search for the app in different PHP version directories
foreach ($phpVersions as $version) {
    $appPath = "/var/www/html/$version/$app";
    if (is_dir($appPath)) {
        $foundPath = "/$version/$app";
        
        // Check if app has a public directory (Laravel pattern)
        $publicPath = "$appPath/public";
        if (is_dir($publicPath)) {
            $foundPath = "/$version/$app/public";
            $hasPublicDir = true;
        }
        break;
    }
}

if (!$foundPath) {
    http_response_code(404);
    echo "Application '$app' not found in any PHP version directory";
    exit;
}

// Redirect to the correct path
$redirectUrl = $foundPath . ($path ? "/$path" : '');

// For Laravel apps, handle special routing
if ($hasPublicDir && !empty($path)) {
    // Don't add extra path for direct file access in public directory
    $redirectUrl = $foundPath . "/$path";
}

header("Location: $redirectUrl", true, 302);
exit;
?>
