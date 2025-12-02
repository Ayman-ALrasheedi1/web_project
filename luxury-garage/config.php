<?php
/**
 * config.php
 * Database connection using PDO for Luxury Garage project
 */

$host    = 'localhost';
$db      = 'luxury_garage';
$user    = 'root';   // غيّرها لو عندك يوزر مختلف
$pass    = '';       // حط الباسورد لو فيه
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // show errors as exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch as associative arrays
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
