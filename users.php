<?php
// Memulai sesi dan memeriksa apakah pengguna sudah login
session_start();

// Pastikan user sudah login dan memiliki level admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['level'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Memasukkan koneksi database
require_once 'koneksi.php';

// Ambil data pengguna
$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Menangani aksi hapus pengguna
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Menyiapkan query untuk menghapus pengguna
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Pengguna berhasil dihapus.'); window.location.href = 'users.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus pengguna.');</script>";
    }
}

// Menangani aksi tambah atau edit pengguna (bisa ditangani dengan form lain atau di bawah ini)
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    
    <!-- Link ke Bootstrap dan FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>
        /* Styling untuk tabel pengguna */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px 12px;
            text-align: left;
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
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="dashboard.php">Dashboard Admin</a>
            <a href="logout.php" class="btn-logout ml-auto"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Daftar Pengguna</h2>

        <!-- Tabel Daftar Pengguna -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo ucfirst($user['level']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <a href="users.php?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="add_user.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Pengguna</a>
    </div>

</body>
</html>
