<?php
// Database configuration
$host = "localhost";
$db_name = "kyt_shop"; // Make sure your database exists
$db_user = "root";     // Your MySQL username
$db_pass = "";         // Your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
