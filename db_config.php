<?php
// db_config.php

$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'dbretail'; // Ganti dengan nama database Anda
$username = 'admin'; // Ganti dengan username database Anda
$password = 'admin123'; // Ganti dengan password database Anda jika ada

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set mode error PDO ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
