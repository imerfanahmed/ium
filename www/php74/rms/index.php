<?php
// Sample PHP 7.4 application - RMS (Restaurant Management System)
echo "<h1>Restaurant Management System (PHP 7.4)</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Server: " . $_SERVER['HTTP_HOST'] . "</p>";
echo "<p>Application: RMS</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";

// Database connection test
try {
    $pdo = new PDO('mysql:host=mariadb;dbname=ium_default', 'ium_user', 'ium_password');
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Create a sample table for RMS
    $pdo->exec("CREATE TABLE IF NOT EXISTS restaurants (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    echo "<p style='color: green;'>✓ RMS tables ready</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "<h2>Quick Navigation</h2>";
echo "<ul>";
echo "<li><a href='/php74/rms/'>Home</a></li>";
echo "<li><a href='/php74/rms/menu.php'>Menu Management</a></li>";
echo "<li><a href='/php74/rms/orders.php'>Orders</a></li>";
echo "</ul>";
?>
