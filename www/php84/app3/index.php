<?php
// Sample PHP 8.4 application - app3
echo "<h1>Welcome to App3 (PHP 8.4)</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Server: " . $_SERVER['HTTP_HOST'] . "</p>";
echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";

// Test PHP 8.4 features
echo "<h2>PHP 8.4 Features Demo</h2>";

// Match expression (PHP 8.0+)
$status = 'active';
$message = match($status) {
    'active' => 'System is running',
    'inactive' => 'System is stopped',
    default => 'Unknown status'
};
echo "<p>Match Expression: $message</p>";

// Nullsafe operator (PHP 8.0+)
$user = (object)['profile' => (object)['name' => 'John Doe']];
$name = $user?->profile?->name ?? 'Unknown';
echo "<p>Nullsafe Operator: $name</p>";

// Database connection test
try {
    $pdo = new PDO('mysql:host=mariadb;dbname=ium_default', 'ium_user', 'ium_password');
    echo "<p style='color: green;'>✓ Database connection successful</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

phpinfo();
?>
