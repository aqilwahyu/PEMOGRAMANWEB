<?php
session_start();
require_once 'db_config.php'; // Pastikan koneksi ke database sudah benar

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Cek apakah ID laporan ada di parameter URL dan valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID laporan tidak valid.');
}

$report_id = $_GET['id'];

// Menghapus laporan berdasarkan ID
try {
    // Siapkan query DELETE
    $delete_sql = "DELETE FROM laporan WHERE id = ?";
    $delete_stmt = $pdo->prepare($delete_sql);
    $delete_stmt->execute([$report_id]);

    // Redirect ke halaman laporan setelah menghapus
    header('Location: reports.php');
    exit;

} catch (PDOException $e) {
    die("Terjadi kesalahan saat menghapus laporan: " . $e->getMessage());
}
?>
