<?php
session_start();

// Cek apakah user sudah login dan memiliki hak akses sebagai admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['level'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
require_once 'koneksi.php';

// Ambil ID pengguna yang ingin diedit
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Ambil data pengguna dari database berdasarkan ID
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("Pengguna tidak ditemukan!");
        }
    } catch (PDOException $e) {
        die("Terjadi kesalahan: " . $e->getMessage());
    }
} else {
    die("ID pengguna tidak ditemukan!");
}

// Proses update data pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $level = trim($_POST['level']);
    $password = trim($_POST['password']); // Ambil password baru
    $confirm_password = trim($_POST['confirm_password']); // Ambil konfirmasi password

    // Validasi input
    if (empty($username) || empty($email) || empty($level)) {
        $message = "Semua kolom harus diisi!";
    } elseif ($password !== $confirm_password) {
        $message = "Password dan konfirmasi password tidak cocok!";
    } elseif (!empty($password) && strlen($password) < 6) {
        $message = "Password minimal 6 karakter!";
    } else {
        // Update data pengguna, termasuk password jika ada perubahan
        try {
            if (!empty($password)) {
                // Jika password baru diisi, enkripsi password dan update
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, level = ?, password = ? WHERE id = ?");
                $stmt->execute([$username, $email, $level, $password_hash, $user_id]);
            } else {
                // Jika password kosong, hanya update username, email, dan level
                $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, level = ? WHERE id = ?");
                $stmt->execute([$username, $email, $level, $user_id]);
            }

            $message = "Data pengguna berhasil diperbarui!";
            header('Location: users.php'); // Redirect ke halaman daftar pengguna
            exit;
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>

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

    <!-- Form Edit Pengguna -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($message)): ?>
                            <div class="alert alert-info"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="level">Level</label>
                                <select class="form-control" id="level" name="level" required>
                                    <option value="admin" <?php echo ($user['level'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                    <option value="user" <?php echo ($user['level'] === 'user') ? 'selected' : ''; ?>>User</option>
                                </select>
                            </div>

                            <!-- Input untuk password -->
                            <div class="form-group mt-3">
                                <label for="password">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru (biarkan kosong jika tidak ingin mengubah)">
                            </div>
                            <div class="form-group mt-3">
                                <label for="confirm_password">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password baru">
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
