<?php
session_start();
require_once 'db_config.php'; // Pastikan untuk menyertakan koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Cek apakah ID laporan ada di parameter URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID laporan tidak valid.');
}

$report_id = $_GET['id'];

// Ambil data laporan berdasarkan ID
$sql = "SELECT * FROM laporan WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$report_id]);
$report = $stmt->fetch();

if (!$report) {
    die('Laporan tidak ditemukan.');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand text-white" href="#">Dashboard Admin</a>
    </nav>

    <div class="container mt-5">
        <h3>Detail Laporan</h3>
        <div class="card">
            <div class="card-header">
                <h4><?php echo htmlspecialchars($report['judul']); ?></h4>
            </div>
            <div class="card-body">
                <p><strong>Tanggal Dibuat:</strong> <?php echo $report['tanggal']; ?></p>
                <p><strong>Isi Laporan:</strong> <?php echo nl2br(htmlspecialchars($report['isi'])); ?></p>
            </div>
        </div>
    </div>
</body>

</html>
