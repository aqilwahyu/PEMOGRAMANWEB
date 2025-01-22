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
try {
    $sql = "SELECT * FROM laporan WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$report_id]);
    $report = $stmt->fetch();

    if (!$report) {
        die('Laporan tidak ditemukan.');
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Proses formulir saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];

    // Validasi input
    if (empty($judul) || empty($tanggal)) {
        $error_message = "Semua kolom harus diisi.";
    } else {
        try {
            // Update data laporan di database
            $update_sql = "UPDATE laporan SET judul = ?, tanggal = ? WHERE id = ?";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([$judul, $tanggal, $report_id]);

            // Redirect setelah update
            header('Location: reports.php');
            exit;
        } catch (PDOException $e) {
            $error_message = "Terjadi kesalahan saat menyimpan perubahan: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand text-white" href="#">Dashboard Admin</a>
    </nav>

    <div class="container mt-5">
        <h3>Edit Laporan</h3>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Laporan</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($report['judul']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Dibuat</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $report['tanggal']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
