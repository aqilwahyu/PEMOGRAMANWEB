<?php
session_start();  // Memulai sesi

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Koneksi ke database (ganti dengan konfigurasi database Anda)
require_once 'db_config.php';

// Ambil data user
$username = $_SESSION['username'];
$level = $_SESSION['level'];

// Ambil data laporan dari database
$sql = "SELECT * FROM laporan";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Dashboard Admin</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Styling untuk halaman */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #2575fc; 
            padding: 10px 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand {
            font-weight: 600;
            color: white;
        }
        .navbar-nav .nav-item {
            margin-left: 20px;
        }
        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #ffcc00;
        }

        /* Sidebar Styling */
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
            transition: transform 0.3s ease;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 15px 20px;
            display: block;
            transition: background-color 0.3s, transform 0.2s;
        }
        .sidebar a:hover {
            background-color: #1e2a38;
            transform: scale(1.05);
        }
        .sidebar h3 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.2rem;
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
            transition: background-color 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        /* Button Delete */
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</a>
            <div class="d-flex ms-auto">
                <!-- Logout -->
                <a href="logout.php" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
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
                <!-- Judul Laporan -->
                <div class="col-md-12 mb-4">
                    <div class="card bg-white shadow-lg rounded-lg p-4">
                        <div class="card-header text-center text-white bg-blue-500 rounded-t-lg">
                            <h4>Laporan - Data Admin</h4>
                        </div>
                        <div class="card-body">
                            <p>Berikut adalah laporan yang tersedia di dashboard ini:</p>
                            
                            <!-- Tombol Tambah Laporan -->
                            <a href="add_report.php" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Tambah Laporan</a>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Laporan</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($reports as $report):
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($report['judul']); ?></td>
                                        <td><?php echo $report['tanggal']; ?></td>
                                        <td>
                                            <a href="view_report.php?id=<?php echo $report['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Lihat</a>
                                            <a href="edit_report.php?id=<?php echo $report['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="delete_report.php?id=<?php echo $report['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus laporan ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
