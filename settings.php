<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Pastikan hanya admin yang dapat mengakses halaman ini
if ($_SESSION['level'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

// Variabel untuk menampilkan pesan sukses atau error
$message = "";

// Cek apakah form telah disubmit untuk update pengaturan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    // Validasi input
    if (empty($username) || empty($email)) {
        $message = "Semua field harus diisi!";
    } else {
        // Koneksi ke database
        require_once 'koneksi.php';

        try {
            // Query untuk memperbarui pengaturan pengguna
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $stmt->execute([$username, $email, $_SESSION['id']]);

            // Tampilkan pesan sukses
            $message = "Pengaturan berhasil diperbarui!";
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
    <title>Pengaturan Pengguna</title>

    <!-- Link ke Bootstrap dan Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 50px auto;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-submit {
            background-color: #2575fc;
            color: white;
            padding: 12px 20px;
            width: 100%;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-submit:hover {
            transform: scale(1.05);
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
        }

        .alert {
            margin-bottom: 20px;
            font-size: 1rem;
            padding: 15px;
            border-radius: 10px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        /* Styling untuk Navbar */
        .navbar {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>

    <!-- Navbar Dashboard -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Pengaturan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="form-container">
        <h2>Pengaturan Pengguna</h2>

        <!-- Tampilkan pesan sukses atau error -->
        <?php if ($message): ?>
            <div class="alert <?php echo strpos($message, 'berhasil') !== false ? 'alert-success' : 'alert-danger'; ?> text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form untuk mengubah pengaturan pengguna -->
        <form action="settings.php" method="post">
            <!-- Username Input -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>" required>
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Perbarui Pengaturan</button>
        </form>
    </div>

    <!-- Link ke JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
