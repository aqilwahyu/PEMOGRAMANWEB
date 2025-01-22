<?php
session_start();
require_once 'db_config.php'; // Pastikan koneksi database

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Proses saat formulir disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $isi = $_POST['isi'];

    // Validasi input
    if (empty($judul) || empty($tanggal) || empty($isi)) {
        $error_message = "Semua kolom harus diisi.";
    } else {
        // Simpan laporan ke database
        $sql = "INSERT INTO laporan (judul, tanggal, isi) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$judul, $tanggal, $isi]);

        // Redirect setelah berhasil menambahkan
        header('Location: reports.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand text-white" href="#">Dashboard Admin</a>
    </nav>

    <div class="container mt-5">
        <h3>Tambah Laporan Baru</h3>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Laporan</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Dibuat</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Isi Laporan</label>
                <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan Laporan</button>
        </form>
    </div>

</body>

</html>
