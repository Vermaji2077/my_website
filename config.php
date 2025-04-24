<?php
// Database credentials
$host = 'localhost';
$db   = 'airline';
$user = 'root';      // use your DB username
$pass = '';          // use your DB password

// Optional: PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// Establish connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
