<?php
session_start();

// Cek apakah user sudah login dan memiliki hak akses sebagai admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['level'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
require_once 'koneksi.php';

// Ambil ID pengguna yang ingin dihapus
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Hapus pengguna dari database
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);

        $message = "Pengguna berhasil dihapus!";
        header('Location: users.php'); // Redirect ke halaman daftar pengguna
        exit;
    } catch (PDOException $e) {
        $message = "Terjadi kesalahan: " . $e->getMessage();
    }
} else {
    $message = "ID pengguna tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pengguna</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar (Posisi atas) -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2575fc;">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Dashboard Admin</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="users.php"><i class="fas fa-users"></i> Pengguna</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Pengguna Dihapus -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Hapus Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($message)): ?>
                            <div class="alert alert-info"><?php echo $message; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
