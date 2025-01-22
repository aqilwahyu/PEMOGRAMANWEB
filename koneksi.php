<?php
// Mengatur kredensial database
$host = 'localhost';       // Ganti dengan host database Anda, misalnya 'localhost'
$dbname = 'dbretail'; // Ganti dengan nama database Anda
$username = 'admin';        // Ganti dengan username database Anda
$password = 'admin123';            // Ganti dengan password database Anda, kosong jika tidak ada password

// Mencoba koneksi ke database menggunakan PDO
try {
    // Membuat instance PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Menyeting mode error untuk PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Jika berhasil, Anda bisa menguji koneksi ini
    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    // Jika ada kesalahan, tampilkan pesan error
    die("Koneksi gagal: " . $e->getMessage());
}
?>
