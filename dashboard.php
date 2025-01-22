<?php
session_start();  // Memulai sesi

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Ambil data user
$username = $_SESSION['username'];
$level = $_SESSION['level'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #2575fc; /* Warna biru cerah */
            padding: 15px 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            font-weight: 600;
            color: white;
        }

        .navbar .navbar-nav .nav-link {
            color: white;
            font-weight: 500;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #ffcc00;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            background-color: #2f3b52;
            padding-top: 30px;
            color: white;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 15px;
            display: block;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s ease;
        }

        .sidebar a:hover {
            background-color: #2575fc;
            transform: scale(1.05);
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar h3 {
            color: #ffffff;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Content Styling */
        .content {
            margin-left: 260px;
            padding: 30px;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        }

        .btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

    </style>
</head>

<body>

    <!-- Navbar (Posisi atas) -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Dashboard Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="profile.php"><i class="fas fa-user"></i> Profil</a>
                    </li>
                </ul>
            </div>
            <!-- Tombol Logout di Navbar -->
            <a href="logout.php" class="btn-logout ml-auto"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Selamat Datang, <?php echo $username; ?></h3>
        <ul class="list-unstyled">
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Pengguna</a></li>
            <li><a href="settings.php"><i class="fas fa-cogs"></i> Pengaturan</a></li>
            <li><a href="reports.php"><i class="fas fa-chart-line"></i> Laporan</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <!-- Selamat Datang Card -->
                <div class="col-md-12 mb-4">
                    <div class="card bg-white shadow-lg rounded-lg p-4">
                        <div class="card-header text-center text-white bg-blue-500 rounded-t-lg">
                            <h4>Selamat Datang di Dashboard, <?php echo $username; ?>!</h4>
                        </div>
                        <div class="card-body">
                            <p>Anda sebagai <strong><?php echo ucfirst($level); ?></strong>, memiliki akses penuh untuk mengelola pengguna, pengaturan, dan laporan.</p>
                            <p>Gunakan sidebar untuk navigasi ke bagian-bagian dashboard lainnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
