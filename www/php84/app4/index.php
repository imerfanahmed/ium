<?php
// Sample PHP 8.4 application - app4
echo "<h1>Welcome to App4 (PHP 8.4)</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Server: " . $_SERVER['HTTP_HOST'] . "</p>";
echo "<p>Application: Modern PHP App</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";

// Test modern PHP features
echo "<h2>Modern PHP Features</h2>";

// Named arguments (PHP 8.0+)
function createUser(string $name, string $email, bool $active = true): array {
    return [
        'name' => $name,
        'email' => $email,
        'active' => $active,
        'created' => date('Y-m-d H:i:s')
    ];
}

$user = createUser(name: 'Jane Doe', email: 'jane@example.com', active: true);
echo "<p>Named Arguments: " . json_encode($user) . "</p>";

// Attributes (PHP 8.0+)
#[Deprecated("Use newMethod() instead")]
function oldMethod(): string {
    return "This is deprecated";
}

echo "<p>Attributes: Method marked as deprecated</p>";

// Database connection test
try {
    $pdo = new PDO('mysql:host=mariadb;dbname=ium_default', 'ium_user', 'ium_password');
    echo "<p style='color: green;'>✓ Database connection successful</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "<h2>Services Available</h2>";
echo "<ul>";
echo "<li><a href='http://localhost:8080' target='_blank'>phpMyAdmin</a></li>";
echo "<li><a href='http://localhost:8025' target='_blank'>Mailpit (Email Testing)</a></li>";
echo "<li>Redis: localhost:6379</li>";
echo "<li>MariaDB: localhost:3306</li>";
echo "</ul>";
?>
