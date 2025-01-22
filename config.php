<?php
// Konfigurasi untuk menghubungkan ke database
$host = 'localhost';    // Host database (misalnya localhost)
$user = 'admin';         // Username database
$pass = 'admin123';             // Password database
$dbname = 'dbretail';   // Nama database

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
